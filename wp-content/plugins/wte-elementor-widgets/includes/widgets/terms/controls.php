<?php
namespace WPTRAVELENGINEEB;

/**
 * Trip Widget Controls.
 *
 * @since 1.2.0
 */
$selectors = array(
	// general section.
	'terms_typography'                 => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category',
	'terms_boxshadow'                  => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container',
	'terms_border'                     => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container',
	'terms_alignment'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container' => 'text-align: {{VALUE}};',
	),
	'terms_padding'                    => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'terms_margin'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'terms_background_color'           => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container' => 'background-color: {{VALUE}};',
	),
	'terms_overlay_color'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category-img-wrap .wpte-trip-category-overlay' => 'background-color: {{VALUE}};',
	),
	'terms_border_radius'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-inner-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_boxshadow_hover'            => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category:hover .wpte-inner-container',
	'terms_border_hover'               => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category:hover .wpte-inner-container',
	'terms_background_hover_color'     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category:hover .wpte-inner-container' => 'background-color: {{VALUE}};',
	),
	'terms_border_radius_hover'        => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category:hover .wpte-inner-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// title.
	'terms_title_typography'           => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title',
	'terms_title_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-text-wrap .wpte-trip-category-title' => 'color: {{VALUE}};',
	),
	'terms_title_color_hover'          => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title a:hover' => 'color: {{VALUE}};',
	),
	'terms_title_padding'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-text-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_title_margin'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-text-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),

	// count.
	'terms_count_border'               => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .trip-count',
	'terms_count_border_radius'        => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .trip-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_count_padding'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .trip-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_count_typography'           => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .trip-count',
	'terms_count_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .trip-count' => 'color: {{VALUE}};',
	),
	'terms_count_bg_color'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .trip-count' => 'background-color: {{VALUE}};',
	),
	// arrow.
	'terms_arrow_size'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .wpte-icon' => 'font-size: {{SIZE}}{{UNIT}};',
	),
	'terms_arrow_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-title .wpte-icon' => 'color: {{VALUE}};',
	),
	// image.
	'terms_image_scale'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category figure img' => 'object-fit: {{VALUE}};',
	),
	'terms_image_width'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category figure img' => 'width: {{SIZE}}{{UNIT}};',
	),
	'terms_image_height'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category figure' => 'height: {{SIZE}}{{UNIT}} !important;',
	),
	'terms_animation_type'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category figure img' => 'transition-timing-function: {{VALUE}};',
	),
	'terms_img_animation_duration'     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category figure img' => 'transition-duration: {{VALUE}}s;',
	),
	'terms_image_border_radius'        => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category figure, {{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-category-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .wpte-trip-category.style-1 .wpte-trip-category-text-wrap' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
	),

	// button.
	'terms_button_typography'          => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn',
	'terms_button_padding'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_button_bg_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn' => 'background-color: {{VALUE}};',
	),
	'terms_button_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn' => 'color: {{VALUE}};',
	),
	'terms_button_border'              => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn',
	'terms_button_border_radius'       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_button_boxshadow'           => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn',
	'terms_button_bg_hover_color'      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn:hover' => 'background-color: {{VALUE}};',
	),
	'terms_button_hover_color'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn:hover' => 'color: {{VALUE}};',
	),
	'terms_button_hover_border'        => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn:hover',
	'terms_button_hover_border_radius' => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'terms_button_hover_boxshadow'     => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-category .wpte-trip-cat-btn:hover',
	// slider
	'slider_dots_active_color'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
	),
	'slider_dots_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
	),
	'slider_dots_spacing'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_padding'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_margin'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_bg_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'background-color: {{VALUE}};',
	),
	'slider_arrow_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'color: {{VALUE}};',
	),
	'slider_arrow_bg_color_hover'      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover' => 'background-color: {{VALUE}};',
	),
	'slider_arrow_color_hover'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover' => 'color: {{VALUE}};',
	),
	'slider_arrow_border'              => '{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next',
	'slider_arrow_border_radius'       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_box_shadow'          => '{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next',
	'slider_arrow_border_hover'        => '{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover',
	'slider_arrow_border_radius_hover' => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_dots_alignment'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination' => 'text-align: {{VALUE}};',
	),

	// slider arrow.
	'slider_arrow_size'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}};',
	),
	'slider_arrow_offset'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
	),
);
$controls = array(
	'terms_general_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'terms_typography'   => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['terms_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'terms_alignment'    => array(
				'type'      => 'CHOOSE',
				'label'     => __( 'Alignment', 'wptravelengine-elementor-widgets' ),
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
				'selectors' => $selectors['terms_alignment'],
			),
			'terms_padding'      => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['terms_padding'],
			),
			'terms_margin'       => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['terms_margin'],
			),
			'terms_general_tabs' => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'terms_general_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_background_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_background_color'],
							),
							'terms_boxshadow'        => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['terms_boxshadow'],
								'label'    => __( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
							'terms_border'           => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['terms_border'],
							),
							'terms_border_radius'    => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['terms_border_radius'],
							),
						),
					),
					'terms_general_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_background_hover_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_background_hover_color'],
							),
							'terms_overlay_color'          => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Overlay Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_overlay_color'],
								'condition' => array(
									'cardlayout'         => '1',
									'showViewMoreButton' => 'yes',
								),
							),
							'terms_boxshadow_hover'        => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['terms_boxshadow_hover'],
								'label'    => __( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
							'terms_border_hover'           => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['terms_border_hover'],
							),
							'terms_border_radius_hover'    => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['terms_border_radius_hover'],
							),
						),
					),
				),
			),
		),
	),
	'terms_title_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'terms_title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['terms_title_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'terms_title_tabs'       => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'terms_title_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_title_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_title_color'],
							),
						),
					),
					'terms_title_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_title_color_hover' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_title_color_hover'],
							),
						),
					),
				),
			),
			'terms_title_padding'    => array(
				'label'      => esc_html__( 'Padding', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['terms_title_padding'],
			),
			'terms_title_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['terms_title_margin'],
			),
		),
	),
	'terms_count_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Count', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'terms_count_typography'    => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['terms_count_typography'],
			),
			'terms_count_color'         => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['terms_count_color'],
			),
			'terms_count_bg_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['terms_count_bg_color'],
			),
			'terms_count_border'        => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['terms_count_border'],
			),
			'terms_count_border_radius' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['terms_count_border_radius'],
			),
			'terms_count_padding'       => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['terms_count_padding'],
			),
		),
		'condition'   => array( 'showTripCounts' => 'yes' ),
	),
	'terms_arrow_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Arrow', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'terms_arrow_enable' => array(
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'label'   => esc_html__( 'Enable/Disable', 'wptravelengine-elementor-widgets' ),
				'default' => 'yes',
			),
			'terms_arrow_color'  => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Arrow Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['terms_arrow_color'],
				'condition' => array( 'terms_arrow_enable' => 'yes' ),
			),
			'terms_arrow_size'   => array(
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
				'selectors'  => $selectors['terms_arrow_size'],
				'condition'  => array( 'terms_arrow_enable' => 'yes' ),
			),
			'terms_arrow_icon'   => array(
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label'       => esc_html__( 'Custom Upload', 'wptravelengine-elementor-widgets' ),
				'recommended' => array(
					'fa-solid'   => array(
						'arrow-alt-circle-left',
						'arrow-alt-circle-right',
						'arrow-left',
						'arrow-right',
					),
					'fa-regular' => array(
						'arrow-alt-circle-left',
						'arrow-alt-circle-right',
					),
				),
				'condition'   => array( 'terms_arrow_enable' => 'yes' ),
			),
		),
	),
	'terms_image_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Image', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'terms_image_tabs' => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'terms_image_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_image_size'          => array(
								'type'    => 'SELECT',
								'label'   => esc_html__( 'Image Size', 'wptravelengine-elementor-widgets' ),
								'options' => Widget::get_image_size_options(),
								'default' => 'trip-single-size',
							),
							'terms_image_custom_size'   => array(
								'type'      => 'IMAGE_DIMENSIONS',
								'label'     => esc_html__( 'Custom Image Size', 'wptravelengine-elementor-widgets' ),
								'condition' => array(
									'terms_image_size' => 'custom',
								),
							),
							'terms_image_scale'         => array(
								'type'      => 'SELECT',
								'label'     => esc_html__( 'Object Fit', 'wptravelengine-elementor-widgets' ),
								'options'   => array(
									'original' => esc_html__( 'Original', 'wptravelengine-elementor-widgets' ),
									'contain'  => esc_html__( 'Contain', 'wptravelengine-elementor-widgets' ),
									'cover'    => esc_html__( 'Cover', 'wptravelengine-elementor-widgets' ),
									'fill'     => esc_html__( 'Fill', 'wptravelengine-elementor-widgets' ),
								),
								'default'   => 'original',
								'selectors' => $selectors['terms_image_scale'],
							),
							'terms_image_width'         => array(
								'type'       => 'SLIDER',
								'label'      => esc_html__( 'Width', 'wptravelengine-elementor-widgets' ),
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
								'selectors'  => $selectors['terms_image_width'],
							),
							'terms_image_height'        => array(
								'type'       => 'SLIDER',
								'label'      => esc_html__( 'Height', 'wptravelengine-elementor-widgets' ),
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
								'selectors'  => $selectors['terms_image_height'],
							),
							'terms_image_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['terms_image_border_radius'],
							),
						),
					),
					'terms_image_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_animation_type'         => array(
								'type'      => 'SELECT',
								'label'     => esc_html__( 'Animation Type', 'wptravelengine-elementor-widgets' ),
								'options'   => array(
									'linear'      => esc_html__( 'Linear', 'wptravelengine-elementor-widgets' ),
									'ease'        => esc_html__( 'Ease', 'wptravelengine-elementor-widgets' ),
									'ease-in'     => esc_html__( 'Ease-in', 'wptravelengine-elementor-widgets' ),
									'ease-out'    => esc_html__( 'Ease-out', 'wptravelengine-elementor-widgets' ),
									'ease-in-out' => esc_html__( 'Ease-in-out', 'wptravelengine-elementor-widgets' ),
									'step-start'  => esc_html__( 'Step-start', 'wptravelengine-elementor-widgets' ),
									'step-end'    => esc_html__( 'Step-end', 'wptravelengine-elementor-widgets' ),
									'initial'     => esc_html__( 'Initial', 'wptravelengine-elementor-widgets' ),
									'inherit'     => esc_html__( 'Inherit', 'wptravelengine-elementor-widgets' ),
								),
								'default'   => 'linear',
								'selectors' => $selectors['terms_animation_type'],
							),
							'terms_img_animation_duration' => array(
								'type'      => \Elementor\Controls_Manager::NUMBER,
								'label'     => esc_html__( 'Animation Duration (sec)', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_img_animation_duration'],
								'min'       => 0,
								'max'       => 100,
								'step'      => 0.1,
								'default'   => 3,
							),
						),
					),
				),
			),
		),
	),
	'terms_button_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Button', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'terms_button_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['terms_button_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'terms_button_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['terms_button_padding'],
			),
			'terms_button_tabs'       => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'terms_button_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_button_bg_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_button_bg_color'],
							),
							'terms_button_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_button_color'],
							),
							'terms_button_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['terms_button_border'],
							),
							'terms_button_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['terms_button_border_radius'],
							),
							'terms_button_boxshadow'     => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['terms_button_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'terms_button_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'terms_button_bg_hover_color'  => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_button_bg_hover_color'],
							),
							'terms_button_hover_color'     => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['terms_button_hover_color'],
							),
							'terms_button_hover_border'    => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['terms_button_hover_border'],
							),
							'terms_button_hover_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['terms_button_hover_border_radius'],
							),
							'terms_button_hover_boxshadow' => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['terms_button_hover_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
				),
			),
		),
	),
	'slider_style_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Slider', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'slider_arrow_position'    => array(
				'type'    => 'SELECT',
				'label'   => __( 'Arrow Position', 'wptravelengine-elementor-widgets' ),
				'default' => 'default',
				'options' => array(
					'arrow-top-left'      => __( 'Top Left', 'wptravelengine-elementor-widgets' ),
					'arrow-top-center'    => __( 'Top Center', 'wptravelengine-elementor-widgets' ),
					'arrow-top-right'     => __( 'Top Right', 'wptravelengine-elementor-widgets' ),
					'arrow-bottom-left'   => __( 'Bottom Left', 'wptravelengine-elementor-widgets' ),
					'arrow-bottom-center' => __( 'Bottom Center', 'wptravelengine-elementor-widgets' ),
					'arrow-bottom-right'  => __( 'Bottom Right', 'wptravelengine-elementor-widgets' ),
					'default'       => __( 'Default', 'wptravelengine-elementor-widgets' ),
				),
			),
			'slider_arrow_padding'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Arrow Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['slider_arrow_padding'],
			),
			'slider_arrow_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Arrow margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['slider_arrow_margin'],
			),
			'slider_prev_arrow_icon'   => array(
				'type'          => \Elementor\Controls_Manager::ICONS,
				'label'         => esc_html__( 'Prev Arrow', 'wptravelengine-elementor-widgets' ),
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'eicon-chevron-left',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
				'recommended'   => array(
					'fa-regular' => array(
						'arrow-alt-circle-left',
						'caret-square-left',
					),
					'fa-solid'   => array(
						'angle-double-left',
						'angle-left',
						'arrow-alt-circle-left',
						'arrow-circle-left',
						'arrow-left',
						'caret-left',
						'caret-square-left',
						'chevron-circle-left',
						'chevron-left',
						'long-arrow-alt-left',
					),
				),
			),
			'slider_next_arrow_icon'   => array(
				'type'          => \Elementor\Controls_Manager::ICONS,
				'label'         => esc_html__( 'Next Arrow', 'wptravelengine-elementor-widgets' ),
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'eicon-chevron-right',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
				'recommended'   => array(
					'fa-regular' => array(
						'arrow-alt-circle-right',
						'caret-square-right',
					),
					'fa-solid'   => array(
						'angle-double-right',
						'angle-right',
						'arrow-alt-circle-right',
						'arrow-circle-right',
						'arrow-right',
						'caret-right',
						'caret-square-right',
						'chevron-circle-right',
						'chevron-right',
						'long-arrow-alt-right',
					),
				),
			),
			'slider_arrow_size'        => array(
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
				'selectors'  => $selectors['slider_arrow_size'],
			),
			'slider_arrow_offset'      => array(
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
				'selectors'  => $selectors['slider_arrow_offset'],
			),
			'slider_options_tabs'      => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'slider_navigation_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'slider_arrow_bg_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_bg_color'],
							),
							'slider_arrow_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_color'],
							),
							'slider_arrow_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'label'    => __( 'Arrow Border', 'wptravelengine-elementor-widgets' ),
								'selector' => $selectors['slider_arrow_border'],
							),
							'slider_arrow_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Arrow Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['slider_arrow_border_radius'],
							),
							'slider_arrow_box_shadow'    => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['slider_arrow_box_shadow'],
								'label'    => __( 'Arrow Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'slider_navigation_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'slider_arrow_bg_color_hover' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Background Color Hover', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_bg_color_hover'],
							),
							'slider_arrow_color_hover'    => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Color Hover', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_color_hover'],
							),
							'slider_arrow_border_hover'   => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'label'    => esc_html__( 'Arrow Border Color Hover', 'wptravelengine-elementor-widgets' ),
								'selector' => $selectors['slider_arrow_border_hover'],
							),
							'slider_arrow_border_radius_hover' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Arrow Border Radius Hover', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['slider_arrow_border_radius_hover'],
							),
						),
					),
				),
			),
			'slider_pagination_label'  => array(
				'label'       => __( 'Pagination', 'wptravelengine-elementor-widgets' ),
				'description' => esc_html__( 'Pagination.', 'wptravelengine-elementor-widgets' ),
			),
			'slider_dots_active_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Pagination Active Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['slider_dots_active_color'],
			),
			'slider_dots_color'        => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Pagination Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['slider_dots_color'],
			),
			'slider_dots_spacing'      => array(
				'label'      => esc_html__( 'Pagination Spacing', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['slider_dots_spacing'],
			),
			'slider_dots_alignment'    => array(
				'type'      => 'CHOOSE',
				'label'     => __( 'Pagination Alignment', 'wptravelengine-elementor-widgets' ),
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
				'selectors' => $selectors['slider_dots_alignment'],
			),
		),
		'condition'   => array( 'layout' => 'slider' ),
	),
);


return $controls;
