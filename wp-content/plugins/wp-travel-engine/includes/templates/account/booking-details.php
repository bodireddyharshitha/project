<?php
/**
 * Booking Details Page
 *
 * This template can be overridden by copying it to yourtheme/wp-travel-engine/account/booking-details.php.
 *
 * HOWEVER, on occasion WP Travel will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://wptravelengine.com
 * @author  WP Travel Engine
 * @package WP Travel Engine/includes/templates
 * @version 1.3.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$booking_details 				= get_post( $booking );
$settings                      	= wp_travel_engine_get_settings();
$wp_travel_engine_dashboard_id 	= isset( $settings['pages']['wp_travel_engine_dashboard_page'] ) ? esc_attr( $settings['pages']['wp_travel_engine_dashboard_page'] ) : wp_travel_engine_get_page_id( 'my-account' );
$set_duration_type    			= ! empty( $settings['set_duration_type'] ?? '' ) ? $settings['set_duration_type'] : 'days';
$billing_info 					= $booking_details->billing_info;
$booking_payments 				= $booking_details->payments ?? false;
$cart_info 						= $booking_details->cart_info;
$currency_code    				= $cart_info['currency'] ?? '';
$order_trip 					= array_shift( $booking_details->order_trips );
$trip_id 						= $order_trip['ID'] ?? '';
$trip_name 						= $order_trip['title'] ?? '';
$trip_start_date 				= $order_trip['datetime'] ?? '';
$trip_end_date 					= $order_trip['end_datetime'] ?? '';
$trip_metas           			= get_post_meta( $trip_id, 'wp_travel_engine_setting', true );
$trip_duration_unit   			= $trip_metas['trip_duration_unit'] ?? 'days';
$trip_duration        			= $trip_metas['trip_duration'] ?? 1;
$trip_duration_nights 			= $trip_metas['trip_duration_nights'] ?? 'nights';
$is_booking_detail    			= true;
$time_format              		= get_option( 'time_format' );
$date_format			  		= get_option( 'date_format' );
$trip_start_date_with_time 		= "";
$trip_end_date_with_time 		= "";

if ( ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $trip_start_date ) ) {
    $trip_start_date_with_time = $trip_start_date;
    $trip_start_date = substr( $trip_start_date, 0, 10 );
}

if ( ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $trip_end_date ) ) {
    $trip_end_date_with_time = $trip_end_date;
    $trip_end_date = substr( $trip_end_date, 0, 10 );
}

if ( '' !== $trip_start_date_with_time && '' === $trip_end_date_with_time ) {
    $start_date_time = new \DateTime( $trip_start_date_with_time );
    $start_date_time->modify( "+{$trip_duration} hours" );
    $trip_end_date_with_time = $start_date_time->format( $time_format );
}

if ( '' !== $trip_start_date && '' === $trip_end_date ) {
    $start_date = new \DateTime( $trip_start_date );
    $start_date->modify( "+{$trip_duration} {$trip_duration_unit}" );
    $trip_end_date = $start_date->format( $date_format );
}

?>
<a href="<?php echo esc_url( get_permalink( $wp_travel_engine_dashboard_id ) ); ?>" class="wpte-back-btn">
	<?php wptravelengine_svg_by_fa_icon( 'fas fa-arrow-left' ); ?><?php esc_html_e( 'Go back', 'wp-travel-engine' ); ?>
</a>
<div class="wpte-booking-details-wrapper">
	<div class="wpte-booking-detail-left-section">
		<div class="wpte-trip-info">
			<div class="wpte-trip-image">
				<?php echo get_the_post_thumbnail( $trip_id ); ?>
			</div>
			<div class="wpte-trip-description">
				<h5 class="wpte-trip-heading">
					<?php echo esc_html( $trip_name ); ?>
				</h5>
				<?php
				if ( class_exists( 'Wte_Trip_Review_Init' ) ) {
					$review_obj              = new Wte_Trip_Review_Init();
					$comment_datas           = $review_obj->pull_comment_data( $trip_id );
					$icon_type               = '';
					$icon_fill_color         = '#F39C12';
					$review_icon_type        = apply_filters( 'trip_rating_icon_type', $icon_type );
					$review_icon_fill_colors = apply_filters( 'trip_rating_icon_fill_color', $icon_fill_color );
					if ( ! empty( $comment_datas ) ) {
						?>
						<span class="review">
						<div
							class="agg-rating trip-review-stars <?php echo ! empty( $review_icon_type ) ? 'svg-trip-adv' : 'trip-review-default'; ?>"
							data-icon-type='<?php echo esc_attr( $review_icon_type ); ?>'
							data-rating-value="<?php echo esc_attr( $comment_datas['aggregate'] ); ?>"
							data-rateyo-rated-fill="<?php echo esc_attr( $review_icon_fill_colors ); ?>"
							data-rateyo-read-only="true"
						>
						</div>
						<div class="aggregate-rating reviw-txt-wrap">
							<span><?php printf( esc_html( _nx( '%s review', '%s reviews', absint( $comment_datas['i'] ), 'review count', 'wp-travel-engine' ) ), esc_html( number_format_i18n( $comment_datas['i'] ) ) ); ?></span>
						</div>
					</span>

						<?php
					}
				}
				?>
				<a class="wpte-trip-link"
					href="<?php echo get_permalink( $trip_id ); ?>"><?php echo esc_html_e( 'View Trip', 'wp-travel-engine' ); ?></a>
			</div>
		</div>
		<div class="wpte-billing-info">
			<h6 class="wpte-billing-heading"><?php esc_html_e( 'Billing Information', 'wp-travel-engine' ); ?></h6>
			<div class="wpte-billing-content">
				<ul>
					<li>
						<span>
						<?php esc_html_e( 'First Name:', 'wp-travel-engine' ); ?>
						</span>
						<span>
						<?php echo esc_html( $billing_info['fname'] ?? '' ); ?>
						</span>
					</li>
					<li>
					<span>
					<?php esc_html_e( 'Email:', 'wp-travel-engine' ); ?>
					</span>
						<span>
					<?php echo esc_html( $billing_info['email'] ?? '' ); ?>
					</span>
					</li>
					<li>
					<span>
					<?php esc_html_e( 'Last Name:', 'wp-travel-engine' ); ?>
					</span>
						<span>
					<?php echo esc_html( $billing_info['lname'] ?? '' ); ?>
					</span>
					</li>
					<li>
					<span>
					<?php esc_html_e( 'Address:', 'wp-travel-engine' ); ?>
					</span>
						<span>
					<?php echo esc_html( $billing_info['address'] ?? '' ); ?>
					</span>
					</li>
					<li>
					<span>
					<?php esc_html_e( 'Country:', 'wp-travel-engine' ); ?>
					</span>
						<span>
					<?php echo esc_html( $billing_info['country'] ?? '' ); ?>
					</span>
					</li>
					<li>
					<span>
					<?php esc_html_e( 'City:', 'wp-travel-engine' ); ?>
					</span>
						<span>
					<?php echo esc_html( $billing_info['city'] ?? '' ); ?>
					</span>
					</li>
				</ul>

			</div>
		</div>
	</div>
	<div class="wte-booking-detail-right-section">
		<div class="wpte-booking-details">
			<h5 class="wpte-booking-heading"><?php echo esc_html( sprintf( __( 'Booking Details #%1$s', 'wp-travel-engine' ), $booking ) ); ?></h5>
			<div class="wpte-trip-booking-info">
				<h6><?php esc_html_e( 'Trip Information', 'wp-travel-engine' ); ?></h6>
				<ul>
					<li>
						<span>
							<?php esc_html_e( 'Trip Code:', 'wp-travel-engine' ); ?>
						</span>
						<span>
							<?php echo esc_html( $trip_metas['trip_code'] ?? '' ); ?>
						</span>
					</li>
				</ul>
				<div class="wpte-trip-booking-date">
					<div class="wpte-trip-start-date">
						<span class="wpte-info-title">
							<?php esc_html_e( 'Trip Start Date:', 'wp-travel-engine' ); ?>
						</span>
						<span class="wpte-info-value">
							<?php
							echo esc_html( date_i18n( $date_format, strtotime( $trip_start_date ) ) );
							?>
						</span>
						<?php if ( !empty( $trip_start_date_with_time ) ) { ?>
							<span class="wpte-info-time">
							<?php
							$modified_start_date_time = date( $time_format, strtotime( $trip_start_date_with_time ) );
							echo esc_html( sprintf( __( 'From %s', 'wp-travel-engine' ), $modified_start_date_time ) );
							?>
						</span>
						<?php } ?>
					</div>
					<div class="wpte-trip-end-date">
						<span class="wpte-info-title">
							<?php esc_html_e( 'Trip End Date:', 'wp-travel-engine' ); ?>
						</span>
						<span class="wpte-info-value">
							<?php
							echo esc_html( date_i18n( $date_format, strtotime( $trip_end_date ) ) );
							?>
						</span>
						<?php if ( !empty( $trip_end_date_with_time ) ) { ?>
							<span class="wpte-info-time">
							<?php
							$modified_end_date_time = date( $time_format, strtotime( $trip_end_date_with_time ) );
							echo esc_html( sprintf( __( 'To %s', 'wp-travel-engine' ), $modified_end_date_time ) );
							?>
						</span>
						<?php } ?>
					</div>
				</div>
				<ul>
					<li>
						<span>
							<?php esc_html_e( 'Total length of travel:', 'wp-travel-engine' ); ?>
						</span>
						<span>
							<?php
							wte_get_template( 'components/content-trip-card-duration.php', compact( 'trip_duration_unit', 'trip_duration', 'trip_duration_nights', 'set_duration_type', 'is_booking_detail' ) );
							?>
						</span>
					</li>
				</ul>
			</div>
			<div class="wpte-travellers-info">
				<h6><?php esc_html_e( 'Travellers', 'wp-travel-engine' ); ?></h6>
				<ul>
					<?php
					$pricing_categories = get_terms(
						array(
							'taxonomy'   => 'trip-packages-categories',
							'hide_empty' => false,
							'orderby'    => 'term_id',
							'fields'     => 'id=>name',
						)
					);
					if ( is_wp_error( $pricing_categories ) ) {
						$pricing_categories = array();
					}
					foreach ( $order_trip['pax'] as $category => $number ) {
						$label = isset( $pricing_categories[ $category ] ) ? $pricing_categories[ $category ] : $category;
						?>
						<li>
							<span>
								<?php echo esc_html( $label ); ?>:
							</span>
							<span>
								<?php echo esc_attr( $number ); ?>
							</span>
						</li>
						<?php
					}
					?>
				</ul>

			</div>
			<?php
			if ( ! empty( $order_trip['trip_extras']) ) {
				?>
				<div class="wpte-extra-services-info">
					<h6><?php esc_html_e( 'Extra Services', 'wp-travel-engine' ); ?></h6>
					<ul>
						<?php
						foreach ( $order_trip['trip_extras']as $index => $tx ) {
							?>
							<li>
									<span>
										<?php echo esc_html( $tx['extra_service'] ); ?>:
									</span>
								<span>
										<?php echo esc_html( $tx['qty'] ); ?>
									</span>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			<?php } ?>
		</div>
		<div class="wpte-payment-details">
			<h5 class="wpte-payment-heading"><?php esc_html_e( 'Payment Details', 'wp-travel-engine' ); ?></h5>
			<div class="wpte-payment-data">
				<?php
				if ( is_array( $booking_payments ) ) {
					foreach ( $booking_payments as $index => $booking_payment ) {
						$payment_status = get_post_meta( $booking_payment, 'payment_status', true );
						?>
						<h6>
							<?php
							// Translators: %s: Payment number.
							printf( __( 'Payment #%s', 'wp-travel-engine' ), $index + 1 );
							?>
						</h6>
						<ul>
							<li>
								<span><?php esc_html_e( 'Payment ID:', 'wp-travel-engine' ); ?></span>
								<span><?php echo esc_html( $booking_payment ); ?></span>
							</li>
							<li>
								<span><?php esc_html_e( 'Payment Status:', 'wp-travel-engine' ); ?></span>
								<span
									class="wpte-status <?php echo $payment_status == 'completed' ? 'completed' : 'pending'; ?>">
									<?php
									$payment_status_labels = wptravelengine_payment_status();
									$payment_status        = $payment_status_labels[ $payment_status ] ?? $payment_status;
									echo esc_html( $payment_status );
									?>
								</span>
							</li>
							<li>
								<span><?php esc_html_e( 'Amount:', 'wp-travel-engine' ); ?></span>
								<span>
									<?php
									$payable = get_post_meta( $booking_payment, 'payable', true ) ?? 0;
									wptravelengine_the_price( $payable['amount'] ?? 0, true, compact( 'currency_code' ) );
									?>
								</span>
							</li>
							<?php
							$wc_order_id = get_post_meta( $booking, '_wte_wc_order_id', true );
							if ( ! empty( $wc_order_id ) ) :
								?>
								<li>
									<?php
									printf(
										__( 'This booking was made using WooCommerce payments, view detail payment information %1$shere%2$s', 'wp-travel-engine' ),
										'<a href="' . admin_url( "/post.php?post={$wc_order_id}&action=edit" ) . '">',
										'</a>'
									);
									?>
								</li>
							<?php endif; ?>
						</ul>
						<?php
					}
				}
				?>
			</div>
			<div class="wpte-payment-info">
				<h6><?php esc_html_e( 'Payment Info', 'wp-travel-engine' ); ?></h6>
				<ul>
					<li>
						<span><?php esc_html_e( 'Total Cost:', 'wp-travel-engine' ); ?></span>
						<span><?php wptravelengine_the_price( $cart_info['total'] ?? 0, true, compact( 'currency_code' ) ); ?></span>
					</li>
					<li>
						<span><?php esc_html_e( 'Paid Amount:', 'wp-travel-engine' ); ?></span>
						<span> <?php wptravelengine_the_price( $booking_details->paid_amount ?? 0, true, compact( 'currency_code' ) ); ?></span>
					</li>
					<li>
						<span><?php esc_html_e( 'Due Amount:', 'wp-travel-engine' ); ?></span>
						<span><?php wptravelengine_the_price( $booking_details->due_amount ?? 0, true, compact( 'currency_code' ) ); ?></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
