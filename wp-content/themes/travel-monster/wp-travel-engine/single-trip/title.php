<?php
/**
 * Single Trip header
 * 
 * This template can be overridden by copying it to yourtheme/wp-travel-engine/single-trip/title.php.
 * 
 * @package Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/templates
 * @since 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( class_exists( 'Wte_Trip_Review_Init' ) ) {
    $idNum         = (!isset($id)) || (isset($id) && empty($id))? get_the_ID() : $id;
    $review_obj    = new Wte_Trip_Review_Init();
    $comment_datas = $review_obj->pull_comment_data( $idNum );
}

$wp_travel_engine_setting = get_post_meta( get_the_ID(), 'wp_travel_engine_setting', true );
?>
<header class="entry-header<?php echo isset($show_trip_duration_days_nights) && $show_trip_duration_days_nights =='yes' ? esc_attr( ' has-night' ) : ''; ?>">
    <h1 class="entry-title" itemprop="name">
        <?php the_title(); ?>
    </h1>
    <span class="wte-title-duration">
        <?php if ( ! empty( $duration ) ) { ?>
            <span class="duration">
                <?php echo esc_html( number_format_i18n( $duration ) ); ?>
            </span>
            <span class="days">
                <?php
                    if ( 'days' === $duration_unit ) printf( esc_html( _nx( 'Day', 'Days', $duration, 'days', 'travel-monster' ) ) );
                    if ( 'hours' === $duration_unit ) printf( esc_html( _nx( 'Hour', 'Hours', $duration, 'hours', 'travel-monster' ) ) );
                ?>				
        </span>		
        <?php } ?>
    </span>
    <span class="wte-title-duration wte-duration-night">
		<?php if( isset($show_trip_duration_days_nights) && $show_trip_duration_days_nights =='yes' && ! empty( $nights ) ) { ?>			
				<span class="duration">
					<?php echo esc_html( number_format_i18n( $nights ) ); ?>
				</span>
				<span class="days">				
					<?php printf( esc_html( _nx( 'Night', 'Nights', $nights , 'nights', 'travel-monster' ) ) ); ?>
				</span>			
			<?php } ?>
	</span>
   <?php if ( ! empty( $comment_datas ) ){ ?>
        <div class="average-rating">
            <?php
            $icon_type               = '';
            $icon_fill_color         = '#F39C12'; ?>
            <div
                class="agg-rating trip-review-stars <?php echo ! empty( $review_icon_type ) ? 'svg-trip-adv' : 'trip-review-default'; ?>"
                data-icon-type='<?php echo esc_attr( $icon_type ); ?>' data-rating-value="<?php echo esc_attr( $comment_datas['aggregate'] ); ?>"
                data-rateyo-rated-fill="<?php echo esc_attr( $icon_fill_color ); ?>"
                data-rateyo-read-only="true"
            >
            </div>
            <a class="tmp-rating-text" href="#tmp-overall-rating">
                <?php echo esc_html( $comment_datas['i'] );
                if( $comment_datas['i']=="1" ) { 
                    echo esc_html( ' Review','travel-monster' ); 
                }else{
                    echo esc_html( ' Reviews','travel-monster' ); 
                } ?>
            </a>
        </div>
	<?php } ?>
    <?php do_action('wp_travel_engine_header_hook'); ?>
</header>
<!-- ./entry-header -->
<?php
