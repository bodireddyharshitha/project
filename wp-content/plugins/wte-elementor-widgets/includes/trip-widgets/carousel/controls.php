<?php
/**
 * Carousel Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$selectors = array(
	'carousel_height'            => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-trip-feat-img-gallery .owl-stage-outer' => 'height: {{SIZE}}{{UNIT}};',
	),
	'arrow_padding'              => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'arrow_bg_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next' => 'background-color: {{VALUE}} !important;',
	),
	'arrow_color'                => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav button::before,{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav button::after' => 'background-color: {{VALUE}};',
	),
	'arrow_border'               => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next',
	'arrow_border_radius'        => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'arrow_box_shadow'           => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next',
	'arrow_bg_hover_color'       => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev:hover, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next:hover' => 'background-color: {{VALUE}} !important;',
	),
	'arrow_hover_color'          => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav button:hover::before,{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav button:hover::after' => 'background-color: {{VALUE}};',
	),
	'arrow_hover_border'         => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev:hover, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next:hover',
	'arrow_hover_border_radius'  => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev:hover, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'arrow_hover_box_shadow'     => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev:hover, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next:hover',
	'arrow_size'                 => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev, {{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next' => 'font-size: {{SIZE}}{{UNIT}} !important;width: 2em;height: 2em;',
	),
	'arrow_offset'               => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-prev' => 'left: {{SIZE}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .owl-nav .owl-next' => 'right: {{SIZE}}{{UNIT}};',
	),

	// Button.
	'button_typography'          => '{{WRAPPER}} .wpte-gallery-wrapper .wte-trip-vidgal-popup-trigger, {{WRAPPER}} .wpte-gallery-wrapper .wte-trip-image-gal-popup-trigger',
	'button_padding'             => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_margin'              => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_bg_color'            => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a' => 'background-color: {{VALUE}};',
	),
	'button_color'               => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a' => 'color: {{VALUE}};',
	),
	'button_border'              => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
	{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a',
	'button_border_radius'       => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_boxshadow'           => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a,
	{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a',
	'button_bg_hover_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a:hover,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a:hover' => 'background-color: {{VALUE}};',
	),
	'button_hover_color'         => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a:hover,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a:hover' => 'color: {{VALUE}};',
	),
	'button_hover_border'        => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a:hover,
	{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a:hover',
	'button_hover_border_radius' => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a:hover,
		{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_hover_boxshadow'     => '{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-image-gal-popup a:hover,
	{{WRAPPER}} .elementor-widget-container .wpte-gallery-wrapper .wpte-gallery-container .wp-travel-engine-vid-gal-popup a:hover',

);

global $post;
$wpte_trip_images         = get_post_meta( $post->ID, 'wpte_gallery_id', true );
$wp_travel_engine_setting = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$controls                 = array(
	'layout_settings'   => array(
		'type'        => 'control_section',
		'label'       => __( 'Layout', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'carousel_height' => array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => __( 'Carousel Height', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
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
				'selectors'  => $selectors['carousel_height'],
			),
		),
	),
	'carousel_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Gallery', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'showGalleryPopup' => array(
				'label'   => __( 'Show Gallery Button', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showVideoPopup'   => array(
				'label'   => __( 'Show Video Button', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'popup_alignment'  => array(
				'type'    => 'SELECT',
				'label'   => __( 'Button Position', 'wptravelengine-elementor-widgets' ),
				'default' => 'bottom-left',
				'options' => array(
					'top-left'     => __( 'Top Left', 'wptravelengine-elementor-widgets' ),
					'top-right'    => __( 'Top Right', 'wptravelengine-elementor-widgets' ),
					'bottom-left'  => __( 'Bottom Left', 'wptravelengine-elementor-widgets' ),
					'bottom-right' => __( 'Bottom Right', 'wptravelengine-elementor-widgets' ),
				),
			),
		),
	),
	'arrow_styling'     => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Arrows', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'arrow_tabs'   => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'arrow_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'arrow_bg_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['arrow_bg_color'],
							),
							'arrow_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['arrow_color'],
							),
							'arrow_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'label'    => __( 'Arrow Border', 'wptravelengine-elementor-widgets' ),
								'selector' => $selectors['arrow_border'],
							),
							'arrow_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Arrow Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['arrow_border_radius'],
							),
							'arrow_box_shadow'    => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['arrow_box_shadow'],
								'label'    => __( 'Arrow Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'arrow_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'arrow_bg_hover_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['arrow_bg_hover_color'],
							),
							'arrow_hover_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['arrow_hover_color'],
							),
							'arrow_hover_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'label'    => __( 'Arrow Border', 'wptravelengine-elementor-widgets' ),
								'selector' => $selectors['arrow_hover_border'],
							),
							'arrow_hover_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Arrow Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['arrow_hover_border_radius'],
							),
							'arrow_hover_box_shadow'    => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['arrow_hover_box_shadow'],
								'label'    => __( 'Arrow Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
				),
			),
			'arrow_size'   => array(
				'type'       => 'SLIDER',
				'label'      => esc_html__( 'Arrow Size', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => $selectors['arrow_size'],
			),
			'arrow_offset' => array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Arrow Offset', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -80,
						'max'  => 80,
						'step' => 1,
					),
					'%'  => array(
						'min' => -15,
						'max' => 100,
					),
				),
				'selectors'  => $selectors['arrow_offset'],
			),
		),
	),
	'button_styling'    => array(
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
		),
	),
);

return $controls;
