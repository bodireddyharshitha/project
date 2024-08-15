<?php
/**
 * Trip Cost Excludes Widget Demo.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$attributes    = (object) $attributes;
$icon          = isset( $attributes->{'icon'} ) ? $attributes->{'icon'} : '';
$cost_excludes = array(
	'International flights',
	'Travel insurance',
	'Nepal entry visa',
	'Personal expenses',
);
$costexcludes  = array();
?>

<div class="post-data cost">
	<div class="content">
		<?php
		foreach ( $cost_excludes as $key => $exclude ) {
			$costexcludes[] = '<li><i class="' . $icon['value'] . '"></i>' . esc_html( $exclude ) . '</li>';
		}
		?>
		<ul <?php echo empty( $icon['value'] ) ? 'id="exclude-result"' : 'class:"custom-icon"'; ?>> <?php echo wp_kses_post( implode( '', $costexcludes ) ); ?> </ul>
	</div>
</div>
<?php
