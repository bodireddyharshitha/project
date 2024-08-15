<?php
namespace WPTRAVELENGINEEB;

/**
 * Trip Card Layout - 1
 */
list( $settings, $trip, $results ) = $args;

$is_featured       = wte_is_trip_featured( $trip->ID );
$meta              = \wte_trip_get_trip_rest_metadata( $trip->ID );
$tag_placement     = wte_array_get( $settings, 'tagplacement', false );
$image_size        = wte_array_get( $settings, 'image_size', false );
$image_custom_size = wte_array_get( $settings, 'image_custom_size', false );
$image_size        = 'custom' === $image_size && $image_custom_size ? Widget::wte_get_custom_image_size( $image_custom_size ) : $image_size;
$wte_global        = get_option( 'wp_travel_engine_settings', true );

?>
<div class="category-trips-single" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<div class="category-trips-single-inner-wrap">
		<figure class="category-trip-fig">
			<?php if ( wte_array_get( $settings, 'layoutFilters.showFeaturedRibbon', false ) && $is_featured ) : ?>
				<div class="category-feat-ribbon" data-placement="<?php echo esc_attr( $tag_placement ); ?>">
					<span class="category-feat-ribbon-txt"><?php esc_html_e( 'Featured', 'wptravelengine-elementor-widgets' ); ?></span>
					<span class="cat-feat-shadow"></span>
				</div>
			<?php endif; ?>
			<?php if ( wte_array_get( $settings, 'layoutFilters.showFeaturedImage', true ) ) : ?>
				<a href="<?php echo esc_url( get_the_permalink( $trip ) ); ?>">
					<?php
					$size = apply_filters( 'wp_travel_engine_archive_trip_feat_img_size', 'destination-thumb-trip-size' );
					if ( has_post_thumbnail( $trip ) ) :
						echo get_the_post_thumbnail( $trip, $image_size );
					endif;
					?>
				</a>
			<?php endif; ?>
		</figure>

		<div class="category-trip-content-wrap">
			<div class="category-trip-prc-title-wrap">
				<?php if ( wte_array_get( $settings, 'layoutFilters.showTitle', true ) ) : ?>
					<h2 class="category-trip-title" itemprop="name">
						<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $trip ) ); ?>"><?php echo $trip->post_title; ?></a>
					</h2>
				<?php endif; ?>

				<?php
				if ( wte_array_get( $settings, 'layoutFilters.showReviews', false ) ) :
					echo \wte_get_the_trip_reviews( $trip->ID );
				endif;
				?>

				<?php if ( ! empty( $position ) ) : ?>
					<meta itemprop="position" content="<?php echo esc_attr( $position ); ?>"/>
				<?php endif; ?>
			</div>

			<div class="category-trip-detail-wrap">
				<div class="category-trip-prc-wrap">
					<div class="category-trip-desti wpte-trip_meta-container">
						<?php
						if ( wte_array_get( $settings, 'layoutFilters.showActivities', false ) ) :
							$terms = wte_get_the_tax_term_list( $trip->ID, 'activities', '', ', ', '' );
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
								?>
								<span class="wpte-trip-meta category-trip-types">
									<span class="wpte-icon-activities"></span>
									<span><?php echo wp_kses_post( $terms ); ?></span>
								</span>
								<?php
							endif;
						endif;

						if ( wte_array_get( $settings, 'layoutFilters.showTripType', false ) ) :
							$terms = wte_get_the_tax_term_list( $trip->ID, 'trip_types', '', ', ', '' );
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
								?>
								<span class="wpte-trip-meta category-trip-types">
									<span class="wpte-icon-trip-types"></span>
									<span><?php echo wp_kses_post( $terms ); ?></span>
								</span>
								<?php
							endif;
						endif;

						if ( wte_array_get( $settings, 'layoutFilters.showLocation', false ) ) :
							$terms = wte_get_the_tax_term_list( $trip->ID, 'destination', '', ', ', '' );
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
								?>
								<span class="wpte-trip-meta category-trip-loc">
									<span class="wpte-icon-map-marker"></span>
									<span><?php echo wp_kses_post( $terms ); ?></span>
								</span>
								<?php
							endif;
						endif;
						if ( wte_array_get( $settings, 'layoutFilters.showDuration', false ) ) :
							$trip_duration_unit   = $meta->duration['duration_unit'];
							$trip_duration_nights = $meta->duration['nights'];
							$set_duration_types   = $settings['durationType'];
							$duration_label       = array();
							?>

							<span class="wpte-trip-meta category-trip-dur">
							<?php if ( $meta->duration['days'] != 0 ) : ?>
								<span class="wpte-icon-clock"></span>
									<span>
										<?php
										if ( ( 'days' !== $trip_duration_unit ) || ( 'days' === $trip_duration_unit && $meta->duration['days'] && in_array( $set_duration_types, array( 'both', 'days' ) ) ) ) {
											$duration_label[] = sprintf(
												_nx( '%1$d %2$s', '%1$d %3$s', (int) $meta->duration['days'], 'trip duration', 'wptravelengine-elementor-widgets' ),
												(int) $meta->duration['days'],
												$results['duration'][ $trip_duration_unit ][0],
												$results['duration'][ $trip_duration_unit ][1]
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
							<span class="wpte-trip-meta category-trip-dur wpte-trip-pax">
								<span class="wpte-icon-users"></span>
								<?php printf( '<span>' . __( '%s People', 'wptravelengine-elementor-widgets' ) . '</span>', (int) $meta->max_pax ? esc_html( $meta->min_pax . '-' . $meta->max_pax ) : esc_html( $meta->min_pax ) ); ?>
							</span>
						<?php endif; ?>
					</div>
					<?php if ( wte_array_get( $settings, 'layoutFilters.showPrice', true ) ) : ?>
						<div class="category-trip-budget">
							<?php if ( wte_array_get( $settings, 'layoutFilters.showDiscount', false ) && $meta->discount_percent ) : ?>
								<div class="category-disc-feat-wrap">
									<div class="category-trip-discount">
										<span class="discount-offer">
											<span><?php echo sprintf( __( '%1$s%% ', 'wptravelengine-elementor-widgets' ), (float) $meta->discount_percent ); ?></span>
										<?php esc_html_e( 'Off', 'wptravelengine-elementor-widgets' ); ?></span>
									</div>
								</div>
							<?php endif; ?>
							<span class="price-holder">
								<span class="actual-price"><?php echo wte_esc_price( wte_get_formated_price_html( $meta->has_sale ? $meta->sale_price : $meta->price ) ); ?></span>
								<?php if ( wte_array_get( $settings, 'layoutFilters.showStrikedPrice', true ) && $meta->has_sale ) : ?>
								<span class="striked-price"><?php echo wte_esc_price( wte_get_formated_price_html( $meta->price ) ); ?></span>
								<?php endif; ?>
							</span>
						</div>
					<?php endif; ?>
				</div>
				<?php if ( \wte_array_get( $settings, 'layoutFilters.showDescription', false ) ) : ?>
					<div class="category-trip-desc">
						<p>
							<?php echo esc_html( \wte_get_the_excerpt( $trip->ID, wte_array_get( $settings, 'excerptLength', 10 ) ) );?>
						</p>
					</div>
				<?php endif; ?>
				<?php if ( wte_array_get( $settings, 'layoutFilters.showViewMoreButton', true ) && ( wte_array_get( $settings, 'layout', 'grid' ) == 'grid' || wte_array_get( $settings, 'layout', 'slider' ) == 'slider' ) ) : ?>
					<a href="<?php echo esc_url( get_the_permalink( $trip->ID ) ); ?>" class="button category-trip-viewmre-btn"><?php echo esc_html( wte_array_get( $settings, 'viewMoreButtonText', __( 'View Details', 'wptravelengine-elementor-widgets' ) ) ); ?></a>
				<?php endif; ?>
			</div>
		</div>

		<?php
		$show_available_months = wte_array_get( $settings, 'layoutFilters.showTripAvailableTime', false );
		if ( $show_available_months || wte_array_get( $settings, 'layoutFilters.showViewMoreButton', true ) ) {

			$layout = wte_array_get( $settings, 'layout', 'list' );
			if ( wte_array_get( $settings, 'layout', '' ) == 'list' ) {
				echo '<div class="category-trip-aval-time">';
			}
			if ( $show_available_months ) {
				$fsds = apply_filters( 'trip_card_fixed_departure_dates', $trip->ID );

				$dates_layout = wte_array_get( $settings, 'datesLayout', 'months_list' );
				if ( $fsds == $trip->ID ) {
					if ( $layout == 'grid' || $layout == 'slider' ) {
						echo '<div class="category-trip-aval-time">';
					}
					echo '<div class="category-trip-avl-tip-inner-wrap">';
					echo '<span class="category-available-trip-text"> ' . __( 'Available through out the year:', 'wptravelengine-elementor-widgets' ) . '</span>';
					echo '<ul class="category-available-months">';
					foreach ( range( 1, 12 ) as $month_number ) :
						echo '<li>' . date_i18n( 'M', strtotime( "2021-{$month_number}-01" ) ) . '</li>';
						endforeach;
					echo '</ul></div>';
					if ( $layout == 'grid' || $layout == 'slider' ) {
						echo '</div>';
					}
				} elseif ( is_array( $fsds ) && count( $fsds ) > 0 ) {
					if ( $layout == 'grid' || $layout == 'slider' ) {
						echo '<div class="category-trip-aval-time">';
					}
					switch ( $dates_layout ) {
						case 'months_list':
							$available_months = array_map(
								function( $fsd ) {
									return date_i18n( 'n', strtotime( $fsd['start_date'] ) );
								},
								$fsds
							);
							$available_months = array_flip( $available_months );

							if ( empty( $available_months ) ) {
								echo '<ul class="category-available-months">';
								foreach ( range( 1, 12 ) as $month_number ) :
									echo '<li>' . date_i18n( 'n-M', strtotime( "2021-{$month_number}-01" ) ) . '</li>';
								endforeach;
								echo '</ul>';
								break;
							}

							$availability_txt     = ! empty( $available_months ) && is_array( $available_months ) ? __( 'Available in the following months:', 'wptravelengine-elementor-widgets' ) : __( 'Available through out the year:', 'wptravelengine-elementor-widgets' );
							$available_throughout = apply_filters( 'wte_available_throughout_txt', $availability_txt );

							echo '<div class="category-trip-avl-tip-inner-wrap">';
							echo '<span class="category-available-trip-text"> ' . esc_html( $available_throughout ) . '</span>';
							$months_list = '';
							echo '<ul class="category-available-months">';
							foreach ( range( 1, 12 ) as $month_number ) {
								isset( $available_months[ $month_number ] ) ? printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( get_the_permalink() ) . '?month=' . esc_html( $available_months[ $month_number ] ) . '#wte-fixed-departure-dates', date_i18n( 'M', strtotime( "2021-{$month_number}-01" ) ) ) : printf( '<li><a href="#" class="disabled">%1$s</a></li>', date_i18n( 'M', strtotime( "2021-{$month_number}-01" ) ) );
							}
							echo '</ul>';
							echo '</div>';
							break;
						case 'dates_list':
							$list_count = wte_array_get( $settings, 'datesCount', 3 );
							$icon       = '<i><svg xmlns="http://www.w3.org/2000/svg" width="17.332" height="15.61" viewBox="0 0 17.332 15.61"><g id="Group_773" data-name="Group 773" transform="translate(283.072 34.13)"><path id="Path_23383" data-name="Path 23383" d="M-283.057-26.176h.1c.466,0,.931,0,1.4,0,.084,0,.108-.024.1-.106-.006-.156,0-.313,0-.469a5.348,5.348,0,0,1,.066-.675,5.726,5.726,0,0,1,.162-.812,5.1,5.1,0,0,1,.17-.57,9.17,9.17,0,0,1,.383-.946,10.522,10.522,0,0,1,.573-.96c.109-.169.267-.307.371-.479a3.517,3.517,0,0,1,.5-.564,6.869,6.869,0,0,1,1.136-.97,9.538,9.538,0,0,1,.933-.557,7.427,7.427,0,0,1,1.631-.608c.284-.074.577-.11.867-.162a7.583,7.583,0,0,1,1.49-.072c.178,0,.356.053.534.062a2.673,2.673,0,0,1,.523.083c.147.038.3.056.445.1.255.07.511.138.759.228a6.434,6.434,0,0,1,1.22.569c.288.179.571.366.851.556a2.341,2.341,0,0,1,.319.259c.3.291.589.592.888.882a4.993,4.993,0,0,1,.64.85,6.611,6.611,0,0,1,.71,1.367c.065.175.121.352.178.53s.118.348.158.526c.054.242.09.487.133.731.024.14.045.281.067.422a.69.69,0,0,1,.008.1c0,.244.005.488,0,.731s-.015.5-.04.745a4.775,4.775,0,0,1-.095.5c-.04.191-.072.385-.128.572-.094.312-.191.625-.313.926a7.445,7.445,0,0,1-.43.9c-.173.3-.38.584-.579.87a8.045,8.045,0,0,1-1.2,1.26,5.842,5.842,0,0,1-.975.687,8.607,8.607,0,0,1-1.083.552,11.214,11.214,0,0,1-1.087.36c-.19.058-.386.1-.58.137-.121.025-.245.037-.368.052a12.316,12.316,0,0,1-1.57.034,3.994,3.994,0,0,1-.553-.065c-.166-.024-.33-.053-.5-.082a1.745,1.745,0,0,1-.21-.043c-.339-.1-.684-.189-1.013-.317a7,7,0,0,1-1.335-.673c-.2-.136-.417-.263-.609-.415a6.9,6.9,0,0,1-.566-.517.488.488,0,0,1-.128-.331.935.935,0,0,1,.1-.457.465.465,0,0,1,.3-.223.987.987,0,0,1,.478-.059.318.318,0,0,1,.139.073c.239.185.469.381.713.559a5.9,5.9,0,0,0,1.444.766,5.073,5.073,0,0,0,.484.169c.24.062.485.1.727.154a1.805,1.805,0,0,0,.2.037c.173.015.346.033.52.036.3.006.6.01.9,0a3.421,3.421,0,0,0,.562-.068c.337-.069.676-.139,1-.239a6.571,6.571,0,0,0,.783-.32,5.854,5.854,0,0,0,1.08-.663,5.389,5.389,0,0,0,.588-.533,8.013,8.013,0,0,0,.675-.738,5.518,5.518,0,0,0,.749-1.274,9.733,9.733,0,0,0,.366-1.107,4.926,4.926,0,0,0,.142-.833c.025-.269.008-.542.014-.814a4.716,4.716,0,0,0-.07-.815,5.8,5.8,0,0,0-.281-1.12,5.311,5.311,0,0,0-.548-1.147,9.019,9.019,0,0,0-.645-.914,9.267,9.267,0,0,0-.824-.788,3.354,3.354,0,0,0-.425-.321,5.664,5.664,0,0,0-1.048-.581c-.244-.093-.484-.2-.732-.275a6.877,6.877,0,0,0-.688-.161c-.212-.043-.427-.074-.641-.109a.528.528,0,0,0-.084,0c-.169,0-.338,0-.506,0a5.882,5.882,0,0,0-1.177.1,6.79,6.79,0,0,0-1.016.274,6.575,6.575,0,0,0-1.627.856,6.252,6.252,0,0,0-1.032.948,6.855,6.855,0,0,0-.644.847,4.657,4.657,0,0,0-.519,1.017c-.112.323-.227.647-.307.979a3.45,3.45,0,0,0-.13.91,4.4,4.4,0,0,1-.036.529c-.008.086.026.1.106.1.463,0,.925,0,1.388,0a.122.122,0,0,1,.08.028c.009.009-.005.051-.019.072q-.28.415-.563.827c-.162.236-.33.468-.489.705-.118.175-.222.359-.339.535-.1.144-.2.281-.3.423-.142.2-.282.41-.423.615-.016.023-.031.047-.048.069-.062.084-.086.083-.142,0-.166-.249-.332-.5-.5-.746-.3-.44-.6-.878-.9-1.318q-.358-.525-.714-1.051c-.031-.045-.063-.09-.094-.134Z" transform="translate(0 0)"/><path id="Path_23384" data-name="Path 23384" d="M150.612,112.52c0,.655,0,1.31,0,1.966a.216.216,0,0,0,.087.178,4.484,4.484,0,0,1,.358.346.227.227,0,0,0,.186.087q1.616,0,3.233,0a.659.659,0,0,1,.622.4.743.743,0,0,1-.516,1.074,1.361,1.361,0,0,1-.323.038q-1.507,0-3.013,0a.248.248,0,0,0-.216.109,1.509,1.509,0,0,1-.765.511,1.444,1.444,0,0,1-1.256-2.555.218.218,0,0,0,.09-.207q0-1.916,0-3.831a.784.784,0,0,1,.741-.732.742.742,0,0,1,.761.544.489.489,0,0,1,.015.127Q150.612,111.547,150.612,112.52Z" transform="translate(-423.686 -141.471)"/></g></svg></i>';
							echo '<div class="next-trip-info">';
							printf( '<div class="fsd-title">%1$s</div>', esc_html__( 'Next Departure', 'wptravelengine-elementor-widgets' ) );
							echo '<ul class="next-departure-list">';
							foreach ( $fsds as $fsd ) {
								if ( --$list_count < 0 ) {
									break;
								}
								printf(
									'<li><span class="left">%1$s %2$s</span><span class="right">%3$s</span></li>',
									wte_esc_svg( $icon ),
									esc_html( wte_get_formated_date( $fsd['start_date'] ) ),
									sprintf( __( '%s Available', 'wptravelengine-elementor-widgets' ), (float) $fsd['seats_left'] )
								);
							}
							echo '</ul>';
							echo '</div>';
							break;
						default:
							break;
					}
					if ( $layout == 'grid' || $layout == 'slider' ) {
						echo '</div>';
					}
				}
			}

			if ( wte_array_get( $settings, 'layoutFilters.showViewMoreButton', true ) && $layout == 'list' ) :
				?>
				<a href="<?php echo esc_url( get_the_permalink( $trip->ID ) ); ?>" class="button category-trip-viewmre-btn"><?php echo esc_html( wte_array_get( $settings, 'viewMoreButtonText', __( 'View Details', 'wptravelengine-elementor-widgets' ) ) ); ?></a>
				<?php
			endif;
			if ( $layout == 'list' ) {
				echo '</div>';
			}
		}
		?>
	</div>
</div>
