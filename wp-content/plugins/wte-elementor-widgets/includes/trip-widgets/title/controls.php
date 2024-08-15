<?php
/**
 * Trip Title Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$selectors = array(
	// title.
	'title_typography' => '{{WRAPPER}} .elementor-widget-container .trip-header .trip-title',
	'title_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .trip-header .trip-title' => 'color: {{VALUE}};',
	),
	'title_stroke'     => '{{WRAPPER}} .elementor-widget-container .trip-header .trip-title',
	'title_shadow'     => array(
		'{{WRAPPER}} .elementor-widget-container .trip-header .trip-title' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
	),
	'title_padding'    => array(
		'{{WRAPPER}} .elementor-widget-container .trip-header .trip-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'title_margin'     => array(
		'{{WRAPPER}} .elementor-widget-container .trip-header .trip-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	'text_alignment'   => array(
		'{{WRAPPER}} .elementor-widget-container .trip-header .trip-title' => 'text-align: {{VALUE}};',
	),
);

$controls = array(
	'title_control_section' => array(
		'type'        => 'control_section',
		'label'       => __( 'Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'html_tag'       => array(
				'label'   => esc_html__( 'HTML Tag', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SELECT',
				'default' => 'h2',
				'options' => array(
					'h1' => __( 'H1', 'wptravelengine-elementor-widgets' ),
					'h2' => __( 'H2', 'wptravelengine-elementor-widgets' ),
					'h3' => __( 'H3', 'wptravelengine-elementor-widgets' ),
					'h4' => __( 'H4', 'wptravelengine-elementor-widgets' ),
					'h5' => __( 'H5', 'wptravelengine-elementor-widgets' ),
					'h6' => __( 'H6', 'wptravelengine-elementor-widgets' ),
				),
			),
			'text_alignment' => array(
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
				'selectors' => $selectors['text_alignment'],
			),
		),
	),
	'title_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['title_typography'],
			),
			'title_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['title_color'],
			),
			'text_stroke'      => array(
				'type'      => \Elementor\Group_Control_Text_Stroke::get_type(),
				'label'     => __( 'Text Stroke', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['title_stroke'],
			),
			'text_shadow'      => array(
				'type'      => \Elementor\Group_Control_Text_Shadow::get_type(),
				'label'     => __( 'Text Shadow', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['title_shadow'],
			),
			'title_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['title_padding'],
			),
			'title_margin'     => array(
				'label'      => esc_html__( 'Margin', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['title_margin'],
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
			),
		),
	),
);

return $controls;
