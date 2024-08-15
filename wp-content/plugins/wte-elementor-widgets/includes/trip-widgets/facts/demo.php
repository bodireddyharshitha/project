<?php
/**
 * Trip Facts Widget Demo.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;

$trip_id = $post->ID;

if ( ! empty( $atts['id'] ) ) {
	$trip_id = $atts['id'];
}

$global_trip_facts = wptravelengine_get_trip_facts_options();
$trip_settings     = get_post_meta( $trip_id, 'wp_travel_engine_setting', true );

// Retrieve attributes value form elementor.
$attributes      = (object) $attributes;
$icon_position   = isset( $attributes->{'icon_alignment'} ) ? $attributes->{'icon_alignment'} : 'left';
$icon_v_position = isset( $attributes->{'vertical_alignment'} ) ? $attributes->{'vertical_alignment'} : 'top';
$column          = isset( $attributes->{'noofcolumn'} ) ? $attributes->{'noofcolumn'} : 2;

$_trip_facts = array(
	'field_id'   => array(
		4  => __( 'Best Season', 'wptravelengine-elementor-widgets' ),
		5  => __( 'Departure City', 'wptravelengine-elementor-widgets' ),
		11 => __( 'Altitude', 'wptravelengine-elementor-widgets' ),
		18 => __( 'Walking Hours', 'wptravelengine-elementor-widgets' ),
	),
	'field_type' => array(
		4  => 'text',
		5  => 'text',
		11 => 'text',
		18 => 'text',
	),
	4            => array(
		4 => __( 'Spring and Autumn', 'wptravelengine-elementor-widgets' ),
	),
	5            => array(
		5 => __( 'Kathmandu, Nepal', 'wptravelengine-elementor-widgets' ),
	),
	11           => array(
		11 => __( '2,800 meters to 5,364 meteres', 'wptravelengine-elementor-widgets' ),
	),
	18           => array(
		18 => __( '5 to 7 hours', 'wptravelengine-elementor-widgets' ),
	),
);

?>
<div class="secondary-trip-info">
	<div class="wte-trip-facts">
		<ul class="trip-facts-value wte-col-<?php echo esc_attr( $column ); ?>">
			<?php
			foreach ( $_trip_facts['field_type'] as $key => $field_type ) {
				if ( isset( $global_trip_facts['fid'][ $key ] ) ) {
					$_id = $global_trip_facts['field_id'][ $key ];
					if ( isset( $_trip_facts[ $key ][ $key ] ) && ! empty( $_trip_facts[ $key ][ $key ] ) ) {
						echo '<li class="trip-facts facts-icon-position-' . esc_attr( $icon_position ) . ' vertical-align-' . esc_attr( $icon_v_position ) . ' ">';
						$icon = '';
						if ( ! empty( $global_trip_facts['field_icon'][ $key ] ) ) {
							$icon = $global_trip_facts['field_icon'][ $key ];
							echo '<div class="wte-trip-fact-icon-wrapper"><span class="icon-holder">' . wptravelengine_svg_by_fa_icon( $icon, false ) . '</span></div>';
						}

						$field_value = isset( $_trip_facts[ $key ][ $key ] ) ? $_trip_facts[ $key ][ $key ] : '';
						if ( 'duration' === $field_type && ! preg_match( '/([^\d]+)/', trim( $field_value ) ) ) {
							$duration_type = 'days';
							if ( isset( $trip_settings['trip_duration_unit'] ) && in_array( $trip_settings['trip_duration_unit'], array( 'days', 'hours' ) ) ) {
								$duration_type = $trip_settings['trip_duration_unit'];
							}
							$field_value = sprintf(
								// translators: %d is the number of days or hours.
								_n( 'hours' === $duration_type ? '%d Hour' : '%d Day', 'hours' === $duration_type ? '%d Hours' : '%d Days', (int) $field_value, 'wptravelengine-elementor-widgets' ),
								(int) $field_value
							);
						}
						if ( 'textarea' === $field_type ) {
							$field_value = nl2br( $field_value );
						}
						?>
						<div class="wte-trip-fact-content-wrapper">
							<label><?php echo esc_html( $_id ); ?></label>
							<div class="trip-facts-<?php echo esc_attr( $field_type ); ?>">
								<div class="value"><?php echo wp_kses_post( $field_value ); ?></div>
							</div>
						</div>
						<?php
						echo '</li>';
					}
				}
			}
			?>
		</ul>
	</div>
</div>
<?php
