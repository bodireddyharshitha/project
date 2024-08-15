<?php
/**
 *
 * This file is used to make changes to contents displayed by the WTE plugin as needed by the Theme
 *
 * @since 1.0.0
 * @package    Travel_Monster
 */

require get_template_directory() . '/inc/wte/single-trip/banner.php';

if( ! function_exists( 'travel_monster_get_currency_converter_template' ) ) :
/**
 * Get template for WTE currency converter dropdown
 */
function travel_monster_get_currency_converter_template(){
	$template = get_template_directory() . '/inc/wte/wte-currency-converter-public-display-alt.php';
	return $template;
}
endif;

/**
 * Add the filter only if WTE currency converter is activated
 */
if ( travel_monster_is_currency_converter_activated() ){
	add_filter( 'wte_cc_display_list', 'travel_monster_get_currency_converter_template' );
}

/**
 * Display archive description only
 */
add_filter( 'wte_trip_archive_description_page_header', function(){ 
	if ( is_archive( 'trip' ) ) return ; ?>
	<header class="tmp-page-header">
		<?php the_archive_description( '<div class="taxonomy-description" itemprop="description">', '</div>' ); ?>
	</header>
	<?php
});

/**
 * Remove search page title
 */
add_filter( 'wte-trip-search-page-title', function(){
	return '';
});

if( ! function_exists( 'wp_travel_engine_trip_reviews_filtered_template_path' ) ) :
function travel_monster_overall_average_custom_template_path(){
	$overall_average_template_path = get_template_directory() . '/wp-travel-engine/single-trip/trip-tabs/template-inner/';
	return $overall_average_template_path;
}
endif;
add_filter( 'wp_travel_engine_trip_reviews_filtered_template_path','travel_monster_overall_average_custom_template_path' );

/**
 * Making the booking form sticky for single trips
 *
 * @return void
 */
function travel_monster_adding_sticky_sidebar_form() {
	 // this class will help stick the trips tabs in the theme
	$default   = travel_monster_get_general_defaults();
	$ed_sticky = get_theme_mod( 'ed_sticky_booking_form', $default['ed_sticky_booking_form'] );
	$class     = '';
	if ( $ed_sticky && is_singular( 'trip' ) ) {
		$class = 'sticky_booking';
	}
	return esc_attr( $class );
}
add_filter( 'wpte_bf_outer_wrapper_classes', 'travel_monster_adding_sticky_sidebar_form' );