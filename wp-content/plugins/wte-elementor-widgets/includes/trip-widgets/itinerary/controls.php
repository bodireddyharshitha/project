<?php
/**
 * Itinerary Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$show_tab_titles = apply_filters( 'wpte_show_tab_titles_inside_tabs', true );

if ( ! $show_tab_titles ) {
	return;
}

$selectors = array(
	// General Section.
	'card_typography'         => '{{WRAPPER}} .elementor-widget-container',
	'card_alignment'          => array(
		'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
	),
	'card_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper, {{WRAPPER}} .elementor-widget-container .itinerary, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title span, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .itinerary-content span, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title' => 'color: {{VALUE}};',
	),
	'card_background_color'   => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper, {{WRAPPER}} .elementor-widget-container .itinerary, {{WRAPPER}} .elementor-widget-container .itinerary .advanced-itinerary-row, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row' => 'background-color: {{VALUE}};',
	),
	'card_border'             => '{{WRAPPER}} .elementor-widget-container',
	'card_border_radius'      => array(
		'{{WRAPPER}} .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'card_padding'            => array(
		'{{WRAPPER}} .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'card_margin'             => array(
		'{{WRAPPER}} .elementor-widget-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Title Section.
	'title_typography'        => '{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .wpte-itinerary-title',
	'title_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .wp-travel-engine-itinerary-header .wpte-itinerary-title' => 'color: {{VALUE}};',
	),
	'title_padding'           => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .wp-travel-engine-itinerary-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'title_margin'            => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .wp-travel-engine-itinerary-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Chart Section.
	'chart_typography'        => '{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .altitude-chart-container div',
	'chart_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .altitude-chart-container div' => 'color: {{VALUE}};',
	),
	'chart_background_color'  => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .altitude-chart-container div' => 'background-color: {{VALUE}};',
	),
	'chart_padding'           => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .altitude-chart-container div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'chart_margin'            => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .altitude-chart-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Days Title Section.
	'days_title_typography'   => '{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title',
	'days_title_color'        => array(
		'{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title span' => 'color: {{VALUE}};',
	),
	'days_title_padding'      => array(
		'{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'days_title_margin'       => array(
		'{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .title, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .itinerary-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Days Content Section.
	'days_content_typography' => '{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .itinerary-content .content, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .itinerary-content',
	'days_content_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .itinerary-content .content, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .itinerary-content, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .itinerary-content span' => 'color: {{VALUE}};',
	),
	'days_content_padding'    => array(
		'{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .itinerary-content .content, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .itinerary-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'days_content_margin'     => array(
		'{{WRAPPER}} .elementor-widget-container .wte-trip-itinerary-v2 .itinerary-row .itinerary-content .content, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .itinerary-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Toggle Section.
	'expand_all_toggle'       => array(
		'{{WRAPPER}} .elementor-widget-container .wte-itinerary-header-wrapper .wp-travel-engine-itinerary-header .toggle-button .checkbox' => 'background-color: {{VALUE}};',
	),
	'expand_icon'             => array(
		'{{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .rotator::before, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .rotator::after' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .accordion-tabs-toggle .rotator' => 'border-color: {{VALUE}};color: {{VALUE}}',
	),

	// Icons Section.
	'day_icon'                => array(
		'{{WRAPPER}} .elementor-widget-container .itinerary-row .wte-itinerary-head-wrap .title::before, {{WRAPPER}} .elementor-widget-container .itinerary .itinerary-row .wte-itinerary-head-wrap .title::before, {{WRAPPER}} .title.has-custom-icon .custom-icon' => 'background-color: {{VALUE}};',
	)
);

$controls = array(
	// Content.
	'title_settings'       => array(
		'type'        => 'control_section',
		'label'       => __( 'Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'show_title' => array(
				'label'     => __( 'Show Title', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'wptravelengine-elementor-widgets' ),
				'label_off' => __( 'Hide', 'wptravelengine-elementor-widgets' ),
				'default'   => 'yes',
			),
			'html_tag'   => array(
				'type'    => 'SELECT',
				'label'   => __( 'HTML Tag', 'wptravelengine-elementor-widgets' ),
				'default' => 'h2',
				'options' => array(
					'h1'   => __( 'H1', 'wptravelengine-elementor-widgets' ),
					'h2'   => __( 'H2', 'wptravelengine-elementor-widgets' ),
					'h3'   => __( 'H3', 'wptravelengine-elementor-widgets' ),
					'h4'   => __( 'H4', 'wptravelengine-elementor-widgets' ),
					'h5'   => __( 'H5', 'wptravelengine-elementor-widgets' ),
					'h6'   => __( 'H6', 'wptravelengine-elementor-widgets' ),
					'div'  => __( 'div', 'wptravelengine-elementor-widgets' ),
					'span' => __( 'span', 'wptravelengine-elementor-widgets' ),
					'p'    => __( 'p', 'wptravelengine-elementor-widgets' ),
				),
			),
		),
	),
	'expand_all_settings'  => array(
		'type'        => 'control_section',
		'label'       => __( 'Expand All', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'expand_all'      => array(
				'label'       => __( 'Always Show All Itinerary', 'wptravelengine-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => __( 'Yes', 'wptravelengine-elementor-widgets' ),
				'label_off'   => __( 'No', 'wptravelengine-elementor-widgets' ),
				'default'     => 'yes',
				'description' => __( 'Default: All hidden. Enable this option to always expand all itinerary on intial page load.', 'wptravelengine-elementor-widgets' ),
			),
			'show_expand_all' => array(
				'label'     => __( 'Show Expand All', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'wptravelengine-elementor-widgets' ),
				'label_off' => __( 'Hide', 'wptravelengine-elementor-widgets' ),
				'default'   => 'yes',
			),
			'expand_all_text' => array(
				'label'   => __( 'Expand All Label', 'wptravelengine-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Expand All', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'icon_settings'        => array(
		'type'        => 'control_section',
		'label'       => __( 'Icons', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'first_day_icon'  => array(
				'label'         => __( 'First Day Icon', 'wptravelengine-elementor-widgets' ),
				'type'          => \Elementor\Controls_Manager::ICONS,
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'fas fa-map-marker-alt',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
			),
			'last_day_icon'   => array(
				'label'         => __( 'Last Day Icon', 'wptravelengine-elementor-widgets' ),
				'type'          => \Elementor\Controls_Manager::ICONS,
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'fas fa-map-marker-alt',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
			),
			'expand_on_icon'  => array(
				'label'         => __( 'Expand On Icon', 'wptravelengine-elementor-widgets' ),
				'type'          => \Elementor\Controls_Manager::ICONS,
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'fas fa-minus',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
			),
			'expand_off_icon' => array(
				'label'         => __( 'Expand Off Icon', 'wptravelengine-elementor-widgets' ),
				'type'          => \Elementor\Controls_Manager::ICONS,
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'fas fa-plus',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
			),
		),
	),
	'additional_settings'  => defined( 'WTEAI_VERSION' ) ? array(
		'type'        => 'control_section',
		'label'       => __( 'Additional', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'show_chart' => array(
				'label'     => __( 'Show Chart', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'wptravelengine-elementor-widgets' ),
				'label_off' => __( 'Hide', 'wptravelengine-elementor-widgets' ),
				'default'   => 'yes',
			),
		),
	) : array(),
	// Style.
	'general_section'      => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'card_typography'       => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['card_typography'],
			),
			'card_color'            => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['card_color'],
			),
			'card_background_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['card_background_color'],
			),
			'card_border'           => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'label'    => __( 'Border', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['card_border'],
			),
			'card_border_radius'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['card_border_radius'],
			),
			'card_padding'          => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%x', 'em' ),
				'selectors'  => $selectors['card_padding'],
			),
			'card_margin'           => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%x', 'em' ),
				'selectors'  => $selectors['card_margin'],
			),
		),
	),
	'title_section'        => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['title_typography'],
			),
			'title_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['title_color'],
			),
			'title_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => $selectors['title_padding'],
			),
			'title_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
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
	'chart_section'        => defined( 'WTEAI_VERSION' ) ? array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Chart', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'chart_typography'       => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['chart_typography'],
			),
			'chart_color'            => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['chart_color'],
			),
			'chart_background_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['chart_background_color'],
			),
			'chart_margin'           => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['chart_margin'],
			),
		),
	) : array(),
	'days_title_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Days Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'days_title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['days_title_typography'],
			),
			'days_title_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['days_title_color'],
			),
			'days_title_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['days_title_padding'],
			),
			'days_title_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => $selectors['days_title_margin'],
			),
		),
	),
	'days_content_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Days Content', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'days_content_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['days_content_typography'],
			),
			'days_content_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['days_content_color'],
			),
			'days_content_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => $selectors['days_content_padding'],
			),
			'days_content_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => $selectors['days_content_margin'],
			),
		),
	),
	'toggle_section'       => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Toggle', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'expand_all_toggle' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Expand All Toggle Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['expand_all_toggle'],
			),
			'expand_icon'       => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Expand Icon Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['expand_icon'],
			)
		),
	),
	'icon_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Icons', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'day_icon'       => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['day_icon'],
			)
		),
	),
);

return $controls;
