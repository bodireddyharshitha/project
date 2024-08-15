<?php
/**
 * Header Setting
 *
 * @package Travel Monster
 */

function travel_monster_customize_register_layout_header( $wp_customize ) {
    
    $defaults      = travel_monster_get_general_defaults();
    $colorDefaults = travel_monster_get_color_defaults();

    $wp_customize->add_section(
        'layout_header',
        array(
            'title'      => __( 'Main Header', 'travel-monster' ),
            'priority'   => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** General Settings */
    $wp_customize->add_setting(
        'main_header_general_settings_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'main_header_general_settings_group',
            array(
                'id'          => 'main_header_general_settings_group',
                'label'       => __( 'General Settings', 'travel-monster' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /*Header layouts*/
    $wp_customize->add_setting( 
        'header_width_layout', 
        array(
            'default'           => $defaults['header_width_layout'],
            'sanitize_callback' => 'travel_monster_sanitize_select_radio',
            'transport'         => 'postMessage'
        ) 
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Radio_Buttonset_Control(
			$wp_customize,
			'header_width_layout',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Header Width', 'travel-monster' ),
				'choices' => array(
					'boxed'     => __( 'Boxed', 'travel-monster' ),
					'fullwidth' => __( 'Fullwidth', 'travel-monster' ),
                ),
                'group' => 'main_header_general_settings_group',
			)
		)
	);

    /** Sticky Header Menu */
    $wp_customize->add_setting(
        'ed_sticky_header',
        array(
            'default'           => $defaults['ed_sticky_header'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_sticky_header',
			array(
				'section'  => 'layout_header',
				'label'    => __( 'Sticky Header', 'travel-monster' ),
				'group'    => 'main_header_general_settings_group',
				'priority' => 10
			)
		)
	);

      /** Header Search Menu */
      $wp_customize->add_setting(
        'ed_header_search',
        array(
            'default'           => $defaults['ed_header_search'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_header_search',
			array(
				'section'  => 'layout_header',
				'label'    => __( 'Header Search', 'travel-monster' ),
				'group'    => 'main_header_general_settings_group',
				'priority' => 15
			)
		)
    );

    /** Top Header Background Color */
    $wp_customize->add_setting(
        'top_header_bg_color',
        array(
            'default'           => $colorDefaults['top_header_bg_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'travel_monster_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Alpha_Color_Customize_Control(
            $wp_customize,
            'top_header_bg_color',
            array(
                'label'    => __( 'Top Header Color', 'travel-monster' ),
                'section'  => 'layout_header',
                'group'    => 'main_header_general_settings_group',
                'priority' => 25
            )
        )
    );

    /** Top Header Text Color */
    $wp_customize->add_setting(
        'top_header_text_color',
        array(
            'default'           => $colorDefaults['top_header_text_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'travel_monster_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Alpha_Color_Customize_Control(
            $wp_customize,
            'top_header_text_color',
            array(
                'label'   => __( 'Text Color', 'travel-monster' ),
                'section' => 'layout_header',
                'group'   => 'main_header_general_settings_group',
                'priority' => 30
            )
        )
    );

    /** Navigation Menu Settings */
    $wp_customize->add_setting(
        'main_header_navigation_menu_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'main_header_navigation_menu_group',
            array(
                'id'          => 'main_header_navigation_menu_group',
                'label'       => __( 'Navigation Menu', 'travel-monster' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /** Items Spacing */
    $wp_customize->add_setting(
        'header_items_spacing',
        array(
            'default'           => $defaults['header_items_spacing'],
            'sanitize_callback' => 'travel_monster_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Range_Slider_Control(
            $wp_customize,
            'header_items_spacing',
            array(
                'label'    => __( 'Items Spacing', 'travel-monster' ),
                'section'  => 'layout_header',
                'settings' => array(
                    'desktop' => 'header_items_spacing',
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                ),
                'group' => 'main_header_navigation_menu_group', 
            )
        )
    );

    /** Header Strech Menu */
    $wp_customize->add_setting(
        'header_strech_menu',
        array(
            'default'           => $defaults['header_strech_menu'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
            'transport' => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'header_strech_menu',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Stretch Menu', 'travel-monster' ),
				'group'   => 'main_header_navigation_menu_group',
			)
		)
	);

    /** Dropdown Width */
    $wp_customize->add_setting(
        'header_dropdown_width',
        array(
            'default'           => $defaults['header_dropdown_width'],
            'sanitize_callback' => 'travel_monster_sanitize_empty_absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Range_Slider_Control(
            $wp_customize,
            'header_dropdown_width',
            array(
                'label'    => __( 'Dropdown Width', 'travel-monster' ),
                'section'  => 'layout_header',
                'settings' => array(
                    'desktop' => 'header_dropdown_width',
                ),
                'choices' => array(
                    'desktop' => array(
                        'min'  => 0,
                        'max'  => 350,
                        'step' => 1,
                        'edit' => true,
                        'unit' => 'px',
                    ),
                ),
                'group' => 'main_header_navigation_menu_group', 
            )
        )
    );

    /** Contact Information */
    $wp_customize->add_setting(
        'main_header_contact_information_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'main_header_contact_information_group',
            array(
                'id'          => 'main_header_contact_information_group',
                'label'       => __( 'Contact Information', 'travel-monster' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

     /** Phone */
     $wp_customize->add_setting(
        'tmp_phone',
        array(
            'default'           => $defaults['tmp_phone'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Text_Control( 
			$wp_customize,
			'tmp_phone',
			array(
				'section'  => 'layout_header',
				'priority' => 8,
				'label'    => __( 'Phone', 'travel-monster' ),
				'group'    => 'main_header_contact_information_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'tmp_phone', array(
        'selector'        => '.header-m .contact-phone-wrap',
        'render_callback' => 'travel_monster_header_phone',
    ) );

    /** Email */
    $wp_customize->add_setting(
        'tmp_email',
        array(
            'default'           => $defaults['tmp_email'],
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Text_Control( 
			$wp_customize,
			'tmp_email',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Email', 'travel-monster' ),
				'group'   => 'main_header_contact_information_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'tmp_email', array(
        'selector'        => '.header-m .contact-email-wrap',
        'render_callback' => 'travel_monster_header_email',
    ) );

    /** Header Button */
    $wp_customize->add_setting(
        'main_header_header_button_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'main_header_header_button_group',
            array(
                'id'          => 'main_header_header_button_group',
                'label'       => __( 'Header Button', 'travel-monster' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

     /** Phone */
     $wp_customize->add_setting(
        'header_button_label',
        array(
            'default'           => $defaults['header_button_label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Text_Control( 
			$wp_customize,
			'header_button_label',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Button Label', 'travel-monster' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'header_button_label', array(
        'selector'        => '.site-header .btn-book .btn-primary',
        'render_callback' => 'travel_monster_get_header_button',
    ) );

    /** Phone */
    $wp_customize->add_setting(
        'header_button_link',
        array(
            'default'           => $defaults['header_button_link'],
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Text_Control( 
			$wp_customize,
			'header_button_link',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Button URL', 'travel-monster' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);
    
    $wp_customize->add_setting(
        'ed_header_button_newtab',
        array(
            'default'           => $defaults['ed_header_button_newtab'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_header_button_newtab',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Open link in new Tab', 'travel-monster' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);

    $wp_customize->add_setting(
        'ed_header_button_sticky',
        array(
            'default'           => $defaults['ed_header_button_sticky'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_header_button_sticky',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show in Sticky Header', 'travel-monster' ),
				'group'   => 'main_header_header_button_group',
			)
		)
	);

    /** Background Color */
    $wp_customize->add_setting(
        'header_btn_bg_color',
        array(
            'default'           => $colorDefaults['header_btn_bg_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'travel_monster_sanitize_rgba',
        )
    );
    $wp_customize->add_control(
        new Travel_Monster_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_bg_color',
            array(
                'label'   => __( 'Background Color', 'travel-monster' ),
                'section' => 'layout_header',
				'group'   => 'main_header_header_button_group',
            )
        )
    );

    /** Background Hover Color */
    $wp_customize->add_setting(
        'header_btn_bg_hover_color',
        array(
            'default'           =>  $colorDefaults['header_btn_bg_hover_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'travel_monster_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_bg_hover_color',
            array(
                'label'   => __( 'Background Hover Color', 'travel-monster' ),
                'section' => 'layout_header',
				'group'   => 'main_header_header_button_group',
            )
        )
    );
    
    /** Text Color */
    $wp_customize->add_setting(
        'header_btn_text_color',
        array(
            'default'           => $colorDefaults['header_btn_text_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'travel_monster_sanitize_rgba',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_text_color',
            array(
                'label'   => __( 'Text Color', 'travel-monster' ),
                'section' => 'layout_header',
                'group'   => 'main_header_header_button_group',
            )
        )
    );

    /** Text Hover Color */
    $wp_customize->add_setting(
        'header_btn_text_hover_color',
        array(
            'default'           => $colorDefaults['header_btn_text_hover_color'],
            'transport'         => 'postMessage',
            'sanitize_callback' => 'travel_monster_sanitize_rgba',
        )
    );
    $wp_customize->add_control(
        new Travel_Monster_Alpha_Color_Customize_Control(
            $wp_customize,
            'header_btn_text_hover_color',
            array(
                'label'   => __( 'Text Hover Color', 'travel-monster' ),
                'section' => 'layout_header',
                'group'   => 'main_header_header_button_group',
            )
        )
    );

    /** Currency Converter Settings */
    $wp_customize->add_setting(
        'main_header_currency_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'main_header_currency_group',
            array(
                'id'              => 'main_header_currency_group',
                'label'           => __( 'Currency Converter', 'travel-monster' ),
                'section'         => 'layout_header',
                'type'            => 'group',
                'style'           => 'collapsible',
                'active_callback' => 'travel_monster_is_currency_converter_activated'
            )
        )
    );

    /** Currency Code */
    $wp_customize->add_setting(
        'ed_currency_code',
        array(
            'default'           => $defaults['ed_currency_code'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_currency_code',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Currency Code', 'travel-monster' ),
				'group'   => 'main_header_currency_group',
			)
		)
	);

    /** Currency Symbol */
    $wp_customize->add_setting(
        'ed_currency_symbol',
        array(
            'default'           => $defaults['ed_currency_symbol'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_currency_symbol',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Currency Symbol', 'travel-monster' ),
				'group'   => 'main_header_currency_group',
			)
		)
	);
    
    /** Currency Name */
      $wp_customize->add_setting(
        'ed_currency_name',
        array(
            'default'           => $defaults['ed_currency_name'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_currency_name',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Currency Name', 'travel-monster' ),
				'group'   => 'main_header_currency_group',
			)
		)
	);

    /** Social Media Settings */
    $wp_customize->add_setting(
        'main_header_social_media_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'main_header_social_media_group',
            array(
                'id'          => 'main_header_social_media_group',
                'label'       => __( 'Social Media Settings', 'travel-monster' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /** Social Media */
    $wp_customize->add_setting(
        'ed_social_media',
        array(
            'default'           => $defaults['ed_social_media'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_social_media',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Social Media', 'travel-monster' ),
				'group'   => 'main_header_social_media_group',
			)
		)
	);

    /* Open in new tab */

    $wp_customize->add_setting(
        'ed_social_media_newtab',
        array(
            'default'           => $defaults['ed_social_media_newtab'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_social_media_newtab',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Open in new tab', 'travel-monster' ),
				'group'   => 'main_header_social_media_group',
			)
		)
	);

    $wp_customize->add_setting(
		'social_media_order', 
		array(
			'default'           => $defaults['social_media_order'], 
			'sanitize_callback' => 'travel_monster_sanitize_sortable',
		)
	);

	$wp_customize->add_control(
		new Travel_Monster_Sortable_Control(
			$wp_customize,
			'social_media_order',
			array(
				'section'     => 'layout_header',
				'label'       => __( 'Social Media', 'travel-monster' ),
				'choices'     => array(
            		'tmp_facebook'    => __( 'Facebook', 'travel-monster'),
            		'tmp_twitter'     => __( 'Twitter', 'travel-monster'),
            		'tmp_instagram'   => __( 'Instagram', 'travel-monster'),
            		'tmp_pinterest'   => __( 'Pinterest', 'travel-monster'),
            		'tmp_youtube'     => __( 'Youtube', 'travel-monster'),
            		'tmp_tiktok'      => __( 'TikTok', 'travel-monster'),
            		'tmp_linkedin'    => __( 'LinkedIn', 'travel-monster'),
            		'tmp_whatsapp'    => __( 'WhatsApp', 'travel-monster'),
            		'tmp_viber'       => __( 'Viber', 'travel-monster'),
            		'tmp_telegram'    => __( 'Telegram', 'travel-monster'),
            		'tmp_tripadvisor' => __( 'Trip Advisor', 'travel-monster')
            	),
                'group'           => 'main_header_social_media_group',
			)
		)
    );

    $wp_customize->add_setting(
        'header_social_media_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Travel_Monster_Note_Control( 
            $wp_customize,
            'header_social_media_text',
            array(
                'section'         => 'layout_header',
                'description'     => sprintf(__( 'You can add links to your social media profiles %1$s here. %2$s', 'travel-monster' ), '<span class="text-inner-link header_social_media_text">', '</span>'),
                'group'           => 'main_header_social_media_group',
            )
        )
    );

     /** Mobile Header Settings */
     $wp_customize->add_setting(
        'mobile_header_settings_group',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        new Travel_Monster_Group_Control( 
            $wp_customize,
            'mobile_header_settings_group',
            array(
                'id'          => 'mobile_header_settings_group',
                'label'       => __( 'Mobile Header Settings', 'travel-monster' ),
                'section'     => 'layout_header',
                'type'        => 'group',
                'style'       => 'collapsible',
            )
        )
    );

    /** Phone Label */
    $wp_customize->add_setting(
        'mobile_menu_label',
        array(
            'default'           => $defaults['mobile_menu_label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Text_Control( 
			$wp_customize,
			'mobile_menu_label',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Menu Label', 'travel-monster' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    $wp_customize->selective_refresh->add_partial( 'mobile_menu_label', array(
        'selector'        => '.mobile-header .mob-menu-op-txt',
        'render_callback' => 'travel_monster_header_mobile_menu_label',
    ) );

    /** Mobile Menu Search */
    $wp_customize->add_setting(
        'ed_mobile_search',
        array(
            'default'           => $defaults['ed_mobile_search'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_mobile_search',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Search', 'travel-monster' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    /** Mobile Menu Phone */
    $wp_customize->add_setting(
        'ed_mobile_phone',
        array(
            'default'           => $defaults['ed_mobile_phone'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_mobile_phone',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Phone Number', 'travel-monster' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    /** Mobile Menu Email*/
    $wp_customize->add_setting(
        'ed_mobile_email',
        array(
            'default'           => $defaults['ed_mobile_email'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_mobile_email',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Email Address', 'travel-monster' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);

    /** Mobile Menu Social Media */
    $wp_customize->add_setting(
        'ed_mobile_social_media',
        array(
            'default'           => $defaults['ed_mobile_social_media'],
            'sanitize_callback' => 'travel_monster_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		new Travel_Monster_Toggle_Control( 
			$wp_customize,
			'ed_mobile_social_media',
			array(
				'section' => 'layout_header',
				'label'   => __( 'Show Social Media', 'travel-monster' ),
				'group'   => 'mobile_header_settings_group',
			)
		)
	);
}
add_action( 'customize_register', 'travel_monster_customize_register_layout_header' );