<?php
/**
 * Travel Monster Single Trip Banner functions lists here
 *
 * @package Travel_Monster
 */

/*****************
* Banner Functions
*****************/

/**
 * Removing Gallery Slider from Trip Content
 *  
 * @package Wp_Travel_Engine
 */
$single_trip_hooks = WP_Travel_Engine_Template_Hooks::get_instance();
remove_action( 'wte_single_trip_content', array( $single_trip_hooks, 'display_single_trip_gallery' ), 10 );



if( ! function_exists( 'travel_monster_single_trip_feature_image' ) ) :
/**
 * Single Trip Feature Image
 *  
 * @package Travel_Monster
*/
function travel_monster_single_trip_feature_image(){ 
    global $post;
    $wpte_trip_images         = get_post_meta( $post->ID, 'wpte_gallery_id', true );
    $wp_travel_engine_setting = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
    $enable_vid_gal           = isset( $wp_travel_engine_setting['enable_video_gallery'] ) ? true : false;
	$wp_travel_engine_options = get_option('wp_travel_engine_settings');
    $displayFeatImage         = isset($wp_travel_engine_settings['show_featured_image_in_gallery']) ? $wp_travel_engine_settings['show_featured_image_in_gallery'] : 'yes';

    //enqueing the jquery
    wp_enqueue_script( 'jquery-fancy-box' );
    wp_enqueue_style( 'jquery-fancy-box' );
    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-carousel' );
    $owl_class  = isset( $wpte_trip_images['enable'] ) && $wpte_trip_images['enable'] == '1' ? 'tmp-trip-images owl-carousel' : '';

    $trip_class		  = '';

    if( !has_post_thumbnail() && !(isset( $wpte_trip_images['enable'] ) && $wpte_trip_images['enable'] == '1' 
        && count( $wpte_trip_images ) > 1) )
    $trip_class = " no-trip-post-img";
	

    ?>
    <div class="tmp-gallery<?php echo esc_attr( $trip_class); ?>">
        <div class="<?php echo esc_attr( $owl_class ); ?>">
            <?php 
            /**
             * @hooked travel_monster_content_start - 10
            */
            if( $displayFeatImage === 'yes') do_action( 'travel_monster_before_trip_entry_content' );
            if( isset( $wpte_trip_images['enable'] ) && $wpte_trip_images['enable'] == '1' ){
                if( count( $wpte_trip_images ) > 1 ){
                    unset( $wpte_trip_images['enable'] );
                    foreach ( $wpte_trip_images as $image ) {  
                        $url = wp_get_attachment_image_url( $image, 'travel-monster-single-layout-two' );
                        echo '<div>';
                        echo '<img class="temp-img-item" src="'. esc_url( $url ) . '">';
                        echo '</div>';
                    }
                }
            } ?>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($){ 
                var isRtl= $("body").hasClass("rtl");
                $('.tmp-trip-images').owlCarousel({
                    items: 1,
                    margin: 30,
                    autoplay: false,
                    rtl: isRtl,
                    loop: true,
                    nav: true,
                    dots: false,
                    autoplaySpeed: 800,
                    autoplayTimeout: 3000,
                });
            });
        </script>

        <div class="st-gal container">
            <?php 
                travel_monster_wte_gallery_override();
                if( $enable_vid_gal) echo do_shortcode( '[wte_video_gallery label="Video"]' ); 
            ?>
        </div>
        
    </div>
<?php 
}
endif;

if( ! function_exists( 'travel_monster_wte_gallery_override' ) ) :
/**
 * Single Trip Gallery Override
 * 
 * @link https://codepen.io/fancyapps/pen/wEVbdY?editors=1010
 * @package Travel_Monster
*/
function travel_monster_wte_gallery_override(){
    global $post;
	$social_icons              = new Travel_Monster_Social_Lists;
	$wpte_trip_images          = get_post_meta( $post->ID, 'wpte_gallery_id', true );
	$wp_travel_engine_settings = get_option('wp_travel_engine_settings');
	$displayFeatImage          = isset($wp_travel_engine_settings['show_featured_image_in_gallery']) ? $wp_travel_engine_settings['show_featured_image_in_gallery'] : 'yes';
	$image_ID                  = get_post_thumbnail_id();
    if( isset( $wpte_trip_images['enable'] ) && $wpte_trip_images['enable'] == '1' ){
        if( count( $wpte_trip_images ) > 1 ){
            unset( $wpte_trip_images['enable'] );
            if( $displayFeatImage === 'yes') array_unshift($wpte_trip_images, $image_ID );
            ?>
            <div class="st-gallery-wrapper">
                <button class="gallery-btn">
                    <?php echo wp_kses( $social_icons->travel_monster_lists_all_svgs( 'image' ), travel_monster_get_kses_extended_ruleset() ); ?>
                    <span><?php esc_html_e( 'Gallery', 'travel-monster' ); ?></span>                    
                </button>
                <script type="text/javascript">
                    jQuery(document).ready(function($){ 
                        $('.gallery-btn').on( 'click', function(){
                            $.fancybox.open([
                                <?php
                                    foreach ( $wpte_trip_images as $image ) { 
                                        $url = wp_get_attachment_image_url( $image, 'full' );
                                        echo "{ src : '". esc_url( $url ) ."', },";
                                    }
                                ?>                            
                            ],{
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
            </div>
            <?php 
        }
    }
}
endif;