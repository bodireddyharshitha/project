<?php
/**
 * Renders Active Booking, Recent Bookings & Bookings History Tab.
 *
 * @since 6.0.0
 * @package wp-travel-engine/includes/templates/account/tab-content/bookings
 */
?>
<div class="wpte-booked-trip-wrap">
	<div class="wpte-booked-trip-image">
	<?php
	if ( has_post_thumbnail( $booked_trip->ID ) ) {
		echo get_the_post_thumbnail( $booked_trip->ID );
	} else {
		?>
			<img alt="<?php the_title(); ?>"  itemprop="image" src="<?php echo esc_url( WP_TRAVEL_ENGINE_IMG_URL . '/public/css/images/single-trip-featured-img.jpg' ); ?>" alt="">
		<?php
	}
	?>
	</div>
	<div class="wpte-booked-trip-content">
		<div class="wpte-booked-trip-description-left">
			<div class="wpte-booked-trip-title">
		<?php echo esc_html( $booked_trip->title ); ?>
			</div>
			<div class="wpte-booked-trip-descriptions">
				<div class="wpte-booked-trip-inner-descriptions-left">
					<ul class="booking-status-info">
						<li>
							<span class="lrf-td-title"><?php esc_html_e( 'Departure:', 'wp-travel-engine' ); ?></span>
							<span class="lrf-td-desc"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $booked_trip->datetime ) ) ); ?></span>
						</li>
						<li>
							<span class="lrf-td-title"><?php esc_html_e( 'Booking Status:', 'wp-travel-engine' ); ?></span>
							<span class="lrf-td-desc"><?php echo wp_kses( wptravelengine_booking_status( $booking_instance->get_booking_status() ), array( 'code' => array() ) ); ?></span>
						</li>
					</ul>
				</div>
				<div class="wpte-booked-trip-inner-descriptions-right">
					<ul class="booking-payment-info">
						<li>
							<span class="lrf-td-title"><?php esc_html_e( 'Total:', 'wp-travel-engine' ); ?></span>
							<span
								class="lrf-td-desc"><?php wptravelengine_the_price( $booking_instance->get_total() ?? 0, true, compact( 'currency_code' ) ); ?></span>
						</li>
						<li>
							<span class="lrf-td-title"><?php esc_html_e( 'Paid:', 'wp-travel-engine' ); ?></span>
							<span
								class="lrf-td-desc"><?php wptravelengine_the_price( $total_paid, true, compact( 'currency_code' ) ); ?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="wpte-booked-trip-buttons-right">
		<?php if ( $show_pay_now_btn && 'history' !== $type ) { ?>
			<a class="wpte-lrf-btn-transparent wpte-pay-btn"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'wte_add_trip_to_cart' ) ); ?>"
				data-booking-id="<?php echo esc_attr( $booking_instance->ID ); ?>"
				data-xhr-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
				href="<?php echo esc_url( get_the_permalink() . '?action=partial-payment&booking_id=' . $booking_instance->ID . '"' ); ?>"><?php esc_html_e( 'Pay Now', 'wp-travel-engine' ); ?></a>
		<?php } ?>
			<a class="wpte-lrf-btn-transparent wpte-detail-btn" href="<?php echo esc_url( get_the_permalink() . '?action=booking-details&booking_id=' . $booking_instance->ID . '"' ); ?>"><?php esc_html_e( 'View Details', 'wp-travel-engine' ); ?></a>
		</div>
	</div>
</div>
