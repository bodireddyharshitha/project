<?php
/**
 * Content for Trips Block.
 */
wp_enqueue_script( 'wp-travel-engine' );
wp_enqueue_style( 'wp-travel-engine' );
wp_enqueue_style( 'wte-blocks-index' );
$results = array();
if ( ! empty( $attributes['filters']['tripsToDisplay'] ) ) {
	$results = get_posts(
		array(
			'post_type'      => WP_TRAVEL_ENGINE_POST_TYPE,
			'post__in'       => $attributes['filters']['tripsToDisplay'],
			'posts_per_page' => 100,
		)
	);
	if ( ! is_array( $results ) ) {
		return;
	}
}


$results = array_combine( array_column( $results, 'ID' ), $results );

$layout       = wte_array_get( $attributes, 'layout', 'grid' );
$column_desktop       = wte_array_get( $attributes, 'tripsCountPerRow', 3 );
$column_tablet       = wte_array_get( $attributes, 'tripsCountPerRow_tablet', 2 );
$column_mobile      = wte_array_get( $attributes, 'tripsCountPerRow_mobile', 1 );
$settings     = get_option( 'wp_travel_engine_settings', array() );
$dates_layout = ! empty( $settings['fsd_dates_layout'] ) ? $settings['fsd_dates_layout'] : 'dates_list';
$show_heading = wte_array_get( $attributes, 'showSectionHeading', false );

$show_section_description = wte_array_get( $attributes, 'showSectionDescription', false );

$viewMoreLink    = wte_array_get( $attributes, 'viewAllLink', '' ) != '' ? trailingslashit( $attributes['viewAllLink'] ) : trailingslashit( get_post_type_archive_link( WP_TRAVEL_ENGINE_POST_TYPE ) );
$slider_settings = array(
	'speed'         => wte_array_get( $attributes, 'slider.speed', 300 ),
	'effect'        => wte_array_get( $attributes, 'slider.effect', 'slide' ),
	'loop'          => wte_array_get( $attributes, 'slider.loop', 'yes' ) === 'yes',
	'wrapperClass'  => 'wpte-swiper-wrapper',
	'slidesPerView' => wte_array_get( $attributes, 'slider.slidesPerViewDesktop_mobile', 1 ),
	'spaceBetween'  => wte_array_get( $attributes, 'slider.spaceBetween', 30 ),
	'breakpoints'   => wte_array_get(
		$attributes,
		'slider.breakpoints',
		array(
			768  => array(
				'slidesPerView' => (int) wte_array_get( $attributes, 'slider.slidesPerViewDesktop_tablet', 2 ),
			),
			1025 => array(
				'slidesPerView' => (int) wte_array_get( $attributes, 'slider.slidesPerViewDesktop_laptop', 3 ),
			),
			1367 => array(
				'slidesPerView' => (int) wte_array_get( $attributes, 'slider.slidesPerViewDesktop', 3 ),
			),
		)
	),
);
if ( $layout == 'list' ) {
	$attributes['cardlayout'] = 1;
}
if ( wte_array_get( $attributes, 'slider.autoplay', 'yes' ) === 'yes' ) {
	$slider_settings['autoplay'] = array(
		'delay' => (int) wte_array_get( $attributes, 'slider.autoplaydelay', 3000 ),
	);
}
if ( $results && is_array( $results ) ) :
	echo '<div class="wp-block-wptravelengine-trips wpte-gblock-wrapper elementor-addon wpte-elementor-widget">';   ?>
	<div class="<?php echo esc_attr( "category-{$layout} wte-d-flex wpte-trip-list-wrapper" ); ?>
						   <?php
							if ( $layout != 'slider' ) {
								echo isset( $column_desktop ) && ! empty( $column_desktop ) ? esc_attr( " wte-col-{$column_desktop}" ) : '';
								echo isset( $column_tablet ) && ! empty( $column_tablet ) ? esc_attr( " columns-tablet-{$column_tablet}" ) : '';
								echo isset( $column_mobile ) && ! empty( $column_mobile ) ? esc_attr( " columns-mobile-{$column_mobile}" ) : '';
							} else {
								echo '';}
							?>
	">
	<?php
	( 'slider' === $layout ) && print( '<div class="wpte-swiper swiper" data-swiper-options="' . esc_attr( wp_json_encode( $slider_settings ) ) . '"><div class="wpte-swiper-wrapper swiper-wrapper">' );
			$position = 1;
	foreach ( $attributes['filters']['tripsToDisplay'] as $trip_id ) :
		if ( ! isset( $results[ $trip_id ] ) ) {
			continue;
		}
		$trip                = $results[ $trip_id ];
		$is_featured         = wte_is_trip_featured( $trip->ID );
		$meta                = \wte_trip_get_trip_rest_metadata( $trip->ID );
		$duration_mapping    = array(
			'days'   => array( __( 'Day', 'wptravelengine-elementor-widgets' ), __( 'Days', 'wptravelengine-elementor-widgets' ) ),
			'nights' => array( __( 'Night', 'wptravelengine-elementor-widgets' ), __( 'Nights', 'wptravelengine-elementor-widgets' ) ),
			'hours'  => array( __( 'Hour', 'wptravelengine-elementor-widgets' ), __( 'Hours', 'wptravelengine-elementor-widgets' ) ),
		);
		$results['duration'] = $duration_mapping;
		$args                = array( $attributes, $trip, $results );
		( 'slider' === $layout ) && print( '<div class="swiper-slide">' );
		include __DIR__ . '/layouts/layout-' . $attributes['cardlayout'] . '.php';
		( 'slider' === $layout ) && print( '</div>' );
		$position++;
			endforeach;
	if ( 'slider' === $layout ) :
		?>
			</div><!-- .wpte-swiper-wrapper -->
		</div><!-- .wpte-swiper -->
		<?php
		$arrow_class      = '';
		$prev_arrow_class = ! empty( $attributes['slider_prev_arrow_icon']['value'] ) ? 'custom-prev-arrow' : '';
		$next_arrow_class = ! empty( $attributes['slider_next_arrow_icon']['value'] ) ? ' custom-next-arrow' : '';
		$hidden_class_xl  = empty( $attributes['slider.arrow'] ) ? ' hide-xl' : '';
		$hidden_class_lg  = empty( $attributes['slider.arrow_laptop'] ) ? ' hide-lg' : '';
		$hidden_class_md  = empty( $attributes['slider.arrow_tablet'] ) ? ' hide-md' : '';
		$hidden_class_sm  = empty( $attributes['slider.arrow_mobile'] ) ? ' hide-sm' : '';
		$hidden_pg_xl     = empty( $attributes['slider.pagination'] ) ? ' hide-xl' : '';
		$hidden_pg_lg     = empty( $attributes['slider.pagination_laptop'] ) ? ' hide-lg' : '';
		$hidden_pg_md     = empty( $attributes['slider.pagination_tablet'] ) ? ' hide-md' : '';
		$hidden_pg_sm     = empty( $attributes['slider.pagination_mobile'] ) ? ' hide-sm' : '';
		?>
		<div class="wpte-swiper-navigation 
		<?php
		echo esc_attr( $prev_arrow_class );
		echo esc_attr( $next_arrow_class );
		echo esc_attr( $hidden_class_xl );
		echo esc_attr( $hidden_class_lg );
		echo esc_attr( $hidden_class_md );
		echo esc_attr( $hidden_class_sm );
		?>
		">
					<!-- If we need navigation buttons -->
					<div class="wpte-swiper-button-prev">
					<?php
					if ( ! empty( $attributes['slider_prev_arrow_icon'] ) && is_array( $attributes['slider_prev_arrow_icon'] ) && ! empty( $attributes['slider_prev_arrow_icon']['value'] ) && ! is_array( $attributes['slider_prev_arrow_icon']['value'] ) ) :
						?>
							<i class="<?php echo esc_attr( $attributes['slider_prev_arrow_icon']['value'] ); ?>"></i>
						<?php
						elseif ( is_array( $attributes['slider_prev_arrow_icon']['value'] ) && ! empty( $attributes['slider_prev_arrow_icon']['value']['url'] ) ) :
							\Elementor\Icons_Manager::render_icon( $attributes['slider_prev_arrow_icon'] );
						else :
							?>
							<?php
						endif;
						?>
					</div>
					<div class="wpte-swiper-button-next">
					<?php
					if ( ! empty( $attributes['slider_next_arrow_icon'] ) && is_array( $attributes['slider_next_arrow_icon'] ) && ! empty( $attributes['slider_next_arrow_icon']['value'] ) && ! is_array( $attributes['slider_next_arrow_icon']['value'] ) ) :
						?>
							<i class="<?php echo esc_attr( $attributes['slider_next_arrow_icon']['value'] ); ?>"></i>
						<?php
						elseif ( is_array( $attributes['slider_next_arrow_icon']['value'] ) && ! empty( $attributes['slider_next_arrow_icon']['value']['url'] ) ) :
							\Elementor\Icons_Manager::render_icon( $attributes['slider_next_arrow_icon'] );
						else :
							?>
							<?php
						endif;
						?>
				</div>
		</div><!-- .wpte-swiper-navigation -->
			<!-- If we need pagination -->
			<div class="wpte-swiper-pagination 
			<?php
			echo esc_attr( $hidden_pg_xl );
			echo esc_attr( $hidden_pg_lg );
			echo esc_attr( $hidden_pg_md );
			echo esc_attr( $hidden_pg_sm );
			?>
			"></div>
		<?php
	endif;
	echo '</div><!-- .category-{$layout} -->';

	if ( wte_array_get( $attributes, 'layoutFilters.showViewAll', false ) ) :
		?>
		<?php
endif;
	echo '</div>';
else :
	echo __('No trips available. Please add a new trip.','wptravelengine-elementor-widgets');
endif;
