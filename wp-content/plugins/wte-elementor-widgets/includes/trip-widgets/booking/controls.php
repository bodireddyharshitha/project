<?php
/**
 * Booking Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$trip_id  = $post->ID;
$wtetrip  = \wte_get_trip( $trip_id );
$settings = get_option( 'wp_travel_engine_settings', array() );

// Highlight.
$highlights_content = '';
$static_hightlight  = array(
	array(
		'highlight' => __( 'Unbeatable Value Assurance', 'wptravelengine-elementor-widgets' ),
		'help'      => __( 'Discover extraordinary adventures', 'wptravelengine-elementor-widgets' ),
	),
	array(
		'highlight' => __( 'Effortless Reservation Process', 'wptravelengine-elementor-widgets' ),
		'help'      => __( 'No booking hassles', 'wptravelengine-elementor-widgets' ),
	),
	array(
		'highlight' => __( 'Transparent Pricing, Zero Surprises', 'wptravelengine-elementor-widgets' ),
		'help'      => __( 'No hidden costs', 'wptravelengine-elementor-widgets' ),
	),
	array(
		'highlight' => __( 'Expertise Beyond Measure', 'wptravelengine-elementor-widgets' ),
		'help'      => __( 'Team of seasoned experts', 'wptravelengine-elementor-widgets' ),
	),
	array(
		'highlight' => __( 'Your Joy, Our Priority', 'wptravelengine-elementor-widgets' ),
		'help'      => __( 'Happiness Commitment', 'wptravelengine-elementor-widgets' ),
	),
);

$selectors = array(
	// General section.
	'booking_typography'           => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
	{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-price-wrap .wpte-bf-price-from,
	{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-price-wrap .wpte-bf-pqty,
	{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte_price-toggle-btn-mb .current-text',
	'booking_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-price-wrap .wpte-bf-price-from,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-price-wrap .wpte-bf-pqty,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte_price-toggle-btn-mb .current-text' => 'color: {{VALUE}};',
	),
	'booking_padding'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3 .wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3' => 'padding:0px;',
	),
	'booking_margin'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3 .wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'booking_border'               => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
	{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3 .wrap',
	'booking_border_radius'        => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3 .wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'booking_bg_color'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte_price-toggle-btn-mb,
		{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3 .wrap' => 'background-color: {{VALUE}};',
	),
	'booking_boxshadow'            => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area,
	{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area.wpte-form-layout-3 .wrap',

	// Content.
	'content_padding'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'content_margin'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Button.
	'button_typography'            => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now',
	'button_padding'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_margin'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_bg_color'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now' => 'background-color: {{VALUE}};',
	),
	'button_color'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now' => 'color: {{VALUE}};',
	),
	'button_border'                => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now',
	'button_border_radius'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_boxshadow'             => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now',
	'button_bg_hover_color'        => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now:hover' => 'background-color: {{VALUE}};',
	),
	'button_hover_color'           => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now:hover' => 'color: {{VALUE}};',
	),
	'button_hover_border'          => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now:hover',
	'button_hover_border_radius'   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_hover_boxshadow'       => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-btn-wrap .wte-book-now:hover',

	// Discount .
	'discount_typography'          => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-discount-tag',
	'discount_bg_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-discount-tag' => 'background-color: {{VALUE}};',
	),
	'discount_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-discount-tag' => 'color: {{VALUE}};',
	),
	'discount_border_radius'       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-discount-tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'discount_boxshadow'           => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-discount-tag',
	'discount_padding'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-discount-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Group Discount.
	'group_discount_typography'    => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-gd-text',
	'group_discount_bg_color'      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-gd-text' => 'background-color: {{VALUE}};',
	),
	'group_discount_color'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-gd-text' => 'color: {{VALUE}};',
	),
	'group_discount_border_radius' => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-gd-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'group_discount_boxshadow'     => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-gd-text',
	'group_discount_padding'       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-gd-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Price.
	'price_typography'             => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-price-wrap .wpte-bf-offer-amount',
	'price_color'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-price-wrap .wpte-bf-offer-amount' => 'color: {{VALUE}};',
	),
	'strike_typography'            => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-reg-price del',
	'strike_color'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-bf-reg-price del' => 'color: {{VALUE}};',
	),
	// Highlights.
	'highlights_typography'        => '{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-content ul li',
	'highlights_icon_color'        => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-content ul li::before' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-custom-tooltip' => 'background-color: {{VALUE}};',
	),
	'highlights_color'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-content ul li' => 'color: {{VALUE}};',
	),
	'highlights_gap'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-content ul li' => 'padding-bottom: {{SIZE}}{{UNIT}};',
	),
	'highlights_alignment'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-booking-area-wrapper .wpte-booking-area .wpte-booking-inner-wrapper .wpte-bf-content ul' => 'text-align: {{VALUE}};',
	),
);

$settings['trip_highlights'] = isset( $settings['trip_highlights'] ) && is_array( $settings['trip_highlights'] ) && count( $settings['trip_highlights'] ) > 0 ? $settings['trip_highlights'] : $static_hightlight;
$highlights                  = isset( $settings['trip_highlights'] ) && is_array( $settings['trip_highlights'] ) ? $settings['trip_highlights'] : array();
if ( isset( $settings['trip_highlights'] ) && is_array( $settings['trip_highlights'] ) && count( $settings['trip_highlights'] ) > 0 ) :
	?>
	<div class="wpte-bf-content">
		<ul>
			<?php
			foreach ( $highlights as $highlight ) {
				$highlight         = (object) $highlight;
				$trip_highlights[] = '<li>' . esc_html( $highlight->highlight ) . ( ! empty( $highlight->help ) ? '<span class="wpte-custom-tooltip" data-title="' . esc_attr( $highlight->help ) . '"> <em> - ( ' . esc_attr( $highlight->help ) . ' )</em></span>' : '' ) . '</li>';
			}
			$highlights_content = implode( '', $trip_highlights );
			?>
		</ul>
	</div>
	<?php
endif;
$controls = array(
	'booking_button_settings'  => array(
		'type'        => 'control_section',
		'label'       => __( 'Button', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'checkAvailabilityLink' => array(
				'type'        => \Elementor\Controls_Manager::URL,
				'options'     => array( 'url', 'is_external', 'nofollow' ),
				'default'     => array(
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => 'class|wpte-bf-btn wte-book-now',
				),
				'label_block' => true,
				'label'       => __( 'Link', 'wptravelengine-elementor-widgets' ),
			),
			'checkAvailabilityText' => array(
				'default' => __( 'Check Availability', 'wptravelengine-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label'   => __( 'Text', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'booking_text_settings'    => array(
		'type'        => 'control_section',
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'highlightContent' => array(
				'default'     => $highlights_content,
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'label'       => __( 'Highlight Content', 'wptravelengine-elementor-widgets' ),
				'description' => __( 'Note: To change tooltip content switch to text editor and change content of data-title attribute.', 'wptravelengine-elementor-widgets' ),
				'separator'   => 'after',
			),
			'helpText'         => array(
				'default' => __( '<span>Need help with booking?</span> <a href="#wte_enquiry_form_scroll_wrapper" id="wte-send-enquiry-message">Send Us A Message</a>', 'wptravelengine-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'label'   => __( 'Enquiry Text', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'booking_display_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Additional', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'showPriceSection'  => array(
				'label'   => __( 'Show Price', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showDiscountTag'   => array(
				'label'   => __( 'Show Discount', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showGroupDiscount' => defined( 'WP_TRAVEL_ENGINE_GROUP_DISCOUNT_VERSION' ) && $wtetrip->has_group_discount ? array(
				'label'   => __( 'Show Group Discount', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			) : array(),
			'showTripHighlight' => array(
				'label'   => __( 'Show Highlights', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showButton'        => array(
				'label'   => __( 'Show Availability Button', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showInfoSection'   => array(
				'label'   => __( 'Show Inquiry Content', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
		),
	),
	'price_section'            => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Price', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'price_tabs' => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'price_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'price_typography' => array(
								'type'     => \Elementor\Group_Control_Typography::get_type(),
								'selector' => $selectors['price_typography'],
							),
							'price_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['price_color'],
							),
						),
					),
					'price_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Strikeout', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'strike_typography' => array(
								'type'     => \Elementor\Group_Control_Typography::get_type(),
								'selector' => $selectors['strike_typography'],
							),
							'strike_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['strike_color'],
							),
						),
					),
				),
			),
		),
	),
	'highlights_section'       => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Highlights', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'highlights_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['highlights_typography'],
			),
			'highlights_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['highlights_color'],
			),
			'highlights_icon_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['highlights_icon_color'],
			),
			'highlights_gap'        => array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => __( 'Space Between', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'selectors'  => $selectors['highlights_gap'],
			),
			'highlights_alignment'  => array(
				'label'     => esc_html__( 'Alignment', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => $selectors['highlights_alignment'],
			),
		),
	),
	'tags_section'             => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Discount', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'discount_bg_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['discount_bg_color'],
			),
			'discount_color'         => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['discount_color'],
			),
			'discount_border_radius' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['discount_border_radius'],
			),
			'discount_padding'       => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['discount_padding'],
			),
		),
	),
	'group_discount_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Group Discount', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'group_discount_bg_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['group_discount_bg_color'],
			),
			'group_discount_color'         => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['group_discount_color'],
			),
			'group_discount_border_radius' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['group_discount_border_radius'],
			),
		),
	),
	'button_section'           => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Button', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'button_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['button_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'button_tabs'       => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'button_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'button_bg_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['button_bg_color'],
							),
							'button_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['button_color'],
							),
							'button_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['button_border'],
							),
							'button_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['button_border_radius'],
							),
							'button_boxshadow'     => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['button_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'button_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'button_bg_hover_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['button_bg_hover_color'],
							),
							'button_hover_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['button_hover_color'],
							),
							'button_hover_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['button_hover_border'],
							),
							'button_hover_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['button_hover_border_radius'],
							),
							'button_hover_boxshadow'     => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['button_hover_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
				),
			),
			'button_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['button_padding'],
			),
			'button_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['button_margin'],
			),
		),
	),
);

return $controls;
