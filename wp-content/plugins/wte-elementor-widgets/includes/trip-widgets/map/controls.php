<?php
/**
 * Map Widget Controls.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB;

$selectors = array(
	// General section.
	'general_boxshadow'        => '{{WRAPPER}} .elementor-widget-container .post-data',
	'general_border'           => '{{WRAPPER}} .elementor-widget-container .post-data',
	'general_background_color' => array(
		'{{WRAPPER}} .elementor-widget-container .post-data' => 'background-color: {{VALUE}};',
	),
	'general_border_radius'    => array(
		'{{WRAPPER}} .elementor-widget-container .post-data' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	),

	// Iframe section.
	'iframe_padding'           => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .iframe' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'iframe_margin'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .iframe' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	// Image section.
	'image_padding'            => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
	'image_margin'             => array(
		'{{WRAPPER}} .elementor-widget-container .post-data .content .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
	),
);

global $post;
$trip_id              = $post->ID;
$trip_settings        = get_post_meta( $trip_id, 'wp_travel_engine_setting', true );
$default_map_location = '';
$src                  = '';
if ( isset( $trip_settings['map'] ) && ! empty( $trip_settings['map'] ) ) {
	$default_map_location = isset( $trip_settings['map']['iframe'] ) ? $trip_settings['map']['iframe'] : null;
	$src                  = isset( $trip_settings['map']['image_url'] ) ? wp_get_attachment_image_src( $trip_settings['map']['image_url'], 'full' ) : null;
}

$controls = array(
	'controls'        => array(),
	'map_section'     => array(
		'type'        => 'control_section',
		'label'       => __( 'Map', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'map_location' => array(
				'label'   => __( 'Location', 'wptravelengine-elementor-widgets' ),
				'type'    => 'TEXTAREA',
				'default' => __( $default_map_location, 'wptravelengine-elementor-widgets' ),
			),
			'map_height'   => array(
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Height', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', 'em', 'rem', 'vh' ),
				'range'      => array(
					'px'  => array(
						'min'  => 40,
						'max'  => 1440,
						'step' => 1,
					),
					'em'  => array(
						'min'  => 0.1,
						'max'  => 100,
						'step' => 0.1,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'vh'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 400,
				),
			),
		),
	),
	'control_section' => array(
		'type'        => 'control_section',
		'label'       => __( 'Additional', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'show_image'  => isset( $src[0] ) ? array(
				'label'   => __( 'Show Image', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			) : array(),
			'show_iframe' => array(
				'label'   => __( 'Show Iframe', 'wptravelengine-elementor-widgets' ),
				'type'    => 'SWITCHER',
				'default' => 'yes',
			),
		),
	),
	'iframe_section'  => array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Iframe', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'iframe_margin' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['iframe_margin'],
			),
		),
	),
	'image_section'   => isset( $src[0] ) ? array(
		'type'        => \Elementor\Controls_Manager::TAB_STYLE,
		'label'       => __( 'Image', 'wptravelengine-elementor-widgets' ),
		'subcontrols' => array(
			'image_padding' => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Padding', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['image_padding'],
			),
			'image_margin'  => array(
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => __( 'Margin', 'wptravelengine-elementor-widgets' ),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => $selectors['image_margin'],
			),
		),
	) : array(),
);

return $controls;
