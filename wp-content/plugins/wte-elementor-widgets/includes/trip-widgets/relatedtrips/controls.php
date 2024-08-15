<?php
/**
 * Related Trips Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

$layout_options = array(
	'grid' => __( 'Grid', 'wptravelengine-elementor-widgets' ),
	'list' => __( 'List', 'wptravelengine-elementor-widgets' ),
);

$taxonomies = array(
	'destination' => __( 'Destination', 'wptravelengine-elementor-widgets' ),
	'activities'  => __( 'Activities', 'wptravelengine-elementor-widgets' ),
	'trip_types'  => __( 'Trip Types', 'wptravelengine-elementor-widgets' ),
	'difficulty'  => __( 'Difficulty', 'wptravelengine-elementor-widgets' ),
	'trip_tag'    => __( 'Trip Tag', 'wptravelengine-elementor-widgets' ),
);

$slider_settings = array();
if ( version_compare( \WP_TRAVEL_ENGINE_VERSION, '5.3.6', '>' ) ) {
	$layout_options['slider'] = __( 'Slider', 'wptravelengine-elementor-widgets' );
	$search_form_filters      = array();
	if ( isset( $wte_blocks_registration_args['trip-search']['attributes']['searchFilters']['default'] ) ) {
		$search_form_filters = $wte_blocks_registration_args['trip-search']['attributes']['searchFilters']['default'];
	}
	$terms_display_settings = array();
	foreach ( $taxonomies as $filter_name => $filter_args ) {
		$terms_display_settings['tax_relation']                    = array(
			'label'        => __( 'Enable Tax Relation', 'wptravelengine-elementor-widgets' ) . WPTRAVELENGINEEB_NEWCONTROL,
			'type'         => 'SWITCHER',
			'default'      => 'OR',
			'return_value' => 'OR',
			'description'  => 'This includes trips with at least one selected term enabled.',
			'condition'    => array(
				'listby' => 'byterms',
			),
			'label_on'     => 'OR',
			'label_off'    => 'AND',
		);
		$terms_display_settings[ "{$filter_name}_termstoDisplay" ] = array(
			'type'          => 'TAXONOMY_TERMS_SELECT2',
			'label'         => $filter_args . WPTRAVELENGINEEB_NEWCONTROL,
			'taxonomy_name' => $filter_name,
			'condition'     => array(
				'listby' => 'byterms',
			),
			'multiple'      => true,
		);
	}
	$slider_settings = array(
		'slider.slidesPerViewDesktop' => array(
			'type'          => \Elementor\Controls_Manager::NUMBER,
			'label'         => __( 'Slides Number', 'wptravelengine-elementor-widgets' ),
			'default'       => 3,
			'is_responsive' => true,
			'condition'     => array( 'layout' => 'slider' ),
		),
		'slider.spaceBetween'         => array(
			'type'      => 'NUMBER',
			'label'     => __( 'Space Between Slides', 'wptravelengine-elementor-widgets' ),
			'default'   => 30,
			'condition' => array( 'layout' => 'slider' ),
		),
		'slider.autoplay'             => array(
			'type'      => 'SWITCHER',
			'label'     => __( 'Autoplay', 'wptravelengine-elementor-widgets' ),
			'default'   => 'yes',
			'condition' => array( 'layout' => 'slider' ),
		),
		'slider.autoplaydelay'        => array(
			'type'      => 'NUMBER',
			'label'     => __( 'Autoplay Speed', 'wptravelengine-elementor-widgets' ),
			'default'   => 3000,
			'condition' => array( 'layout' => 'slider' ),
		),
		'slider.loop'                 => array(
			'type'      => 'SWITCHER',
			'label'     => __( 'Loop', 'wptravelengine-elementor-widgets' ),
			'default'   => 'yes',
			'condition' => array( 'layout' => 'slider' ),
		),
		'slider.speed'                => array(
			'type'      => 'NUMBER',
			'label'     => __( 'Transition Speed (ms)', 'wptravelengine-elementor-widgets' ),
			'default'   => 300,
			'condition' => array( 'layout' => 'slider' ),
		),
		'slider.arrow'                => array(
			'type'          => \Elementor\Controls_Manager::SWITCHER,
			'label'         => __( 'Slider Arrow', 'wptravelengine-elementor-widgets' ),
			'default'       => 'yes',
			'condition'     => array( 'layout' => 'slider' ),
			'is_responsive' => true,
			'condition'     => array( 'layout' => 'slider' ),
		),
		'slider.pagination'           => array(
			'type'          => \Elementor\Controls_Manager::SWITCHER,
			'label'         => __( 'Slider Pagination', 'wptravelengine-elementor-widgets' ),
			'default'       => 'yes',
			'condition'     => array( 'layout' => 'slider' ),
			'is_responsive' => true,
			'condition'     => array( 'layout' => 'slider' ),
		),
	);
}

$selectors = array(
	// general section.
	'card_typography'                  => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap',
	'card_boxshadow'                   => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap',
	'card_border'                      => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap',
	'card_alignment'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap' => 'text-align: {{VALUE}};',
	),
	'card_padding'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'card_margin'                      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'card_background_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap' => 'background-color: {{VALUE}};',
	),
	'card_border_radius'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
	),
	'card_boxshadow_hover'             => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:hover .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap:hover',
	'card_border_hover'                => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:hover .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap:hover',
	'card_background_hover_color'      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:hover .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap:hover' => 'background-color: {{VALUE}};',
	),
	'card_border_radius_hover'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:hover .wpte-inner-container, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:hover .wpte-inner-container .wpte-trip-image-wrap figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
	),

	// image.
	'image_scale'                      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure img, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-fig > a img' => 'object-fit: {{VALUE}};',
	),
	'image_width'                      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure img, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-fig > a img' => 'width: {{SIZE}}{{UNIT}};',
	),
	'image_height'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure img, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-fig > a img' => 'height: {{SIZE}}{{UNIT}};',
	),
	'animation_type'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure img, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-fig > a img' => 'transition-timing-function: {{VALUE}};',
	),
	'img_animation_duration'           => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure img, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-fig > a img' => 'transition-duration: {{VALUE}}s;',
	),
	'image_border_radius'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-image-wrap figure, {{WRAPPER}} .wpte-elementor-widget .category-trips-single .category-trips-single-inner-wrap .category-trip-fig > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// title.
	'title_typography'                 => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-header-wrap .wpte-trip-title, {{WRAPPER}} .wpte-elementor-widget .category-trip-prc-title-wrap .category-trip-title',
	'title_color'                      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-header-wrap .wpte-trip-title, {{WRAPPER}} .wpte-elementor-widget .category-trip-prc-title-wrap .category-trip-title' => 'color: {{VALUE}};',
	),
	'title_color_hover'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-header-wrap .wpte-trip-title a:hover, {{WRAPPER}} .wpte-elementor-widget .category-trip-prc-title-wrap .category-trip-title a:hover' => 'color: {{VALUE}};',
	),
	'title_margin'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-header-wrap .wpte-trip-title, {{WRAPPER}} .wpte-elementor-widget .category-trip-prc-title-wrap .category-trip-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// content.
	'content_typography'               => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-content, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-content-wrap .category-trip-desc',
	'content_color'                    => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-content, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-content-wrap .category-trip-desc' => 'color: {{VALUE}};',
	),
	'content_padding'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-details-wrap, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-content-wrap' => 'padding-bottom: 0;',
		'{{WRAPPER}} .wpte-elementor-widget .category-trip-aval-time' => 'margin-top: {{BOTTOM}}{{UNIT}};',
	),

	// meta.
	'meta_typography'                  => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-meta',
	'meta_color'                       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-meta' => 'color: {{VALUE}};',
	),
	'meta_hover_color'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-meta a:hover' => 'color: {{VALUE}};',
	),
	'meta_icon_color'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-meta [class*="wpte-icon-"]' => 'color: {{VALUE}} !important;',
	),
	'meta_spacing'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-meta-list' => '--meta-spacing: {{SIZE}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .category-trip-desti .wpte-trip-meta:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}}',
	),
	'meta_margin'                      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip_meta-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'meta_hover_text'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-meta a:hover' => 'text-decoration: {{VALUE}} !important;',
	),

	// price.
	'price_typography'                 => '{{WRAPPER}} .wpte-elementor-widget .price-holder .actual-price, {{WRAPPER}} .wpte-elementor-widget .wpte-trip-price-wrap ins',
	'price_color'                      => array(
		'{{WRAPPER}} .wpte-elementor-widget .price-holder .actual-price, {{WRAPPER}} .wpte-elementor-widget .wpte-trip-price-wrap ins' => 'color: {{VALUE}};',
	),
	'strike_typography'                => '{{WRAPPER}} .wpte-elementor-widget .price-holder .striked-price, {{WRAPPER}} .wpte-elementor-widget .wpte-trip-price-wrap del',
	'strike_color'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .price-holder .striked-price, {{WRAPPER}} .wpte-elementor-widget .wpte-trip-price-wrap del' => 'color: {{VALUE}};',
	),


	// feat tag.
	'feat_tag_color'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:not(.wpte-layout-4) .featured-text-wrap .featured-text, {{WRAPPER}} .wpte-elementor-widget .category-feat-ribbon .category-feat-ribbon-txt' => 'color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .featured-text-wrap svg path' => 'fill: {{VALUE}};',
	),
	'feat_tag_bg_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single:not(.wpte-layout-4) .featured-text-wrap, {{WRAPPER}} .wpte-elementor-widget .category-feat-ribbon .category-feat-ribbon-txt' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-single.wpte-layout-4 .featured-text-wrap .featured-icon' => 'background-color: {{VALUE}};',
	),

	// discounttag.
	'discount_tag_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .discount-text-wrap .discount-percent, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-discount' => 'color: {{VALUE}};',
	),
	'discount_tag_bg_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .discount-text-wrap .discount-percent, {{WRAPPER}} .wpte-elementor-widget .category-trips-single-inner-wrap .category-trip-discount' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .discount-text-wrap::after' => 'background-color: {{VALUE}};',
	),

	// button.
	'button_typography'                => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn',
	'button_padding'                   => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_margin'                    => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_bg_color'                  => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn' => 'background-color: {{VALUE}};',
	),
	'button_color'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn' => 'color: {{VALUE}};',
	),
	'button_border'                    => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn',
	'button_border_radius'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_boxshadow'                 => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn',
	'button_bg_hover_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn:hover, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn:hover' => 'background-color: {{VALUE}};',
	),
	'button_hover_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn:hover, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn:hover' => 'color: {{VALUE}};',
	),
	'button_hover_border'              => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn:hover',
	'button_hover_border_radius'       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn:hover, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_hover_boxshadow'           => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-btn-wrap .wpte-trip-explore-btn:hover, {{WRAPPER}} .wpte-elementor-widget .category-trip-viewmre-btn:hover',

	// dates.
	'date_typography'                  => '{{WRAPPER}} .wpte-elementor-widget .category-trip-avl-tip-inner-wrap .category-available-trip-text',
	'date_title_color'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-trip-avl-tip-inner-wrap .category-available-trip-text' => 'color: {{VALUE}};',
	),
	'date_month_color'                 => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-trip-avl-tip-inner-wrap .category-available-months li a' => 'color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .category-trip-avl-tip-inner-wrap .category-available-months li a.disabled' => 'opacity: 0.3;',
	),
	'date_month_hover_color'           => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-trip-avl-tip-inner-wrap .category-available-months li a:hover' => 'color: {{VALUE}};',
	),

	// rating.
	'rating_typography'                => '{{WRAPPER}} .wpte-elementor-widget .wpte-trip-review-stars .wpte-trip-review-count',
	'rating_color'                     => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-review-stars .wpte-trip-review-count' => 'color: {{VALUE}};',
	),
	'rating_margin'                    => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-trip-review-stars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// slider.
	'slider_dots_active_color'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
	),
	'slider_dots_color'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
	),
	'slider_dots_spacing'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_padding'             => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_bg_color'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'background-color: {{VALUE}};',
	),
	'slider_arrow_color'               => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'color: {{VALUE}};',
	),
	'slider_arrow_bg_color_hover'      => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover' => 'background-color: {{VALUE}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover' => 'background-color: {{VALUE}};',
	),
	'slider_arrow_color_hover'         => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover' => 'color: {{VALUE}};',
	),
	'slider_arrow_border'              => '{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next',
	'slider_arrow_border_radius'       => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_arrow_box_shadow'          => '{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next',
	'slider_arrow_border_hover'        => '{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover',
	'slider_arrow_border_radius_hover' => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev:hover, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'slider_dots_alignment'            => array(
		'{{WRAPPER}} .wpte-elementor-widget .category-slider .wpte-swiper-pagination' => 'text-align: {{VALUE}};',
	),

	// slider arrow.
	'slider_arrow_size'                => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev, {{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}};',
	),
	'slider_arrow_offset'              => array(
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
		'{{WRAPPER}} .wpte-elementor-widget .wpte-swiper-navigation .wpte-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
	),
);

$controls = array(
	'block_layout_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Layout', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'layout'           => array(
				'label'   => __( 'Card View', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SELECT',
				'options' => array(
					'grid'   => __( 'Grid', 'wptravelengine-elementor-widgets' ),
					'list'   => __( 'List', 'wptravelengine-elementor-widgets' ),
					'slider' => __( 'Slider', 'wptravelengine-elementor-widgets' ),
				),
				'default' => 'grid',
			),
			'tripsCountPerRow' => array(
				'type'          => \Elementor\Controls_Manager::NUMBER,
				'min'           => '2',
				'max'           => '4',
				'label'         => __( 'Columns', 'wptravelengine-elementor-widgets' ),
				'default'       => '3',
				'is_responsive' => true,
				'condition'     => array( 'layout' => 'grid' ),
			),
			'tripsgap'         => array(
				'devices'        => array( 'desktop', 'tablet', 'mobile' ),
				'label'          => __( 'Column Gap', 'wptravelengine-elementor-widgets' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'range'          => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'        => array(
					'size' => 30,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 20,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .elementor-widget-container .wpte-elementor-widget .wpte-trip-list-wrapper' => '--gap: {{SIZE}}{{UNIT}};',
				),
				'condition'      => array( 'layout!' => 'slider' ),
			),
			'trips_row_gap'    => array(
				'label'          => __( 'Row Gap', 'wptravelengine-elementor-widgets' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => array( 'px', '%' ),
				'range'          => array(
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
				'default'        => array(
					'size' => 50,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 20,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}} .elementor-widget-container .wpte-elementor-widget .wpte-trip-list-wrapper' => 'row-gap: {{SIZE}}{{UNIT}};',
				),
				'condition'      => array( 'layout!' => 'slider' ),
			),
			'cardlayout'       => array(
				'label'     => __( 'Widget Layouts', 'wptravelengine-elementor-widgets' ),
				'type'      => 'SELECT',
				'options'   => array(
					1 => __( 'Layout 1', 'wptravelengine-elementor-widgets' ),
					2 => __( 'Layout 2', 'wptravelengine-elementor-widgets' ),
					3 => __( 'Layout 3', 'wptravelengine-elementor-widgets' ),
					4 => __( 'Layout 4', 'wptravelengine-elementor-widgets' ),
					5 => __( 'Layout 5', 'wptravelengine-elementor-widgets' ),
				),
				'default'   => 1,
				'condition' => array(
					'layout!' => array( 'list' ),
				),
			),
		),
	),
	'sorting_filtering'     => array(
		'type'        => 'control_section',
		'label'       => __( 'Query', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'listby'         => array(
				'type'    => 'SELECT',
				'label'   => __( 'Show Trips By', 'wptravelengine-elementor-widgets' ),
				'default' => 'activities',
				'options' => array(
					'activities'  => __( 'Activities', 'wptravelengine-elementor-widgets' ),
					'destination' => __( 'Destinations', 'wptravelengine-elementor-widgets' ),
					'trip_types'  => __( 'Trip Type', 'wptravelengine-elementor-widgets' ),
					'difficulty'  => __( 'Difficulty', 'wptravelengine-elementor-widgets' ),
					'trip_tag'    => __( 'Trip Tag', 'wptravelengine-elementor-widgets' ),
					'byid'        => __( 'Choose from the List', 'wptravelengine-elementor-widgets' ),
				),
			),
			'tripsCount'     => array(
				'type'      => 'NUMBER',
				'label'     => __( 'Number of Trips', 'wptravelengine-elementor-widgets' ),
				'default'   => 6,
				'min'       => '1',
				'condition' => array(
					'listby!' => 'byid',
				),
			),
			'tripsToDisplay' => array(
				'type'      => 'tripselector',
				'label'     => __( 'Select Trips', 'wptravelengine-elementor-widgets' ),
				'default'   => array(),
				'multiple'  => true,
				'condition' => array(
					'listby' => 'byid',
				),
			),
		),
	),
	'additional_settings'   => array(
		'type'        => 'control_section',
		'label'       => __( 'Additional', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'showDescription'       => array(
				'label'   => __( 'Trip Description', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'excerptLength'         => array(
				'label'     => __( 'Max number of words in description', 'wptravelengine-elementor-widgets' ),
				'type'      => 'NUMBER',
				'default'   => 20,
				'min'       => '1',
				'condition' => array( 'showDescription' => 'yes' ),
			),
			'showFeaturedImage'     => array(
				'label'   => __( 'Featured Image', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showFeaturedRibbon'    => array(
				'label'   => __( 'Featured Ribbon', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showTitle'             => array(
				'label'   => __( 'Title', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showPrice'             => array(
				'label'   => __( 'Price', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showStrikedPrice'      => array(
				'label'   => __( 'Show striked price on sale', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showDuration'          => array(
				'label'   => __( 'Duration', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'durationType'          => array(
				'type'      => 'SELECT',
				'label'     => __( 'Duration Type', 'wptravelengine-elementor-widgets' ),
				'default'   => 'days',
				'options'   => array(
					'both'   => __( 'Both Days & Nights', 'wptravelengine-elementor-widgets' ),
					'days'   => __( 'Days only', 'wptravelengine-elementor-widgets' ),
					'nights' => __( 'Nights only', 'wptravelengine-elementor-widgets' ),
				),
				'condition' => array( 'showDuration' => 'yes' ),
			),
			'showLocation'          => array(
				'label'   => __( 'Location', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showReviews'           => array(
				'label' => __( 'Reviews', 'wptravelengine-elementor-widgets' ),
				'type'  => 'SWITCHER',
			),
			'showDiscount'          => array(
				'label'   => __( 'Discount', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
			'showGroupSize'         => array(
				'label' => __( 'Group Size', 'wptravelengine-elementor-widgets' ),
				'type'  => 'SWITCHER',
			),
			'showActivities'        => array(
				'label' => __( 'Trip Activities', 'wptravelengine-elementor-widgets' ),
				'type'  => 'SWITCHER',
			),
			'showTripType'          => array(
				'label' => __( 'Trip Type', 'wptravelengine-elementor-widgets' ),
				'type'  => 'SWITCHER',
			),
			'showTripAvailableTime' => array(
				'label' => __( 'Trip Available Times', 'wptravelengine-elementor-widgets' ),
				'type'  => 'SWITCHER',
			),
			'showViewMoreButton'    => array(
				'label' => __( 'View Details button', 'wptravelengine-elementor-widgets' ),
				'type'  => 'SWITCHER',
			),
			'viewMoreButtonText'    => array(
				'default'   => __( 'View Details', 'wptravelengine-elementor-widgets' ),
				'type'      => 'TEXT',
				'condition' => array( 'showViewMoreButton' => 'yes' ),
				'label'     => __( 'Button label', 'wptravelengine-elementor-widgets' ),
				'condition' => array( 'showViewMoreButton' => 'yes' ),
			),
		),
	),
	'slider_settings'       => array(
		'type'        => 'control_section',
		'label'       => __( 'Slider', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => $slider_settings,
		'condition'   => array( 'layout' => 'slider' ),
	),
	'general_section'       => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'general_tabs'    => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'general_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'card_background_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['card_background_color'],
							),
							'card_boxshadow'        => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['card_boxshadow'],
								'label'    => __( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
							'card_border'           => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['card_border'],
							),
							'card_border_radius'    => array(
								'type'       => 'DIMENSIONS',
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['card_border_radius'],
							),
						),
					),
					'general_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'card_background_hover_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['card_background_hover_color'],
							),
							'card_boxshadow_hover'        => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['card_boxshadow_hover'],
								'label'    => __( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
							'card_border_hover'           => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'selector' => $selectors['card_border_hover'],
							),
							'card_border_radius_hover'    => array(
								'type'       => 'DIMENSIONS',
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['card_border_radius'],
							),
						),
					),
				),
			),
			'card_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['card_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'card_alignment'  => array(
				'type'      => 'CHOOSE',
				'label'     => __( 'Alignment', 'wptravelengine-elementor-widgets' ),
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
				'selectors' => $selectors['card_alignment'],
			),
			'card_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['card_padding'],
			),
			'card_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['card_margin'],
			),
		),
	),
	'image_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Image', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'image_tabs' => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'image_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'image_size'          => array(
								'type'    => 'SELECT',
								'label'   => esc_html__( 'Image Size', 'wptravelengine-elementor-widgets' ),
								'options' => Widget::get_image_size_options(),
								'default' => 'trip-single-size',
							),
							'image_custom_size'   => array(
								'type'      => 'IMAGE_DIMENSIONS',
								'label'     => esc_html__( 'Custom Image Size', 'wptravelengine-elementor-widgets' ),
								'condition' => array(
									'image_size' => 'custom',
								),
								// 'selectors'  => $selectors['image_customSize'],
							),
							'image_scale'         => array(
								'type'      => 'SELECT',
								'label'     => esc_html__( 'Object Fit', 'wptravelengine-elementor-widgets' ),
								'options'   => array(
									'original' => esc_html__( 'Original', 'wptravelengine-elementor-widgets' ),
									'contain'  => esc_html__( 'Contain', 'wptravelengine-elementor-widgets' ),
									'cover'    => esc_html__( 'Cover', 'wptravelengine-elementor-widgets' ),
									'fill'     => esc_html__( 'Fill', 'wptravelengine-elementor-widgets' ),
								),
								'default'   => 'original',
								'selectors' => $selectors['image_scale'],
							),
							'image_width'         => array(
								'type'       => 'SLIDER',
								'label'      => esc_html__( 'Width', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'range'      => array(
									'%'  => array(
										'min' => 0,
										'max' => 100,
									),
									'px' => array(
										'min' => 0,
										'max' => 1000,
									),
								),
								'selectors'  => $selectors['image_width'],
							),
							'image_height'        => array(
								'type'       => 'SLIDER',
								'label'      => esc_html__( 'Height', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'range'      => array(
									'%'  => array(
										'min' => 0,
										'max' => 100,
									),
									'px' => array(
										'min' => 0,
										'max' => 1000,
									),
								),
								'selectors'  => $selectors['image_height'],
							),
							'image_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['image_border_radius'],
							),
						),
					),
					'image_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'animation_type'         => array(
								'type'      => 'SELECT',
								'label'     => esc_html__( 'Animation Type', 'wptravelengine-elementor-widgets' ),
								'options'   => array(
									'linear'      => esc_html__( 'Linear', 'wptravelengine-elementor-widgets' ),
									'ease'        => esc_html__( 'Ease', 'wptravelengine-elementor-widgets' ),
									'ease-in'     => esc_html__( 'Ease-in', 'wptravelengine-elementor-widgets' ),
									'ease-out'    => esc_html__( 'Ease-out', 'wptravelengine-elementor-widgets' ),
									'ease-in-out' => esc_html__( 'Ease-in-out', 'wptravelengine-elementor-widgets' ),
									'step-start'  => esc_html__( 'Step-start', 'wptravelengine-elementor-widgets' ),
									'step-end'    => esc_html__( 'Step-end', 'wptravelengine-elementor-widgets' ),
									'initial'     => esc_html__( 'Initial', 'wptravelengine-elementor-widgets' ),
									'inherit'     => esc_html__( 'Inherit', 'wptravelengine-elementor-widgets' ),
								),
								'default'   => 'linear',
								'selectors' => $selectors['animation_type'],
							),
							'img_animation_duration' => array(
								'type'      => \Elementor\Controls_Manager::NUMBER,
								'label'     => esc_html__( 'Animation Duration (sec)', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['img_animation_duration'],
								'min'       => 0,
								'max'       => 100,
								'step'      => 0.1,
								'default'   => 3,
							),
						),
					),
				),
			),
		),
	),
	'title_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['title_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'title_tabs'       => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'title_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'title_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['title_color'],
							),
						),
					),
					'title_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'title_color_hover' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['title_color_hover'],
							),
						),
					),
				),
			),
			'title_margin'     => array(
				'label'      => esc_html__( 'Margin', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['title_margin'],
			),
		),
	),
	'content_section'       => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Content', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'content_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['content_typography'],
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
			),
			'content_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['content_color'],
			),
			'content_padding'    => array(
				'label'      => esc_html__( 'Padding', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['content_padding'],
			),
		),
	),
	'meta_section'          => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Meta', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'meta_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['meta_typography'],
			),
			'meta_tabs'       => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'meta_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'meta_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['meta_color'],
							),
						),
					),
					'meta_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'meta_hover_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['meta_hover_color'],
							),
							'meta_hover_text'  => array(
								'type'      => 'SELECT',
								'label'     => esc_html__( 'Link Text Decoration', 'wptravelengine-elementor-widgets' ),
								'options'   => array(
									'default'      => esc_html__( 'Default', 'wptravelengine-elementor-widgets' ),
									'underline'    => esc_html__( 'Underline', 'wptravelengine-elementor-widgets' ),
									'overline'     => esc_html__( 'Overline', 'wptravelengine-elementor-widgets' ),
									'line-through' => esc_html__( 'Line Through', 'wptravelengine-elementor-widgets' ),
									'none'         => esc_html__( 'None', 'wptravelengine-elementor-widgets' ),
								),
								'default'   => 'default',
								'selectors' => $selectors['meta_hover_text'],
							),
						),
					),
				),
			),
			'meta_icon_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['meta_icon_color'],
			),
			'meta_spacing'    => array(
				'type'       => 'SLIDER',
				'label'      => esc_html__( 'Space Between', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => $selectors['meta_spacing'],
			),
			'meta_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['meta_margin'],
			),
			'meta_direction'  => array(
				'type'      => 'SELECT',
				'label'     => esc_html__( 'Direction', 'wptravelengine-elementor-widgets' ),
				'options'   => array(
					'horizontal' => esc_html__( 'Horizontal', 'wptravelengine-elementor-widgets' ),
					'vertical'   => esc_html__( 'Vertical', 'wptravelengine-elementor-widgets' ),
				),
				'default'   => 'horizontal',
				'condition' => array(
					'cardlayout' => array( '3', '4' ),
				),
			),
		),
	),
	'price_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Price', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'price_tabs' => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'price_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'price_typography' => array(
								'type'     => \Elementor\Group_Control_Typography::get_type(),
								'selector' => $selectors['price_typography'],
							),
							'price_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['price_color'],
							),
						),
					),
					'price_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Strikeout', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'strike_typography' => array(
								'type'     => \Elementor\Group_Control_Typography::get_type(),
								'selector' => $selectors['strike_typography'],
							),
							'strike_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['strike_color'],
							),
						),
					),
				),
			),
		),
	),
	'featured_section'      => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Featured Tag', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'feat_tag_color'    => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['feat_tag_color'],
			),
			'feat_tag_bg_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['feat_tag_bg_color'],
			),
		),
	),
	'discount_section'      => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Discount Tag', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'discount_tag_color'    => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['discount_tag_color'],
			),
			'discount_tag_bg_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['discount_tag_bg_color'],
			),
		),
	),
	'button_section'        => array(
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
	'date_section'          => ! class_exists( 'WTE_Fixed_Starting_Dates' ) ? array() : array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Available Dates', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'date_typography'  => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['date_typography'],
			),
			'date_title_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Title Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['date_title_color'],
			),
			'date_tabs'        => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'date_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'date_month_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['date_month_color'],
							),
						),
					),
					'date_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'date_month_hover_color' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['date_month_hover_color'],
							),
						),
					),
				),
			),
		),
	),
	'rating_section'        => ! class_exists( 'Wte_Trip_Review_Init' ) ? array() : array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Rating', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'rating_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'selector' => $selectors['rating_typography'],
			),
			'rating_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['rating_color'],
			),
			'rating_margin'     => array(
				'label'      => esc_html__( 'Margin', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['rating_margin'],
			),
		),
	),
	'slider_style_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Slider', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'slider_arrow_padding'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Arrow Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['slider_arrow_padding'],
			),
			'slider_prev_arrow_icon'   => array(
				'type'          => \Elementor\Controls_Manager::ICONS,
				'label'         => esc_html__( 'Prev Arrow', 'wptravelengine-elementor-widgets' ),
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'eicon-chevron-left',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
				'recommended'   => array(
					'fa-regular' => array(
						'arrow-alt-circle-left',
						'caret-square-left',
					),
					'fa-solid'   => array(
						'angle-double-left',
						'angle-left',
						'arrow-alt-circle-left',
						'arrow-circle-left',
						'arrow-left',
						'caret-left',
						'caret-square-left',
						'chevron-circle-left',
						'chevron-left',
						'long-arrow-alt-left',
					),
				),
			),
			'slider_next_arrow_icon'   => array(
				'type'          => \Elementor\Controls_Manager::ICONS,
				'label'         => esc_html__( 'Next Arrow', 'wptravelengine-elementor-widgets' ),
				'skin'          => 'inline',
				'label_block'   => false,
				'skin_settings' => array(
					'inline' => array(
						'none' => array(
							'label' => 'Default',
							'icon'  => 'eicon-chevron-right',
						),
						'icon' => array(
							'icon' => 'eicon-star',
						),
					),
				),
				'recommended'   => array(
					'fa-regular' => array(
						'arrow-alt-circle-right',
						'caret-square-right',
					),
					'fa-solid'   => array(
						'angle-double-right',
						'angle-right',
						'arrow-alt-circle-right',
						'arrow-circle-right',
						'arrow-right',
						'caret-right',
						'caret-square-right',
						'chevron-circle-right',
						'chevron-right',
						'long-arrow-alt-right',
					),
				),
			),
			'slider_arrow_size'        => array(
				'type'       => 'SLIDER',
				'label'      => esc_html__( 'Arrow Size', 'wptravelengine-elementor-widgets' ),
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
				'selectors'  => $selectors['slider_arrow_size'],
			),
			'slider_arrow_offset'      => array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Arrow Offset', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => -80,
						'max'  => 80,
						'step' => 1,
					),
					'%'  => array(
						'min' => -15,
						'max' => 100,
					),
				),
				'selectors'  => $selectors['slider_arrow_offset'],
			),
			'slider_options_tabs'      => array(
				'type' => 'start_controls_tabs',
				'tabs' => array(
					'slider_navigation_normal' => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Normal', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'slider_arrow_bg_color'      => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Background Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_bg_color'],
							),
							'slider_arrow_color'         => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Color', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_color'],
							),
							'slider_arrow_border'        => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'label'    => __( 'Arrow Border', 'wptravelengine-elementor-widgets' ),
								'selector' => $selectors['slider_arrow_border'],
							),
							'slider_arrow_border_radius' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Arrow Border Radius', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['slider_arrow_border_radius'],
							),
							'slider_arrow_box_shadow'    => array(
								'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
								'selector' => $selectors['slider_arrow_box_shadow'],
								'label'    => __( 'Arrow Box Shadow', 'wptravelengine-elementor-widgets' ),
							),
						),
					),
					'slider_navigation_hover'  => array(
						'type'        => 'start_controls_tab',
						'label'       => __( 'Hover', 'wptravelengine-elementor-widgets' ),
						'subcontrols' => array(
							'slider_arrow_bg_color_hover' => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Background Color Hover', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_bg_color_hover'],
							),
							'slider_arrow_color_hover'    => array(
								'type'      => \Elementor\Controls_Manager::COLOR,
								'label'     => esc_html__( 'Arrow Color Hover', 'wptravelengine-elementor-widgets' ),
								'selectors' => $selectors['slider_arrow_color_hover'],
							),
							'slider_arrow_border_hover'   => array(
								'type'     => \Elementor\Group_Control_Border::get_type(),
								'label'    => esc_html__( 'Arrow Border Color Hover', 'wptravelengine-elementor-widgets' ),
								'selector' => $selectors['slider_arrow_border_hover'],
							),
							'slider_arrow_border_radius_hover' => array(
								'type'       => \Elementor\Controls_Manager::DIMENSIONS,
								'label'      => __( 'Arrow Border Radius Hover', 'wptravelengine-elementor-widgets' ),
								'size_units' => array( 'px', '%' ),
								'selectors'  => $selectors['slider_arrow_border_radius_hover'],
							),
						),
					),
				),
			),
			'slider_pagination_label'  => array(
				'label'       => __( 'Pagination', 'wptravelengine-elementor-widgets' ),
				'description' => esc_html__( 'Pagination.', 'wptravelengine-elementor-widgets' ),
			),
			'slider_dots_active_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Pagination Active Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['slider_dots_active_color'],
			),
			'slider_dots_color'        => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Pagination Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['slider_dots_color'],
			),
			'slider_dots_spacing'      => array(
				'label'      => esc_html__( 'Pagination Spacing', 'wptravelengine-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['slider_dots_spacing'],
			),
			'slider_dots_alignment'    => array(
				'type'      => 'CHOOSE',
				'label'     => __( 'Pagination Alignment', 'wptravelengine-elementor-widgets' ),
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
				'selectors' => $selectors['slider_dots_alignment'],
			),
		),
		'condition'   => array( 'layout' => 'slider' ),
	),
);

return $controls;
