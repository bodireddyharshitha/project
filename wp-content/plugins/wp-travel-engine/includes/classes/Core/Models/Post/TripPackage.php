<?php
/**
 * Trip Package Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WPTravelEngine\Abstracts\PostModel;
use WPTravelEngine\Core\Booking\Inventory;
use WPTravelEngine\Helpers\PackageDateParser;

/**
 * Class TripPackage.
 * This class represents a trip package to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class TripPackage extends PostModel {

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'trip-packages';

	/**
	 * The trip object.
	 *
	 * @var Trip
	 */
	protected Trip $trip;

	/**
	 *
	 * @param $package
	 * @param Trip $trip
	 */
	public function __construct( $package, Trip $trip ) {
		$this->trip = $trip;
		parent::__construct( $package );
	}

	/**
	 * Gets package's categories data.
	 *
	 * @return object
	 */
	public function get_traveler_categories() {
		return new TravelerCategories( $this->trip, $this );
	}

	/**
	 *
	 *
	 * @return array
	 */
	public function get_group_pricing(): array {
		$fields = apply_filters( 'wte_rest_fields__trip-packages', array(), true );

		$callback = $fields[ 'group-pricing' ][ 'get_callback' ] ?? false;

		if ( $callback ) {
			return $callback( array( 'id' => $this->ID ), 'group-pricing' );
		}

		return array();
	}

	/**
	 * Package Dates.
	 *
	 * @return mixed
	 */
	public function get_package_dates( $args = array() ) {

		$fields = apply_filters( 'wte_rest_fields__trip-packages', array(), true );

		$callback = $fields[ 'package-dates' ][ 'get_callback' ] ?? false;

		$from = $args[ 'from' ] ?? date( 'Y-m-d' );
		$to   = $args[ 'to' ] ?? date( 'Y-m-d', strtotime( '+1 year' ) );

		$cut_off_enabled = $this->trip->get_setting( 'trip_cutoff_enable', 'false' ) === 'true';
		if ( $cut_off_enabled ) {
			$cut_off_days = (int) $this->trip->get_setting( 'trip_cut_off_time', 0 );
			$from         = date( 'Y-m-d', strtotime( "+{$cut_off_days} days", strtotime( $from ) ) );
		}

		if ( $callback ) {
			$package_dates = $callback( array( 'id' => $this->ID ), 'package-dates' );

			if ( ! is_array( $package_dates ) || empty( $package_dates ) ) {
				$package_dates = array(
					array(
						'dtstart'      => date( 'Y-m-d' ),
						'is_recurring' => '1',
						'rrule'        => array(
							'r_frequency' => 'DAILY',
							'r_until'     => $to,
						),
						'seats'        => '',
					),
				);
			}

			$dates = array();

			foreach ( $package_dates as $package_date ) {
				$package_date_parser = new PackageDateParser( $this, $package_date );

				$package_dates = $package_date_parser->get_dates( false, compact( 'from', 'to' ) );

				foreach ( $package_dates as $date => $date_data ) {
					if ( ! isset( $dates[ $date ] ) ) {
						$dates[ $date ] = $date_data;
						continue;
					}

					foreach ( $date_data['times'] as $value ) {
						if ( ! in_array( $value[ 'key' ], array_column( $dates[ $date ][ 'times' ], 'key' ) ) ) {
							$dates[ $date ][ 'times' ][] = $value;
						}
					}
				}
			}

			return $dates;
		}

		$enabled_time_slots = $this->get_meta( 'enable_weekly_time_slots', 'no' ) === 'yes';

		$dates = array();
		$available_seats = $this->trip->is_enabled_min_max_participants() ? $this->trip->get_maximum_participants() : '';
		$available_seats = is_numeric( $available_seats ) ? (int) $available_seats : '';
		if ( $enabled_time_slots && 'days' !== $this->trip->get_setting( 'trip_duration_unit', 'days' ) ) {
			$weekly_time_slots = $this->get_meta( 'weekly_time_slots', array() );
			$week_days         = array_keys( $weekly_time_slots );

			$week_days_mapping   = array_combine( range( 1, 7 ), array( 'MO', 'TU', 'WE', 'TH', 'FR', 'SA', 'SU' ) );
			$package_date_parser = new PackageDateParser(
				$this,
				array(
					'dtstart'      => date( 'Y-m-d' ),
					'is_recurring' => '1',
					'rrule'        => array(
						'r_frequency' => 'WEEKLY',
						'r_weekdays'  => array_map(
							function ( $week_day ) use ( $week_days_mapping ) {
								return $week_days_mapping[ $week_day ];
							},
							$week_days
						),
						'r_until'     => date( 'Y-m-d', strtotime( '+1 year' ) ),
					),
					'seats'        => '',
				)
			);

			$package_dates = $package_date_parser->get_dates();
			/* @var \DateTime $package_date */
			foreach ( $package_dates as $package_date ) {
				$times         = array();
				$times_by_days = $weekly_time_slots[ $package_date->format( 'w' ) ] ?? array();
				foreach ( $times_by_days as $time ) {
					if ( empty( $time ) ) {
						continue;
					}

					list( $hours, $minutes ) = explode( ':', $time );

					$package_date->setTime( $hours, $minutes, 0, 0 );

					$duration      = $this->trip->get_setting( 'trip_duration', 0 );
					$duration_unit = $this->trip->get_setting( 'trip_duration_unit', 'days' );

					$to = clone $package_date;
					$to->add( new \DateInterval( "PT{$duration}H" ) );

					$times[] = array(
						'key'   => "{$this->ID}_{$package_date->format( 'Y-m-d_H:i' )}_{$to->format('H:i')}",
						'from'  => $package_date->format( 'Y-m-d\TH:i' ),
						'to'    => $to->format( 'Y-m-d\TH:i' ),
						'seats' => $available_seats,
					);
				}
				$dates[ $package_date->format( 'Y-m-d' ) ] = array(
					'times' => $times,
					'seats' => is_int( $available_seats ) ? array_sum( array_column( $times, 'seats' ) ) : '',
				);
			}
		} else {
			$package_date_parser = new PackageDateParser(
				$this,
				array(
					'dtstart'      => date( 'Y-m-d' ),
					'is_recurring' => '1',
					'rrule'        => array(
						'r_frequency' => 'DAILY',
						'r_until'     => $to,
					),
					'seats'        => '',
				)
			);

			$dates = $package_date_parser->get_dates( false, compact( 'from', 'to' ) );
		}

		return $dates;
	}

	/**
	 * Get the trip object.
	 *
	 * @return Trip
	 */
	public function get_trip(): Trip {
		return $this->trip;
	}
}
