<?php
/**
 * Content for Terms Listing.
 *
 * @package wp-travel-engine/blocks
 */

/**
 * Template vars: $attribtues
 */
wp_enqueue_script( 'wp-travel-engine' );
wp_enqueue_style( 'wp-travel-engine' );
wp_enqueue_style( 'wte-blocks-index' );
$results = array();
if ( ! empty( $attributes['listItems'] ) ) {
	$results = wte_get_terms_by_id(
		$attributes['taxonomy'],
		array(
			'taxonomy'   => $attributes['taxonomy'],
			// 'include'    => $attributes['listItems'],
			'number'     => 100,
			'hide_empty' => true,
		)
	);
	if ( ! is_array( $results ) ) {
		return;
	}
}
$taxonomies_slugs = array(
	'trip_types' => 'trip-types',
);

$taxonomy_slug            = isset( $taxonomies_slugs[ $attributes['taxonomy'] ] ) ? $taxonomies_slugs[ $attributes['taxonomy'] ] : $attributes['taxonomy'];
$show_heading             = wte_array_get( $attributes, 'showTitle', false );
$show_section_description = wte_array_get( $attributes, 'showSubtitle', false );
$view_all_link            = wte_array_get( $attributes, 'viewAllLink', '' ) != '' ? trailingslashit( $attributes['viewAllLink'] ) : home_url( $taxonomy_slug );
$layout                   = wte_array_get( $attributes, 'layout', 'grid' );
$slider_settings          = array(
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
if ( wte_array_get( $attributes, 'slider.autoplay', 'yes' ) === 'yes' ) {
	$slider_settings['autoplay'] = array(
		'delay' => (int) wte_array_get( $attributes, 'slider.autoplaydelay', 3000 ),
	);
}
$attributes = (object) $attributes;
$width      = $attributes->{'cardlayout'} == 2 ? 'full-width' : '';
$arrow_position = isset( $attributes->{'slider_arrow_position'} ) ? $attributes->{'slider_arrow_position'} : 'default';
if ( $results && is_array( $results ) ) :
	?>
<div class="wp-block-wptravelengine wpte-gblock-wrapper wpte-elementor-widget">
	<div class="<?php echo esc_attr( "category-{$layout} wte-d-flex wte-layout-{$layout} wpte-trip-list-wrapper {$arrow_position}" ); ?> <?php
	if ( $layout != 'slider' ) {
		echo isset( $attributes->{'itemsPerRow'} ) && ! empty( $attributes->{'itemsPerRow'} ) ? esc_attr( " wte-col-{$attributes->{'itemsPerRow'}} {$width}") : '';
		echo isset( $attributes->{'itemsPerRow_tablet'} ) && ! empty( $attributes->{'itemsPerRow_tablet'} ) ? esc_attr( " columns-tablet-{$attributes->{'itemsPerRow_tablet'}} {$width}" ) : '';
		echo isset( $attributes->{'itemsPerRow_mobile'} ) && ! empty( $attributes->{'itemsPerRow_mobile'} ) ? esc_attr( " columns-mobile-{$attributes->{'itemsPerRow_mobile'}} {$width}" ) : '';
	} else {
		echo '';}
	?>
	">
	<?php
		( 'slider' === $layout ) && print( '<div class="wpte-swiper swiper" data-swiper-options="' . esc_attr( wp_json_encode( $slider_settings ) ) . '"><div class="wpte-swiper-wrapper swiper-wrapper">' );
		$position = 1;
	foreach ( $attributes->{'listItems'} as $term_id ) :
		if ( ! isset( $results[ (int) $term_id ] ) ) {
			continue;
		}
		$args = array( $attributes, $results[ $term_id ], $results );
		( 'slider' === $layout ) && print( '<div class="swiper-slide">' );

		include __DIR__ . "/layouts/layout-{$attributes->cardlayout}.php";
		( 'slider' === $layout ) && print( '</div>' );
		$position++;

		endforeach;
	if ( 'slider' === $layout ) :
		$attributes = (array) $attributes;
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
	?>
	</div>
	<?php if ( wte_array_get( (array) $attributes, 'layoutFilters.showViewAll', false ) ) : ?>
		<?php
	endif;
	?>
</div>
	<?php
else :
	echo 'No trips available. Please add a new trip.';
endif;
