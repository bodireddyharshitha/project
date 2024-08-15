<?php
namespace MegaElementsAddonsForElementor\Widget;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;

class EAFE_Blog extends Widget_Base
{

    public function get_name() {
        return 'eafe-blog';
    }

    public function get_title() {
        return esc_html__( 'Blog', 'mega-elements-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eafe-blog';
    }

    public function get_categories() {
        return ['eafe-elements'];
    }

    public function get_style_depends() {
        return ['eafe-blog'];
    }

    public function get_script_depends() {
        return ['isotope'];
    }

    public function get_authors() {
        
        $users = get_users([
            'who' => 'authors',
            'has_published_posts' => true,
            'fields' => [
                'ID',
                'display_name',
            ],
        ]);

        if ( !empty( $users ) ) {
            return wp_list_pluck( $users, 'display_name', 'ID' );
        }

        return [];
    }

    public function get_all_types_post() {
        
        $posts = get_posts([
            'post_type'     => 'post',
            'post_style'    => 'all_types',
            'post_status'   => 'publish',
            'posts_per_page' => '-1',
        ]);

        if ( !empty( $posts ) ) {
            return wp_list_pluck( $posts, 'post_title', 'ID' );
        }

        return [];
    }

    public function get_post_orderby_options() {
        
        $orderby = array(
            'ID' => 'Post ID',
            'author' => 'Post Author',
            'title' => 'Title',
            'date' => 'Date',
            'modified' => 'Last Modified Date',
            'parent' => 'Parent Id',
            'rand' => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order' => 'Menu Order',
        );

        return $orderby;
    }

    protected function query_controls()
    {
        
        /**
         * Blog Query Settings
        */
        $taxonomies = get_taxonomies( [], 'objects' );

        $this->start_controls_section(
            'mefe_blog_content_query_settings',
            [
                'label'     => esc_html__( 'Query Settings', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'bbcqs_blog_authors', [
                'label'         => esc_html__( 'Author', 'mega-elements-addons-for-elementor' ),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'default'       => [],
                'options'       => $this->get_authors(),
            ]
        );

        foreach ($taxonomies as $taxonomy => $object) {
            if( in_array( $taxonomy, array( 'category', 'post_tag' ) ) ) :
                $this->add_control(
                    'bbcqs_blog_' . $taxonomy . '_ids',
                    [
                        'label'         => $object->label,
                        'type'          => Controls_Manager::SELECT2,
                        'label_block'   => true,
                        'multiple'      => true,
                        'object_type'   => $taxonomy,
                        'options'       => wp_list_pluck( get_terms( $taxonomy ), 'name', 'term_id' ),
                    ]
                );
            endif;
        }

        $this->add_control(
            'bbcqs_blog_post__not_in',
            [
                'label'         => esc_html__( 'Exclude', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->get_all_types_post(),
                'label_block'   => true,
                'post_type'     => '',
                'multiple'      => true,
            ]
        );

        $this->add_control(
            'bbcqs_blog_posts_per_page',
            [
                'label'     => esc_html__( 'Posts Per Page', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '3',
            ]
        );

        $this->add_control(
            'bbcqs_blog_orderby',
            [
                'label'     => esc_html__( 'Order By', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->get_post_orderby_options(),
                'default'   => 'date',

            ]
        );

        $this->add_control(
            'bbcqs_blog_order',
            [
                'label'     => esc_html__( 'Order', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'asc'       => 'Ascending',
                    'desc'      => 'Descending',
                ],
                'default'   => 'desc',

            ]
        );

        $this->end_controls_section();
    }

    protected function layout_controls()
    {
        /**
         * Blog Layout Settings
        */
        $this->start_controls_section(
            'mefe_blog_content_layout_settings',
            [
                'label'     => esc_html__( 'Layout Settings', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'bbcls_blog_columns',
            [
                'label'     => esc_html__( 'Column', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'ba-blog-col-3',
                'tablet_default' => 'ba-blog-col-2',
                'mobile_default' => 'ba-blog-col-1',
                'options'   => [
                    'ba-blog-col-1' => esc_html__( '1', 'mega-elements-addons-for-elementor' ),
                    'ba-blog-col-2' => esc_html__( '2', 'mega-elements-addons-for-elementor' ),
                    'ba-blog-col-3' => esc_html__( '3', 'mega-elements-addons-for-elementor' ),
                    'ba-blog-col-4' => esc_html__( '4', 'mega-elements-addons-for-elementor' ),
                    'ba-blog-col-5' => esc_html__( '5', 'mega-elements-addons-for-elementor' ),
                    'ba-blog-col-6' => esc_html__( '6', 'mega-elements-addons-for-elementor' ),
                ],
                'prefix_class' => 'eafe-grid%s-',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bbcls_blog_layout_mode',
            [
                'label'     => esc_html__( 'Layout', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'masonry',
                'options'   => [
                    'grid'      => esc_html__( 'Grid', 'mega-elements-addons-for-elementor' ),
                    'masonry'   => esc_html__( 'Masonry', 'mega-elements-addons-for-elementor' ),
                ],
            ]
        );
            
        $this->add_control(
            'bbcls_blog_show_load_more',
            [
                'label'     => esc_html__( 'Show Load More', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => '',
            ]
        );

        $this->add_control(
            'bbcls_blog_show_load_more_text',
            [
                'label'     => esc_html__( 'Label Text', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'label_block' => false,
                'default'   => esc_html__( 'Load More', 'mega-elements-addons-for-elementor' ),
                'condition' => [
                    'bbcls_blog_show_load_more' => 'yes',
                ],
            ]
        );

    
        $this->add_control(
            'bbcls_blog_show_image',
            [
                'label'     => esc_html__( 'Show Image', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'bbcls_blog_image',
                'exclude'   => ['custom'],
                'default'   => 'medium',
                'condition' => [
                    'bbcls_blog_show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bbcls_blog_show_title',
            [
                'label'     => esc_html__( 'Show Title', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'bbcls_blog_show_excerpt',
            [
                'label'     => esc_html__( 'Show excerpt', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'bbcls_blog_excerpt_length',
            [
                'label'     => esc_html__( 'Excerpt Words', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '10',
                'condition' => [
                    'bbcls_blog_show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bbcls_blog_excerpt_expanison_indicator',
            [
                'label'     => esc_html__( 'Expanison Indicator', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'label_block' => false,
                'default'   => esc_html__( '...', 'mega-elements-addons-for-elementor' ),
                'condition' => [
                    'bbcls_blog_show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'bbcls_blog_show_read_more_button',
            [
                'label'     => esc_html__( 'Show Read More Button', 'mega-elements-addons-for-elementor'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'bbcls_blog_read_more_button_text',
            [
                'label'     => esc_html__( 'Button Text', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Read More', 'mega-elements-addons-for-elementor' ),
                'condition' => [
                    'bbcls_blog_show_read_more_button' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'bbcls_blog_show_author',
            [
                'label'     => esc_html__( 'Show Author', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'bbcls_blog_show_author_avatar',
            [
                'label'     => esc_html__( 'Show Author Avatar', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => '',
            ]
        );
        
        $this->add_control(
            'bbcls_blog_show_date',
            [
                'label'     => esc_html__( 'Show Date', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );
        
        $this->add_control(
            'bbcls_blog_show_category',
            [
                'label'     => esc_html__( 'Show Category', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function read_more_button_style()
    {
        /**
         * Blog Read More Button Style
        */ 
        $this->start_controls_section(
            'mefe_blog_style_read_more_style',
            [
                'label'     => esc_html__( 'Read More Button Style', 'mega-elements-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'bbcls_blog_show_read_more_button' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'bbsrms_blog_read_more_btn_typography',
                'selector'  => '{{WRAPPER}} .eafe-post-elements-readmore-btn',
            ]
        );

        $this->start_controls_tabs( 'bbsrms_blog_read_more_button_tabs' );

        $this->start_controls_tab(
            'bbsrms_blog_read_more_button_style_normal',
            [
                'label'     => esc_html__( 'Normal', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'bbsrms_blog_read_more_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-post-elements-readmore-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'bbsrms_blog_read_more_btn_background',
                'label'     => esc_html__( 'Background', 'mega-elements-addons-for-elementor' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .eafe-post-elements-readmore-btn',
                'exclude'   => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'bbsrms_blog_read_more_btn_border',
                'label'     => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-post-elements-readmore-btn',
            ]
        );

        $this->add_responsive_control(
            'bbsrms_blog_read_more_btn_border_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-post-elements-readmore-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'bbsrms_blog_read_more_button_style_hover',
            [
                'label'     => esc_html__( 'Hover', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'bbsrms_blog_read_more_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-post-elements-readmore-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'bbsrms_blog_read_more_btn_hover_background',
                'label'     => esc_html__( 'Background', 'mega-elements-addons-for-elementor' ),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .eafe-post-elements-readmore-btn:hover',
                'exclude'   => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'bbsrms_blog_read_more_btn_hover_border',
                'label'     => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-post-elements-readmore-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'bbsrms_blog_read_more_btn_border_hover_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-post-elements-readmore-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'bbsrms_blog_read_more_btn_padding',
            [
                'label'     => esc_html__( 'Padding', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-post-elements-readmore-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bbsrms_blog_read_more_btn_margin',
            [
                'label'     => esc_html__( 'Margin', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-post-elements-readmore-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function load_more_button_style()
    {
        /**
         * Blog Load More Button Style
        */ 
        $this->start_controls_section(
            'mefe_blog_style_load_more_style',
            [
                'label'     => esc_html__( 'Load More Button Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'bbcls_blog_show_load_more' => ['yes', '1', 'true'],
                ],
            ]
        );

        $this->add_responsive_control(
            'bbslms_blog_load_more_btn_padding',
            [
                'label'     => esc_html__( 'Padding', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bbslms_blog_load_more_btn_margin',
            [
                'label'     => esc_html__('Margin', 'mega-elements-addons-for-elementor'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'bbslms_blog_load_more_btn_typography',
                'selector'  => '{{WRAPPER}} .eafe-load-more-button',
            ]
        );

        $this->start_controls_tabs( 'bbslms_blog_load_more_btn_tabs' );

        // Normal State Tab
        $this->start_controls_tab(
            'bbslms_blog_load_more_btn_normal', 
            [
                'label'     => esc_html__( 'Normal', 'mega-elements-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'bbslms_blog_load_more_btn_normal_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'mega-elements-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bbslms_blog_load_more_btn_normal_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'bbslms_blog_load_more_btn_normal_border',
                'label'     => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-load-more-button',
            ]
        );

        $this->add_control(
            'bbslms_blog_load_more_btn_border_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button' => 'border-radius: {{SIZE}}px',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'bbslms_blog_load_more_btn_shadow',
                'selector'  => '{{WRAPPER}} .eafe-load-more-button',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'bbslms_blog_load_more_btn_hover', 
            [
                'label'     => esc_html__( 'Hover', 'mega-elements-addons-for-elementor' ) 
            ] 
        );

        $this->add_control(
            'bbslms_blog_load_more_btn_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bbslms_blog_load_more_btn_hover_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bbslms_blog_load_more_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]

        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'bbslms_blog_load_more_btn_hover_shadow',
                'selector'  => '{{WRAPPER}} .eafe-load-more-button:hover',
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'bbslms_blog_loadmore_button_alignment',
            [
                'label'     => esc_html__( 'Button Alignment', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'    => [
                        'title'     => esc_html__( 'Left', 'mega-elements-addons-for-elementor' ),
                        'icon'      => 'fa fa-align-left',
                    ],
                    'center'        => [
                        'title'     => esc_html__( 'Center', 'mega-elements-addons-for-elementor' ),
                        'icon'      => 'fa fa-align-center',
                    ],
                    'flex-end'      => [
                        'title'     => esc_html__( 'Right', 'mega-elements-addons-for-elementor' ),
                        'icon'      => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .eafe-load-more-button-wrap' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function _register_controls()
    {
        /**
         * Query Controls
         */
        $this->query_controls();

        /**
         * Layout Controls
         */
        $this->layout_controls();

        /**
         * General Style Controls
         */
        $this->start_controls_section(
            'mefe_blog_style_general_style',
            [
                'label'     => esc_html__( 'General Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bbsgs_blog_bg_color',
            [
                'label'     => esc_html__( 'Post Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post-holder' => 'background-color: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            'bbsgs_blog_spacing',
            [
                'label'     => esc_html__( 'Spacing Between Items', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post, {{WRAPPER}} .eafe-blog-grid-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .eafe-post-grid-container [data-layout-mode="grid"], .eafe-post-grid-container [data-layout-mode="masonry"]' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'bbsgs_blog_spacing_content',
            [
                'label'     => esc_html__( 'Content Padding', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-blog-post-grid .eafe-entry-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'bbsgs_blog_border',
                'label'     => esc_html__( 'Border', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-grid-post-holder',
            ]
        );

        $this->add_control(
            'bbsgs_blog_border_radius',
            [
                'label'     => esc_html__( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post-holder' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'bbsgs_blog_box_shadow',
                'selector'  => '{{WRAPPER}} .eafe-grid-post-holder',
            ]
        );

        $this->add_responsive_control(
            'bbsgs_blog_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'mega-elements-addons-for-elementor' ),
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
                ],
                'prefix_class' => 'eafe-blog-aligment-',
            ]
        );

        $this->end_controls_section();

        /**
         * Color & Typography Style
         */
        $this->start_controls_section(
            'mefe_blog_style_color_typography_style',
            [
                'label'     => esc_html__( 'Color & Typography', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bbscts_blog_title_style',
            [
                'label'     => esc_html__( 'Title Style', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bbscts_blog_title_color',
            [
                'label'     => esc_html__( 'Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-title a' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_control(
            'bbscts_blog_title_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-title:hover, {{WRAPPER}} .eafe-entry-title a:hover' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'bbscts_blog_title_typography',
                'label'     => esc_html__( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-entry-title',
            ]
        );

        $this->add_control(
            'bbscts_blog_excerpt_style',
            [
                'label'     => esc_html__( 'Excerpt Style', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bbscts_blog_excerpt_color',
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
                'name'      => 'bbscts_blog_excerpt_typography',
                'label'     => esc_html__( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-grid-post-excerpt p',
            ]
        );

        $this->add_control(
            'bbscts_blog_content_height',
            [
                'label'     => esc_html__( 'Content Height', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'     => [
                    'px' => ['max' => 300],
                    '%' => ['max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-grid-post-holder .eafe-entry-wrapper' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'bbscts_blog_meta_style',
            [
                'label'     => esc_html__( 'Meta Style', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bbscts_blog_meta_color',
            [
                'label'     => esc_html__( 'Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eafe-entry-meta, .eafe-entry-meta a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'bbscts_blog_meta_typography',
                'label'     => esc_html__( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-entry-meta > div, {{WRAPPER}} .eafe-entry-meta > span',
            ]
        );

        $this->end_controls_section();

        /**
         * Read More Button Style
         */
        $this->read_more_button_style();

        /**
         * Load More Button Style
         */
        $this->load_more_button_style();
    }

    public function get_query_args( $settings = [] )
    {
        $settings = wp_parse_args( $settings, [
            'post_type' => 'post',
            'posts_ids' => [],
            'orderby' => 'date',
            'order' => 'desc',
            'posts_per_page' => 3,
            'post__not_in' => [],
        ]);

        $args = [
            'orderby' => $settings['bbcqs_blog_orderby'],
            'order' => $settings['bbcqs_blog_order'],
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
            'posts_per_page' => $settings['bbcqs_blog_posts_per_page'],
        ];

        
        $args['tax_query'] = [];
        $taxonomies = get_object_taxonomies( 'post', 'objects' );

        foreach ( $taxonomies as $object ) {
            $setting_key = 'bbcqs_blog_' . $object->name . '_ids';

            if ( !empty( $settings[$setting_key] ) ) {
                $args['tax_query'][] = [
                    'taxonomy' => $object->name,
                    'field' => 'term_id',
                    'terms' => $settings[$setting_key],
                ];
            }
        }

        if ( !empty( $args['tax_query'] ) ) {
            $args['tax_query']['relation'] = 'AND';
        }

        if ( !empty( $settings['bbcqs_blog_authors'] ) ) {
            $args['author__in'] = $settings['bbcqs_blog_authors'];
        }

        if ( !empty( $settings['bbcqs_blog_post__not_in'] ) ) {
            $args['post__not_in'] = $settings['bbcqs_blog_post__not_in'];
        }

        return $args;
    }

    public function render_blog_template( $args, $settings )
    {

        $blog_query = new \WP_Query($args);
         
        ob_start();

        if( $blog_query->have_posts() ) {
            while( $blog_query->have_posts() ) {
                $blog_query->the_post();
                echo '<article class="eafe-blog-grid-post eafe-post-grid-column" data-id="' . esc_attr( get_the_ID() ) . '">
                    <div class="eafe-grid-post-holder">
                        <div class="eafe-grid-post-holder-inner">';
                            if ( has_post_thumbnail() && $settings['bbcls_blog_show_image'] == 'yes') {
                                echo '<div class="eafe-entry-media">';
                                    echo '<div class="eafe-entry-thumbnail">
                                        <img src="' . esc_url( wp_get_attachment_image_url( get_post_thumbnail_id(), $settings['bbcls_blog_image'])) . '" alt="' . esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ) . '">
                                    </div>';
                                echo '</div>';
                            }
                            echo '<div class="eafe-entry-wrapper">';

                                echo '<header class="eafe-entry-header">';
                                    if ( 'post' === get_post_type() && $settings['bbcls_blog_show_category'] ) {
                                        /* translators: used between list items, there is a space after the comma */
                                        $categories_list = get_the_category_list( esc_html__( ' ', 'mega-elements-addons-for-elementor' ) );
                                        if ( $categories_list ) {
                                            echo '<span class="category" itemprop="about">' . $categories_list . '</span>';
                                        }
                                    }

                                    if ( $settings['bbcls_blog_show_title'] ) {
                                        echo '<h2 class="eafe-entry-title"><a class="eafe-grid-post-link" href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h2>';
                                    }
                                echo '</header>';

                                echo '<div class="eafe-entry-meta">';
                                    if ( $settings['bbcls_blog_show_author'] || $settings['bbcls_blog_show_author_avatar'] ) {
                                        echo '<span class="eafe-posted-by">';
                                            if ( $settings['bbcls_blog_show_author_avatar'] ) {
                                                echo '<div class="eafe-author-avatar">
                                                    <a href="' . get_author_posts_url( get_the_author_meta('ID')) . '">' . get_avatar(get_the_author_meta( 'ID' ), 96 ) . '</a>
                                                </div>';
                                            }
                                            if ( $settings['bbcls_blog_show_author'] ) echo esc_url( get_the_author_posts_link() );
                                        echo '</span>';
                                    }
                                    if ( $settings['bbcls_blog_show_date'] ) echo '<span class="eafe-posted-on"><time datetime="' . get_the_date() . '">' . get_the_date() . '</time></span>';
                                echo '</div>';

                                if ( $settings['bbcls_blog_show_excerpt'] ) {
                                    echo '<div class="eafe-entry-content">
                                        <div class="eafe-grid-post-excerpt">
                                            <p>' . wp_trim_words( strip_shortcodes( get_the_excerpt() ? get_the_excerpt() : get_the_content() ), $settings['bbcls_blog_excerpt_length'], $settings['bbcls_blog_excerpt_expanison_indicator']) . '</p>';
                                        echo '</div>
                                    </div>';
                                }

                                if ( $settings['bbcls_blog_show_read_more_button'] ) {
                                    echo '<a href="' . esc_url( get_the_permalink() ) . '" class="eafe-post-elements-readmore-btn">' . esc_attr( $settings['bbcls_blog_read_more_button_text'] ) . '</a>';
                                }
                            echo '</div>';
                        echo '</div>
                    </div>
                </article>';
            }
        } else {
            _e( '<p class="no-posts-found">No posts found!</p>', 'mega-elements-addons-for-elementor' );
        }

        wp_reset_postdata();

        return ob_get_clean();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        $args = $this->get_query_args($settings);

        $settings_arry = [
            'bbcls_blog_show_image'                  => $settings['bbcls_blog_show_image'],
            'bbcls_blog_image'                       => $settings['bbcls_blog_image_size'],
            'bbcls_blog_show_title'                  => $settings['bbcls_blog_show_title'],
            'bbcls_blog_show_excerpt'                => $settings['bbcls_blog_show_excerpt'],
            'bbcls_blog_show_author'                 => $settings['bbcls_blog_show_author'],
            'bbcls_blog_show_author_avatar'          => $settings['bbcls_blog_show_author_avatar'],
            'bbcls_blog_show_date'                   => $settings['bbcls_blog_show_date'],
            'bbcls_blog_show_category'               => $settings['bbcls_blog_show_category'],
            'bbcls_blog_excerpt_length'              => intval( $settings['bbcls_blog_excerpt_length'], 10 ),
            'bbcls_blog_show_read_more_button'       => $settings['bbcls_blog_show_read_more_button'],
            'bbcls_blog_read_more_button_text'       => $settings['bbcls_blog_read_more_button_text'],
            'bbcls_blog_show_load_more'              => $settings['bbcls_blog_show_load_more'],
            'bbcls_blog_show_load_more_text'         => $settings['bbcls_blog_show_load_more_text'],
            'bbcls_blog_excerpt_expanison_indicator' => $settings['bbcls_blog_excerpt_expanison_indicator'],
            'bbcls_blog_layout_mode'                 => $settings['bbcls_blog_layout_mode'],
            'bbcqs_blog_orderby'                     => $settings['bbcqs_blog_orderby'],
        ];

        $this->add_render_attribute(
            'blog_wrapper',
            [
                'id' => 'eafe-post-grid-' . esc_attr( $this->get_id() ),
                'class' => [
                    'eafe-post-grid-container',
                ],
            ]
        );

        echo '<div ' . $this->get_render_attribute_string( 'blog_wrapper' ) . '>
            <div class="eafe-blog-post-grid eafe-post-appender eafe-post-appender-' . $this->get_id() . '" data-layout-mode="' . $settings["bbcls_blog_layout_mode"] . '">
                ' . self::render_blog_template( $args, $settings_arry ) . '
            </div>
            <div class="clearfix"></div>
        </div>';

        if ( 'yes' == $settings['bbcls_blog_show_load_more'] ) {
            if ($args['posts_per_page'] != '-1') {
                echo '<div class="eafe-load-more-button-wrap">
                    <button class="eafe-load-more-button" id="eafe-load-more-btn-' . $this->get_id() . '" data-widget="' . $this->get_id() . '" data-class="' . get_class( $this ) . '" data-args="' . http_build_query( $args ) . '" data-settings="' . http_build_query( $settings_arry ) . '" data-layout="masonry" data-page="1">
                        <div class="eafe-btn-loader button__loader"></div>
                        <span>' . $settings['bbcls_blog_show_load_more_text'] . '</span>
                    </button>
                </div>';
            }
        }

        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) { ?>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    jQuery(".eafe-blog-post-grid").each(function() {
                        var $scope = jQuery(".elementor-element-<?php echo $this->get_id(); ?>"),
                            $gallery = $(this);
                            $layout_mode = $gallery.data('layout-mode');

                        if($layout_mode === 'masonry') {
                            // init isotope
                            var $isotope_gallery = $gallery.isotope({
                                    itemSelector   : ".eafe-blog-grid-post",
                                    layoutMode     : $layout_mode,
                                    percentPosition: true
                                });

                            // layout gal, while images are loading
                            $isotope_gallery.imagesLoaded().progress(function() {
                                $isotope_gallery.isotope("layout");
                            });

                            $('.eafe-grid-post', $gallery).resize(function() {
                                $isotope_gallery.isotope('layout');
                            });
                        }

                    });
                });
            </script>
            <?php
        }
    }

    protected function _content_template() {
    }
}
