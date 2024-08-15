<?php
/**
 * Demo file for the duration widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$attributes    = (object) $attributes;
$display_style = isset( $attributes->{'displayStyle'} ) ? $attributes->{'displayStyle'} : 'vertically';
?>
<div class="single-trip">
	<div class="elementor-widget-wte-duration">
		<header class="entry-header">
			<span class="wte-title-duration <?php echo esc_attr( $display_style ); ?>">
				<span class="duration">
					<?php esc_attr_e( '14', 'wptravelengine-elementor-widgets' ); ?>
				</span>
				<span class="days">
					<?php esc_attr_e( 'Days', 'wptravelengine-elementor-widgets' ); ?>
				</span>
			</span>
		</header>
	</div>
</div>
<?php
