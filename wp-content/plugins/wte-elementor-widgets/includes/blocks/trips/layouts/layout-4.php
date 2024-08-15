<?php
namespace WPTRAVELENGINEEB;

/**
 * Trip Card Layout - 4
 */
list( $settings, $trip, $results ) = $args;

$is_featured       = wte_is_trip_featured( $trip->ID );
$meta              = \wte_trip_get_trip_rest_metadata( $trip->ID );
$image_size        = wte_array_get( $settings, 'image_size', false );
$image_custom_size = wte_array_get( $settings, 'image_custom_size', false );
$image_size        = 'custom' === $image_size && $image_custom_size ? Widget::wte_get_custom_image_size( $image_custom_size ) : $image_size;
$meta_dir          = wte_array_get( $settings, 'meta_direction', false );
?>
<div class="wpte-trip-single wpte-layout-4">
	<div class="wpte-inner-container">
		<div class="wpte-trip-image-wrap">
			<?php if ( wte_array_get( $settings, 'layoutFilters.showDiscount', false ) && $meta->discount_percent ) : ?>
			<div class="discount-text-wrap">
				<span class="discount-percent"><?php echo sprintf( __( '%1$s%% Off', 'wptravelengine-elementor-widgets' ), (int) $meta->discount_percent ); ?></span>
			</div>
			<?php endif; ?>
			<?php if ( wte_array_get( $settings, 'layoutFilters.showFeaturedRibbon', false ) && $is_featured ) : ?>
			<div class="featured-text-wrap">
				<span class="featured-icon">
					<svg
						width="14"
						height="14"
						viewBox="0 0 14 14"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
					>
						<g clip-path="url(#clip0)">
							<path
								d="M13.8081 4.12308C13.6427 3.98191 13.4093 3.95216 13.2137 4.04737L10.2211 5.50424L7.41314 2.26669C7.30929 2.14692 7.15855 2.07812 7.00001 2.07812C6.84147 2.07812 6.69075 2.14692 6.58687 2.26669L3.77888 5.50421L0.786276 4.04734C0.590686 3.95216 0.357334 3.98188 0.191904 4.12305C0.0264748 4.26423 -0.0395877 4.49004 0.0236584 4.69812L2.10178 11.5341C2.17181 11.7644 2.38424 11.9219 2.62501 11.9219H11.375C11.6157 11.9219 11.8282 11.7644 11.8982 11.5341L13.9763 4.69815C14.0396 4.49006 13.9735 4.26426 13.8081 4.12308ZM10.9696 10.8281H3.03032L1.43479 5.57955L3.67758 6.67141C3.90026 6.7798 4.16785 6.72506 4.33008 6.53803L7.00001 3.45967L9.66996 6.53803C9.83216 6.72509 10.0998 6.77977 10.3224 6.67141L12.5652 5.57955L10.9696 10.8281Z"
								fill="white"
							/>
						</g>
						<defs>
							<clipPath id="clip0">
								<rect
									width="14"
									height="14"
									fill="white"
								/>
							</clipPath>
						</defs>
					</svg>
				</span>
				<span class="featured-text"><?php esc_html_e( 'Featured', 'wptravelengine-elementor-widgets' ); ?></span>
			</div>
			<?php endif; ?>
			<?php if ( wte_array_get( $settings, 'layoutFilters.showFeaturedImage', true ) ) : ?>
			<figure class="thumbnail">
				<a href="<?php echo esc_url( get_the_permalink( $trip ) ); ?>">
					<?php
					$size = apply_filters( 'wp_travel_engine_archive_trip_feat_img_size', 'destination-thumb-trip-size' );
					if ( has_post_thumbnail( $trip ) ) :
						echo get_the_post_thumbnail( $trip, $image_size );
					endif;
					?>
				</a>
			</figure>
			<?php endif; ?>
		</div>
		<div class="wpte-trip-details-wrap">
			<div class="wpte-trip-header-wrap">
				<?php if ( wte_array_get( $settings, 'layoutFilters.showTitle', true ) ) : ?>
				<div class="wpte-trip-title-wrap">
					<h2 class="wpte-trip-title">
						<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $trip ) ); ?>"><?php echo esc_html( $trip->post_title ); ?></a>
					</h2>
				</div>
				<?php endif; ?>
				<?php
				if ( wte_array_get( $settings, 'layoutFilters.showReviews', false ) ) :
					echo \wte_get_the_trip_reviews( $trip->ID );
				endif;
				?>
			</div>
			<div class="wpte-trip_meta-container">
				<div class="wpte-trip-meta-list <?php echo $meta_dir === 'vertical' ? esc_attr( 'wpte-dir-vertical' ) : esc_attr( 'wpte-dir-horizontal' ); ?>">
					<?php
					if ( wte_array_get( $settings, 'layoutFilters.showLocation', false ) ) :
						$terms = wte_get_the_tax_term_list( $trip->ID, 'destination', '', ', ', '' );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
							?>
							<span class="wpte-trip-meta wpte-trip-destination">
								<span class="wpte-icon-map-marker"></span>
								<span><?php echo wp_kses_post( $terms ); ?></span>
							</span>
							<?php
						endif;
					endif;
					?>
					<?php
					if ( wte_array_get( $settings, 'layoutFilters.showDuration', false ) ) :
						$trip_duration_unit   = $meta->duration['duration_unit'];
						$trip_duration_nights = $meta->duration['nights'];
						$set_duration_types   = $settings['durationType'];
						$duration_label       = array();
						?>
														
						<span class="wpte-trip-meta wpte-trip-duration">
							<?php if ( $meta->duration['days'] != 0 ) : ?>
							<span class="wpte-icon-clock"></span>
								<span>
									<?php
									if ( ( 'days' !== $trip_duration_unit ) || ( 'days' === $trip_duration_unit && $meta->duration['days'] && in_array( $set_duration_types, array( 'both', 'days' ) ) ) ) {
										$duration_label[] = sprintf(
											_nx( '%1$d %2$s', '%1$d %3$s', (int) $meta->duration['days'], 'trip duration', 'wptravelengine-elementor-widgets' ),
											(int) $meta->duration['days'],
											$results['duration'][ $trip_duration_unit ][0],
											$results['duration'][ $trip_duration_unit ][1],
										);
									}
									if ( 'days' === $trip_duration_unit && $trip_duration_nights && in_array( $set_duration_types, array( 'both', 'nights' ) ) ) {
										$duration_label[] = sprintf( _nx( '%1$d Night', '%1$d Nights', (int) $trip_duration_nights, 'trip duration night', 'wptravelengine-elementor-widgets' ), (int) $trip_duration_nights );
									}
									?>
										<?php echo esc_html( implode( ' - ', $duration_label ) ); ?>
								</span>
								<?php endif; ?>
							</span>
						<?php
					endif;
					?>

					<?php if ( wte_array_get( $settings, 'layoutFilters.showGroupSize', false ) && (int) $meta->min_pax ) : ?>
					<span class="wpte-trip-meta wpte-trip-pax">
						<span class="wpte-icon-users"></span>
						<?php printf( __( '%s People', 'wptravelengine-elementor-widgets' ), (int) $meta->max_pax ? esc_html( $meta->min_pax . '-' . $meta->max_pax ) : $meta->min_pax ); ?>
					</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="wpte-trip-budget-wrap justify-content-between align-items-center">
				<?php if ( wte_array_get( $settings, 'layoutFilters.showPrice', true ) ) : ?>
				<div class="wpte-trip-price-wrap">
					<?php if ( wte_array_get( $settings, 'layoutFilters.showStrikedPrice', true ) && $meta->has_sale ) : ?>
						<del><?php echo wte_esc_price( wte_get_formated_price_html( $meta->price ) ); ?></del>
					<?php endif; ?>
					<ins><?php echo wte_esc_price( wte_get_formated_price_html( $meta->has_sale ? $meta->sale_price : $meta->price ) ); ?></ins>
				</div>
				<?php endif; ?>
				<?php if ( wte_array_get( $settings, 'layoutFilters.showViewMoreButton', true ) ) : ?>
				<div class="wpte-trip-btn-wrap">
					<a href="<?php echo esc_url( get_the_permalink( $trip->ID ) ); ?>" class="wpte-trip-explore-btn"><?php echo esc_html( wte_array_get( $settings, 'viewMoreButtonText', __( 'View Details', 'wptravelengine-elementor-widgets' ) ) ); ?></a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
