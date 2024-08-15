<?php
/**
 * Reviews Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$selectors = array(
	// Content.
	'hide_average_rating'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .average-rating' => 'display: {{VALUE}};',
	),
	'hide_overall_rating'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap' => 'display: {{VALUE}};',
	),
	'hide_reviews'               => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list' => 'display: {{VALUE}};',
	),
	'hide_review_user'           => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .comment-author' => 'display: {{VALUE}};',
	),
	'hide_review_title'          => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .comment-title' => 'display: {{VALUE}};',
	),
	'hide_review_content'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating .comment-content' => 'display: {{VALUE}};',
	),
	'hide_review_gallery'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .comment-rating .trip-review-detail-gallery' => 'display: {{VALUE}};',
	),
	'hide_date_of_experience'    => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .comment-rating .comment-experience-date' => 'display: {{VALUE}};',
	),

	// General Style.
	'typography'                 => '{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap',
	'padding'                    => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'margin'                     => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'color'                      => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap div, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap .rating-bar .rating-bar-inner::after, {{WRAPPER}} .elementor-widget-container .post-data .review-wrap .average-rating .aggregate-rating .stars .rating-star, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating span' => 'color: {{VALUE}};',
	),
	'background_color'           => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap' => 'background-color: {{VALUE}};',
	),

	// Average Rating.
	'average_rating_typography'  => '{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .average-rating, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap',
	'average_rating_padding'     => array(
		'{{WRAPPER}} .elementor-widget-container post-data .content .review-wrap .average-rating, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'average_rating_color'       => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .average-rating div, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap .rating-bar .rating-bar-inner::after, {{WRAPPER}} .elementor-widget-container .post-data .review-wrap .average-rating .aggregate-rating .stars .rating-star' => 'color: {{VALUE}};',
	),
	'average_rating_bg_color'    => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .average-rating, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap' => 'background-color: {{VALUE}};',
	),

	// List Reviews.
	'list_reviews_typography'    => '{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list',
	'list_reviews_padding'       => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'list_reviews_margin'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'list_reviews_color'         => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating span, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating .comment-experience-date' => 'color: {{VALUE}};',
	),
	'list_reviews_bg_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list' => 'background-color: {{VALUE}};',
	),

	// Reviews Title.
	'reviews_title_typography'   => '{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-title',
	'reviews_title_padding'      => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'reviews_title_color'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-title' => 'color: {{VALUE}};',
	),

	// Reviews Content.
	'reviews_content_typography' => '{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating',
	'reviews_content_padding'    => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'reviews_content_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating span, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating .comment-experience-date' => 'color: {{VALUE}};',
	),
);

$controls = array(
	'reviews'                 => array(
		'type'        => 'control_section',
		'label'       => __( 'Reviews', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'hide_average_rating'     => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Average Rating', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_average_rating'],
			),
			'hide_overall_rating'     => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Overall Rating', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_overall_rating'],
			),
			'hide_reviews'            => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Reviews', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_reviews'],
			),
			'hide_review_user'        => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Review User', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_review_user'],
			),
			'hide_review_title'       => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Review Title', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_review_title'],
			),
			'hide_review_content'     => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Review Content', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_review_content'],
			),
			'hide_review_gallery'     => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Review Gallery', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_review_gallery'],
			),
			'hide_date_of_experience' => array(
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label'        => __( 'Hide Date of Experience', 'wptravelengine-elementor-widgets' ),
				'default'      => 'no',
				'return_value' => 'none',
				'selectors'    => $selectors['hide_date_of_experience'],
			),
		),
	),
	'general_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['typography'],
			),
		),
	),
	'star_section'            => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Stars', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'rated_color'   => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Primary Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#ebad34',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .average-rating .wpte-trip-review-stars .stars-group-wrapper .stars-rated-group svg path, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating .wpte-trip-review-stars .stars-group-wrapper .stars-rated-group svg path' => 'fill: {{VALUE}}',
				),
			),
			'unrated_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Secondary Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#ccc',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .average-rating .wpte-trip-review-stars .stars-group-wrapper .stars-placeholder-group svg path, {{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .comment-list .wte-review-comment-id .trip-comment-content .comment-rating .wpte-trip-review-stars .stars-group-wrapper .stars-placeholder-group svg path' => 'fill: {{VALUE}}',
				),
			),
			'5stars_color'  => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( '5 Stars Rating Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#66DAB0',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(1) .rating-bar-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(1)' => '--rating-color: {{VALUE}}',
				),
			),
			'4stars_color'  => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( '4 Stars Rating Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#6FEBA1',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(2) .rating-bar-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(2)' => '--rating-color: {{VALUE}}',
				),
			),
			'3stars_color'  => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( '3 Stars Rating Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#F3CE85',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(3) .rating-bar-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(3)' => '--rating-color: {{VALUE}}',
				),
			),
			'2stars_color'  => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( '2 Stars Rating Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#F3B881',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(4) .rating-bar-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(4)' => '--rating-color: {{VALUE}}',
				),
			),
			'1stars_color'  => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( '1 Stars Rating Color', 'wptravelengine-elementor-widgets' ),
				'default'   => '#EE7874',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(5) .rating-bar-inner' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-widget-container .post-data .content .review-wrap .overall-rating-wrap .rating-bar-outer-wrap:nth-child(5)' => '--rating-color: {{VALUE}}',
				),
			),
		),
	),
	'average_rating_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Average Rating', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'average_rating_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['average_rating_typography'],
			),
			'average_rating_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['average_rating_padding'],
			),
			'average_rating_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['average_rating_color'],
			),
			'average_rating_bg_color'   => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['average_rating_bg_color'],
			),
		),
	),
	'list_reviews_section'    => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'List Reviews', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'list_reviews_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['list_reviews_typography'],
			),
			'list_reviews_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['list_reviews_padding'],
				'default'    => array(
					'top'      => '24',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
			),
			'list_reviews_margin'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['list_reviews_margin'],
				'default'    => array(
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				),
			),
			'list_reviews_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['list_reviews_color'],
			),
			'list_reviews_bg_color'   => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['list_reviews_bg_color'],
			),
		),
	),
	'reviews_title_section'   => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Reviews Title', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'reviews_title_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['reviews_title_typography'],
			),
			'reviews_title_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['reviews_title_padding'],
			),
			'reviews_title_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['reviews_title_color'],
			),
		),
	),
	'reviews_content_section' => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Reviews Content', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'reviews_content_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['reviews_content_typography'],
			),
			'reviews_content_padding'    => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['reviews_content_padding'],
			),
			'reviews_content_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['reviews_content_color'],
			),
		),
	),
);

return $controls;
