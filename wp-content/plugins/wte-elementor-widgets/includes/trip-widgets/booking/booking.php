<?php
/**
 * Booking Widget Render.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

/**
 * Enqueue Scripts
 *
 * @since 1.3.0
 */
wp_enqueue_script( 'parsley' );
wp_enqueue_script( 'jquery-fancy-box' );

global $wtetrip;
global $post;

$wrapper_classes = apply_filters( 'wpte_bf_outer_wrapper_classes', '' );
$settings        = get_option( 'wp_travel_engine_settings', array() );

$trip    = $post;
$trip_id = $post->ID;
$wtetrip = \wte_get_trip( $trip_id );
$package = $wtetrip->default_package;
// Pricing Section layout Options.
$form_layout           = isset( $settings['pricing_section_layout'] ) ? $settings['pricing_section_layout'] : 'layout-1';
$class_based_on_layout = isset( $settings['pricing_section_layout'] ) ? ' wpte-form-' . $settings['pricing_section_layout'] . '' : ' wpte-form-layout-1';
if ( isset( $package ) && isset( $package->{'package-categories'} ) ) {
	$package_categories       = (object) $package->{'package-categories'};
	$primary_pricing_category = get_option( 'primary_pricing_category', 0 );
	$categories_in_package    = $package_categories->c_ids;
	if ( is_array( $categories_in_package ) && in_array( $primary_pricing_category, $categories_in_package, true ) ) {
		$ids_as_key = array_combine( $categories_in_package, range( 1, count( $categories_in_package ) ) );
		unset( $ids_as_key[ $primary_pricing_category ] );
		$categories_in_package = array_keys( $ids_as_key );
		array_unshift( $categories_in_package, $primary_pricing_category );
	}
	if ( 'layout-2' === $form_layout ) {
		if ( \WP_Travel_Engine_Template_Hooks::is_single_pricing_category() ) {
			$class_based_on_layout = ( 'layout-2' === $form_layout ) ? ' wpte-form-layout-2 wpte-default-form' : ' wpte-form-layout-2';
		}
	}
}


// Retrieve attributes value form elementor.
$attributes              = (object) $attributes;
$check_availability_text = isset( $attributes->{'checkAvailabilityText'} ) ? $attributes->{'checkAvailabilityText'} : __( 'Check Availability', 'wptravelengine-elementor-widgets' );
$help_text               = isset( $attributes->{'helpText'} ) ? $attributes->{'helpText'} : __( 'Need help with booking?', 'wptravelengine-elementor-widgets' );
$highlight_text          = isset( $attributes->{'highlightContent'} ) ? $attributes->{'highlightContent'} : '';
$show_price              = isset( $attributes->{'showPriceSection'} ) ? $attributes->{'showPriceSection'} : true;
$show_discount           = isset( $attributes->{'showDiscountTag'} ) ? $attributes->{'showDiscountTag'} : true;
$show_highlights         = isset( $attributes->{'showTripHighlight'} ) ? $attributes->{'showTripHighlight'} : true;
$show_button             = isset( $attributes->{'showButton'} ) ? $attributes->{'showButton'} : true;
$show_info               = isset( $attributes->{'showInfoSection'} ) ? $attributes->{'showInfoSection'} : true;
$show_groupdiscount      = isset( $attributes->{'showGroupDiscount'} ) ? $attributes->{'showGroupDiscount'} : true;
// Get the currency symbol
$currency_code   = isset( $settings['currency_code'] ) ? $settings['currency_code'] : '';
$currency_symbol = wp_travel_engine_get_currency_symbol( $currency_code );
?>
<div class="wpte-elementor-widget">
<div class="widget wpte-booking-area-wrapper wpte-bf-outer <?php echo esc_attr( $wrapper_classes ); ?>">
	<!-- Prices List -->
	<?php do_action( 'wte_before_price_info' ); ?>
	<div class="wpte-booking-area<?php echo esc_attr( $class_based_on_layout ); ?>">
		<button data-text="<?php echo $form_layout == 'layout-3' ? esc_attr( $currency_symbol ) : ''; ?>" type="button" id="wpte_price-toggle-btn-mb" class="wpte_price-toggle-btn-mb" data-active-text="<?php 'layout-1' === $form_layout ? esc_attr_e( 'Hide Prices', 'wptravelengine-elementor-widgets' ) : ''; ?>">
			<?php if ( 'layout-1' === $form_layout ) : ?>
				<span class="current-text">
					<?php esc_html_e( 'Show Prices', 'wptravelengine-elementor-widgets' ); ?>
				</span>
			<?php endif; ?>
		</button>
		<?php if ( 'layout-3' === $form_layout ) : ?>
			<div class="wrap">
			<button type="button" id="wpte_price-toggle-btn-mb-<?php echo esc_attr( $form_layout ); ?>" class="wpte_price-toggle-btn-mb-<?php echo esc_attr( $form_layout ); ?>"></button>
		<?php endif; ?>
			<div class="wpte-booking-inner-wrapper">
			<?php
			if ( true || wte_array_get( $settings, 'show_multiple_pricing_list_disp', '' ) === '1' ) :
				?>
				<!-- Group Discount Badge Section -->
				<?php
				if ( $wtetrip->has_group_discount && $show_groupdiscount ) :
					?>
					<span class="wpte-bf-gd-text"><?php echo esc_html( apply_filters( 'wte_group_discount_badge_text', __( 'Group Discount Available', 'wptravelengine-elementor-widgets' ) ) ); ?></span>
				<?php endif; // Group Discount Badge. ?>

				<!-- Discount Percent Badge -->
				<?php
				// Show Discount Percent if Available.
				if ( $wtetrip->has_sale && $show_discount ) :
					?>
					<span class="wpte-bf-discount-tag">
						<?php
						// translators: %d is a placeholder with the sale percentage.
						printf( wp_kses_post( '%d%% Off', 'wptravelengine-elementor-widgets' ), (float) $wtetrip->sale_percentage );
						?>
						</span>
					<?php
				endif;
				?>
				<?php if ( $show_price && isset( $package ) && isset( $package->{'package-categories'} ) ) : ?>
					<div class="wpte-bf-price-wrap">
						<?php
						// Displays Package with lowest pricings.
							\WP_Travel_Engine_Template_Hooks::categorised_trip_prices();
						?>
					</div>
				<?php endif; ?>
				<?php if ( $show_highlights ) : ?>
					<div class="wpte-bf-content">
					<ul>
					<?php
					$settings = $this->get_settings_for_display();
					echo '<div ' . esc_attr( $this->get_render_attribute_string( 'highlightContent' ) ) . '>' . wp_kses_post( $this->get_settings( 'highlightContent' ) ) . '</div>';
					?>
					</ul>
				</div>
					<?php
				endif;
				if ( $show_button && isset( $package ) && isset( $package->{'package-categories'} ) ) :
					?>
					<div class="wpte-bf-btn-wrap">
					<?php
					if ( empty( $settings['checkAvailabilityLink']['url'] ) || '#' === $settings['checkAvailabilityLink']['url'] ) {
						?>
							<button type="button" id="open-booking-modal" class="wpte-bf-btn wte-book-now">
								<?php echo wp_kses_post( $check_availability_text ); ?>
							</button>
							<?php
					} else {
						$this->add_link_attributes( 'checkAvailabilityLink', $settings['checkAvailabilityLink'] );
						?>
							<a 
							<?php
							echo wp_kses(
								$this->get_render_attribute_string(
									'checkAvailabilityLink'
								),
								array( 'a' => array( 'class' => array() ) )
							);
							?>
							>
								<?php echo esc_attr( $settings['checkAvailabilityText'] ); ?>
							</a>
							<?php
					}
					?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php if ( empty( $settings['enquiry'] ) && $show_info ) : ?>
			<div class="wpte-booking-footer-text">
				<?php echo wp_kses_post( $help_text ); ?>
			</div>
			<?php
		endif;
		if ( 'layout-3' === $form_layout ) :
			?>
		</div>
		<?php endif; ?>
	</div>
	<?php
	do_action( 'wte_after_price_info' );
	?>
	<!-- ./ Prices List -->
</div>
</div>
	<?php
