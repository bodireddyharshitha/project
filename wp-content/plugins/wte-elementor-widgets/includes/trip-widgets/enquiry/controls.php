<?php
/**
 * Enquiry Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$selectors = array(
	// General section.
	'enquiry_typography'         => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .enquiry-form-title,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .wp-travel-engine-info-field label,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .row-repeater label',
	'general_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .enquiry-form-title,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .wp-travel-engine-info-field label,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .row-repeater label' => 'color: {{VALUE}};',
	),

	// Button.
	'button_typography'          => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit',
	'button_padding'             => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_margin'              => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_bg_color'            => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit' => 'background-color: {{VALUE}};',
	),
	'button_color'               => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit' => 'color: {{VALUE}};',
	),
	'button_border'              => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit',
	'button_border_radius'       => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_boxshadow'           => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit',
	'button_bg_hover_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit:hover' => 'background-color: {{VALUE}};',
	),
	'button_hover_color'         => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit:hover' => 'color: {{VALUE}};',
	),
	'button_hover_border'        => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit:hover',
	'button_hover_border_radius' => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .enquiry-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_hover_boxshadow'     => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form .enquiry-submit:hover',

	// Input Fields.
	'input_typography'           => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap #wte_enquiry_contact_form input:not([type="submit"]),{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap #wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap #wte_enquiry_contact_form select',
	'input_bg_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap #wte_enquiry_contact_form input:not([type="submit"]),{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap #wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap #wte_enquiry_contact_form select' => 'background-color: {{VALUE}};',
	),
	'input_color'                => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input::placeholder,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea::placeholder,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select option,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select' => 'color: {{VALUE}};',
	),
	'input_border'               => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select',
	'input_border_radius'        => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'input_boxshadow'            => '{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select',
	'input_padding'              => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'input_margin'               => array(
		'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form input,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form textarea,{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
);

$controls = array(
	'enquiry_text_settings'    => array(
		'type'        => 'control_section',
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'buttonText' => array(
				'default' => __( 'Send Email', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Button Label', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'enquiry_display_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Additional', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'showFormLabels' => array(
				'label'        => __( 'Hide Form Labels', 'wptravelengine-elementor-widgets' ),
				'type'         => 'SWITCHER',
				'default'      => 'yes',
				'return_value' => 'none',
				'selectors'    => array(
					'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .row-repeater label' => 'display: {{VALUE}}',
				),
			),
			'showTripName'   => array(
				'label'        => __( 'Hide Trip Name', 'wptravelengine-elementor-widgets' ),
				'type'         => 'SWITCHER',
				'default'      => 'yes',
				'return_value' => 'none',
				'selectors'    => array(
					'{{WRAPPER}} .elementor-widget-container .wte_enquiry_contact_form-wrap .wte_enquiry_contact_form .row-repeater.wp-travel-engine-info-field' => 'display: {{VALUE}}',
				),
			),
		),
	),
	'general_section'          => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'enquiry_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['enquiry_typography'],
			),
			'general_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['general_color'],
			),
		),
	),
	'input_section'            => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Form Fields', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'input_typography'    => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['input_typography'],
			),
			'input_bg_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['input_bg_color'],
			),
			'input_color'         => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['input_color'],
			),
			'input_border'        => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['input_border'],
			),
			'input_border_radius' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['input_border_radius'],
			),
			'input_boxshadow'     => array(
				'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' => $selectors['input_boxshadow'],
				'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
			),
			'input_padding'       => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['input_padding'],
			),
			'input_margin'        => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['input_margin'],
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
