<?php
/**
 * Carousel Widget Render.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

wp_enqueue_style( 'jquery-fancy-box' );
wp_enqueue_script( 'jquery-fancy-box' );
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_style( 'owl-carousel' );

global $post;
global $wp_query;

do_action( 'wp_travel_engine_feat_img_trip_galleries' );
$global_settings     = get_option( 'wp_travel_engine_settings', true );
$hide_featured_image = isset( $global_settings['feat_img'] ) && '1' === $global_settings['feat_img'];

$is_main_slider = isset( $is_main_slider ) && $is_main_slider;

$wpte_trip_images               = get_post_meta( $post->ID, 'wpte_gallery_id', true );
$global_settings                = get_option( 'wp_travel_engine_settings', array() );
$show_featured_image_in_gallery = ! isset( $global_settings['show_featured_image_in_gallery'] ) || 'yes' === $global_settings['show_featured_image_in_gallery'];

$hide_featured_image = isset( $global_settings['feat_img'] ) && '1' === $global_settings['feat_img'];

// Retrieve attributes value form elementor.
$attributes        = (object) $attributes;
$show_gallerypopup = isset( $attributes->{'showGalleryPopup'} ) ? $attributes->{'showGalleryPopup'} : true;
$show_videopopup   = isset( $attributes->{'showVideoPopup'} ) ? $attributes->{'showVideoPopup'} : true;
$popup_position    = isset( $attributes->{'popup_alignment'} ) ? $attributes->{'popup_alignment'} : 'bottom-left';
if ( ! empty( $wpte_trip_images ) ) :?>
<div class="wpte-gallery-wrapper wte-elementor-widget">
    <?php
    if ( isset( $wpte_trip_images['enable'] ) && '1' === $wpte_trip_images['enable'] ) {
        if ( isset( $wpte_trip_images ) && '' !== $wpte_trip_images ) {
            unset( $wpte_trip_images['enable'] );
            ?>
            <?php ob_start(); ?>
            <div class="wpte-trip-feat-img-gallery owl-carousel elementor-trip-main-carousel" >
                <?php
                if ( $show_featured_image_in_gallery && has_post_thumbnail( $post->ID ) ) {
                    array_unshift( $wpte_trip_images, get_post_thumbnail_id( $post->ID ) );
                }
                foreach ( $wpte_trip_images as $image ) {
                    $gallery_image_size = apply_filters( 'wp_travel_engine_trip_single_gallery_image_size', 'large' );
                    $_link              = wp_get_attachment_image_src( $image, $gallery_image_size );
                    $image_alt          = get_post_meta( $image, '_wp_attachment_image_alt', true );
                    if ( empty( $image_alt ) ) {
                        $image_alt = get_the_title( $image );
                    }
                    if ( isset( $_link[0] ) ) :
                        ?>
                        <div class="item" data-thumb="<?php echo esc_url( $_link[0] ); ?>">
                            <img alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy" itemprop="image" src="<?php echo esc_url( $_link[0] ); ?>">
                        </div>
                        <?php
                    endif;
                }
                ?>
            </div>
            <?php
            $html = ob_get_clean();
            echo wp_kses_post( apply_filters( 'wpte_trip_gallery_images', $html, $wpte_trip_images ) );
        }
    } else {
        $featured_image_url = WP_TRAVEL_ENGINE_IMG_URL . '/public/css/images/single-trip-featured-img.jpg';
        $image_alt          = get_the_title();
        if ( has_post_thumbnail( $post->ID ) ) {
            $trip_feat_img_size         = apply_filters( 'wp_travel_engine_single_trip_feat_img_size', 'trip-single-size' );
            list( $featured_image_url ) = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $trip_feat_img_size );
            $image_alt                  = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
            if ( empty( $image_alt ) ) {
                $image_alt = get_the_title( get_post_thumbnail_id( $post->ID ) );
            }
        }
        ?>
        <div class="wpte-trip-feat-img">
            <img alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy" itemprop="image" src="<?php echo esc_url( $featured_image_url ); ?>">
        </div>
        <?php
    }
    ?>
    <div class="wpte-gallery-container <?php echo esc_attr( $popup_position ); ?>">
        <?php
        global $post;
        $random                   = wp_rand();
        $wp_travel_engine_setting = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
        $wpte_trip_images         = get_post_meta( $post->ID, 'wpte_gallery_id', true );
        if ( isset( $wpte_trip_images['enable'] ) && '1' === $wpte_trip_images['enable'] ) {
            if ( count( $wpte_trip_images ) > 1 ) {
                unset( $wpte_trip_images['enable'] );
                ?>
                <?php if ( $show_gallerypopup ) : ?>
                <span class="wp-travel-engine-image-gal-popup">
                    <a
                        data-galtarget="#wte-image-gallary-popup-<?php echo esc_attr( $post->ID . $random ); ?>"
                        data-variable="<?php echo esc_attr( 'wteimageGallery' . $random ); ?>"
                        href="#wte-image-gallary-popup-<?php echo esc_attr( $post->ID . $random ); ?>"
                        class="wte-trip-image-gal-popup-trigger"><?php echo esc_html_e( 'Gallery', 'wptravelengine-elementor-widgets' ); ?>
                    </a>
                </span>
                <?php
                endif;
                $gallery_images = array_map(
                    function ( $image ) {
                        return array( 'src' => wp_get_attachment_image_url( $image, 'large' ) );
                    },
                    $wpte_trip_images
                );
                ?>
                <script type="text/javascript">
                    var <?php echo 'wtevideoGallery' . $random; ?> = <?php echo wp_json_encode( array_values( $gallery_images ) ); ?>;
                    jQuery(function($){
                        $('.wte-trip-image-gal-popup-trigger').on( 'click', function(){
                            jQuery.fn.fancybox && $.fancybox.open(<?php echo 'wtevideoGallery' . $random; ?>, {
                                buttons: [
                                    "zoom",
                                    "slideShow",
                                    "fullScreen",
                                    "close"
                                ]
                            });
                        });
                    });
                </script>
                <?php
            }
        }
        if ( isset( $wp_travel_engine_setting['enable_video_gallery'] ) && 'true' === $wp_travel_engine_setting['enable_video_gallery'] && $show_videopopup ) {
            global $post;
            $_post_id = is_object( $post ) && isset( $post->ID ) ? $post->ID : false;
            $atts     = '';
            $atts     = shortcode_atts(
                array(
                    'title'   => false,
                    'trip_id' => $_post_id,
                    'type'    => 'popup',
                    'label'   => esc_html__( 'Video', 'wptravelengine-elementor-widgets' ),
                ),
                $atts,
                'wte_video_gallery'
            );
            // Bail if no trip ID found.
            if ( ! $atts['trip_id'] ) {
                esc_html_e( 'No Trip ID supplied. Gallery Unavailable.', 'wptravelengine-elementor-widgets' );
                $output = ob_get_clean();
                return $output;
            }
            $video_gallery = get_post_meta( $atts['trip_id'], 'wpte_vid_gallery', true );
            if ( ! empty( $video_gallery ) ) {
                if ( 'popup' === $atts['type'] ) {
                    wp_enqueue_script( 'jquery-fancy-box' );
                    wp_enqueue_style( 'jquery-fancy-box' );
                    if ( $atts['title'] ) :
                        ?>
                            <h3><?php echo esc_html( $atts['title'] ); ?></h3>
                        <?php
                    endif;
                    if ( 'Video' === $atts['label'] ) {
                        $atts['label'] = __( 'Video', 'wptravelengine-elementor-widgets' );
                    }
                    if ( ! empty( $video_gallery ) ) :
                        $random = wp_rand();
                        ?>
                        <span class="wp-travel-engine-vid-gal-popup">
                            <a
                                data-galtarget="#wte-video-gallary-popup-<?php echo esc_attr( $atts['trip_id'] . $random ); ?>"
                                data-variable="<?php echo esc_attr( 'wtevideoGallery' . $random ); ?>"
                                href="#wte-video-gallary-popup-<?php echo esc_attr( $atts['trip_id'] . $random ); ?>"
                                class="wte-trip-vidgal-popup-trigger"><?php echo esc_html( $atts['label'] ); ?></a>
                        </span>
                        <?php
                        $slides = array();
                        foreach ( $video_gallery as $key => $gallery_item ) :
                            $video_id  = $gallery_item['id'];
                            $video_url = 'youtube' === $gallery_item['type'] ? '//www.youtube.com/watch?v=' . $video_id : '//vimeo.com/' . $video_id;
                            $slides[]  = array( 'src' => $video_url );
                        endforeach;
                        ?>
                        <script type="text/javascript">
                            var <?php echo 'wtevideoGallery' . $random; ?> = <?php echo wp_json_encode( $slides ); ?>;
                            jQuery(function($){
                                $('.wte-trip-vidgal-popup-trigger').on( 'click', function(){
                                    jQuery.fn.fancybox && $.fancybox.open(<?php echo 'wtevideoGallery' . $random; ?>, {
                                        buttons: [
                                            "zoom",
                                            "slideShow",
                                            "fullScreen",
                                            "close"
                                        ]
                                    });
                                });
                            });
                        </script>
                        <?php
                    endif;
                } elseif ( 'slider' === $atts['type'] ) {
                    wte_get_template(
                        'single-trip/gallery-video-slider.php',
                        array(
                            'label'   => $atts['label'],
                            'title'   => $atts['title'],
                            'trip_id' => $atts['trip_id'],
                            'gallery' => $video_gallery,
                        )
                    );
                }
            }
        }
        ?>
    </div>
</div>
<?php
endif;
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>
