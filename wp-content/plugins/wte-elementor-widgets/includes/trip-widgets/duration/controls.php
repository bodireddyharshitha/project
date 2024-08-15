<?php
/**
 * Trip Duration Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

$selectors = array(
	// general.
	'general_background'           => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration' => 'background-color: {{VALUE}};',
	),
	'general_border_radius'        => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'general_boxshadow'            => '{{WRAPPER}} .elementor-widget-container .wte-title-duration',
	'general_border'               => '{{WRAPPER}} .elementor-widget-container .wte-title-duration',
	// Duration.
	'duration_typography'          => '{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration',
	'duration_padding'             => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'duration_color'               => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration' => 'color: {{VALUE}};',
	),
	'duration_bg_color'            => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration' => 'background-color: {{VALUE}};',
	),
	'duration_border_radius'       => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'duration_boxshadow'           => '{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration',
	'duration_border'              => '{{WRAPPER}} .elementor-widget-container .wte-title-duration .duration',

	// Days.
	'date_typography'              => '{{WRAPPER}} .elementor-widget-container .wte-title-duration .days',
	'date_padding'                 => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration .days' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'date_title_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .wte-title-duration .days' => 'color: {{VALUE}};',
	),
);

$controls = array(
	'title'            => __( 'Trip Duration', 'wptravelengine-elementor-widgets' ),
	'icon'             => 'wtei-b-trips',
	'categories'       => 'wptravelengine',
	'display_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Layout', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'displayStyle' => array(
				'type'    => 'SELECT',
				'label'   => __( 'Display Style', 'wptravelengine-elementor-widgets' ),
				'default' => 'vertically',
				'options' => array(
					'vertically'   => __( 'Vertical', 'wptravelengine-elementor-widgets' ),
					'horizontally' => __( 'Horizontal', 'wptravelengine-elementor-widgets' ),
				),
			),
		),
	),
	'general_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'general_background'    => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['general_background'],
			),
			'general_border'        => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['general_border'],
			),
			'general_border_radius' => array(
				'type'       => 'DIMENSIONS',
				'label'      => esc_html__( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['general_border_radius'],
			),
			'general_boxshadow'     => array(
				'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' => $selectors['general_boxshadow'],
				'label'    => __( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'duration_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Duration Unit', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'duration_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['duration_typography'],
			),
			'duration_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['duration_padding'],
			),
			'duration_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['duration_color'],
			),
			'duration_bg_color'   => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['duration_bg_color'],
			),
		),
	),
	'date_section'     => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Duration Type', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'date_typography'  => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['date_typography'],
			),
			'date_padding'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['date_padding'],
			),
			'date_title_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['date_title_color'],
			),
		),
	),
);

return $controls;
