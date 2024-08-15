<?php
/**
 * Package Date Parser.
 *
 * @package WPTravelEngine
 * @since 6.0.0
 */

namespace WPTravelEngine\Helpers;

use DateTime;
use RRule\RRule;
use WPTravelEngine\Core\Booking\Inventory;
use WPTravelEngine\Core\Models\Post\TripPackage;

#[\AllowDynamicProperties]
/**
 * Class PackageDateParser.
 * This class is responsible for parsing package dates.
 *
 * @since 6.0.0
 */
class PackageDateParser {
	/**
	 * @var string
	 */
	protected string $dtstart;

	/**
	 * @var array
	 */
	protected array $times;

	/**
	 * @var bool
	 */
	protected bool $is_recurring = false;

	/**
	 * @var array
	 */
	protected array $rrule;

	/**
	 * @var mixed
	 */
	protected $seats;

	/**
	 * @var TripPackage
	 */
	protected TripPackage $package;

	/**
	 * @var array
	 */
	protected array $booked_seats = array();

	/**
	 * Constructor.
	 *
	 * @param TripPackage $trip_package Trip package object.
	 */
	public function __construct( TripPackage $trip_package, array $args ) {

		$args[ 'is_recurring' ] = empty( $args[ 'is_recurring' ] ) ? false : $args[ 'is_recurring' ];

		$this->package      = $trip_package;
		$this->dtstart      = $args[ 'dtstart' ];
		$this->times        = $args[ 'times' ] ?? array();
		$this->is_recurring = is_bool( $args[ 'is_recurring' ] ) ? $args[ 'is_recurring' ] : '1' === $args[ 'is_recurring' ];
		$this->seats        = is_numeric( $args[ 'seats' ] ?? '' ) ? (int) $args[ 'seats' ] : '';
		$this->rrule        = $this->parse_rrule( $args[ 'rrule' ] ?? array() );
	}

	/**
	 * Parse the rrule.
	 *
	 * @param array $args RRULE arguments.
	 *
	 * @return array
	 */
	protected function parse_rrule( $args ): array {
		$rrule = array();

		try {
			$rrule[ 'dtstart' ] = new DateTime( $this->dtstart );
			$rrule[ 'freq' ]    = $args[ 'r_frequency' ] ?? RRule::DAILY;
			if ( $args[ 'r_until' ] ?? false ) {
				$rrule[ 'until' ] = new DateTime( $args[ 'r_until' ] );
			} else if ( is_numeric( $args[ 'r_count' ] ?? false ) ) {
				$rrule[ 'count' ] = $args[ 'r_count' ];
			} else {
				$rrule[ 'count' ] = 10;
			}

			switch ( $rrule[ 'freq' ] ) {
				case 'WEEKLY':
					$rrule[ 'byday' ] = $args[ 'r_weekdays' ] ?? array();
					break;
				case 'MONTHLY':
					$rrule[ 'bymonth' ] = $args[ 'r_months' ] ?? array();
					break;
			}

			return $rrule;
		} catch ( \Exception $e ) {
			return array();
		}
	}

	/**
	 * @return string
	 */
	public function get_starting_date(): string {
		return $this->dtstart;
	}

	/**
	 * Get the time slots.
	 *
	 * @return array
	 */
	public function get_times(): array {
		return $this->times;
	}

	/**
	 * If the data is recurring.
	 *
	 * @return bool
	 */
	public function is_recurring(): bool {
		return $this->is_recurring;
	}

	/**
	 * @param $date
	 *
	 * @return array
	 */
	protected function prepare_date( $date ): array {
		$times          	= array();
		$formatted_date 	= $date->format( 'Y-m-d' );
		$trip 				= $this->package->get_trip();
		
		$booked_for_the_date = $this->booked_seats[ $this->package->get_id() ][ $formatted_date ][ '00:00' ] ?? 0;

		foreach ( $this->times as $index => $time ) {
			$booked_for_the_time  = $this->booked_seats[ $this->package->get_id() ][ $formatted_date ][ $time[ 'from' ] ] ?? 0;
			$available_time_seats = is_numeric( $this->seats ) ? max( $this->seats - $booked_for_the_time, 0 ) : '';

			if ( is_numeric( $available_time_seats ) && $available_time_seats <= 0 ) {
				continue;
			}
			$times[] = array(
				'key'   => implode(
					'_',
					array(
						$this->package->get_id(),
						$formatted_date,
						$time[ 'from' ],
						$time[ 'to' ],
					)
				),
				'from'  => $formatted_date . 'T' . $time[ 'from' ],
				'to'    => $formatted_date . 'T' . $time[ 'to' ],
				'seats' => $available_time_seats,
			);
		}

		$available_seats = is_numeric( $this->seats ) ? max( $this->seats - $booked_for_the_date, 0 ) : '';
		if ( !class_exists( 'WTE_Fixed_Starting_Dates' ) && $trip->is_enabled_min_max_participants() ) {
			$available_seats = $trip->get_maximum_participants();
		}

		if ( ! empty( $times ) ) {
			$available_seats = is_numeric( $this->seats ) ? array_sum( array_column( $times, 'seats' ) ) : '';
		}

		return array(
			'times' => $times,
			'seats' => is_numeric( $available_seats ) ? (int) $available_seats : '',
		);
	}

	/**
	 * Get the dates from the rrule.
	 *
	 * @param RRule $rrule
	 * @param array $args
	 *
	 * @return array
	 */
	protected function get_dates_from_rrule( RRule $rrule, $args = array() ): array {

		$recurring_dates = $rrule;

		if ( isset( $args[ 'from' ], $args[ 'to' ] ) ) {
			$recurring_dates = $rrule->getOccurrencesBetween( $args[ 'from' ], $args[ 'to' ] );
		} else if ( isset( $args[ 'from' ] ) ) {
			$recurring_dates = $rrule->getOccurrencesAfter( $args[ 'from' ], true );
		}

		$dates = array();

		foreach ( $recurring_dates as $date ) {
			$_date = $this->prepare_date( $date );
			if ( is_numeric( $_date[ 'seats' ] ) && $_date[ 'seats' ] <= 0 ) {
				continue;
			}
			$dates[ $date->format( 'Y-m-d' ) ] = $this->prepare_date( $date );
		}

		return $dates;
	}

	/**
	 * Get the recurring Dates.
	 *
	 * @return RRule|array
	 */
	public function get_dates( bool $object = true, $args = array() ) {

		$this->booked_seats = $this->package->get_trip()->get_inventory()->inventory();

		if ( ! $this->is_recurring || empty( $this->rrule ) ) {
			if ( $this->dtstart < date( 'Y-m-d' ) ) {
				return array();
			}
			try {
				return [ $this->dtstart => $this->prepare_date( new \DateTime( $this->dtstart ) ) ];
			} catch ( \Exception $e ) {
				return array();
			}
		}

		$rrule = new RRule( $this->rrule );

		if ( $object ) {
			return $rrule;
		}

		return $this->get_dates_from_rrule( $rrule, $args );
	}
}
