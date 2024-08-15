<?php
namespace WPTRAVELENGINEEB;

/**
 * Terms Listing Layout 1
 */

list( $settings, $term_object, $results ) = $args;

$thumbnail = null;
$terms_image_size       = isset( $settings->{'terms_image_size'} ) && $settings->{'terms_image_size'} ? $settings->{'terms_image_size'} : '';
$terms_image_custom_size       = isset( $settings->{'terms_image_custom_size'} ) && $settings->{'terms_image_custom_size'} ? $settings->{'terms_image_custom_size'} : '';
$terms_image_size        = 'custom' === $terms_image_size && $terms_image_custom_size ? Widget::wte_get_custom_image_size( $terms_image_custom_size ) : $terms_image_size;
$thumbnail = wp_get_attachment_image_src( $term_object->thumbnail, $terms_image_size );
$image_title = get_the_title( $term_object->thumbnail );
$alt_text = get_post_meta( $term_object->thumbnail, '_wp_attachment_image_alt', true );
$alt_attribute = $alt_text ? $alt_text  : $image_title;

$show_cta_button       = isset( $settings->{'layoutFilters'}['showCTAButton'] ) && $settings->{'layoutFilters'}['showCTAButton'];
$show_view_more_button = isset( $settings->{'layoutFilters'}['showViewMoreButton'] ) && $settings->{'layoutFilters'}['showViewMoreButton'];
$show_view_more_button = isset( $settings->{'layoutFilters'}['showViewMoreButton'] ) && $settings->{'layoutFilters'}['showViewMoreButton'];
$show_trip_counts      = isset( $settings->{'layoutFilters'}['showTripCounts'] ) && $settings->{'layoutFilters'}['showTripCounts'];
?>
<div class="wpte-trip-category">
	<div class="wpte-inner-container">
		<div class="wpte-trip-category-img-wrap">
			<figure class="thumbnail">
				<?php if ( isset( $thumbnail[0] ) ) : ?>
				<a href="<?php echo esc_url( $term_object->link ); ?>">
					<img src="<?php echo esc_url( $thumbnail[0] ); ?>" alt="<?php echo esc_attr( $alt_attribute ); ?>" />
				</a>
				<?php endif; ?>
			</figure>
			<?php if ( count( $term_object->children ) > 0 ||  $show_view_more_button ) : ?>
			<div class="wpte-trip-category-overlay">
				<?php if ( count( $term_object->children ) > 0 ) : ?>
				<div class="wpte-trip-subcat-wrap">
					<?php
					foreach ( $term_object->children as $term_child_id ) {
						$term_child_object = $results[ $term_child_id ];
						printf( '<a href="%1$s">%2$s</a>', esc_url( $term_child_object->link ), esc_html( $term_child_object->name ) );
					}
					?>
				</div>
				<?php endif; ?>
				<?php
				if ( $show_view_more_button ) :
					?>
					<div class="wpte-trip-category-btn">
						<a href="<?php echo esc_url( $term_object->link ); ?>" class="wpte-trip-cat-btn"><?php echo ! empty( $attributes->{'linkText'} ) ? esc_html( $attributes->{'linkText'} ) : esc_html__( 'View All', 'wptravelengine-elementor-widgets' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
			<?php endif;?>
		</div>
		<?php if ( $show_cta_button ) : ?>
			<div class="wpte-trip-category-text-wrap">
				<h2 class="wpte-trip-category-title"><a href="<?php echo esc_url( $term_object->link ); ?>"><?php echo esc_html( $term_object->name ); ?></a>
					<?php
					if ( $show_trip_counts ) :
						$count_label = $settings->{'countLabel'};
						if ( strpos( $settings->{'countLabel'}, '|') !== false ) {
							$countlabels = explode( '|', $settings->{'countLabel'} );
							$count_label = (int) $term_object->count === 1 ? $countlabels[0] : $countlabels[1];
						}
						?>
						<span class="trip-count">(<?php echo esc_html( sprintf( '%1$d %2$s', $term_object->count, $count_label ) ); ?>)</span>
					<?php endif; ?>
					<span class="wpte-icon">
						<?php
						if ( isset( $settings->{'terms_arrow_enable'} ) && $settings->{'terms_arrow_enable'} == 'yes' ) {
							if ( ! empty( $settings->{'terms_arrow_icon'} ) && is_array( $settings->{'terms_arrow_icon'} ) && ! empty( $settings->{'terms_arrow_icon'}['value'] ) && ! is_array( $settings->{'terms_arrow_icon'}['value'] ) ) :
								?>
								<i class="<?php echo esc_attr( $settings->{'terms_arrow_icon'}['value'] ); ?>"></i>
								<?php
								elseif ( is_array( $settings->{'terms_arrow_icon'}['value'] ) && ! empty( $settings->{'terms_arrow_icon'}['value'] ) ) :
									\Elementor\Icons_Manager::render_icon( $settings->{'terms_arrow_icon'} );
								else :
									?>
								<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.8933 8.49342C15.8299 8.32975 15.7347 8.18022 15.6133 8.05342L8.94667 1.38675C8.82235 1.26243 8.67476 1.16382 8.51233 1.09654C8.3499 1.02926 8.17581 0.994629 8 0.994629C7.64493 0.994629 7.30441 1.13568 7.05333 1.38675C6.92902 1.51107 6.8304 1.65866 6.76312 1.82109C6.69584 1.98352 6.66121 2.15761 6.66121 2.33342C6.66121 2.68849 6.80226 3.02901 7.05333 3.28008L11.4533 7.66675H1.33333C0.979711 7.66675 0.640573 7.80723 0.390525 8.05728C0.140476 8.30733 0 8.64646 0 9.00009C0 9.35371 0.140476 9.69285 0.390525 9.94289C0.640573 10.1929 0.979711 10.3334 1.33333 10.3334H11.4533L7.05333 14.7201C6.92836 14.844 6.82917 14.9915 6.76148 15.154C6.69379 15.3165 6.65894 15.4907 6.65894 15.6668C6.65894 15.8428 6.69379 16.017 6.76148 16.1795C6.82917 16.342 6.92836 16.4895 7.05333 16.6134C7.17728 16.7384 7.32475 16.8376 7.48723 16.9053C7.64971 16.973 7.82398 17.0078 8 17.0078C8.17602 17.0078 8.35029 16.973 8.51277 16.9053C8.67525 16.8376 8.82272 16.7384 8.94667 16.6134L15.6133 9.94675C15.7347 9.81995 15.8299 9.67042 15.8933 9.50675C16.0267 9.18214 16.0267 8.81803 15.8933 8.49342Z" fill="#2183DF" /></svg>
									<?php
							endif;
						}
						?>
					</span>
				</h2>
			</div>
		<?php endif; ?>
	</div>
</div>
