<?php
/**
 * Demo file for the booking widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

// Retrieve attributes value from elementor controls.
$attributes              = (object) $attributes;
$check_availability_text = isset( $attributes->{'checkAvailabilityText'} ) ? $attributes->{'checkAvailabilityText'} : __( 'Check Availability', 'wptravelengine-elementor-widgets' );
$help_text               = isset( $attributes->{'helpText'} ) ? $attributes->{'helpText'} : __( 'Need help with booking?', 'wptravelengine-elementor-widgets' );
$show_price              = isset( $attributes->{'showPriceSection'} ) ? $attributes->{'showPriceSection'} : true;
$show_discount           = isset( $attributes->{'showDiscountTag'} ) ? $attributes->{'showDiscountTag'} : true;
$show_highlights         = isset( $attributes->{'showTripHighlight'} ) ? $attributes->{'showTripHighlight'} : true;
$show_button             = isset( $attributes->{'showButton'} ) ? $attributes->{'showButton'} : true;
$show_info               = isset( $attributes->{'showInfoSection'} ) ? $attributes->{'showInfoSection'} : true;
?>

<div class="elementor-widget-container">
	<div class="widget-area wpte-elementor-widget">
		<div class="widget wpte-booking-area-wrapper wpte-bf-outer">
			<!-- Prices List -->
			<div class="wpte-booking-area wpte-form-layout-1">
				<button type="button" id="wpte_price-toggle-btn-mb" class="wpte_price-toggle-btn-mb" data-active-text="Hide Prices">
					<span class="current-text">
						<?php esc_html_e( 'Show Prices', 'wptravelengine-elementor-widgets' ); ?>
					</span>
				</button>
				<div class="wpte-booking-inner-wrapper">
					<?php if ( $show_discount ) : ?>
						<span class="wpte-bf-discount-tag">
							<?php esc_html_e( '20% Off', 'wptravelengine-elementor-widgets' ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $show_price ) : ?>
						<div class="wpte-bf-price-wrap">
							<div class="wpte-bf-price">
								<span class="wpte-bf-reg-price">
									<span class="wpte-bf-price-from">
										<?php esc_html_e( 'From', 'wptravelengine-elementor-widgets' ); ?>
									</span>
									<del><?php \wte_the_formated_price( 1800 ); ?></del>
								</span>
								<span class="wpte-bf-offer-price">
									<ins class="wpte-bf-offer-amount">
										<?php \wte_the_formated_price( 1440 ); ?>
									</ins>
									<div class="wpte-bf-pqty">
										<?php esc_html_e( '/ Adult', 'wptravelengine-elementor-widgets' ); ?>
									</div>
								</span>
							</div>
							<div class="wpte-bf-price">
								<span class="wpte-bf-reg-price">
									<span class="wpte-bf-price-from">
										<?php esc_html_e( 'From', 'wptravelengine-elementor-widgets' ); ?>
									</span>
									<del><?php \wte_the_formated_price( 1500 ); ?></del>
								</span>
								<span class="wpte-bf-offer-price">
									<ins class="wpte-bf-offer-amount">
										<?php \wte_the_formated_price( 1200 ); ?>
									</ins>
									<div class="wpte-bf-pqty">
										<?php esc_html_e( '/ Child', 'wptravelengine-elementor-widgets' ); ?>
									</div>
								</span>
							</div>
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
					<?php endif; ?>
					<?php if ( $show_button ) : ?>
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
					<?php endif; ?>
					</div>
				</div>
				<?php if ( empty( $settings['enquiry'] ) && $show_info ) : ?>
					<div class="wpte-booking-footer-text">
						<?php echo wp_kses_post( $help_text ); ?>
					</div>
				<?php endif; ?>
			</div>
			<!-- ./ Prices List -->
		</div>
	</div>
</div>
<?php
