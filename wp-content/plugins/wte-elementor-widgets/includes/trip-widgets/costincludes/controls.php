<?php
/**
 * Trip Cost Includes Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

$selectors = array(
	// Cost Includes.
	'costincludes_typography' => '{{WRAPPER}} .elementor-widget-container .post-data .content ul li',
	'color'                   => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content ul li' => 'color: {{VALUE}};',
	),
	'costincludes_margin'     => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),

	// Icon.
	'icon_size'               => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content ul li:before, {{WRAPPER}} .elementor-widget-container .post-data .content .custom-icon li i, {{WRAPPER}} .elementor-widget-container .post-data .content .custom-icon li svg' => 'font-size: {{SIZE}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .post-data .content ul li, {{WRAPPER}} ul#include-result li' => 'padding-left: calc({{SIZE}}{{UNIT}} + 14px);',
	),
	'icon_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content #include-result li:before' => 'background: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .post-data .content .custom-icon li i, {{WRAPPER}} .elementor-widget-container .post-data .content .custom-icon li svg' => 'color: {{VALUE}};',
	),
);

$controls = array(
	'title'           => __( 'Trip Cost Includes/Excludes', 'wptravelengine-elementor-widgets' ),
	'icon'            => 'wtei-b-trips',
	'categories'      => 'wptravelengine',
	'controls'        => array(),
	'general_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'List Items', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'cost_typography'     => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['costincludes_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'color'               => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['color'],
			),
			'costincludes_margin' => array(
				'label'      => esc_html__( 'Margin', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['costincludes_margin'],
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
				'type'       => 'SLIDER',
				'label'      => esc_html__( 'Size', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em', 'rem' ),
				'default'    => array(
					'size' => 20,
				),
				'range'      => array(
					'px' => array(
						'min' => 6,
						'max' => 40,
					),
					'%'  => array(
						'min' => 6,
						'max' => 40,
					),
				),
				'selectors'  => $selectors['icon_size'],
			),
			'icon'       => array(
				'type'          => \Elementor\Controls_Manager::ICONS,
				'label'         => esc_html__( 'Custom Upload', 'wptravelengine-elementor-widgets' ),
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'eicon-check',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
			),
		),
	),
);

return $controls;
