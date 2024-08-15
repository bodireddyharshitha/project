<?php
/**
 * Carousel Widget Demo.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

?>
<?php
$demo_images = array(
	'demo1',
	'demo2',
	'demo3',
	'demo4',
);
?>
<div class="wpte-gallery-wrapper wte-elementor-widget">
	<div class="wpte-trip-feat-img-gallery owl-carousel">
		<?php foreach ( $demo_images as $image ) { ?>
			<div class="item">
				<img src="<?php echo esc_url( plugins_url( 'images/' . $image . '.png', dirname( __DIR__, 2 ) ) ); ?>">
			</div>
		<?php } ?>
	</div>
</div>
<?php
