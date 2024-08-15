<?php
/**
 * Customer Details parts.
 */
global $post;

$booking_details = new \stdClass();

/** @var array $_args */
extract( $_args );

$billing_info = $booking_details->billing_info;

$additional_fields = get_post_meta( $post->ID, 'additional_fields', ! 0 );
$additional_fields = is_array( $additional_fields ) ? $additional_fields : array();
?>
<div class="wpte-block wpte-col3">
	<div class="wpte-title-wrap">
		<h4 class="wpte-title"><?php esc_html_e( 'Billing Details', 'wp-travel-engine' ); ?></h4>
		<div class="wpte-button-wrap wpte-edit-booking-detail">
			<a href="#" class="wpte-btn-transparent wpte-btn-sm">
				<?php wptravelengine_svg_by_fa_icon( "fas fa-pencil-alt" ); ?>
				<?php esc_html_e( 'Edit', 'wp-travel-engine' ); ?>
			</a>
		</div>
	</div>
	<div class="wpte-block-content">
		<?php do_action( 'wptravelengine_before_billing_details', $billing_info, $post->ID ); ?>
		<ul class="wpte-list">
			<?php
			if ( is_array( $billing_info ) ) {
				foreach ( $billing_info as $key => $value ) : // foreachbokv
					$booking_key = 'booking_' . $key;
					if ( isset( $additional_fields[ $key ] ) ) {
						$booking_key = $key;
					}
					if ( 'fname' === $key ) {
						$booking_key = 'booking_first_name';
					} else if ( 'lname' === $key ) {
						$booking_key = 'booking_last_name';
					}
					if ( 'survey' === $key ) {
						continue;
					}
					if ( is_array( $value ) ) {
						$value = implode( ',', $value );
					}
					$data_label = wp_travel_engine_get_booking_field_label_by_name( preg_replace( '/(^booking_booking_)/', 'booking_', $booking_key ) );
					?>
					<li>
						<b><?php echo esc_html( $data_label ); ?></b>
						<span>
						<div class="wpte-field">
							<input readonly data-attrib-name="billing_info[<?php echo esc_attr( $key ); ?>]" type="text"
								   value="<?php echo esc_attr( $value ); ?>" />
						</div>
					</span>
					</li>
				<?php
				endforeach; // endforeachbokv
			}
			?>
		</ul>
		<?php do_action( 'wptravelengine_after_billing_details', $billing_info, $post->ID ); ?>
	</div>
</div>

