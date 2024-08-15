<?php
/**
 * Trip Cost Includes Widget Demo.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$attributes    = (object) $attributes;
$icon          = isset( $attributes->{'icon'} ) ? $attributes->{'icon'} : '';
$cost_includes = array(
	'Airport transfers.',
	'Accommodation.',
	'Meals.',
	'Internal flights',
);
$costincludes  = array();
?>

<div class="post-data cost">
	<div class="content">
		<?php
		foreach ( $cost_includes as $key => $include ) {
			$costincludes[] = '<li><i class="' . $icon['value'] . '"></i>' . esc_html( $include ) . '</li>';
		}
		?>
		<ul <?php echo empty( $icon['value'] ) ? 'id="include-result"' : 'class="custom-icon"'; ?>> <?php echo wp_kses_post( implode( '', $costincludes ) ); ?> </ul>
	</div>
</div>
<?php
