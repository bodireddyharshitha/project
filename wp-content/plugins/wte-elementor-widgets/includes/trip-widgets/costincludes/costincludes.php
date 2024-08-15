<?php
/**
 * Trip Cost Includes Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$attributes = (object) $attributes;
$icon       = isset( $attributes->{'icon'} ) ? $attributes->{'icon'} : '';

global $post;

$post_meta             = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$cost_includes_content = isset( $post_meta['cost']['cost_includes'] ) ? $post_meta['cost']['cost_includes'] : '';
$costincludes          = array();
?>

<div class="post-data cost">
	<div class="content">
		<?php
		if ( ! empty( trim( $cost_includes_content ) ) ) {
			$cost_includes = preg_split( '/\r\n|[\r\n]/', $cost_includes_content );
			foreach ( $cost_includes as $key => $include ) {
				$costincludes[] = '<li><i class="' . $icon['value'] . '"></i>' . esc_html( $include ) . '</li>';
			}
		}
		?>
		<ul <?php echo empty( $icon['value'] ) ? 'id="include-result"' : 'class="custom-icon"'; ?>> <?php echo wp_kses_post( implode( '', $costincludes ) ); ?> </ul>
	</div>
</div>
