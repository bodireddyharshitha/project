<?php
namespace MegaElementsAddonsForElementor\Widget;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class EAFE_Testimonial extends Widget_Base
{

    public function get_name() {
        return 'eafe-testimonial';
    }

    public function get_title() {
        return esc_html__( 'Testimonial', 'mega-elements-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eafe-testimonial';
    }

    public function get_categories() {
        return ['eafe-elements'];
    }

    public function get_style_depends() {
        return ['eafe-testimonial'];
    }

    protected function _register_controls() 
    {
        /**
         * Testimonial General Settings
        */
        $this->start_controls_section(
            'mefe_testimonial_content_general_settings',
            [
                'label'     => __( 'General Settings', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'btcgs_testimonial_title',
            [
                'label'         => __( 'Testimonial Title', 'mega-elements-addons-for-elementor' ),
                'label_block'   => true,
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Testimonial Title', 'mega-elements-addons-for-elementor' ),
                'dynamic'       => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'btcgs_testimonial_content',
            [
                'label'         => __( 'Testimonial Content', 'mega-elements-addons-for-elementor' ),
                'label_block'   => true,
                'type'          => Controls_Manager::WYSIWYG,
                'default'       => __( 'Testimonial Contents', 'mega-elements-addons-for-elementor' ),
                'dynamic'       => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'btcgs_testimonial_name',
            [
                'label'         => __( 'Name', 'mega-elements-addons-for-elementor' ),
                'label_block'   => true,
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'John Doe', 'mega-elements-addons-for-elementor' ),
                'dynamic'       => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'btcgs_testimonial_position',
            [
                'label'         => __( 'Position', 'mega-elements-addons-for-elementor' ),
                'label_block'   => true,
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Manager', 'mega-elements-addons-for-elementor' ),
                'dynamic'       => [
                    'active' => true,
                ]
            ]
        );

        $this->add_responsive_control(
            'btcgs_testimonial_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options'   => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'mega-elements-addons-for-elementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'eafe-testimonial-align-'
            ]
        );

        $this->add_control(
            'btcgs_testimonial_image',
            [
                'label'     => __( 'Image', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'btcgs_testimonial_thumbnail',
                'default'   => 'full',
                'condition' => [
                    'btcgs_testimonial_image[url]!' => '',
                ],
            ]
        );

        $this->end_controls_section();
        
        /**
         * Testimonial General Style
        */
        $this->start_controls_section(
            'mefe_testimonial_style_general_style',
            [
                'label'     => __( 'General Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btsgs_testimonial_title_heading_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Testimonial Title', 'mega-elements-addons-for-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btsgs_testimonial_title_padding',
            [
                'label'     => __( 'Padding', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'btsgs_testimonial_title_spacing',
            [
                'label'     => __( 'Bottom Spacing', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'btsgs_testimonial_title_color',
            [
                'label'     => __( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btsgs_testimonial_title_bg_color',
            [
                'label'     => __( 'Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-title' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .eafe-testimonial-title:after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btsgs_testimonial_title_typography',
                'label'     => __( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-testimonial-title',
            ]
        );

        $this->add_responsive_control(
            'btsgs_testimonial_title_border_radius',
            [
                'label'     => __( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'btsgs_testimonial_title_box_shadow',
                'selector'  => '{{WRAPPER}} .eafe-testimonial-title',
            ]
        );

        $this->add_control(
            'btsgs_testimonial_content_heading_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Testimonial Content', 'mega-elements-addons-for-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btsgs_testimonial_content_padding',
            [
                'label'     => __( 'Padding', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'btsgs_testimonial_content_spacing',
            [
                'label'     => __( 'Bottom Spacing', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'btsgs_testimonial_content_color',
            [
                'label'     => __( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btsgs_testimonial_content_bg_color',
            [
                'label'     => __( 'Background Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-content' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .eafe-testimonial-content:after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btsgs_testimonial_content_typography',
                'label'     => __( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-testimonial-content',
            ]
        );

        $this->add_responsive_control(
            'btsgs_testimonial_content_border_radius',
            [
                'label'     => __( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'btsgs_testimonial_content_box_shadow',
                'selector'  => '{{WRAPPER}} .eafe-testimonial-content',
            ]
        );

        $this->end_controls_section();

        /**
         * Testimonial Image Style
        */
        $this->start_controls_section(
            'mefe_testimonial_style_image_style',
            [
                'label'     => __( 'Image Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'btsis_testimonial_image_width',
            [
                'label'     => __( 'Width', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'     => [
                    'px' => [
                        'min' => 65,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-reviewer-thumb' => '-webkit-flex: 0 0 {{SIZE}}{{UNIT}}; -ms-flex: 0 0 {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btsis_testimonial_image_height',
            [
                'label'     => __( 'Height', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'     => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-reviewer-thumb' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'btsis_testimonial_image_border',
                'selector'  => '{{WRAPPER}} .eafe-testimonial-reviewer-thumb',
            ]
        );

        $this->add_responsive_control(
            'btsis_testimonial_image_border_radius',
            [
                'label'     => __( 'Border Radius', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-reviewer-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'btsis_testimonial_image_box_shadow',
                'selector'  => '{{WRAPPER}} .eafe-testimonial-reviewer-thumb',
            ]
        );

        $this->end_controls_section();

        /**
         * Testimonial General Style
        */
        $this->start_controls_section(
            'mefe_testimonial_style_reviewer_style',
            [
                'label'     => __( 'Reviewer Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btsrs_testimonial_heading_name',
            [
                'label'     => __( 'Name', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'btsrs_testimonial_name_color',
            [
                'label'     => __( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-reviewer-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btsrs_testimonial_name_typography',
                'label'     => __( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-testimonial-reviewer-name',
            ]
        );

        $this->add_responsive_control(
            'btsrs_testimonial_name_spacing',
            [
                'label'     => __( 'Bottom Spacing', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-reviewer-name' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'btsrs_testimonial_heading_title',
            [
                'label'     => __( 'Title', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'btsrs_testimonial_title_color',
            [
                'label'     => __( 'Text Color', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eafe-testimonial-reviewer-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btsrs_testimonial_title_typography',
                'label'     => __( 'Typography', 'mega-elements-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .eafe-testimonial-reviewer-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'btcgs_testimonial_title', 'basic' );
        $this->add_render_attribute( 'btcgs_testimonial_title', 'class', 'eafe-testimonial-title' );

        $this->add_inline_editing_attributes( 'btcgs_testimonial_content', 'intermediate' );
        $this->add_render_attribute( 'btcgs_testimonial_content', 'class', 'eafe-testimonial-content' );

        $this->add_inline_editing_attributes( 'btcgs_testimonial_name', 'basic' );
        $this->add_render_attribute( 'btcgs_testimonial_name', 'class', 'eafe-testimonial-reviewer-name' );

        $this->add_inline_editing_attributes( 'btcgs_testimonial_position', 'basic' );
        $this->add_render_attribute( 'btcgs_testimonial_position', 'class', 'eafe-testimonial-reviewer-title' );
        ?>

        <div <?php $this->print_render_attribute_string( 'btcgs_testimonial_title' ); ?>>
            <?php echo $settings['btcgs_testimonial_title']; ?>
        </div>
        <div <?php $this->print_render_attribute_string( 'btcgs_testimonial_content' ); ?>>
            <?php echo $settings['btcgs_testimonial_content']; ?>
        </div>
        <div class="eafe-testimonial-reviewer">
            <?php if ( $settings['btcgs_testimonial_image']['url'] || $settings['btcgs_testimonial_image']['id'] ) : ?>
                <div class="eafe-testimonial-reviewer-thumb">
                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'btcgs_testimonial_thumbnail', 'btcgs_testimonial_image' ); 
                    ?>
                </div>
            <?php endif; ?>

            <div class="eafe-testimonial-reviewer-meta">
                <div <?php $this->print_render_attribute_string( 'btcgs_testimonial_name' ); ?>><?php echo $settings['btcgs_testimonial_name']; ?></div>
                <div <?php $this->print_render_attribute_string( 'btcgs_testimonial_position' ); ?>><?php echo $settings['btcgs_testimonial_position']; ?></div>
            </div>
        </div>
        <?php
    }

    public function _content_template() {
        ?>
        <#

        view.addInlineEditingAttributes( 'btcgs_testimonial_title', 'basic' );
        view.addRenderAttribute( 'btcgs_testimonial_title', 'class', 'eafe-testimonial-title' );

        view.addInlineEditingAttributes( 'btcgs_testimonial_content', 'intermediate' );
        view.addRenderAttribute( 'btcgs_testimonial_content', 'class', 'eafe-testimonial-content' );

        view.addInlineEditingAttributes( 'btcgs_testimonial_name', 'basic' );
        view.addRenderAttribute( 'btcgs_testimonial_name', 'class', 'eafe-testimonial-reviewer-name' );

        view.addInlineEditingAttributes( 'btcgs_testimonial_position', 'basic' );
        view.addRenderAttribute( 'btcgs_testimonial_position', 'class', 'eafe-testimonial-reviewer-title' );

        #>

        <# if (settings.btcgs_testimonial_title) { #>
            <div {{{ view.getRenderAttributeString( 'btcgs_testimonial_title' ) }}}>{{ settings.btcgs_testimonial_title }}</div>
        <# } #>

        <# if (settings.btcgs_testimonial_content) { #>
            <div {{{ view.getRenderAttributeString( 'btcgs_testimonial_content' ) }}}>{{ settings.btcgs_testimonial_content }}</div>
        <# } #>

        <div class="eafe-testimonial-reviewer">
            <# if ( settings.btcgs_testimonial_image.url || settings.btcgs_testimonial_image.id ) {
                var image = {
                    id: settings.btcgs_testimonial_image.id,
                    url: settings.btcgs_testimonial_image.url,
                    size: settings.btcgs_testimonial_thumbnail_size,
                    dimension: settings.btcgs_testimonial_thumbnail_custom_dimension,
                    model: view.getEditModel()
                };

                var image_url = elementor.imagesManager.getImageUrl( image );
                #>
                <div class="eafe-testimonial-reviewer-thumb">
                    <img src="{{ image_url }}">
                </div>
            <# } #>
            <div class="eafe-testimonial-reviewer-meta">
                <# if (settings.btcgs_testimonial_name) { #>
                    <div {{{ view.getRenderAttributeString( 'btcgs_testimonial_name' ) }}}>{{ settings.btcgs_testimonial_name }}</div>
                <# } #>

                <# if (settings.btcgs_testimonial_position) { #>
                    <div {{{ view.getRenderAttributeString( 'btcgs_testimonial_position' ) }}}>{{ settings.btcgs_testimonial_position }}</div>
                <# } #>
            </div>
        </div>


    <?php
    }
}
