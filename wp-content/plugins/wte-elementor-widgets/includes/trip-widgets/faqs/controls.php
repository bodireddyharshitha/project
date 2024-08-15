<?php
/**
 * Trip-faqs Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

$selectors = array(
	// General section.
	'expand_all_typography'   => '{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .expand-all-button label',
	'expand_all_color'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .expand-all-button label' => 'color: {{VALUE}};',
	),
	'generals_padding'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'generals_margin'         => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'generals_gap'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
	),

	// Title.
	'title_typography'        => '{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title',
	'title_padding'           => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'title_margin'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'title_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title' => 'color: {{VALUE}};',
	),
	'title_text_shadow'       => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
	),
	'title_text_stroke'       => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title',
	),
	'title_alignment'         => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-header .wpte-faqs-title' => 'text-align: {{VALUE}};',
	),

	// Faqs title.
	'faqs_typography'         => '{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .faq-title',
	'faqs_padding'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .faq-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'faqs_margin'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .faq-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'faqs_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .faq-title' => 'color: {{VALUE}};',
	),
	'faqs_background_color'   => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .faq-title' => 'background-color: {{VALUE}};',
	),

	// Faqs content.
	'faqs_content_typography' => '{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .faq-content',
	'faqs_content_padding'    => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .faq-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'faqs_content_margin'     => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .faq-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'faqs_content_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .faq-content' => 'color: {{VALUE}};',
	),

	// Toogle.
	'toogle_background_color' => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .expand-all-button input[type=checkbox]:checked' => 'background-color: {{VALUE}};',
	),

	// Icon.
	'icon_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .rotator:before,
		{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .rotator:after' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .post-data .wp-travel-engine-faq-tab-content .faq-row .accordion-tabs-toggle .rotator' => 'border-color: {{VALUE}};',
	),
);

$controls = array(
	'title'                => __( 'Trip - FAQs', 'wptravelengine-elementor-widgets' ),
	'expand_all_settings'  => array(
		'type'        => 'control_section',
		'label'       => __( 'Expand All', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'show_expand_all'  => array(
				'label'     => __( 'Show Expand All', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'wptravelengine-elementor-widgets' ),
				'label_off' => __( 'Hide', 'wptravelengine-elementor-widgets' ),
				'default'   => 'yes',
			),
			'expand_all_label' => array(
				'label'   => __( 'Expand All Label', 'wptravelengine-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Expand All', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'faqs_title'           => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Faq Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'faq_title_typography'       => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['faqs_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'faq_title_color'            => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['faqs_color'],
			),
			'faq_title_padding'          => array(
				'label'      => esc_html__( 'Padding', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['faqs_padding'],
			),
			'faq_title_margin'           => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['faqs_margin'],
			),
			'faq_title_background_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['faqs_background_color'],
			),

		),
	),
	'faqs_content_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( ' Faq Content', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'faqs_content_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['faqs_content_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'faqs_content_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['faqs_content_color'],
			),
			'faqs_content_padding'    => array(
				'label'      => esc_html__( 'Padding', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['faqs_content_padding'],
			),
			'faqs_content_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['faqs_content_margin'],
			),
		),
	),
	'toogle_section'       => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Toogle', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'toogle_background_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['toogle_background_color'],
			),
		),
	),
	'icon_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Icon', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'icon_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['icon_color'],
			),
		),
	),
);

return $controls;
