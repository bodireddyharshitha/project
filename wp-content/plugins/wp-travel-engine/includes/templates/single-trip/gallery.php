<?php
/**
 * Trip gallery template.
 *
 * This template can be overridden by copying it to yourtheme/wp-travel-engine/single-trip/gallery.php.
 *
 * @package Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/templates
 * @since @release-version
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;

// Retrieve settings and gallery images.
$wptravelengine_trip_images     = get_post_meta( $post->ID, 'wpte_gallery_id', true );
$enable_image_gallery           = isset( $wptravelengine_trip_images['enable'] ) && '1' === $wptravelengine_trip_images['enable'];
$wptravelengine_settings        = get_option( 'wp_travel_engine_settings', array() );
$show_featured_image_in_gallery = ! isset( $wptravelengine_settings['show_featured_image_in_gallery'] ) || 'yes' === $wptravelengine_settings['show_featured_image_in_gallery'];
$gallery_autoplay               = $wptravelengine_settings['gallery_autoplay'] ?? 'no';
$hide_featured_image            = isset( $wptravelengine_settings['feat_img'] ) && '1' === $wptravelengine_settings['feat_img'];
$is_main_slider                 = $is_main_slider ?? false;
$wptravelengine_trip_settings   = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$enable_video_gallery           = $wptravelengine_trip_settings['enable_video_gallery'] ?? false;
?>
<div class="wpte-gallery-wrapper">
	<?php
	if ( isset( $wptravelengine_trip_images['enable'] ) && '1' === $wptravelengine_trip_images['enable'] ) {
		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_style( 'owl-carousel' );
		if ( ! empty( $wptravelengine_trip_images ) ) {
			unset( $wptravelengine_trip_images['enable'] );
			if ( $show_featured_image_in_gallery && has_post_thumbnail( $post->ID ) ) {
				$thumbnail_id = get_post_thumbnail_id( $post->ID );
				if ( ! in_array( $thumbnail_id, $wptravelengine_trip_images, false ) ) {
					array_unshift( $wptravelengine_trip_images, $thumbnail_id );
				}
			}
			if ( ! empty( $wptravelengine_trip_images ) ) :
				$gallery_class = 'wpte-trip-feat-img-gallery owl-carousel'
								. ( $is_main_slider ? ' single-trip-main-carousel' : '' )
								. ( $is_main_slider && 'yes' === $gallery_autoplay ? ' is-autoplay' : '' );
				$html          = '<div class="' . esc_attr( $gallery_class ) . '">';
				foreach ( $wptravelengine_trip_images as $image ) {
					if ( is_wp_error( $image ) ) {
						continue;
					}
					$gallery_image_size = apply_filters( 'wp_travel_engine_trip_single_gallery_image_size', 'large' );
					$image_url          = wp_get_attachment_image_src( $image, $gallery_image_size );
					$image_alt          = get_post_meta( $image, '_wp_attachment_image_alt', true ) ?? get_the_title( $image );
					if ( $image_url ) {
						$html .= '<div class="item" data-thumb="' . esc_url( $image_url[0] ) . '">';
						$html .= '<img alt="' . esc_attr( $image_alt ) . '" loading="lazy" itemprop="image" src="' . esc_url( $image_url[0] ) . '">';
						$html .= '</div>';
					}
				}
				$html .= '</div>';
				echo wp_kses_post( apply_filters( 'wpte_trip_gallery_images', $html, $wptravelengine_trip_images ) );
			endif;
		}
	} else {
		$default_image_url  = WP_TRAVEL_ENGINE_IMG_URL . '/public/css/images/single-trip-featured-img.jpg';
		$featured_image_url = has_post_thumbnail( $post->ID )
							? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'trip-single-size' )[0]
							: $default_image_url;
		$image_alt          = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) ?? get_the_title( $post->ID );
		if ( ! $hide_featured_image ) :
			?>
			<div class="wpte-trip-feat-img">
				<img alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy" itemprop="image" src="<?php echo esc_url( $featured_image_url ); ?>" alt="">
			</div>
			<?php
		endif;
	}
	if ( is_singular( 'trip' ) && ! isset( $args['related_query'] ) ) :
		wp_enqueue_style( 'jquery-fancy-box' );
		wp_enqueue_script( 'jquery-fancy-box' );
		if ( $enable_image_gallery || $enable_video_gallery ) :
			$random = wp_rand();
			?>
			<div class="wpte-gallery-container">
				<?php
				if ( $enable_image_gallery && count( $wptravelengine_trip_images ) >= 1 ) :
					if ( isset( $wptravelengine_trip_images['enable'] ) ) {
						unset( $wptravelengine_trip_images['enable'] );
					}
					$gallery_images = array_map(
						function ( $image ) {
							return is_wp_error( $image ) ? '' : array( 'src' => wp_get_attachment_image_url( $image, 'large' ) );
						},
						$wptravelengine_trip_images
					);
					$gallery_images = array_filter( $gallery_images, fn( $value ) => ! empty( $value['src'] ) );

					if ( ! empty( $gallery_images ) ) :
						?>
					<span class="wp-travel-engine-image-gal-popup">
						<a data-galtarget="#wte-image-gallary-popup-<?php echo esc_attr( $post->ID . $random ); ?>"
							data-variable="<?php echo esc_attr( 'wteimageGallery' . $random ); ?>"
							href="#wte-image-gallary-popup-<?php echo esc_attr( $post->ID . $random ); ?>"
							data-items="<?php echo esc_attr( wp_json_encode( array_values( $gallery_images ) ) ); ?>"
							class="wte-trip-image-gal-popup-trigger"><?php esc_html_e( 'Gallery', 'wp-travel-engine' ); ?>
						</a>
					</span>
					<?php endif; ?>
					<script type="text/javascript">
						document.addEventListener('DOMContentLoaded', function() {
							const galleryTriggers = document.querySelectorAll('.wte-trip-image-gal-popup-trigger');
							galleryTriggers.forEach(trigger => {
								trigger.addEventListener('click', () => {
									jQuery.fancybox.open(JSON.parse(trigger.getAttribute('data-items') || '[]'), {
										buttons: ['zoom', 'slideShow', 'fullScreen', 'close']
									});
								});
							});
						});
					</script>
					<?php
				endif;
				if ( $enable_video_gallery ) {
					echo do_shortcode( '[wte_video_gallery label="Video"]' );
				}
				?>
			</div>
			<?php
		endif;
	endif;
	?>
</div>
<?php
