<?php
/**
 * Trip - Title Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$trip_title = get_the_title( $post->ID );

$attributes = (object) $attributes;
$html_tag   = isset( $attributes->{'html_tag'} ) ? $attributes->{'html_tag'} : 'h2';
?>
<header class="trip-header">
	<?php
		// translators: %1$s: html tag, %2$s: trip title.
		printf( '<%1$s class="trip-title">%2$s</%1$s>', esc_html( $html_tag ), esc_html( $trip_title ) );
	?>
</header>
<?php
