<?php
/**
 * Render File for Trip Gallery block.
 * @var Render $render
 * @var Attributes $attributes_parser
 * @var string $wrapper_attributes
 * @package Wp_Travel_Engine
 * @since 5.9
 */

use WPTravelEngine\Blocks\SampleData;

global $wtetrip;

$gallery = [];
$gallery_images = [];
$slides = [];
$video_slides = [];
$global_settings = get_option( 'wp_travel_engine_settings', [] );

if ( $render->is_editor() ) {
    $gallery = SampleData::gallery();
    $gallery_images = [
        $gallery[0][1] => ['src' => $gallery[0][0]]
    ];
    $slides = [
        ['src' => $gallery[0][0]]
    ];
} else {
	$post_id = $_GET[ 'post' ] ?? $wtetrip->post->ID;
	if ( isset( $post_id ) ) {
		$post_type = get_post_type( $post_id );
	}
	$video_gallery = get_post_meta( $post_id, 'wpte_vid_gallery', true);
    $featured_image = !isset($global_settings['show_featured_image_in_gallery']) || 'yes' === $global_settings['show_featured_image_in_gallery'];
    $wpte_trip_images = get_post_meta($post_id, 'wpte_gallery_id', true);

	if ( is_array( $video_gallery ) ) {
		foreach ( $video_gallery as $gallery_item ) {
            $video_id = $gallery_item['id'];
            $video_url = 'youtube' === $gallery_item['type'] ? '//www.youtube.com/watch?v=' . $video_id : '//vimeo.com/' . $video_id;
            $slides[] = ['src' => $video_url];
        }
    }
	$video_slides = array_map(function( $slide ) {
		return array_map( 'htmlspecialchars', $slide );
	}, $slides);

	if ( is_array( $wpte_trip_images ) ) {
		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_style( 'owl-carousel' );
		unset( $wpte_trip_images[ 'enable' ] );
		$image_size = $attributes_parser->get( 'imageSize' ) ?? 'large';
		$gallery_images = array_map(
			function ($image) use ($image_size) {
				return ['src' => wp_get_attachment_image_url($image, $image_size )];
			},
			$wpte_trip_images
		);

		if ( $featured_image && has_post_thumbnail( $post_id ) ) {
            array_unshift($wpte_trip_images, get_post_thumbnail_id($post_id));
        }
        $gallery = [];
		foreach ( $wpte_trip_images as $image ) {
            $link = wp_get_attachment_image_src($image, $image_size );
            $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
            $image_alt = $image_alt ?: get_the_title($image);
			if (is_array( $link ) && !empty( $link ) ) {
				$gallery[] = [ $link[0], $image_alt ];
			}
        }
	}
	?>
    <script type="text/javascript">
        jQuery(function($) {
            $('.wte-trip-image-gal-popup-trigger').on('click', function() {
                jQuery.fn.fancybox && $.fancybox.open(<?php echo wp_json_encode( array_values( $gallery_images ) ); ?>, {
                    buttons: [
                        'zoom',
                        'slideShow',
                        'fullScreen',
                        'close',
                    ],
                })
            })
            $('.wte-trip-vidgal-popup-trigger').on('click', function() {
                jQuery.fn.fancybox && $.fancybox.open(<?php echo wp_json_encode( $video_slides ); ?>, {
                    buttons: [
                        'zoom',
                        'slideShow',
                        'fullScreen',
                        'close',
                    ],
                })
            })
        })
    </script>
	<?php
}
if( is_array( $gallery ) && count ( $gallery ) >= 1  ):?>
    <div <?php echo esc_attr( $attributes_parser->wrapper_attributes() ); ?>>
        <div
            class="wpte-gallery-wrapper <?php echo $attributes_parser->get( 'iconType' ) == 'rounded' ? 'owl-nav-rounded ' : 'owl-nav-square ';
			echo $attributes_parser->get( 'showDots' ) == true ? 'owl-dots-enabled ' : '';
			echo $attributes_parser->get( 'showNav' ) == true ? 'owl-nav-enabled ' : '';?>">
        <div class="wpte-trip-feat-img-gallery owl-carousel">
            <?php
            if( is_array( $gallery) ){
                foreach( $gallery as $imagedetail => $image ){
	                // Main div to display slider for sample as well as dynamic images.
                    ?>
                    <div class="item">
                        <img src="<?php echo esc_url($image[0]);?>"
                        alt="<?php echo esc_attr( $image[1] ); ?>"
                        loading="lazy" itemprop="image">
                    </div>
                    <?php
                }
            }

            if ( is_array( $gallery ) && $render->is_editor() ):
	            // Owl nav and dots code has been added just for the purpose of template page with sample image.
	            ?>
                <div class="owl-nav">
                    <button type="button" role="presentation" class="owl-prev">
                        <span aria-label="Previous">‹</span>
                    </button>
                    <button type="button" role="presentation" class="owl-next">
                        <span aria-label="Next">›</span>
                    </button>
                </div>
                <div class="owl-dots">
                    <div class="owl-dot"></div>
                    <div class="owl-dot active"></div>
                    <div class="owl-dot"></div>
                </div>
            <?php endif;?>
        </div>
        <?php
        if ( is_array( $gallery ) && count( $gallery ) >= 1 ):
	        //Div for popup button.
			wp_enqueue_style( 'jquery-fancy-box' );
			wp_enqueue_script( 'jquery-fancy-box' );
	        ?>
            <div
                class="wpte-gallery-container <?php echo esc_attr( $attributes_parser->get( 'buttonSize' ) . ' ' . $attributes_parser->get( 'buttonPlacement' ) ) ?>">
            <?php
            if ( $attributes_parser->get( 'imageGallery' ) ): ?>
            <span class="wp-travel-engine-image-gal-popup">
                <a
                    href="#wte-image-gallary-popup-<?php echo isset( $post_id ) && esc_attr( $post_id ); ?>"
                    class="wte-trip-image-gal-popup-trigger">
                    <?php echo esc_html__('Gallery', 'wp-travel-engine');?>
                </a>
            </span>
            <?php endif;?>
            <?php
            if ( $attributes_parser->get( 'videoGallery' ) && isset( $slides ) && count ( $slides ) >= 1): ?>
            <span class="wp-travel-engine-vid-gal-popup">
                <a class="wte-trip-vidgal-popup-trigger"
                data-galtarget="#wte-video-gallary-popup-<?php echo isset( $post_id ) && esc_attr( $post_id ); ?>"
                data-variable="<?php echo esc_attr( 'wtevideoGallery' ); ?>"
                href="#wte-video-gallary-popup-<?php echo isset( $post_id ) && esc_attr( $post_id ); ?>"
                >
                    <?php echo esc_html__('Video', 'wp-travel-engine');?>
                </a>
            </span>
            <?php endif;?>
        </div>
        <?php endif;?>
    </div>
</div>
<?php endif;?>
