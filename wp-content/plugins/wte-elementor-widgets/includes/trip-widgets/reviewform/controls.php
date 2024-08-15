<?php
/**
 * Review Form Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$selectors = array(
	'star_gap'                   => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .aggregate-rating .stars .rating-star .wpte-trip-review-stars .stars-group-wrapper svg:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
	),

	// Style Section.
	'text_typography'            => '{{WRAPPER}} .elementor-widget-container .post-data .content .aggregate-rating .stars',

	// General section.
	'review_typography'          => '
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-notes,
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .review-title-rating .comment-form-wte-trip-review-rating,
    {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating p.comment-form-title label,
	{{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating legend',
	'general_color'              => array(
		'
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-notes,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .review-title-rating .comment-form-wte-trip-review-rating,
        {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating p.comment-form-title label,
        {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating .comment-form-comment label,
        {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating legend' => 'color: {{VALUE}};',
	),
	'general_padding'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'general_margin'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Title.
	'messages_typography'        => '{{WRAPPER}} .elementor-widget-container .post-data #respond #reply-title,
		{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .logged-in-as,
		{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .logged-in-as a',
	'messages_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #reply-title' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .logged-in-as' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .logged-in-as a' => 'color: {{VALUE}};',
	),

	// Button.
	'button_typography'          => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input',
	'button_padding'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_margin'              => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_bg_color'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input' => 'background-color: {{VALUE}};',
	),
	'button_color'               => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input' => 'color: {{VALUE}};',
	),
	'button_border'              => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input',
	'button_border_radius'       => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_boxshadow'           => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input',
	'button_bg_hover_color'      => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input:hover' => 'background-color: {{VALUE}};',
	),
	'button_hover_color'         => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input:hover' => 'color: {{VALUE}};',
	),
	'button_hover_border'        => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input:hover',
	'button_hover_border_radius' => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'button_hover_boxshadow'     => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform p.form-submit input:hover',

	// Input Fields.
	'input_typography'           => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
	{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images .wte-reviews-dropzone-placeholder',
	'input_bg_color'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images' => 'background-color: {{VALUE}};',
	),
	'input_color'                => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input::placeholder,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea::placeholder,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
		{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images .wte-reviews-dropzone-placeholder' => 'color: {{VALUE}};',
	),
	'input_border'               => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images',
	'input_border_radius'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'input_boxshadow'            => '{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images',
	'input_padding'              => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	'input_margin'               => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title input,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment textarea,
        {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),
	// Uploader.
	'icon_color'                 => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .dropzone .dz-button .file-upload-icon svg path' => 'fill: {{VALUE}};',
	),
	'message_color'              => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .dropzone .dz-button .supported-message' => 'color: {{VALUE}};',
	),
	'uploader_text_color'        => array(
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images .wte-reviews-dropzone-placeholder' => 'color: {{VALUE}};',
		'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform #wpte-upload-review-images .wte-reviews-dropzone-placeholder span' => 'color: {{VALUE}};',
	),
);

$controls = array(
	'rating'                  => array(
		'type'        => 'control_section',
		'label'       => __( 'General', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'buttonText' => array(
				'default' => __( 'Submit', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXT',
				'label'   => __( 'Button Label', 'wptravelengine-elementor-widgets' ),
			),
		),
	),
	'rating_display_settings' => array(
		'type'        => 'control_section',
		'label'       => __( 'Additional', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'showFormTitle'  => array(
				'label'        => __( 'Hide Form Title', 'wptravelengine-elementor-widgets' ),
				'type'         => 'SWITCHER',
				'default'      => 'yes',
				'return_value' => 'none',
				'selectors'    => array(
					'{{WRAPPER}} .elementor-widget-container .post-data #respond h3' => 'display: {{VALUE}}',
				),
			),
			'showFormInfo'   => array(
				'label'        => __( 'Hide Form Info', 'wptravelengine-elementor-widgets' ),
				'type'         => 'SWITCHER',
				'default'      => 'yes',
				'return_value' => 'none',
				'selectors'    => array(
					'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .logged-in-as,
                    {{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-notes' => 'display: {{VALUE}}',
				),
			),
			'showFormLabels' => array(
				'label'        => __( 'Hide Form Labels', 'wptravelengine-elementor-widgets' ),
				'type'         => 'SWITCHER',
				'default'      => 'yes',
				'return_value' => 'none',
				'selectors'    => array(
					'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .review-title-rating .comment-form-wte-trip-review-rating,
                    {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating p.comment-form-title label,
                    {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating .comment-form-comment label,
                    {{WRAPPER}} .elementor-widget-container .post-data #respond .rating-form .review-title-rating legend' => 'display: {{VALUE}} !important',
				),
			),
		),
	),
	'general_section'         => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Form', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'messages_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['messages_typography'],
			),
			'messages_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['messages_color'],
			),
			'form_gap'            => array(
				'type'      => 'SLIDER',
				'label'     => esc_html__( 'Row Gap', 'wptravelengine-elementor-widgets' ),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .comment-form-comment' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-widget-container .post-data #respond #commentform .review-combined-field' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			),
			'general_padding'     => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['general_padding'],
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 0,
				),
			),
			'general_margin'      => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['general_margin'],
			),
		),
	),
	'label_section'           => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Field Label', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'label_gap'         => array(
				'type'      => 'SLIDER',
				'label'     => esc_html__( 'Spacing', 'wptravelengine-elementor-widgets' ),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 8,
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data #respond  .rating-form .review-title-rating p.comment-form-title label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-widget-container .post-data #respond  .rating-form .review-title-rating .comment-form-comment label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			),
			'review_typography' => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['review_typography'],
			),
			'general_color'     => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['general_color'],
			),
		),
	),
	'input_section'           => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Input Field', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'input_typography'    => array(
				'type'     => \Elementor\Group_Control_Typography::get_type(),
				'label'    => __( 'Typography', 'wptravelengine-elementor-widgets' ),
				'selector' => $selectors['input_typography'],
			),
			'input_bg_color'      => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['input_bg_color'],
			),
			'input_color'         => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['input_color'],
			),
			'input_border'        => array(
				'type'     => \Elementor\Group_Control_Border::get_type(),
				'selector' => $selectors['input_border'],
			),
			'input_border_radius' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Radius', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%' ),
				'selectors'  => $selectors['input_border_radius'],
			),
			'input_boxshadow'     => array(
				'type'     => \Elementor\Group_Control_Box_Shadow::get_type(),
				'selector' => $selectors['input_boxshadow'],
				'label'    => esc_html__( 'Box Shadow', 'wptravelengine-elementor-widgets' ),
			),
			'input_padding'       => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['input_padding'],
			),
		),
	),
	'button_section'          => array(
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
	'uploader_section'        => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Uploader', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'icon_color'          => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Icon Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['icon_color'],
			),
			'icon_size'           => array(
				'type'      => 'SLIDER',
				'label'     => esc_html__( 'Icon Size', 'wptravelengine-elementor-widgets' ),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => '44',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container .post-data .dropzone .dz-button .file-upload-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'uploader_text_color' => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Text Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['uploader_text_color'],
			),
			'message_color'       => array(
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => esc_html__( 'Info Color', 'wptravelengine-elementor-widgets' ),
				'selectors' => $selectors['message_color'],
			),
		),
	),
	'icon_section'            => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Icon', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'primary_color'   => array(
				'label'     => __( 'Primary Color', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jq-ry-container > .jq-ry-group-wrapper > .jq-ry-group.jq-ry-rated-group > svg path' => 'fill: {{VALUE}};stroke: {{VALUE}}',
				),
			),
			'secondary_color' => array(
				'label'     => __( 'Secondary Color', 'wptravelengine-elementor-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jq-ry-container > .jq-ry-group-wrapper > .jq-ry-group.jq-ry-normal-group > svg path' => 'fill: {{VALUE}};stroke: {{VALUE}}',
				),
			),
		),
	),
);

return $controls;
