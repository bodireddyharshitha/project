<?php
/**
 * Trip Cost Excludes Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$attributes = (object) $attributes;
$icon       = isset( $attributes->{'icon'} ) ? $attributes->{'icon'} : '';

global $post;

$post_meta             = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$cost_excludes_content = isset( $post_meta['cost']['cost_excludes'] ) ? $post_meta['cost']['cost_excludes'] : '';
$costexcludes          = array();
?>

<div class="post-data cost">
	<div class="content">
		<?php
		if ( ! empty( trim( $cost_excludes_content ) ) ) {
			$cost_excludes = preg_split( '/\r\n|[\r\n]/', $cost_excludes_content );
			foreach ( $cost_excludes as $key => $exclude ) {
				$costexcludes[] = '<li><i class="' . $icon['value'] . '"></i>' . esc_html( $exclude ) . '</li>';
			}
		}
		?>
		<ul <?php echo empty( $icon['value'] ) ? 'id="exclude-result"' : 'class="custom-icon"'; ?>> <?php echo wp_kses_post( implode( '', $costexcludes ) ); ?> </ul>
	</div>
</div>
