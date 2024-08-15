<?php
/**
 * Passes the booking details to the bookings html template.
 *
 * @since 6.0.0
 * @package wp-travel-engine/includes/templates/account/tab-content/bookings
 */

use WPTravelEngine\Core\Models\Post\Booking;

$booking_details = [];
foreach ( $args['bookings'] ?? [] as $booking ) {

    if ( empty( get_metadata( 'post', $booking ) ) ) {
        continue;
    }

    $booking_instance   = new Booking( $booking );
    $booking_metas      = $booking_instance->get_meta( 'wp_travel_engine_booking_setting' );
    if ( 'publish' !== $booking_instance->post->post_status || empty( $booking_metas ) ) {
        continue;
    }

    $order_items = $booking_instance->get_order_items();
    $booked_trip = is_array( $order_items ) ? array_pop( $order_items ) : '';
    $booked_trip = is_null( $booked_trip ) || empty( $booked_trip ) ? '' : (object) $booked_trip;
    if ( ( empty( $booked_trip ) ) || ( ( $booked_trip->datetime <= gmdate( 'Y-m-d' ) ) && 'active' === $type ) ) {
        continue;
    }

    $active_payment_methods = wp_travel_engine_get_active_payment_gateways();
    $booking_payments       = (array) $booking_instance->get_payment_detail();
	if ( empty( $booking_payments ) ) {
        $payment_status   = $booking_instance->get_payment_status();
        $total_paid       = (float) ( $booking_metas['place_order']['cost'] ?? 0 );
        $due              = (float) ( $booking_metas['place_order']['due'] ?? 0 );
        $due              = $due < 1 ? 0 : $due;
        $show_pay_now_btn = ( 'partially-paid' === $payment_status || $due > 0 ) && ! empty( $active_payment_methods );
    } else {
        $total_paid       = (float) $booking_instance->get_paid_amount();
        $due              = (float) $booking_instance->get_due_amount();
        $due              = $due < 1 ? 0 : $due;
        $show_pay_now_btn = $due > 0;

        $payment_status   = [];
        foreach ( $booking_payments as $payment_id ) {
            $payment_status[] = get_post_meta( $payment_id, 'payment_status', true );
        }

        $payment_status = implode( '/', $payment_status );
    }

    if ( 'active' !== $type && ! $payment_status ) {
        $payment_status = __( 'pending', 'wp-travel-engine' );
    }

	$currency_code = $booking_instance->get_cart_info( 'currency' ) ?? '';

	$booking_details[] = compact(
		'active_payment_methods',
		'booked_trip',
		'payment_status',
		'total_paid',
		'due',
		'show_pay_now_btn',
		'booking_instance',
		'currency_code'
    );

}

?>
<div class="wpte-bookings-contents">
<?php
foreach ( $booking_details as $details ) :
    wte_get_template( "account/tab-content/bookings/bookings-html.php", array_merge( $details, [ 'type' => $type ] ) );
endforeach;
?>
</div>
