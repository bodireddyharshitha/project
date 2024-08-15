<?php

/**
 * Highlights Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

$selectors = array(
	// General Section.
	'general_typography'       => '{{WRAPPER}} .elementor-widget-container .highlights-content',
	'general_padding'          => array(
		'{{WRAPPER}} .elementor-widget-container .highlights-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'general_margin'           => array(
		'{{WRAPPER}} .elementor-widget-container .highlights-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'general_color'            => array(
		'{{WRAPPER}} .elementor-widget-container .highlights-content' => 'color: {{VALUE}};',
	),
	'general_boxshadow'        => '{{WRAPPER}} .elementor-widget-container .highlights-content',
	'general_border'           => '{{WRAPPER}} .elementor-widget-container .highlights-content',
	'general_background_color' => array(
		'{{WRAPPER}} .elementor-widget-container .highlights-content' => 'background-color: {{VALUE}};',
	),
	'general_border_radius'    => array(
		'{{WRAPPER}} .elementor-widget-container .highlights-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'text_shadow'              => array(
		'{{WRAPPER}} .elementor-widget-container .highlights-content' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
	),
	// Icon.
	'icon_size'               => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-trip-highlights li:before' => 'font-size: {{SIZE}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .wpte-trip-highlights li' => 'padding-left: calc({{SIZE}}{{UNIT}} + 14px);',
	),
	'icon_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .wpte-trip-highlights li:before' => 'background: {{VALUE}};',
	),
);

$controls = array(
	'categories'      => 'wptravelengine',
	'general_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __('General', 'wptravelengine-elementor-widgets'),
		'subcontrols' => array(
			'general_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['general_typography'],
				'label'    => __('Typography', 'wptravelengine-elementor-widgets'),
			),
			'general_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__('Color', 'wptravelengine-elementor-widgets'),
				'selectors' => $selectors['general_color'],
			)
		),
	),
	'icon_section'    => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __('Icon', 'wptravelengine-elementor-widgets'),
		'subcontrols' => array(
			'icon_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__('Color', 'wptravelengine-elementor-widgets'),
				'selectors' => $selectors['icon_color'],
			),
			'icon_size'  => array(
				'type'       => 'SLIDER',
				'label'      => esc_html__('Size', 'wptravelengine-elementor-widgets'),
				'size_units' => array('px', '%', 'em', 'rem'),
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
			)
		),
	),
);

return $controls;
