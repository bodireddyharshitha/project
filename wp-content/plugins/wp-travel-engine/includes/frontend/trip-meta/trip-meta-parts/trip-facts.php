<?php
/**
 * Display Trip Facts.
 *
 * @package Wp_Travel_Engine
 */

global $post;
$trip_id = $post->ID;
if ( ! empty( $atts['id'] ) ) {
	$trip_id = $atts['id'];
}
$global_trip_facts = wptravelengine_get_trip_facts_options();
$trip_settings     = get_post_meta( $trip_id, 'wp_travel_engine_setting', true );
$_trip_facts       = isset( $trip_settings['trip_facts'] ) && is_array( $trip_settings['trip_facts'] ) ? $trip_settings['trip_facts'] : array();

if ( empty( $_trip_facts ) ) {
	return;
}
?>
	<div class="secondary-trip-info">
		<div class="wte-trip-facts">
			<?php
			$trip_facts_title = ! empty( $trip_settings['trip_facts_title'] ) ? $trip_settings['trip_facts_title'] : '';
			if ( $trip_facts_title ) :
				?>
				<h2 class="widget-title">
					<?php echo esc_html( apply_filters( 'wp_travel_engine_trip_facts_title', $trip_facts_title ) ); ?>
				</h2>
			<?php endif; ?>
			<ul class="trip-facts-value">
				<?php
				foreach ( $_trip_facts['field_type'] as $key => $field_type ) {
					if ( isset( $global_trip_facts['fid'][ $key ] ) && ! empty( $_trip_facts[ $key ][ $key ] ) ) {
						$id          = $global_trip_facts['field_id'][ $key ];
						$icon        = ! empty( $global_trip_facts['field_icon'][ $key ] ) ? $global_trip_facts['field_icon'][ $key ] : '';
						$field_value = $_trip_facts[ $key ][ $key ];
						if ( 'duration' === $field_type ) {
							$field_value = wptravelengine_format_duration( $field_value, $trip_settings );
						} elseif ( 'textarea' === $field_type ) {
							$field_value = nl2br( $field_value );
						}
						?>
						<li>
							<?php if ( ! empty( $icon ) ) : ?>
								<span class="icon-holder"><?php echo wptravelengine_svg_by_fa_icon( $icon, false ); ?></span>
							<?php endif; ?>
							<label><?php echo esc_html( $id ); ?></label>
							<div class="trip-facts-<?php echo esc_attr( $field_type ); ?>">
								<div class="value"><?php echo wp_kses_post( $field_value ); ?></div>
							</div>
						</li>
						<?php
					}
				}
				$trip_facts_value      = wptravelengine_trip_facts_value( $trip_id, $trip_settings );
				$additional_trip_facts = wptravelengine_get_trip_facts_default_options();
				foreach ( $additional_trip_facts as $fact ) :
					if ( ! isset( $fact['enabled'] ) || 'no' === $fact['enabled'] ) {
						continue;
					}
					if ( isset( $trip_facts_value[ $fact['field_type'] ]['value'] ) ) {
						$value_callable = $trip_facts_value[ $fact['field_type'] ]['value'];
						$fact_value     = is_callable( $value_callable ) && ( ! isset( $trip_facts_value[ $fact['field_type'] ]['condition'] ) || $trip_facts_value[ $fact['field_type'] ]['condition'] ) ? call_user_func( $value_callable ) : '';
					} elseif ( isset( $fact['field_type'] ) && 0 === strpos( $fact['field_type'], 'taxonomy:' ) ) {
						list($label, $taxonomy) = explode( ':', $fact['field_type'] );
						$fact_value             = wptravelengine_trip_terms( $trip_id, $taxonomy );
						$fact_class             = 'trip-facts-taxonomy';
					}
					if ( empty( $fact_value ) ) {
						continue;
					}
					?>
					<li>
						<span class="icon-holder"><?php echo wptravelengine_svg_by_fa_icon( $fact['field_icon'] ); ?></span>
						<label><?php echo esc_html( $fact['field_id'] ); ?></label>
						<div class="trip-facts-text <?php echo isset( $fact_class ) ? esc_attr( $fact_class ) : ''; ?>">
							<div class="value"><?php echo wp_kses( $fact_value, array( 'a' => array( 'href' => array() ) ) ); ?></div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<?php
