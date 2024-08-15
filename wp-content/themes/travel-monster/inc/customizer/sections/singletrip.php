<?php
/**
 * Single Trip Setting
 *
 * @param [type] $wp_customize
 * @return void
 */
function travel_monster_customize_register_single_trip( $wp_customize ){

    if( travel_monster_is_wpte_activated() ){

        $default = travel_monster_get_general_defaults();

        /** Single Trip */
        $wp_customize->add_section( 
            'single_trip_section',
            array(
                'priority' => 71,
                'title'    => __( 'Single Trip', 'travel-monster' ),
            ) 
        );

        
        $wp_customize->add_setting(
            'ed_sticky_booking_form',
            array(
                'default'           => $default['ed_sticky_booking_form'],
                'sanitize_callback' => 'travel_monster_sanitize_checkbox',
            )
        );
    
        $wp_customize->add_control(
            new Travel_Monster_Toggle_Control( 
                $wp_customize,
                'ed_sticky_booking_form',
                array(
                    'section' => 'single_trip_section',
                    'label'   => __( 'Enable sticky booking form', 'travel-monster' ),
                )
            )
        );
    }
}
add_action( 'customize_register', 'travel_monster_customize_register_single_trip' );