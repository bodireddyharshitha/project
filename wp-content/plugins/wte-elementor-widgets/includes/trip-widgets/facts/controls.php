<?php
/**
 * Facts Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$selectors = array(
	// Title.
	'facts_title_typography'   => '{{WRAPPER}} .elementor-widget-container .secondary-trip-info ul.trip-facts-value li label',
	'facts_title_color'        => array(
		'{{WRAPPER}} .elementor-widget-container .secondary-trip-info ul.trip-facts-value li label' => 'color: {{VALUE}};',
	),
	// Content.
	'facts_content_typography' => '{{WRAPPER}} .elementor-widget-container .secondary-trip-info ul.trip-facts-value li .wte-trip-fact-content-wrapper .value',
	'facts_content_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .secondary-trip-info ul.trip-facts-value li .wte-trip-fact-content-wrapper .value' => 'color: {{VALUE}};',
	),
	// Icon.
	'icon_color'               => array(
		'{{WRAPPER}} .elementor-widget-container .secondary-trip-info ul.trip-facts-value li .icon-holder' => 'color: {{VALUE}};',
	),
	'icon_size'                => array(
		'{{WRAPPER}} .elementor-widget-container .secondary-trip-info .wte-trip-facts .trip-facts-value .trip-facts .wte-trip-fact-icon-wrapper .icon-holder' => 'font-size: {{SIZE}}{{UNIT}};',
	),
);


$controls = array(
	'icon_settings'   => array(
		'type'        => 'control_section',
		'label'       => __( 'Icon Controls', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'icon_alignment'     => array(
				'label'   => esc_html__( 'Icon Position', 'wptravelengine-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Top', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-v-align-top',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default' => 'left',
				'toggle'  => true,
			),
			'vertical_alignment' => array(
				'label'   => esc_html__( 'Vertical Alignment', 'wptravelengine-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'wptravelengine-elementor-widgets' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default' => 'top',
				'toggle'  => true,
			),
			'noofcolumn'         => array(
				'type'    => 'NUMBER',
				'label'   => __( 'Number of columns', 'wptravelengine-elementor-widgets' ),
				'default' => 3,
				'min'     => '1',
				'max'     => '4',
			),
			'factsgap'           => array(
				'label'      => __( 'Column Gap', 'wptravelengine-elementor-widgets' ),
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
					'{{WRAPPER}} .elementor-widget-container .secondary-trip-info ul.trip-facts-value' => '--gap: {{SIZE}}{{UNIT}};',
				),
			),
		),
	),
	'title_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'facts_title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['facts_title_typography'],
			),
			'facts_title_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['facts_title_color'],
			),
		),
	),
	'content_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Content', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'facts_content_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['facts_content_typography'],
			),
			'facts_content_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['facts_content_color'],
			),
		),
	),
	'icon_section'    => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Icon', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'icon_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['icon_color'],
			),
			'icon_size'  => array(
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Size', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['icon_size'],
				'range'     => array(
					'px' => array(
						'min'  => 6,
						'max'  => 100,
						'step' => 1,
					),
				),
			),
		),
	),
);

return $controls;
