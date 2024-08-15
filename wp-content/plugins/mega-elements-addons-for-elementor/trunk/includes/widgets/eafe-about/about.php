<?php
namespace MegaElementsAddonsForElementor\Widget;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;

class EAFE_About extends Widget_Base
{

    public function get_name() {
        return 'eafe-about';
    }

    public function get_title() {
        return esc_html__( 'Featured Page', 'mega-elements-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eafe-feature-page';
    }

    public function get_categories() {
        return ['eafe-elements'];
    }

    public function get_style_depends() {
        return ['eafe-about'];
    }
    
    public function get_all_pages() {
        
        $posts = get_posts([
            'post_type'         => 'page',
            'post_style'        => 'all_types',
            'posts_per_page'    => '-1',
        ]);

        if ( !empty( $posts ) ) {
            return wp_list_pluck( $posts, 'post_title', 'ID' );
        }

        return [];
    }

    protected function _register_controls() 
    {    
        /**
         * About Query Settings
         */
        $this->start_controls_section(
            'mefe_about_content_query_settings',
            [
                'label'     => esc_html__( 'Query Settings', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'bacqs_posts_ids',
            [
                'label'         => esc_html__( 'Search & Select', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->get_all_pages(),
                'label_block'   => true,
                'multiple'      => false,
            ]
        );

        $this->end_controls_section();

        /**
         * About Layout Settings
         */
        $this->start_controls_section(
            'mefe_about_content_layout_settings',
            [
                'label'         => esc_html__( 'Layout Settings', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'bacls_show_image',
            [
                'label'         => esc_html__( 'Show Image', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mega-elements-addons-for-elementor'),
                'label_off'     => esc_html__( 'Hide', 'mega-elements-addons-for-elementor'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'          => 'bacls_image',
                'exclude'       => ['custom'],
                'default'       => 'eafe-featured-page',
                'condition'     => [
                    'bacls_show_image' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'bacls_image_alignment',
            [
                'label'     => esc_html__( 'Image Alignment', 'mega-elements-addons-for-elementor' ),
                'default'   => 'left',
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title' => __( 'Left', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'prefix_class'  => 'eafe-media-align-'
            ]
        );

        $this->add_control(
            'bacls_show_title',
            [
                'label'         => esc_html__( 'Show Title', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off'     => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'bacls_show_subtitle',
            [
                'label'         => esc_html__( 'Show Subtitle', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off'     => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'bacls_add_subtitle',
            [
                'label'         => esc_html__( 'Add Subtitle', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::TEXT,
                'return_value'  => 'yes',
                'condition'     => [
                    'bacls_show_subtitle' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bacls_show_excerpt',
            [
                'label'         => esc_html__( 'Show excerpt', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off'     => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'bacls_excerpt_length',
            [
                'label'         => esc_html__( 'Excerpt Words', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => '10',
                'condition'     => [
                    'bacls_show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bacls_excerpt_expanison_indicator',
            [
                'label'         => esc_html__( 'Expanison Indicator', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
                'default'       => esc_html__( '...', 'mega-elements-addons-for-elementor' ),
                'condition'     => [
                    'bacls_show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bacls_show_full_content',
            [
                'label'         => esc_html__( 'Show Full Content', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off'     => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value'  => 'yes',
                'default'       => '',
                'condition'     => [
                    'bacls_show_excerpt!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bacls_show_read_more',
            [
                'label'         => esc_html__( 'Show Read More', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off'     => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'bacls_read_more_text',
            [
                'label'         => esc_html__( 'Label Text', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
                'default'       => esc_html__( 'Read More', 'mega-elements-addons-for-elementor' ),
                'condition'     => [
                    'bacls_show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * About Content Style
         */
        $this->start_controls_section(
            'mefe_about_style_content_style',
            [
                'label'     => esc_html__( 'Content Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bascs_about_content_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post-holder-inner' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            'bascs_about_content_spacing',
            [
                'label'         => esc_html__( 'Padding', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'default' => [
                    'size' => 7,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-grid-post-holder-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'bascs_about_content_border',
                'label'         => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'      => '{{WRAPPER}} .eafe-grid-post-holder-inner',
            ]
        );

        $this->add_control(
            'bascs_about_content_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'selectors'     => [
                    '{{WRAPPER}} .eafe-grid-post-holder-inner' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'bascs_about_content_box_shadow',
                'selector'  => '{{WRAPPER}} .eafe-grid-post-holder-inner',
            ]
        );

        $this->add_responsive_control(
            'basct_content_alignment',
            [
                'label'     => esc_html__( 'Content Alignment', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title' => esc_html__( 'Center', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify'   => [
                        'title' => esc_html__( 'Justified', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class'  => 'eafe-about-content-align-',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-wrapper' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * About Color & Typography Style
         */
        $this->start_controls_section(
            'mefe_about_style_color_typography',
            [
                'label'     => esc_html__( 'Color & Typography', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'basct_subtitle_style',
            [
                'label'     => esc_html__( 'SubTitle Style', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'basct_subtitle_color',
            [
                'label'     => esc_html__( 'Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-subtitle' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'basct_subtitle_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-subtitle' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'basct_subtitle_typography',
                'label'     => esc_html__( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-entry-subtitle',
            ]
        );

        $this->add_responsive_control(
            'basct_subtitle_space',
            [
                'label' => __( 'Spacing', 'mega-elements-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'basct_title_style',
            [
                'label'     => esc_html__( 'Title Style', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'basct_title_color',
            [
                'label'     => esc_html__( 'Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-title a' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'basct_title_typography',
                'label'     => esc_html__( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-entry-title',
            ]
        );

        $this->add_responsive_control(
            'basct_title_space',
            [
                'label' => __( 'Spacing', 'mega-elements-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'basct_excerpt_style',
            [
                'label'     => esc_html__( 'Excerpt Style', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'basct_excerpt_color',
            [
                'label'     => esc_html__( 'Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post-excerpt p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'basct_excerpt_typography',
                'label'     => esc_html__( 'Typography', 'mega-elements-addons-for-elementor'),
                'selector'  => '{{WRAPPER}} .eafe-grid-post-excerpt p',
            ]
        );

        $this->add_responsive_control(
            'basct_excerpt_space',
            [
                'label' => __( 'Spacing', 'mega-elements-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post-excerpt p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * About Button Style
         */
        $this->start_controls_section(
            'mefe_about_style_read_more_style',
            [
                'label'     => esc_html__( 'Button Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'bacls_show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'basrms_read_more_btn_typography',
                'selector'  => '{{WRAPPER}} .eafe-about-elements-readmore-btn',
            ]
        );

        $this->start_controls_tabs('basrms_read_more_tabs');

        $this->start_controls_tab(
            'basrms_read_more_normal',
            [
                'label'     => esc_html__( 'Normal', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'basrms_read_more_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-about-elements-readmore-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'basrms_read_more_btn_background',
                'label'     => __( 'Background', 'mega-elements-addons-for-elementor' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .eafe-about-elements-readmore-btn',
                'exclude'   => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'basrms_read_more_btn_border',
                'label'     => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-about-elements-readmore-btn',
            ]
        );

        $this->add_responsive_control(
            'basrms_read_more_btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-about-elements-readmore-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'basrms_read_more_style_hover',
            [
                'label'     => __( 'Hover', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'basrms_read_more_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-about-elements-readmore-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'basrms_read_more_btn_hover_background',
                'label'     => esc_html__( 'Background', 'mega-elements-addons-for-elementor' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .eafe-about-elements-readmore-btn:hover',
                'exclude'   => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'basrms_read_more_btn_hover_border',
                'label'     => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-about-elements-readmore-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'basrms_read_more_btn_border_hover_radius',
            [
                'label'         => esc_html__('Border Radius', 'mega-elements-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-about-elements-readmore-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'basrms_read_more_btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-about-elements-readmore-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'basrms_read_more_btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-about-elements-readmore-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

    }

    public function render_about_template( $args, $settings ) {

        $about_query = new \WP_Query( $args );
         
        ob_start();

        if( $about_query->have_posts() ) {
            while( $about_query->have_posts() ) {
                $about_query->the_post();
                echo '<article class="eafe-grid-post eafe-post-grid-column" data-id="' . esc_attr( get_the_ID() ) . '">
                    <div class="eafe-grid-post-holder">';
                        if ( $settings['bacls_show_image'] == 'yes' ) {
                            echo '<div class="eafe-entry-media">
                                <div class="eafe-entry-thumbnail">';
                                    if ( has_post_thumbnail() ) {
                                        echo '<img src="' . esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), $settings['bacls_image_size'] ) ) . '" alt="' . esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ) . '">';
                                    }else{
                                        mefe_get_fallback_svg( $settings['bacls_image_size'] );
                                    }
                                echo '</div>
                            </div>';
                        }
                        echo '<div class="eafe-grid-post-holder-inner">';
                            if ( $settings['bacls_show_title'] || ( $settings['bacls_show_subtitle'] && $settings['bacls_add_subtitle'] ) || $settings['bacls_show_excerpt'] || $settings['bacls_show_full_content'] || $settings['bacls_show_read_more'] ) {
                                echo '<div class="eafe-entry-wrapper">';

                                    if ( $settings['bacls_show_title'] || ( $settings['bacls_show_subtitle'] && $settings['bacls_add_subtitle'] ) ) {
                                        echo '<header class="eafe-entry-header">';
                                        if ( $settings['bacls_show_subtitle'] && $settings['bacls_add_subtitle'] ) echo '<div class="eafe-entry-subtitle">' . esc_html( $settings['bacls_add_subtitle'] ) . '</div>';
                                        if ( $settings['bacls_show_title'] ) echo '<h2 class="eafe-entry-title"><a class="eafe-grid-post-link" href="' . esc_url( get_the_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
                                        echo '</header>';
                                    }


                                    if ( $settings['bacls_show_excerpt'] || $settings['bacls_show_full_content'] || $settings['bacls_show_read_more'] ) {
                                        echo '<div class="eafe-entry-content">
                                            <div class="eafe-grid-post-excerpt">';
                                                if ( $settings['bacls_show_excerpt'] ) {
                                                    echo '<p>' . wp_trim_words( strip_shortcodes( get_the_excerpt() ), $settings['bacls_excerpt_length'], $settings['bacls_excerpt_expanison_indicator'] ) . '</p>';
                                                }elseif( $settings['bacls_show_full_content'] ) {
                                                    the_content();
                                                }

                                                if ( $settings['bacls_show_read_more'] ) {
                                                    echo '<a href="' . esc_url( get_the_permalink() ) . '" class="eafe-about-elements-readmore-btn">' . esc_attr( $settings['bacls_read_more_text'] ) . '</a>';
                                                }
                                            echo '</div>
                                        </div>';
                                    }
                                echo '</div>';
                            }
                        echo '</div>
                    </div>
                </article>';
            }
        } else {
            esc_html_e( '<p class="no-posts-found">No posts found!</p>', 'mega-elements-addons-for-elementor' );
        }

        wp_reset_postdata();

        return ob_get_clean();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        $args = array();
        if( ! empty( $settings['bacqs_posts_ids'] ) ) {
            $args = [
                'ignore_sticky_posts' => 1,
                'post_type' => 'page',
            ];
            $args['p'] = $settings['bacqs_posts_ids'];
        }

        $settings_arry = [
            'bacls_show_image'                  => $settings['bacls_show_image'],
            'bacls_image_size'                  => $settings['bacls_image_size'],
            'bacls_show_title'                  => $settings['bacls_show_title'],
            'bacls_show_subtitle'               => $settings['bacls_show_subtitle'],
            'bacls_add_subtitle'                => $settings['bacls_add_subtitle'],
            'bacls_show_excerpt'                => $settings['bacls_show_excerpt'],
            'bacls_excerpt_length'              => intval( $settings['bacls_excerpt_length'], 10 ),
            'bacls_show_read_more'              => $settings['bacls_show_read_more'],
            'bacls_show_full_content'           => $settings['bacls_show_full_content'],
            'bacls_read_more_text'              => $settings['bacls_read_more_text'],
            'bacls_excerpt_expanison_indicator' => $settings['bacls_excerpt_expanison_indicator'],
        ];

        $this->add_render_attribute(
            'post_grid_wrapper',
            [
                'id' => 'eafe-post-grid-' . esc_attr( $this->get_id() ),
                'class' => [
                    'eafe-post-grid-container',
                ],
            ]
        );

        echo '<div ' . $this->get_render_attribute_string( 'post_grid_wrapper' ) . '>
            <div class="eafe-post-grid eafe-post-appender eafe-post-appender-' . esc_attr( $this->get_id() ) . '">
                ' . self::render_about_template( $args, $settings_arry ) . '
            </div>
            <div class="clearfix"></div>
        </div>';
    }

    protected function _content_template() {
    }
}