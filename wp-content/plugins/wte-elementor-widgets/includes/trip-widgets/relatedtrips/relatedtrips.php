<?php
/**
 * Related Trips Widget Layout.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$attributes              = (object) $attributes;
$wte_related_trips_count = ! empty( $attributes->{'tripsCount'} ) ? $attributes->{'tripsCount'} : 3;
$layout                  = ! empty( $attributes->{'layout'} ) ? $attributes->{'layout'} : 'grid';
$column                  = ! empty( $attributes->{'tripsCountPerRow'} ) ? $attributes->{'tripsCountPerRow'} : 3;

// go two level up to get the path of the template.
$template_path = dirname( dirname( __DIR__ ) ) . '/blocks/trips';

/**
 * Get related trips.
 *
 * @param array $attributes
 * @return array
 */
if ( isset( $attributes->{'listby'} ) ) {
	$terms      = get_the_terms( $post->ID, $attributes->{'listby'} );
	$query_args = array(
		'post_type'      => WP_TRAVEL_ENGINE_POST_TYPE,
		'posts_per_page' => $attributes->{'tripsCount'},
		'post__not_in'   => array( $post->ID ),
		'fields'         => 'ids',
		'post_status'    => 'publish',
		'tax_query'      => array(
			array(
				'taxonomy' => $attributes->{'listby'},
				'field'    => 'term_id',
				'terms'    => array_map(
					function ( $term ) {
						return $term->term_id;
					},
					is_array( $terms ) ? $terms : array()
				),
			),
		),
	);
	if ( 'byid' === $attributes->{'listby'} ) {
		$attributes->{'filters'}['tripsToDisplay'] = $attributes->{'tripsToDisplay'};
	} else {
		$trips = get_posts( $query_args );

		if ( is_array( $trips ) ) {
			$attributes->{'filters'}['tripsToDisplay'] = $trips;
		} else {
			$attributes->{'filters'}['tripsToDisplay'] = array();
		}
	}
}

foreach ( array( 'showFeaturedRibbon', 'showDescription', 'showFeaturedImage', 'showTitle', 'showPrice', 'showStrikedPrice', 'showDuration', 'showLocation', 'showReviews', 'showDiscount', 'showActivities', 'showTripType', 'showGroupSize', 'showTripAvailableTime', 'showViewMoreButton', 'showViewAll' ) as $subkey ) {
	if ( isset( $attributes->{ "{$subkey}" } ) ) {
		$attributes->{'layoutFilters'}[ $subkey ] = $attributes->{ "{$subkey}" };
	}
}

foreach ( array( 'listby', 'tripsCount' ) as $subkey ) {
	if ( isset( $attributes->{ "{$subkey}" } ) ) {
		$attributes->{'filters'}[ $subkey ] = $attributes->{ "{$subkey}" };
	}
}

foreach ( array( 'slider.autoplay', 'slider.autoplaydelay', 'slider.loop', 'slider.speed', 'slider.slidesPerViewDesktop', 'slider.slidesPerViewDesktop_laptop', 'slider.slidesPerViewDesktop_tablet', 'slider.slidesPerViewDesktop_mobile', 'slider.spaceBetween' ) as $subkey ) {
	if ( isset( $attributes->{ $subkey } ) ) {
		$attributes->{'slider'}[ str_replace( 'slider.', '', $subkey ) ] = $attributes->{ $subkey };
	}
}

/**
 * Content for Trips Block.
 */
$results = array();
if ( ! empty( $attributes->{'filters'}['tripsToDisplay'] ) ) {
	$results = get_posts(
		array(
			'post_type'      => WP_TRAVEL_ENGINE_POST_TYPE,
			'post__in'       => $attributes->{'filters'}['tripsToDisplay'],
			'posts_per_page' => 100,
		)
	);
	if ( ! is_array( $results ) ) {
		return;
	}
}

$results                  = array_combine( array_column( $results, 'ID' ), $results );
$settings                 = get_option( 'wp_travel_engine_settings', array() );
$dates_layout             = ! empty( $settings['fsd_dates_layout'] ) ? $settings['fsd_dates_layout'] : 'dates_list';
$show_heading             = ! empty( $attributes->{'showSectionHeading'} ) ? $attributes->{'showSectionHeading'} : false;
$show_section_description = ! empty( $attributes->{'showSectionDescription'} ) ? $attributes->{'showSectionDescription'} : false;
$view_more_link           = ! empty( $attributes->{'viewAllLink'} ) ? $attributes->{'viewAllLink'} : trailingslashit( get_post_type_archive_link( WP_TRAVEL_ENGINE_POST_TYPE ) );
$slider_settings          = array(
	'speed'         => ! empty( $attributes->{'slider'}['speed'] ) ? $attributes->{'slider'}['speed'] : 300,
	'effect'        => ! empty( $attributes->{'slider'}['effect'] ) ? $attributes->{'slider'}['effect'] : 'slide',
	'loop'          => ! empty( $attributes->{'slider'}['loop'] ) ? $attributes->{'slider'}['loop'] : 'yes',
	'wrapperClass'  => 'wpte-swiper-wrapper',
	'slidesPerView' => ! empty( $attributes->{'slider'}['slidesPerViewDesktop_mobile'] ) ? $attributes->{'slider'}['slidesPerViewDesktop_mobile'] : 1,
	'spaceBetween'  => ! empty( $attributes->{'slider'}['spaceBetween'] ) ? $attributes->{'slider'}['spaceBetween'] : 30,
	'breakpoints'   => ! empty( $attributes->{'slider'}['breakpoints'] ) ? $attributes->{'slider'}['breakpoints'] : array(
		'768'  => array(
			'slidesPerView' => ! empty( $attributes->{'slider'}['slidesPerViewDesktop_tablet'] ) ? $attributes->{'slider'}['slidesPerViewDesktop_tablet'] : 2,
		),
		'1024' => array(
			'slidesPerView' => ! empty( $attributes->{'slider'}['slidesPerViewDesktop_laptop'] ) ? $attributes->{'slider'}['slidesPerViewDesktop_laptop'] : 3,
		),
		'1367' => array(
			'slidesPerView' => ! empty( $attributes->{'slider'}['slidesPerViewDesktop'] ) ? $attributes->{'slider'}['slidesPerViewDesktop'] : 3,
		),
	),
);
if ( 'list' === $layout ) {
	$attributes->{'cardlayout'} = 1;
}
if ( ! empty( $attributes->{'slider'}['autoplay'] ) ? $attributes->{'slider'}['autoplay'] : 'yes' ) {
	$slider_settings['autoplay'] = array(
		'delay' => (int) ! empty( $attributes->{'slider'}['autoplaydelay'] ) ? $attributes->{'slider'}['autoplaydelay'] : 3000,
	);
}
if ( $results && is_array( $results ) ) :
	echo '<div class="wp-block-wptravelengine-trips wpte-gblock-wrapper elementor-addon wpte-elementor-widget">';
	?>
	<div class="<?php echo esc_attr( "category-{$layout} wte-d-flex wpte-trip-list-wrapper" ); ?>
	<?php
	if ( 'slider' !== $layout ) {
		echo esc_attr( " wte-col-{$column} columns-{$column}" );
	} else {
		echo '';}
	?>
	">
	<?php
	( 'slider' === $layout ) && print( '<div class="wpte-swiper swiper" data-swiper-options="' . esc_attr( wp_json_encode( $slider_settings ) ) . '"><div class="wpte-swiper-wrapper swiper-wrapper">' );
	$position = 1;
	foreach ( $attributes->{'filters'}['tripsToDisplay'] as $trip_id ) :
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
		// convert $attributes object to array.
		$arguments = json_decode( wp_json_encode( $attributes ), true );
		$args      = array( $arguments, $trip, $results );
		( 'slider' === $layout ) && print( '<div class="swiper-slide">' );
		include $template_path . '/layouts/layout-' . $attributes->{'cardlayout'} . '.php';
		( 'slider' === $layout ) && print( '</div>' );
		++$position;
	endforeach;
	if ( 'slider' === $layout ) :
		?>
			</div><!-- .wpte-swiper-wrapper -->
		</div><!-- .wpte-swiper -->
		<?php
		$arrow_class      = '';
		$prev_arrow_class = ! empty( $attributes->{'slider_prev_arrow_icon'}['value'] ) ? 'custom-prev-arrow' : '';
		$next_arrow_class = ! empty( $attributes->{'slider_next_arrow_icon'}['value'] ) ? ' custom-next-arrow' : '';
		$hidden_class_xl  = empty( $attributes->{'slider.arrow'} ) ? ' hide-xl' : '';
		$hidden_class_lg  = empty( $attributes->{'slider'}['arrow_laptop'] ) ? ' hide-lg' : '';
		$hidden_class_md  = empty( $attributes->{'slider'}['arrow_tablet'] ) ? ' hide-md' : '';
		$hidden_class_sm  = empty( $attributes->{'slider'}['arrow_mobile'] ) ? ' hide-sm' : '';
		$hidden_pg_xl     = empty( $attributes->{'slider'}['pagination'] ) ? ' hide-xl' : '';
		$hidden_pg_lg     = empty( $attributes->{'slider'}['pagination_laptop'] ) ? ' hide-lg' : '';
		$hidden_pg_md     = empty( $attributes->{'slider'}['pagination_tablet'] ) ? ' hide-md' : '';
		$hidden_pg_sm     = empty( $attributes->{'slider'}['pagination_mobile'] ) ? ' hide-sm' : '';
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
			if ( ! empty( $attributes->{'slider_prev_arrow_icon'} ) && is_array( $attributes->{'slider_prev_arrow_icon'} ) && ! empty( $attributes->{'slider_prev_arrow_icon'}['value'] ) && ! is_array( $attributes->{'slider_prev_arrow_icon'}['value'] ) ) :
				?>
					<i class="<?php echo esc_attr( $attributes->{'slider_prev_arrow_icon'}['value'] ); ?>"></i>
				<?php
				elseif ( is_array( $attributes->{'slider_prev_arrow_icon'}['value'] ) && ! empty( $attributes->{'slider_prev_arrow_icon'}['value']['url'] ) ) :
					\Elementor\Icons_Manager::render_icon( $attributes->{'slider_prev_arrow_icon'} );
				else :
					?>
					<?php
				endif;
				?>
			</div>
			<div class="wpte-swiper-button-next">
			<?php
			if ( ! empty( $attributes->{'slider_next_arrow_icon'} ) && is_array( $attributes->{'slider_next_arrow_icon'} ) && ! empty( $attributes->{'slider_next_arrow_icon'}['value'] ) && ! is_array( $attributes->{'slider_next_arrow_icon'}['value'] ) ) :
				?>
					<i class="<?php echo esc_attr( $attributes->{'slider_next_arrow_icon'}['value'] ); ?>"></i>
				<?php
				elseif ( is_array( $attributes->{'slider_next_arrow_icon'}['value'] ) && ! empty( $attributes->{'slider_next_arrow_icon'}['value']['url'] ) ) :
					\Elementor\Icons_Manager::render_icon( $attributes->{'slider_next_arrow_icon'} );
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
	if( $is_elementor_editor_page ) echo __( 'No trips available. Please add a new trip.', 'wptravelengine-elementor-widgets' );
endif;
