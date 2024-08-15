<?php

/**
 * Trip Fixed Starting Date Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

global $post;
$tab_content = false;
$args        = array(
	'post_id'       => $post->ID,
	'is_tab_conent' => $tab_content,
);

$wte_fixed_starting_dates_option_settings = wp_travel_engine_get_settings();
$wte_fixed_starting_dates_setting         = get_post_meta( $args['post_id'], 'WTE_Fixed_Starting_Dates_setting', true );
$section_title                            = isset( $wte_fixed_starting_dates_option_settings['departure']['section_title'] ) && '' !== $wte_fixed_starting_dates_option_settings['departure']['section_title'] ? $wte_fixed_starting_dates_option_settings['departure']['section_title'] : __( 'Join Our Fixed Trip Starting Date', 'wptravelengine-elementor-widgets' );

$section_title = isset( $wte_fixed_starting_dates_setting['availability_title'] ) && '' !== $wte_fixed_starting_dates_setting['availability_title'] ? $wte_fixed_starting_dates_setting['availability_title'] : $section_title;

$selectors = array(
	// title.
	'typography'                  => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates, {{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select',
	'color'                       => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd.dd table tbody td' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr th' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select' => 'color: {{VALUE}};',
	),

	'title_color'                 => array(
		'{{WRAPPER}} .elementor-widget-container .wte-fsd-list-container .wte-fsd-list-header .section_title' => 'color: {{VALUE}};',
	),
	'title_margin'                => array(
		'{{WRAPPER}} .elementor-widget-container .wte-fsd-list-container .wte-fsd-list-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container .wte-fsd-list-container .wte-fsd-list-header .section_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Book Now Button.
	'booknow_typography'          => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn',
	'booknow_padding'             => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'booknow_margin'              => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	'booknow_bgcolor'             => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn' => 'background-color: {{VALUE}};',
	),
	'booknow_color'               => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn' => 'color: {{VALUE}};',
	),
	'booknow_border'              => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn',
	'booknow_border_radius'       => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'booknow_boxshadow'           => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn',

	// Book Now Button Hover.
	'booknow_bg_hover_color'      => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn:hover' => 'background-color: {{VALUE}};',
	),
	'booknow_hover_color'         => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn:hover' => 'color: {{VALUE}};',
	),
	'booknow_hover_border'        => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn:hover',
	'booknow_hover_border_radius' => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'booknow_hover_boxshadow'     => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .book-btn:hover',

	// LoadMore and ShowLess Button.
	'button_typography'           => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore, {{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess',
	'button_padding'              => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_margin'               => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	'button_bg_color'             => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess' => 'background-color: {{VALUE}};',
	),
	'button_color'                => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess' => 'color: {{VALUE}};',
	),
	'button_border'               => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore, {{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess',
	'button_border_radius'        => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_boxshadow'            => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore, {{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess',

	// LoadMore and ShowLess Button Hover.
	'button_bg_hover_color'       => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore:hover' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess:hover' => 'background-color: {{VALUE}};',
	),
	'button_hover_color'          => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore:hover' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess:hover' => 'color: {{VALUE}};',
	),
	'button_hover_border'         => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore:hover, {{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess:hover',
	'button_hover_border_radius'  => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_hover_boxshadow'      => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .loadMore:hover, {{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-fsd-frontend-holder-dd .showLess:hover',

	// Icon.
	'icon_color'                  => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .svg-inline--fa' => 'color: {{VALUE}};',
	),
	'icon_size'                   => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates #nestable1 .dd-list table tr .svg-inline--fa' => 'font-size: {{SIZE}}{{UNIT}};',
	),

	// Choose a date.
	'chooseDate_padding'          => array(
		'{{WRAPPER}} #wte-fixed-departure-dates .select2-container--default .select2-selection--single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'chooseDate_color'            => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .select2-container--default .select2-selection--single .select2-selection__rendered' => 'color: {{VALUE}};',
	),
	'chooseDate_bg_color'         => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .select2-container--default .select2-selection--single' => 'background-color: {{VALUE}};',
	),
	'chooseDate_border'           => '{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select,
	{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .select2-container--default .select2-selection--single',
	'chooseDate_border_radius'    => array(
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .wpte-enhanced-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .elementor-widget-container #wte-fixed-departure-dates .wte-user-input .select2-container--default .select2-selection--single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
);

$controls = array(
	'table_display_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Table Headers', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'dateLabel'         => array(
				'default' => __( 'TRIP DATES', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Date Label', 'wptravelengine-elementor-widgets' ),
			),
			'availabilityLabel' => array(
				'default' => __( 'AVAILABILITY', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Availability Label', 'wptravelengine-elementor-widgets' ),
			),
			'priceLabel'        => array(
				'default' => __( 'PRICE', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Price Label', 'wptravelengine-elementor-widgets' ),
			),
			'spaceLabel'        => array(
				'default' => __( 'SPACE LEFT', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Space Left Label', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'button_settings'        => array(
		'type'        => 'control_section',
		'label'       => __( 'Button Labels', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'loadMore' => array(
				'default' => __( 'Load More', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Load More label', 'wptravelengine-elementor-widgets' ),
			),
			'showLess' => array(
				'default' => __( 'Show Less', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Show Less label', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'general_section'        => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['color'],
			),
		),
	),
	'booknow_button_style'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Book Now Button', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'booknow_typography'  => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['booknow_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'booknow_padding'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['booknow_padding'],
			),
			'booknow_margin'      => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['booknow_margin'],
			),
			'booknow_button_tabs' => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'booknow_button_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'booknow_bgcolor'       => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['booknow_bgcolor'],
							),
							'booknow_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['booknow_color'],
							),
							'booknow_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['booknow_border'],
							),
							'booknow_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['booknow_border_radius'],
							),
							'booknow_boxshadow'     => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['booknow_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'booknow_button_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'booknow_bg_hover_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['booknow_bg_hover_color'],
							),
							'booknow_hover_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['booknow_hover_color'],
							),
							'booknow_hover_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['booknow_hover_border'],
							),
							'booknow_hover_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['booknow_hover_border_radius'],
							),
							'booknow_hover_boxshadow'     => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['booknow_hover_boxshadow'],
								'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
				),
			),
		),
	),
	'button_style'           => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Loader Buttons', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'button_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['button_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
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
		),
	),
	'choose_date'            => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Date Dropdown', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'chooseDate_padding'       => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['chooseDate_padding'],
				'default'	 => [
					'top'    => '5',
					'right'  => '32',
					'bottom' => '5',
					'left'   => '10',
				]
			),
			'chooseDate_color'         => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['chooseDate_color'],
				'default'   => '#999',
			),
			'chooseDate_bg_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['chooseDate_bg_color'],
			),
			'chooseDate_border'        => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['chooseDate_border'],
				'default'  => [
					'width' => '1',
					'type' => 'solid',
					'color' => '#eaeaea',
				]
			),
			'chooseDate_border_radius' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['chooseDate_border_radius'],
			),
		),
	),
	'icon_section'           => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Icon', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'icon_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['icon_color'],
			),
			'icon_size'  => array(
				'type'       => 'SLIDER',
				'label'      => esc_html__( 'Icon Size', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em', 'rem' ),
				'default'    => array(
					'size' => 16,
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 30,
					),
					'%'  => array(
						'min' => 10,
						'max' => 30,
					),
				),
				'separator'  => 'before',
				'selectors'  => $selectors['icon_size'],
			),
		),
	),
);

return $controls;
