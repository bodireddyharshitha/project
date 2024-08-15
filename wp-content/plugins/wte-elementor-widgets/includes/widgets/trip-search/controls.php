<?php
namespace WPTRAVELENGINEEB;

/**
 * Trip Widget Controls.
 *
 * @since 1.2.0
 */
$selectors = array(
	// general section.
	'search_typography'                      => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper',
	'search_boxshadow'                       => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper',
	'search_border'                          => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper',
	'search_alignment'                       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper' => 'text-align: {{VALUE}};',
	),
	'search_padding'                         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_background_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper' => 'background-color: {{VALUE}};',
	),
	'search_primary_color'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper' => '--primary-color: {{VALUE}};',
	),
	'search_border_radius'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-sfilter-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// input.
	'search_input_border'                    => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field',
	'search_input_color'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field .wpte__input' => 'color: {{VALUE}};--input-color: {{VALUE}}',
	),
	'search_input_icon_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .icon' => 'color: {{VALUE}};',
	),
	'search_input_arrow_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field.wpte__select-field::after' => 'background-color: {{VALUE}};',
	),
	'search_input_background_color'          => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field' => 'background-color: {{VALUE}};',
	),
	'search_input_border_radius'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_input_first_child_border_radius' => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field:first-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_input_spacing'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_input_padding'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__adv-field .wpte__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_item_spacing'                    => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__adv-field.wpte__select-field .wpte__select-options ul li span' => 'padding-top: calc({{SIZE}}{{UNIT}} / 2 ); padding-bottom: calc({{SIZE}}{{UNIT}} / 2 );',
	),
	// button.
	'search_button_typography'               => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit',
	'search_button_padding'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_button_bg_color'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit' => 'background-color: {{VALUE}};',
	),
	'search_button_color'                    => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit' => 'color: {{VALUE}};',
	),
	'search_button_border'                   => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit',
	'search_button_border_radius'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_button_boxshadow'                => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit',
	'search_button_bg_hover_color'           => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit:hover' => 'background-color: {{VALUE}};',
	),
	'search_button_hover_color'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit:hover' => 'color: {{VALUE}};',
	),
	'search_button_hover_border'             => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit:hover',
	'search_button_hover_border_radius'      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'search_button_hover_boxshadow'          => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip__search-fields .wpte-trip__search-submit:hover',
);
$controls = array(
	'search_general_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'search_primary_color'    => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Primary Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['search_primary_color'],
			),
			'search_background_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['search_background_color'],
			),
			'search_typography'       => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['search_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'search_padding'          => array(
				'type'       => 'DIMENSIONS',
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['search_padding'],
			),
			'search_boxshadow'        => array(
				'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' => $selectors['search_boxshadow'],
				'label'    => __( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
			),
			'search_border'           => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['search_border'],
			),
			'search_border_radius'    => array(
				'type'       => 'DIMENSIONS',
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['search_border_radius'],
			),
		),
	),
	'search_input_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Input', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'search_input_color'            => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['search_input_color'],
			),
			'search_input_background_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['search_input_background_color'],
			),
			'search_input_icon_color'       => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['search_input_icon_color'],
			),
			'search_input_arrow_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Arrow Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['search_input_arrow_color'],
			),
			'search_input_border'           => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['search_input_border'],
			),

			'search_input_tabs'             => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'search_input_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'search_input_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['search_input_border_radius'],
							),
						),
					),
					'search_input_child'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'First Child', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'search_input_first_child_border_radius'    => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['search_input_first_child_border_radius'],
							),
						),
					),
				),
			),
			'search_input_padding'          => array(
				'label'      => esc_html__( 'Padding', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['search_input_padding'],
			),
			'search_input_spacing'          => array(
				'label'      => esc_html__( 'Margin', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['search_input_spacing'],
			),
			'search_item_spacing'           => array(
				'label'      => __( 'Item Spacing', 'wptravelengine-elementor-widgets' ),
				'type'       => 'SLIDER',
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					),
				),
				'selectors'  => $selectors['search_item_spacing'],
			),
		),
	),
	'search_button_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Button', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'search_button_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['search_button_typography'],
				'label'    => esc_html__( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'search_button_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['search_button_padding'],
			),
			'search_button_tabs'       => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'search_button_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'search_button_bg_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['search_button_bg_color'],
							),
							'search_button_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['search_button_color'],
							),
							'search_button_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['search_button_border'],
							),
							'search_button_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['search_button_border_radius'],
							),
							'search_button_boxshadow'     => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['search_button_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'search_button_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'search_button_bg_hover_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['search_button_bg_hover_color'],
							),
							'search_button_hover_color'    => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['search_button_hover_color'],
							),
							'search_button_hover_border'   => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['search_button_hover_border'],
							),
							'search_button_hover_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['search_button_hover_border_radius'],
							),
							'search_button_hover_boxshadow' => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['search_button_hover_boxshadow'],
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
