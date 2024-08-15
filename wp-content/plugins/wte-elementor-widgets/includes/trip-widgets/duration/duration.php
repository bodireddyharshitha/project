<?php

/**
 * Duration Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$post_meta = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );

$duration      = isset( $post_meta['trip_duration'] ) && '' !== $post_meta['trip_duration']
	? $post_meta['trip_duration'] : '';
$duration_unit = isset( $post_meta['trip_duration_unit'] ) && '' !== $post_meta['trip_duration_unit']
	? $post_meta['trip_duration_unit'] : 'days';

// Retrieve attributes from elementor.
$attributes    = (object) $attributes;
$display_style = isset( $attributes->{'displayStyle'} ) ? $attributes->{'displayStyle'} : 'vertically';
?>

<?php if ( ! empty( $duration ) ) : ?>
	<span class="wte-title-duration <?php echo esc_attr( $display_style ); ?>">
		<span class="duration">
			<?php echo esc_html( number_format_i18n( $duration ) ); ?>
		</span>
		<span class="days">
			<?php
			if ( 'days' === $duration_unit ) {
				echo wp_kses_post( sprintf( _nx( 'Day', 'Days', $duration, 'days', 'wptravelengine-elementor-widgets' ) ), 'wptravelengine-elementor-widgets' );
			}
			if ( 'hours' === $duration_unit ) {
				echo wp_kses_post( sprintf( _nx( 'Hour', 'Hours', $duration, 'hours', 'wptravelengine-elementor-widgets' ) ), 'wptravelengine-elementor-widgets' );
			}
			?>
		</span>
	</span>
<?php endif; ?>
<?php do_action( 'wp_travel_engine_header_hook' ); ?>
