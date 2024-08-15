<?php
/**
 * Trip Breadcrumbs Widget Controls.
 *
 * @since 1.3.0
 * @package wptraevlengine-elementor-widgets
 */

$selectors = array(
	// General.
	'typography'              => '{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs a',
	'color'                   => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs a' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li .current a' => 'color: {{VALUE}};',
	),
	'hover_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs a:hover' => 'color: {{VALUE}};',
	),
	'active_color'            => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li.current a' => 'color: {{VALUE}};',
	),
	'separator_color'         => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li:after' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li' => 'border-right-color: {{VALUE}};',
	),

	// Breadcrumb.
	'breadcrumb_padding'      => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li .current a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'breadcrumb_bg_color'     => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs a' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li .current a' => 'background-color: {{VALUE}};',
	),
	'bg_hover_color'          => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs a:hover' => 'background-color: {{VALUE}};',
	),
	'border_radius'           => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li .current a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'border_radius_hover'     => array(
		'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'boxshadow'               => '{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li a',
	'boxshadow_hover'         => '{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li a:hover',
	'breadcrumb_border'       => '{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li a',
	'breadcrumb_border_hover' => '{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs li a:hover',
);

$controls = array(
	'controls'            => array(),
	'breadcrumb_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Breadcrumb', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'type'     => array(
				'label'         => __( 'Separator', 'wptravelengine-elementor-widgets' ),
				'type'          => 'CHOOSE',
				'is_responsive' => false,
				'options'       => array(
					'dot'   => array(
						'title' => esc_html__( '.', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'wte-icon-dot',
					),
					'slash' => array(
						'title' => esc_html__( '/', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'wte-icon-slash',
					),
					'dash'  => array(
						'title' => esc_html__( '-', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'wte-icon-dash',
					),
					'bar'   => array(
						'title' => esc_html__( '|', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'wte-icon-bar',
					),
					'none'  => array(
						'title' => esc_html__( 'None', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'wte-icon-none',
					),
				),
				'default'       => 'dot',
			),
			'item_gap' => array(
				'label'      => __( 'Item Gap', 'wptravelengine-elementor-widgets' ),
				'type'       => 'SLIDER',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-widget-container .breadcrumb-wrapper #crumbs' => '--item-gap: {{SIZE}}{{UNIT}};',
				),
			),
		),
	),
	'general_section'     => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'typography'      => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'color'           => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['color'],
			),
			'hover_color'     => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Hover Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['hover_color'],
			),
			'active_color'    => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Active Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['active_color'],
			),
			'separator_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Separator Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['separator_color'],
			),
		),
	),
);

return $controls;
