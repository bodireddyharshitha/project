<?php
namespace MegaElementsAddonsForElementor\Widget;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

class EAFE_Clients extends Widget_Base
{

    public function get_name() {
        return 'eafe-clients';
    }

    public function get_title() {
        return esc_html__( 'Clients Logo', 'mega-elements-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eafe-client';
    }

    public function get_categories() {
        return ['eafe-elements'];
    }

    public function get_style_depends() {
        return ['eafe-clients', 'owl-carousel'];
    }
    
    public function get_script_depends() {
        return ['eafe-clients', 'owl-carousel'];
    }

    public function get_grid_classes( $settings, $columns_field = 'bccgs_clients_per_line' ) {
        
        $grid_classes = ' eafe-grid-desktop-';
        $grid_classes .= $settings[$columns_field];
        $grid_classes .= ' eafe-grid-tablet-';
        $grid_classes .= $settings[$columns_field . '_tablet'];
        $grid_classes .= ' eafe-grid-mobile-';
        $grid_classes .= $settings[$columns_field . '_mobile'];

        return apply_filters( 'mefe_grid_classes', $grid_classes, $settings, $columns_field );
    }

    protected function _register_controls() 
    {
        /**
         * Clients General Settings
        */
        $this->start_controls_section(
            'mefe_clients_content_general_settings',
            [
                'label'     => esc_html__( 'General Settings', 'mega-elements-addons-for-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'bccgs_clients_per_line',
            [
                'label'     => esc_html__( 'Columns per row', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '4',
                'tablet_default' => '3',
                'mobile_default' => '2',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bccgs_clients_show_carousel',
            [
                'label'     => esc_html__( 'Enable Carousel', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => '',
            ]
        );

        $this->add_control(
            'bccgs_clients_show_carousel_nav',
            [
                'label'     => esc_html__( 'Enable Carousel Navigation', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => '',
                'condition' => [
                    'bccgs_clients_show_carousel' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bccgs_clients_show_carousel_dots',
            [
                'label'     => esc_html__( 'Enable Carousel Dots', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
                'condition' => [
                    'bccgs_clients_show_carousel' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bccgs_clients_show_carousel_auto',
            [
                'label'     => esc_html__( 'Enable Carousel AutoPlay', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => '',
                'condition' => [
                    'bccgs_clients_show_carousel' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bccgs_clients_carousel_autoplay_speed',
            [
                'label'     => __( 'Autoplay Speed', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 100,
                'step'      => 100,
                'max'       => 10000,
                'default'   => 3000,
                'description' => __( 'Autoplay speed in milliseconds', 'mega-elements-addons-for-elementor' ),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bccgs_clients_show_carousel_loop',
            [
                'label'     => esc_html__( 'Enable Carousel Infinite Loop', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => '',
                'condition' => [
                    'bccgs_clients_show_carousel' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'bccgs_clients_show_black_and_white',
            [
                'label'     => esc_html__( 'Show in Black/White', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Show', 'mega-elements-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'mega-elements-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'   => 'yes',
                'prefix_class'  => 'eafe-clients-bw'
            ]
        );

        $this->add_control(
            'bccgs_clients_repeater',
            [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => [

                    [
                        'name'          => 'bccgs_client_image',
                        'label'         => esc_html__( 'Client Logo/Image', 'mega-elements-addons-for-elementor' ),
                        'description'   => esc_html__( 'The logo image for the client/customer.', 'mega-elements-addons-for-elementor' ),
                        'type'          => Controls_Manager::MEDIA,
                        'default'       => [
                            'url'           => Utils::get_placeholder_image_src(),
                        ],
                        'label_block'   => true,
                        'dynamic'       => [
                            'active'        => true,
                        ],
                    ],


                    [
                        'name'          => 'bccgs_client_link',
                        'label'         => esc_html__( 'Client URL', 'mega-elements-addons-for-elementor' ),
                        'description'   => esc_html__( 'The website of the client/customer.', 'mega-elements-addons-for-elementor' ),
                        'type'          => Controls_Manager::URL,
                        'label_block'   => true,
                        'default'       => [
                            'url'           => '',
                            'is_external'   => 'true',
                        ],
                        'placeholder'   => esc_html__( 'http://', 'mega-elements-addons-for-elementor'),
                        'dynamic'       => [
                            'active'        => true,
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Clients General Style
        */
        $this->start_controls_section(
            'mefe_clients_content_general_style',
            [
                'label'     => esc_html__( 'General Style', 'mega-elements-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_control(
            'bccgs_client_heading_image',
            [
                'label'     => esc_html__( 'Client Images', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'bccgs_client_max_width',
            [
                'label'         => esc_html__( 'Max Width', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-clients .eafe-client .eafe-image' => 'max-width: {{SIZE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'bccgs_client_thumbnail_hover_opacity',
            [
                'label'     => esc_html__( 'Logo Hover Opacity (%)', 'mega-elements-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size'      => 0.7,
                ],
                'range'     => [
                    'px'        => [
                        'max'   => 1,
                        'min'   => 0.10,
                        'step'  => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eafe-clients .eafe-client:hover .eafe-image' => 'opacity: {{SIZE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'bccgs_client_padding',
            [
                'label'         => esc_html__( 'Padding', 'mega-elements-addons-for-elementor' ),
                'description'   => esc_html__( 'Padding for the Client Logo images.', 'mega-elements-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .eafe-clients .eafe-client' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .eafe-clients .eafe-grid-container:not(.owl-carousel)' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        ?>
        <div class="eafe-clients eafe-gapless-grid">
            <div class="eafe-grid-container<?php echo $this->get_grid_classes( $settings ); ?><?php if ( $settings['bccgs_clients_show_carousel'] == true ) echo ' owl-carousel'; ?>">                
                <?php
                foreach ( $settings['bccgs_clients_repeater'] as $client ) : ?>
                    <div class="eafe-grid-item eafe-client">
                        <?php 

                        if ( !empty( $client['bccgs_client_link'] ) && !empty( $client['bccgs_client_link']['url'] ) ) :
                            $target = $client['bccgs_client_link']['is_external'] ? ' target="_blank"' : '';
                            echo '<a href="' . esc_url( $client['bccgs_client_link']['url'] ) . '"' . $target . '>'; 
                        endif;
                        if ( !empty( $client['bccgs_client_image'] ) ) :
                            echo wp_get_attachment_image( $client['bccgs_client_image']['id'], 'full', false, array( 'class' => 'eafe-image full' ) );
                        endif;
                        if( !empty( $client['bccgs_client_link'] ) && !empty( $client['bccgs_client_link']['url'] ) ) :
                            echo '</a>';
                        endif; ?>
                    </div><!-- .eafe-client -->
                <?php endforeach; ?>
            </div>
        </div><!-- .eafe-clients -->
        <?php
    }

    protected function _content_template() { 
    }
}
