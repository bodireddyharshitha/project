<?php
/**
 * Customizer Settings Defaults 
 * 
 * @package Travel Monster
 */

if( ! function_exists( 'travel_monster_get_site_defaults' ) ) :
/**
 * Site Defaults
 * 
 * @return array
 */
function travel_monster_get_site_defaults(){

    $defaults = array(
        'hide_title'        => false,
        'hide_tagline'      => true,
        'logo_width'        => '50',
        'tablet_logo_width' => '50',
        'mobile_logo_width' => '50',
    );

    return apply_filters( 'travel_monster_site_options_defaults', $defaults );
}
endif;

if( ! function_exists( 'travel_monster_get_typography_defaults' ) ) :
/**
 * Typography Defaults
 * 
 * @return array
 */
function travel_monster_get_typography_defaults(){
    $defaults = array(
        
        'primary_font' => array(
            'family'         => 'Poppins',
            'variants'       => '',
            'category'       => '',
            'weight'         => '400',
            'transform'      => 'none',
            'desktop' => array(
                'font_size'      => 16,
                'line_height'    => 1.75,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 16,
                'line_height'    => 1.75,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 16,
                'line_height'    => 1.75,
                'letter_spacing' => 0,
            )
        ),
        'site_title' => array(
            'family'    => 'Default Family',
            'variants'  => '',
            'category'  => '',
            'weight'    => 'bold',
            'transform' => 'none',
            'desktop' => array(
                'font_size'      => 18,
                'line_height'    => 1.5,
                'letter_spacing' => 0
            ),
            'tablet' => array(
                'font_size'      => 18,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 18,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            )
        ),
        'button' => array(
            'family'         => 'Default Family',
            'variants'       => '',
            'category'       => '',
            'weight'         => '400',
            'transform'      => 'none',
            'desktop' => array(
                'font_size'      => 16,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 16,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 16,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            )
        ),
        'heading_one' => array(
            'family'      => 'Default Family',
            'variants'    => '',
            'category'    => '',
            'weight'      => '700',
            'transform'   => 'none',
            'desktop' => array(
                'font_size'      => 40,
                'line_height'    => 1.3,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 40,
                'line_height'    => 1.3,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 36,
                'line_height'    => 1.3,
                'letter_spacing' => 0,
            )
        ),
        'heading_two' => array(
            'family'      => 'Default Family',
            'variants'    => '',
            'category'    => '',
            'weight'      => '700',
            'transform'   => 'none',
            'desktop' => array(
                'font_size'      => 32,
                'line_height'    => 1.3,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 32,
                'line_height'    => 1.3,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 30,
                'line_height'    => 1.3,
                'letter_spacing' => 0,
            )
        ),
        'heading_three' => array(
            'family'      => 'Default Family',
            'variants'    => '',
            'category'    => '',
            'weight'      => '700',
            'transform'   => 'none',
            'desktop' => array(
                'font_size'      => 28,
                'line_height'    => 1.4,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 28,
                'line_height'    => 1.4,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 26,
                'line_height'    => 1.4,
                'letter_spacing' => 0,
            )
        ),
        'heading_four' => array(
            'family'      => 'Default Family',
            'variants'    => '',
            'category'    => '',
            'weight'      => '700',
            'transform'   => 'none',
            'desktop' => array(
                'font_size'      => 24,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 24,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 22,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            )
        ),
        'heading_five' => array(
            'family'      => 'Default Family',
            'variants'    => '',
            'category'    => '',
            'weight'      => '700',
            'transform'   => 'none',
            'desktop' => array(
                'font_size'      => 20,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 20,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 18,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            )
        ),
        'heading_six' => array(
            'family'      => 'Default Family',
            'variants'    => '',
            'category'    => '',
            'weight'      => '700',
            'transform'   => 'none',
            'desktop' => array(
                'font_size'      => 16,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'tablet' => array(
                'font_size'      => 16,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            ),
            'mobile' => array(
                'font_size'      => 16,
                'line_height'    => 1.5,
                'letter_spacing' => 0,
            )
        )
    );

    return apply_filters( 'travel_monster_typography_options_defaults', $defaults ); 
}
endif;

if( ! function_exists( 'travel_monster_get_color_defaults' ) ) :
/**
 * Color Defaults
 * 
 * @return array
 */
function travel_monster_get_color_defaults(){
    $defaults = array(
        'primary_color'                     => '#28B5A4',
        'secondary_color'                   => '#e48e45',
        'body_font_color'                   => '#494d41',
        'heading_color'                     => '#232323',
        'section_bg_color'                  => 'rgba(40, 181, 164, 0.05)',
        'site_bg_color'                     => '#FFFFFF',
        'site_title_color'                  => '#232323',
        'site_tagline_color'                => '#232323',
        'header_btn_text_color'             => '#ffffff',
        'header_btn_text_hover_color'       => '#ffffff',
        'header_btn_bg_color'               => '#e48e45',
        'header_btn_bg_hover_color'         => 'rgba(40,181,164,0.92)',
        'btn_text_color_initial'            => '#ffffff',
        'btn_text_color_hover'              => '#ffffff',
        'btn_bg_color_initial'              => '#e48e45',
        'btn_bg_color_hover'                => '#28B5A4',
        'btn_border_color_initial'          => '#e48e45',
        'btn_border_color_hover'            => '#28B5A4',
        'notification_bg_color'             => '#28B5A4',
        'notification_text_color'           => '#ffffff',
        'upper_footer_bg_color'             => '#26786e',
        'upper_footer_text_color'           => '#ffffff',
        'upper_footer_link_hover_color'     => 'rgba(255, 255, 255, 0.8)',
        'upper_footer_widget_heading_color' => '#ffffff',
        'bottom_footer_bg_color'            => '#26786e',
        'bottom_footer_text_color'          => '#ffffff',
        'bottom_footer_link_initial_color'  => '#ffffff',
        'bottom_footer_link_hover_color'    => 'rgba(255, 255, 255, 0.8)',
        'theme_white_color'                 => '#ffffff',
        'theme_black_color'                 => '#000000',
        'top_header_bg_color'               => '#28b5a4',
        'top_header_text_color'             => '#ffffff',
    );

    return apply_filters( 'travel_monster_color_options_defaults', $defaults );
}
endif;

if( ! function_exists( 'travel_monster_get_button_defaults' ) ) :
/**
 * Button Defaults
 * 
 * @return array
 */
function travel_monster_get_button_defaults(){

    $defaults = array(
        'btn_roundness' => array(
            'top'    => 4,
            'right'  => 4,
            'bottom' => 4,
            'left'   => 4,
        ),
        'button_padding'   => array(
            'top'    => 16,
            'right'  => 32,
            'bottom' => 16,
            'left'   => 32,
        )
    );

    return apply_filters( 'travel_monster_button_options_defaults', $defaults );
}
endif;

if( ! function_exists( 'travel_monster_get_general_defaults' ) ) :
/**
 * General Defaults
 * 
 * @return array
 */
function travel_monster_get_general_defaults(){

    $defaults = array(
        'ed_blog_title'                   => true,
        'ed_blog_desc'                    => false,
        'blog_alignment'                  => 'left',
        'blog_crop_image'                 => true,
        'blog_content'                    => 'excerpt',
        'excerpt_length'                  => 55,
        'blog_meta_order'                 => array( 'author', 'date' ),
        'blog_ed_category'                => true,
        'blog_read_more'                  => __( 'Read More', 'travel-monster' ),
        'blog_page_layout'                => 'one',
        'blog_sidebar_layout'             => 'default-sidebar',
        'ed_archive_prefix'               => false,
        'ed_archive_title'                => true,
        'ed_archive_description'          => true,
        'ed_archive_post_count'           => true,
        'archive_alignment'               => 'left',
        'archive_page_layout'             => 'one',
        'archive_sidebar_layout'          => 'default-sidebar',
        'archive_header_image'            => '',
        'ed_page_title'                   => true,
        'page_alignment'                  => 'left',
        'page_sidebar_layout'             => 'right-sidebar',
        'ed_page_image'                   => true,
        'ed_page_comments'                => false,
        'single_post_layout'              => 'one',
        'post_sidebar_layout'             => 'right-sidebar',
        'ed_crop_single_image'            => false,
        'single_post_meta_order'          => array( 'author', 'date' ),
        'ed_author'                       => true,
        'ed_post_tags'                    => true,
        'ed_post_pagination'              => true,
        'ed_post_related'                 => true,
        'single_related_title'            => __( 'Recommended Articles','travel-monster' ),
        'related_taxonomy'                => 'cat',
        'related_post_num'                => 4,
        'related_post_row'                => 4,
        'related_posts_location'          => 'end',
        'ed_single_comments'              => true,
        'single_comment_form'             => 'below',
        'single_comment_location'         => 'below',
        'ed_social_sharing'               => true,
        'ed_og_tags'                      => true,
        'social_share_text'               => __( 'SHARE THIS ARTICLE:', 'travel-monster' ),
        'social_share'                    => array( 'facebook', 'twitter', 'pinterest', 'linkedin' ),
        'no_of_posts_404'                 => 3,
        'ed_latest_post'                  => true,
        'posts_per_row_404'               => 3,
        'read_more_style'                 => 'text',
        'post_navigation'                 => 'numbered',
        'load_more_label'                 => __( 'Load More Posts', 'travel-monster' ),
        'loading_label'                   => __( 'Loading...', 'travel-monster' ),
        'no_more_label'                   => __( 'No More Post', 'travel-monster' ),
        'home_text'                       => __( 'Home', 'travel-monster' ),
        'separator_icon'                  => 'one',
        'ed_post_update_date'             => true,
        'container_width'                 => 1320,
        'tablet_container_width'          => 992,
        'mobile_container_width'          => 420,
        'fullwidth_centered'              => 780,
        'tablet_fullwidth_centered'       => 780,
        'mobile_fullwidth_centered'       => 780,
        'layout'                          => 'boxed',
        'page_layout'                     => 'default',
        'layout_style'                    => 'right-sidebar',
        'ed_header_search'                => false,
        'header_layout'                   => 'one',
        'header_button_label'             => __( 'Book Now','travel-monster' ),
        'header_button_link'              => '',
        'ed_header_button_newtab'         => true,
        'ed_header_button_sticky'         => true,
        'ed_currency_code'                => true,
        'ed_currency_symbol'              => true,
        'ed_currency_name'                => false,
        'ed_social_media'                 => false,
        'ed_social_media_newtab'          => false,
        'social_media_order'              => array( 'tmp_facebook', 'tmp_twitter', 'tmp_instagram'),
        'header_strech_menu'              => false,
        'header_items_spacing'            => 30,
        'header_dropdown_width'           => 230,
        'sidebar_width'                   => 28,
        'tablet_sidebar_width'            => 28,
        'widgets_spacing'                 => 32,
        'tablet_widgets_spacing'          => 32,
        'mobile_widgets_spacing'          => 20,
        'ed_last_widget_sticky'           => false,
        'layout_style'                    => 'right-sidebar',
        'ed_scroll_top'                   => true,
        'scroll_top_alignment'            => 'right',
        'scroll_top_size'                 => 20,
        'tablet_scroll_top_size'          => 20,
        'mobile_scroll_top_size'          => 20,
        'scroll_top_bottom_offset'        => 25,
        'tablet_scroll_top_bottom_offset' => 25,
        'mobile_scroll_top_bottom_offset' => 25,
        'scroll_top_side_offset'          => 25,
        'tablet_scroll_top_side_offset'   => 25,
        'mobile_scroll_top_side_offset'   => 25,
        'tablet_posts_per_row_404'        => 2,
        'mobile_posts_per_row_404'        => 1,
        'header_width_layout'             => 'boxed',
        'ed_sticky_header'                => false,
        'tmp_phone_label'                 => '',
        'tmp_phone'                       => '',
        'tmp_email_label'                 => '',
        'tmp_email'                       => '',
        'mobile_menu_label'               => __('Menu', 'travel-monster'),
        'ed_mobile_search'                => true,
        'ed_mobile_phone'                 => true,
        'ed_mobile_email'                 => true,
        'ed_mobile_social_media'          => true,
        'header_contact_image'            => '',
        'header_trip_advisor_image'       => '',
        'ed_breadcrumb'                   => true,
        'tmp_facebook'                    => '#',
        'tmp_twitter'                     => '#',
        'tmp_instagram'                   => '#',
        'tmp_pinterest'                   => '',
        'tmp_youtube'                     => '',
        'tmp_tiktok'                      => '',
        'tmp_linkedin'                    => '',
        'tmp_whatsapp'                    => '',
        'tmp_viber'                       => '',
        'tmp_telegram'                    => '',
        'tmp_tripadvisor'                 => '',
        'footer_copyright'                => '',
        'ed_author_link'                  => false,
        'ed_wp_link'                      => false,
        'payment_label'                   => __( 'Secured Payment:','travel-monster' ),
        'payment_image'                   => '',
        '404_image'                       => '',
        'blog_header_image'               => '',
        'ed_localgoogle_fonts'            => false,
        'ed_preload_local_fonts'          => false,
        'ed_sticky_booking_form'          => false
    );
    return apply_filters( 'travel_monster_general_defaults', $defaults );
}
endif;