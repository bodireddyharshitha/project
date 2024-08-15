<?php
/**
 * Travel Monster Dynamic Styles
 * 
 * @package Travel Monster
*/

function travel_monster_dynamic_css(){
	$typo_defaults   = travel_monster_get_typography_defaults();
	$defaults        = travel_monster_get_color_defaults();
	$site_defaults   = travel_monster_get_site_defaults();
	$layout_defaults = travel_monster_get_general_defaults();
	$button_defaults = travel_monster_get_button_defaults();

	$logo_width        = get_theme_mod( 'logo_width', $site_defaults['logo_width'] );
	$tablet_logo_width = get_theme_mod( 'tablet_logo_width', $site_defaults['tablet_logo_width'] );
	$mobile_logo_width = get_theme_mod( 'mobile_logo_width', $site_defaults['mobile_logo_width'] );
    
	$primary_font   = wp_parse_args( get_theme_mod( 'primary_font' ), $typo_defaults['primary_font'] );
	$sitetitle      = wp_parse_args( get_theme_mod( 'site_title' ), $typo_defaults['site_title'] );
	$button         = wp_parse_args( get_theme_mod( 'button' ), $typo_defaults['button'] );
	$heading_one    = wp_parse_args( get_theme_mod( 'heading_one' ), $typo_defaults['heading_one'] );
	$heading_two    = wp_parse_args( get_theme_mod( 'heading_two' ), $typo_defaults['heading_two'] );
	$heading_three  = wp_parse_args( get_theme_mod( 'heading_three' ), $typo_defaults['heading_three'] );
	$heading_four   = wp_parse_args( get_theme_mod( 'heading_four' ), $typo_defaults['heading_four'] );
	$heading_five   = wp_parse_args( get_theme_mod( 'heading_five' ), $typo_defaults['heading_five'] );
	$heading_six    = wp_parse_args( get_theme_mod( 'heading_six' ), $typo_defaults['heading_six'] );

    //Primary Font variables
    $primarydesktopFontSize = isset(  $primary_font['desktop']['font_size'] ) ? $primary_font['desktop']['font_size'] : $typo_defaults['primary_font']['desktop']['font_size'];
    $primarydesktopSpacing = isset(  $primary_font['desktop']['letter_spacing'] ) ? $primary_font['desktop']['letter_spacing'] : $typo_defaults['primary_font']['desktop']['letter_spacing'];
    $primarydesktopHeight = isset(  $primary_font['desktop']['line_height'] ) ? $primary_font['desktop']['line_height'] : $typo_defaults['primary_font']['desktop']['line_height'];
    $primarytabletFontSize = isset(  $primary_font['tablet']['font_size'] ) ? $primary_font['tablet']['font_size'] : $typo_defaults['primary_font']['tablet']['font_size'];
    $primarytabletSpacing = isset(  $primary_font['tablet']['letter_spacing'] ) ? $primary_font['tablet']['letter_spacing'] : $typo_defaults['primary_font']['tablet']['letter_spacing'];
    $primarytabletHeight = isset(  $primary_font['tablet']['line_height'] ) ? $primary_font['tablet']['line_height'] : $typo_defaults['primary_font']['tablet']['line_height'];
    $primarymobileFontSize = isset(  $primary_font['mobile']['font_size'] ) ? $primary_font['mobile']['font_size'] : $typo_defaults['primary_font']['mobile']['font_size'];
    $primarymobileSpacing = isset(  $primary_font['mobile']['letter_spacing'] ) ? $primary_font['mobile']['letter_spacing'] : $typo_defaults['primary_font']['mobile']['letter_spacing'];
    $primarymobileHeight = isset(  $primary_font['mobile']['line_height'] ) ? $primary_font['mobile']['line_height'] : $typo_defaults['primary_font']['mobile']['line_height'];
    
    //Site Title variables
    $sitedesktopFontSize = isset(  $sitetitle['desktop']['font_size'] ) ? $sitetitle['desktop']['font_size'] : $typo_defaults['site_title']['desktop']['font_size'];
    $sitedesktopSpacing = isset(  $sitetitle['desktop']['letter_spacing'] ) ? $sitetitle['desktop']['letter_spacing'] : $typo_defaults['site_title']['desktop']['letter_spacing'];
    $sitedesktopHeight = isset(  $sitetitle['desktop']['line_height'] ) ? $sitetitle['desktop']['line_height'] : $typo_defaults['site_title']['desktop']['line_height'];
    $sitetabletFontSize = isset(  $sitetitle['tablet']['font_size'] ) ? $sitetitle['tablet']['font_size'] : $typo_defaults['site_title']['tablet']['font_size'];
    $sitetabletSpacing = isset(  $sitetitle['tablet']['letter_spacing'] ) ? $sitetitle['tablet']['letter_spacing'] : $typo_defaults['site_title']['tablet']['letter_spacing'];
    $sitetabletHeight = isset(  $sitetitle['tablet']['line_height'] ) ? $sitetitle['tablet']['line_height'] : $typo_defaults['site_title']['tablet']['line_height'];
    $sitemobileFontSize = isset(  $sitetitle['mobile']['font_size'] ) ? $sitetitle['mobile']['font_size'] : $typo_defaults['site_title']['mobile']['font_size'];
    $sitemobileSpacing = isset(  $sitetitle['mobile']['letter_spacing'] ) ? $sitetitle['mobile']['letter_spacing'] : $typo_defaults['site_title']['mobile']['letter_spacing'];
    $sitemobileHeight = isset(  $sitetitle['mobile']['line_height'] ) ? $sitetitle['mobile']['line_height'] : $typo_defaults['site_title']['mobile']['line_height'];
    
    //Button variables
    $btndesktopFontSize = isset(  $button['desktop']['font_size'] ) ? $button['desktop']['font_size'] : $typo_defaults['button']['desktop']['font_size'];
    $btndesktopSpacing = isset(  $button['desktop']['letter_spacing'] ) ? $button['desktop']['letter_spacing'] : $typo_defaults['button']['desktop']['letter_spacing'];
    $btndesktopHeight = isset(  $button['desktop']['line_height'] ) ? $button['desktop']['line_height'] : $typo_defaults['button']['desktop']['line_height'];
    $btntabletFontSize = isset(  $button['tablet']['font_size'] ) ? $button['tablet']['font_size'] : $typo_defaults['button']['tablet']['font_size'];
    $btntabletSpacing = isset(  $button['tablet']['letter_spacing'] ) ? $button['tablet']['letter_spacing'] : $typo_defaults['button']['tablet']['letter_spacing'];
    $btntabletHeight = isset(  $button['tablet']['line_height'] ) ? $button['tablet']['line_height'] : $typo_defaults['button']['tablet']['line_height'];
    $btnmobileFontSize = isset(  $button['mobile']['font_size'] ) ? $button['mobile']['font_size'] : $typo_defaults['button']['mobile']['font_size'];
    $btnmobileSpacing = isset(  $button['mobile']['letter_spacing'] ) ? $button['mobile']['letter_spacing'] : $typo_defaults['button']['mobile']['letter_spacing'];
    $btnmobileHeight = isset(  $button['mobile']['line_height'] ) ? $button['mobile']['line_height'] : $typo_defaults['button']['mobile']['line_height'];
    
    //Heading 1 variables
    $h1desktopFontSize = isset(  $heading_one['desktop']['font_size'] ) ? $heading_one['desktop']['font_size'] : $typo_defaults['heading_one']['desktop']['font_size'];
    $h1desktopSpacing = isset(  $heading_one['desktop']['letter_spacing'] ) ? $heading_one['desktop']['letter_spacing'] : $typo_defaults['heading_one']['desktop']['letter_spacing'];
    $h1desktopHeight = isset(  $heading_one['desktop']['line_height'] ) ? $heading_one['desktop']['line_height'] : $typo_defaults['heading_one']['desktop']['line_height'];
    $h1tabletFontSize = isset(  $heading_one['tablet']['font_size'] ) ? $heading_one['tablet']['font_size'] : $typo_defaults['heading_one']['tablet']['font_size'];
    $h1tabletSpacing = isset(  $heading_one['tablet']['letter_spacing'] ) ? $heading_one['tablet']['letter_spacing'] : $typo_defaults['heading_one']['tablet']['letter_spacing'];
    $h1tabletHeight = isset(  $heading_one['tablet']['line_height'] ) ? $heading_one['tablet']['line_height'] : $typo_defaults['heading_one']['tablet']['line_height'];
    $h1mobileFontSize = isset(  $heading_one['mobile']['font_size'] ) ? $heading_one['mobile']['font_size'] : $typo_defaults['heading_one']['mobile']['font_size'];
    $h1mobileSpacing = isset(  $heading_one['mobile']['letter_spacing'] ) ? $heading_one['mobile']['letter_spacing'] : $typo_defaults['heading_one']['mobile']['letter_spacing'];
    $h1mobileHeight = isset(  $heading_one['mobile']['line_height'] ) ? $heading_one['mobile']['line_height'] : $typo_defaults['heading_one']['mobile']['line_height'];
    
    //Heading 2 variables
    $h2desktopFontSize = isset(  $heading_two['desktop']['font_size'] ) ? $heading_two['desktop']['font_size'] : $typo_defaults['heading_two']['desktop']['font_size'];
    $h2desktopSpacing = isset(  $heading_two['desktop']['letter_spacing'] ) ? $heading_two['desktop']['letter_spacing'] : $typo_defaults['heading_two']['desktop']['letter_spacing'];
    $h2desktopHeight = isset(  $heading_two['desktop']['line_height'] ) ? $heading_two['desktop']['line_height'] : $typo_defaults['heading_two']['desktop']['line_height'];
    $h2tabletFontSize = isset(  $heading_two['tablet']['font_size'] ) ? $heading_two['tablet']['font_size'] : $typo_defaults['heading_two']['tablet']['font_size'];
    $h2tabletSpacing = isset(  $heading_two['tablet']['letter_spacing'] ) ? $heading_two['tablet']['letter_spacing'] : $typo_defaults['heading_two']['tablet']['letter_spacing'];
    $h2tabletHeight = isset(  $heading_two['tablet']['line_height'] ) ? $heading_two['tablet']['line_height'] : $typo_defaults['heading_two']['tablet']['line_height'];
    $h2mobileFontSize = isset(  $heading_two['mobile']['font_size'] ) ? $heading_two['mobile']['font_size'] : $typo_defaults['heading_two']['mobile']['font_size'];
    $h2mobileSpacing = isset(  $heading_two['mobile']['letter_spacing'] ) ? $heading_two['mobile']['letter_spacing'] : $typo_defaults['heading_two']['mobile']['letter_spacing'];
    $h2mobileHeight = isset(  $heading_two['mobile']['line_height'] ) ? $heading_two['mobile']['line_height'] : $typo_defaults['heading_two']['mobile']['line_height'];
    
    //Heading 3 variables
    $h3desktopFontSize = isset(  $heading_three['desktop']['font_size'] ) ? $heading_three['desktop']['font_size'] : $typo_defaults['heading_three']['desktop']['font_size'];
    $h3desktopSpacing = isset(  $heading_three['desktop']['letter_spacing'] ) ? $heading_three['desktop']['letter_spacing'] : $typo_defaults['heading_three']['desktop']['letter_spacing'];
    $h3desktopHeight = isset(  $heading_three['desktop']['line_height'] ) ? $heading_three['desktop']['line_height'] : $typo_defaults['heading_three']['desktop']['line_height'];
    $h3tabletFontSize = isset(  $heading_three['tablet']['font_size'] ) ? $heading_three['tablet']['font_size'] : $typo_defaults['heading_three']['tablet']['font_size'];
    $h3tabletSpacing = isset(  $heading_three['tablet']['letter_spacing'] ) ? $heading_three['tablet']['letter_spacing'] : $typo_defaults['heading_three']['tablet']['letter_spacing'];
    $h3tabletHeight = isset(  $heading_three['tablet']['line_height'] ) ? $heading_three['tablet']['line_height'] : $typo_defaults['heading_three']['tablet']['line_height'];
    $h3mobileFontSize = isset(  $heading_three['mobile']['font_size'] ) ? $heading_three['mobile']['font_size'] : $typo_defaults['heading_three']['mobile']['font_size'];
    $h3mobileSpacing = isset(  $heading_three['mobile']['letter_spacing'] ) ? $heading_three['mobile']['letter_spacing'] : $typo_defaults['heading_three']['mobile']['letter_spacing'];
    $h3mobileHeight = isset(  $heading_three['mobile']['line_height'] ) ? $heading_three['mobile']['line_height'] : $typo_defaults['heading_three']['mobile']['line_height'];
    
    //Heading 4 variables
    $h4desktopFontSize = isset(  $heading_four['desktop']['font_size'] ) ? $heading_four['desktop']['font_size'] : $typo_defaults['heading_four']['desktop']['font_size'];
    $h4desktopSpacing = isset(  $heading_four['desktop']['letter_spacing'] ) ? $heading_four['desktop']['letter_spacing'] : $typo_defaults['heading_four']['desktop']['letter_spacing'];
    $h4desktopHeight = isset(  $heading_four['desktop']['line_height'] ) ? $heading_four['desktop']['line_height'] : $typo_defaults['heading_four']['desktop']['line_height'];
    $h4tabletFontSize = isset(  $heading_four['tablet']['font_size'] ) ? $heading_four['tablet']['font_size'] : $typo_defaults['heading_four']['tablet']['font_size'];
    $h4tabletSpacing = isset(  $heading_four['tablet']['letter_spacing'] ) ? $heading_four['tablet']['letter_spacing'] : $typo_defaults['heading_four']['tablet']['letter_spacing'];
    $h4tabletHeight = isset(  $heading_four['tablet']['line_height'] ) ? $heading_four['tablet']['line_height'] : $typo_defaults['heading_four']['tablet']['line_height'];
    $h4mobileFontSize = isset(  $heading_four['mobile']['font_size'] ) ? $heading_four['mobile']['font_size'] : $typo_defaults['heading_four']['mobile']['font_size'];
    $h4mobileSpacing = isset(  $heading_four['mobile']['letter_spacing'] ) ? $heading_four['mobile']['letter_spacing'] : $typo_defaults['heading_four']['mobile']['letter_spacing'];
    $h4mobileHeight = isset(  $heading_four['mobile']['line_height'] ) ? $heading_four['mobile']['line_height'] : $typo_defaults['heading_four']['mobile']['line_height'];
    
    //Heading 5 variables
    $h5desktopFontSize = isset(  $heading_five['desktop']['font_size'] ) ? $heading_five['desktop']['font_size'] : $typo_defaults['heading_five']['desktop']['font_size'];
    $h5desktopSpacing = isset(  $heading_five['desktop']['letter_spacing'] ) ? $heading_five['desktop']['letter_spacing'] : $typo_defaults['heading_five']['desktop']['letter_spacing'];
    $h5desktopHeight = isset(  $heading_five['desktop']['line_height'] ) ? $heading_five['desktop']['line_height'] : $typo_defaults['heading_five']['desktop']['line_height'];
    $h5tabletFontSize = isset(  $heading_five['tablet']['font_size'] ) ? $heading_five['tablet']['font_size'] : $typo_defaults['heading_five']['tablet']['font_size'];
    $h5tabletSpacing = isset(  $heading_five['tablet']['letter_spacing'] ) ? $heading_five['tablet']['letter_spacing'] : $typo_defaults['heading_five']['tablet']['letter_spacing'];
    $h5tabletHeight = isset(  $heading_five['tablet']['line_height'] ) ? $heading_five['tablet']['line_height'] : $typo_defaults['heading_five']['tablet']['line_height'];
    $h5mobileFontSize = isset(  $heading_five['mobile']['font_size'] ) ? $heading_five['mobile']['font_size'] : $typo_defaults['heading_five']['mobile']['font_size'];
    $h5mobileSpacing = isset(  $heading_five['mobile']['letter_spacing'] ) ? $heading_five['mobile']['letter_spacing'] : $typo_defaults['heading_five']['mobile']['letter_spacing'];
    $h5mobileHeight = isset(  $heading_five['mobile']['line_height'] ) ? $heading_five['mobile']['line_height'] : $typo_defaults['heading_five']['mobile']['line_height'];
    
    //Heading 6 variables
    $h6desktopFontSize = isset(  $heading_six['desktop']['font_size'] ) ? $heading_six['desktop']['font_size'] : $typo_defaults['heading_six']['desktop']['font_size'];
    $h6desktopSpacing = isset(  $heading_six['desktop']['letter_spacing'] ) ? $heading_six['desktop']['letter_spacing'] : $typo_defaults['heading_six']['desktop']['letter_spacing'];
    $h6desktopHeight = isset(  $heading_six['desktop']['line_height'] ) ? $heading_six['desktop']['line_height'] : $typo_defaults['heading_six']['desktop']['line_height'];
    $h6tabletFontSize = isset(  $heading_six['tablet']['font_size'] ) ? $heading_six['tablet']['font_size'] : $typo_defaults['heading_six']['tablet']['font_size'];
    $h6tabletSpacing = isset(  $heading_six['tablet']['letter_spacing'] ) ? $heading_six['tablet']['letter_spacing'] : $typo_defaults['heading_six']['tablet']['letter_spacing'];
    $h6tabletHeight = isset(  $heading_six['tablet']['line_height'] ) ? $heading_six['tablet']['line_height'] : $typo_defaults['heading_six']['tablet']['line_height'];
    $h6mobileFontSize = isset(  $heading_six['mobile']['font_size'] ) ? $heading_six['mobile']['font_size'] : $typo_defaults['heading_six']['mobile']['font_size'];
    $h6mobileSpacing = isset(  $heading_six['mobile']['letter_spacing'] ) ? $heading_six['mobile']['letter_spacing'] : $typo_defaults['heading_six']['mobile']['letter_spacing'];
    $h6mobileHeight = isset(  $heading_six['mobile']['line_height'] ) ? $heading_six['mobile']['line_height'] : $typo_defaults['heading_six']['mobile']['line_height'];

	$primary_font_family       = travel_monster_get_font_family( $primary_font );
	$sitetitle_font_family     = travel_monster_get_font_family( $sitetitle );
	$btn_font_family           = travel_monster_get_font_family( $button );
	$heading_one_font_family   = travel_monster_get_font_family( $heading_one );
	$heading_two_font_family   = travel_monster_get_font_family( $heading_two );
	$heading_three_font_family = travel_monster_get_font_family( $heading_three );
	$heading_four_font_family  = travel_monster_get_font_family( $heading_four );
	$heading_five_font_family  = travel_monster_get_font_family( $heading_five );
	$heading_six_font_family   = travel_monster_get_font_family( $heading_six );

    $siteFontFamily = $sitetitle_font_family === '"Default Family"' ? 'inherit' : $sitetitle_font_family;
    $btnFontFamily  = $btn_font_family === '"Default Family"' ? 'inherit' : $btn_font_family;
    $h1FontFamily   = $heading_one_font_family === '"Default Family"' ? 'inherit' : $heading_one_font_family;
    $h2FontFamily   = $heading_two_font_family === '"Default Family"' ? 'inherit' : $heading_two_font_family;
    $h3FontFamily   = $heading_three_font_family === '"Default Family"' ? 'inherit' : $heading_three_font_family;
    $h4FontFamily   = $heading_four_font_family === '"Default Family"' ? 'inherit' : $heading_four_font_family;
    $h5FontFamily   = $heading_five_font_family === '"Default Family"' ? 'inherit' : $heading_five_font_family;
    $h6FontFamily   = $heading_six_font_family === '"Default Family"' ? 'inherit' : $heading_six_font_family;

	$container_width        = get_theme_mod( 'container_width', $layout_defaults['container_width'] );
	$tablet_container_width = get_theme_mod( 'tablet_container_width', $layout_defaults['tablet_container_width'] );
	$mobile_container_width = get_theme_mod( 'mobile_container_width', $layout_defaults['mobile_container_width'] );

    $fullwidth_centered        = get_theme_mod( 'fullwidth_centered', $layout_defaults['fullwidth_centered']);
    $tablet_fullwidth_centered = get_theme_mod( 'tablet_fullwidth_centered', $layout_defaults['tablet_fullwidth_centered']);
    $mobile_fullwidth_centered = get_theme_mod( 'mobile_fullwidth_centered', $layout_defaults['mobile_fullwidth_centered']);

    $sidebar_width        = get_theme_mod( 'sidebar_width', $layout_defaults['sidebar_width']);
    $tablet_sidebar_width = get_theme_mod( 'tablet_sidebar_width', $layout_defaults['tablet_sidebar_width']);

    $widgets_spacing        = get_theme_mod( 'widgets_spacing', $layout_defaults['widgets_spacing']);
    $tablet_widgets_spacing = get_theme_mod( 'tablet_widgets_spacing', $layout_defaults['tablet_widgets_spacing']);
    $mobile_widgets_spacing = get_theme_mod( 'mobile_widgets_spacing', $layout_defaults['mobile_widgets_spacing']);

    $scroll_top_size        = get_theme_mod( 'scroll_top_size', $layout_defaults['scroll_top_size']);
    $tablet_scroll_top_size = get_theme_mod( 'tablet_scroll_top_size', $layout_defaults['tablet_scroll_top_size']);
    $mobile_scroll_top_size = get_theme_mod( 'mobile_scroll_top_size', $layout_defaults['mobile_scroll_top_size']);

    $scroll_top_bottom_offset        = get_theme_mod( 'scroll_top_bottom_offset', $layout_defaults['scroll_top_bottom_offset']);
    $tablet_scroll_top_bottom_offset = get_theme_mod( 'tablet_scroll_top_bottom_offset', $layout_defaults['tablet_scroll_top_bottom_offset']);
    $mobile_scroll_top_bottom_offset = get_theme_mod( 'mobile_scroll_top_bottom_offset', $layout_defaults['mobile_scroll_top_bottom_offset']);

    $scroll_top_side_offset        = get_theme_mod( 'scroll_top_side_offset', $layout_defaults['scroll_top_side_offset']);
    $tablet_scroll_top_side_offset = get_theme_mod( 'tablet_scroll_top_side_offset', $layout_defaults['tablet_scroll_top_side_offset']);
    $mobile_scroll_top_side_offset = get_theme_mod( 'mobile_scroll_top_side_offset', $layout_defaults['mobile_scroll_top_side_offset']);

	$menu_item_spacing = get_theme_mod( 'header_items_spacing', $layout_defaults['header_items_spacing'] );
	$menu_dropdown_width = get_theme_mod( 'header_dropdown_width', $layout_defaults['header_dropdown_width'] );

	$primary_color      = get_theme_mod( 'primary_color', $defaults['primary_color'] );
	$rgb                = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $primary_color ) );
	$secondary_color    = get_theme_mod( 'secondary_color', $defaults['secondary_color'] );
	$rgb2               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $secondary_color ) );
	$body_font_color    = get_theme_mod( 'body_font_color', $defaults['body_font_color'] );
	$rgb3               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $body_font_color ) );
	$heading_color      = get_theme_mod( 'heading_color', $defaults['heading_color'] );
	$rgb4               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $heading_color ) );
	$section_bg_color   = get_theme_mod( 'section_bg_color', $defaults['section_bg_color'] );
	$rgb5               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $section_bg_color ) );
	$background_color   = get_theme_mod( 'site_bg_color', $defaults['site_bg_color'] );
	$rgb6               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $background_color ) );

	$header_btn_text_color         = get_theme_mod( 'header_btn_text_color', $defaults['header_btn_text_color'] );
	$header_btn_bg_color           = get_theme_mod( 'header_btn_bg_color', $defaults['header_btn_bg_color'] );
	$header_btn_text_hover_color   = get_theme_mod( 'header_btn_text_hover_color', $defaults['header_btn_text_hover_color'] );
	$header_btn_bg_hover_color     = get_theme_mod( 'header_btn_bg_hover_color', $defaults['header_btn_bg_hover_color'] );

    $top_header_bg_color   = get_theme_mod( 'top_header_bg_color', $defaults['top_header_bg_color'] );
    $top_header_text_color = get_theme_mod( 'top_header_text_color', $defaults['top_header_text_color'] );
	$rgb7                  = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $top_header_text_color ) );

	$button_roundness = get_theme_mod( 'btn_roundness', $button_defaults['btn_roundness'] );
	$button_padding   = get_theme_mod( 'button_padding', $button_defaults['button_padding'] );
	
	//Button Color
	$btn_text_color         = get_theme_mod( 'btn_text_color_initial', $defaults['btn_text_color_initial'] );
	$btn_bg_color           = get_theme_mod( 'btn_bg_color_initial', $defaults['btn_bg_color_initial'] );
	$btn_text_hover_color   = get_theme_mod( 'btn_text_color_hover', $defaults['btn_text_color_hover'] );
	$btn_bg_hover_color     = get_theme_mod( 'btn_bg_color_hover', $defaults['btn_bg_color_hover'] );
	$btn_border_color       = get_theme_mod( 'btn_border_color_initial', $defaults['btn_border_color_initial'] );
	$btn_border_hover_color = get_theme_mod( 'btn_border_color_hover', $defaults['btn_border_color_hover'] );
	
    //Notification Bar Color
    $notifi_text_color = get_theme_mod( 'notification_text_color', $defaults['notification_text_color'] );
    $notifi_bg_color   = get_theme_mod( 'notification_bg_color', $defaults['notification_bg_color'] );

    //Upper Footer Color
    $uf_text_color         = get_theme_mod( 'upper_footer_text_color', $defaults['upper_footer_text_color'] );
	$uf_bg_color           = get_theme_mod( 'upper_footer_bg_color', $defaults['upper_footer_bg_color'] );
	$uf_link_hover_color   = get_theme_mod( 'upper_footer_link_hover_color', $defaults['upper_footer_link_hover_color'] );
	$uf_heading_color      = get_theme_mod( 'upper_footer_widget_heading_color', $defaults['upper_footer_widget_heading_color'] );

    //Bottom Footer Color
    $bf_text_color         = get_theme_mod( 'bottom_footer_text_color', $defaults['bottom_footer_text_color'] );
    $bf_bg_color           = get_theme_mod( 'bottom_footer_bg_color', $defaults['bottom_footer_bg_color'] );
    $bf_link_initial_color = get_theme_mod( 'bottom_footer_link_initial_color', $defaults['bottom_footer_link_initial_color'] );
    $bf_link_hover_color   = get_theme_mod( 'bottom_footer_link_hover_color', $defaults['bottom_footer_link_hover_color'] );
    echo "<style type='text/css' media='all'>"; ?>

    :root {
		--e-global-color-primary_color  : <?php echo travel_monster_sanitize_rgba( $primary_color ); ?>;
		--e-global-color-secondary_color: <?php echo travel_monster_sanitize_rgba( $secondary_color ); ?>;
		--e-global-color-body_font_color: <?php echo travel_monster_sanitize_rgba( $body_font_color ); ?>;
		--e-global-color-heading_color  : <?php echo travel_monster_sanitize_rgba( $heading_color ); ?>;
		--tmp-primary-color             : <?php echo travel_monster_sanitize_rgba( $primary_color ); ?>;
		--tmp-primary-color-rgb         : <?php printf('%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ); ?>;
		--tmp-secondary-color           : <?php echo travel_monster_sanitize_rgba( $secondary_color ); ?>;
		--tmp-secondary-color-rgb       : <?php printf('%1$s, %2$s, %3$s', $rgb2[0], $rgb2[1], $rgb2[2] ); ?>;
		--tmp-body-font-color           : <?php echo travel_monster_sanitize_rgba( $body_font_color ); ?>;
		--tmp-body-font-color-rgb       : <?php printf('%1$s, %2$s, %3$s', $rgb3[0], $rgb3[1], $rgb3[2] ); ?>;
		--tmp-heading-color             : <?php echo travel_monster_sanitize_rgba( $heading_color ); ?>;
		--tmp-heading-color-rgb         : <?php printf('%1$s, %2$s, %3$s', $rgb4[0], $rgb4[1], $rgb4[2] ); ?>;
		--tmp-section-bg-color          : <?php echo travel_monster_sanitize_rgba( $section_bg_color ); ?>;
		--tmp-section-bg-color-rgb      : <?php printf('%1$s, %2$s, %3$s', $rgb5[0], $rgb5[1], $rgb5[2] ); ?>;
		--tmp-background-color          : <?php echo travel_monster_sanitize_rgba( $background_color ); ?>;
		--tmp-background-color-rgb      : <?php printf('%1$s, %2$s, %3$s', $rgb6[0], $rgb6[1], $rgb6[2] ); ?>;

        --tmp-btn-text-initial-color: <?php echo travel_monster_sanitize_rgba( $btn_text_color ); ?>;
        --tmp-btn-text-hover-color: <?php echo travel_monster_sanitize_rgba( $btn_text_hover_color ); ?>;
        --tmp-btn-bg-initial-color: <?php echo travel_monster_sanitize_rgba( $btn_bg_color ); ?>;
        --tmp-btn-bg-hover-color: <?php echo travel_monster_sanitize_rgba( $btn_bg_hover_color ); ?>;
        --tmp-btn-border-initial-color: <?php echo travel_monster_sanitize_rgba( $btn_border_color ); ?>;
        --tmp-btn-border-hover-color: <?php echo travel_monster_sanitize_rgba( $btn_border_hover_color ); ?>;

        --tmp-primary-font-family: <?php echo wp_kses_post( $primary_font_family ); ?>;     
        --tmp-primary-font-weight: <?php echo esc_html( $primary_font['weight'] ); ?>;
        --tmp-primary-font-transform: <?php echo esc_html( $primary_font['transform'] ); ?>;

        --tmp-btn-font-family: <?php echo wp_kses_post( $btnFontFamily ); ?>;     
        --tmp-btn-font-weight: <?php echo esc_html( $button['weight'] ); ?>;
        --tmp-btn-font-transform: <?php echo esc_html( $button['transform'] ); ?>;
        --tmp-btn-roundness-top: <?php echo absint( $button_roundness['top'] ); ?>px;
        --tmp-btn-roundness-right: <?php echo absint( $button_roundness['right'] ); ?>px;
        --tmp-btn-roundness-bottom: <?php echo absint( $button_roundness['bottom'] ); ?>px;
        --tmp-btn-roundness-left: <?php echo absint( $button_roundness['left'] ); ?>px;
        --tmp-btn-padding-top: <?php echo absint( $button_padding['top'] ); ?>px;
        --tmp-btn-padding-right: <?php echo absint( $button_padding['right'] ); ?>px;
        --tmp-btn-padding-bottom: <?php echo absint( $button_padding['bottom'] ); ?>px;
        --tmp-btn-padding-left: <?php echo absint( $button_padding['left'] ); ?>px;
	}

    .site-header{
        --tmp-menu-items-spacing: <?php echo absint( $menu_item_spacing ); ?>px;
        --tmp-menu-dropdown-width: <?php echo absint( $menu_dropdown_width ); ?>px;
        --tmp-btn-text-initial-color: <?php echo travel_monster_sanitize_rgba( $header_btn_text_color ); ?>;
        --tmp-btn-text-hover-color: <?php echo travel_monster_sanitize_rgba( $header_btn_text_hover_color ); ?>;
        --tmp-btn-bg-initial-color: <?php echo travel_monster_sanitize_rgba( $header_btn_bg_color ); ?>;
        --tmp-btn-bg-hover-color: <?php echo travel_monster_sanitize_rgba( $header_btn_bg_hover_color ); ?>;
    }

    .notification-bar{
        --tmp-bg-color: <?php echo travel_monster_sanitize_rgba( $notifi_bg_color ); ?>;
        --tmp-text-color: <?php echo travel_monster_sanitize_rgba( $notifi_text_color ); ?>;
    }

	.site-header .custom-logo{
		width : <?php echo absint( $logo_width ); ?>px;
	}
    
    .site-footer{
        --tmp-uf-text-color: <?php echo travel_monster_sanitize_rgba( $uf_text_color ); ?>;
        --tmp-uf-bg-color: <?php echo travel_monster_sanitize_rgba( $uf_bg_color ); ?>;
        --tmp-uf-link-hover-color: <?php echo travel_monster_sanitize_rgba( $uf_link_hover_color ); ?>;
        --tmp-uf-widget-heading-color: <?php echo travel_monster_sanitize_rgba( $uf_heading_color ); ?>;
        --tmp-bf-text-color: <?php echo travel_monster_sanitize_rgba( $bf_text_color ); ?>;
        --tmp-bf-bg-color: <?php echo travel_monster_sanitize_rgba( $bf_bg_color ); ?>;
        --tmp-bf-link-initial-color: <?php echo travel_monster_sanitize_rgba( $bf_link_initial_color ); ?>;
        --tmp-bf-link-hover-color: <?php echo travel_monster_sanitize_rgba( $bf_link_hover_color ); ?>;
    }

    .header-layout-1 .header-m{
        --tmp-top-header-bg-color: <?php echo travel_monster_sanitize_rgba( $top_header_bg_color ); ?>;
        --tmp-top-header-text-color: <?php echo travel_monster_sanitize_rgba( $top_header_text_color ); ?>;
		--tmp-top-header-text-color-rgb: <?php printf('%1$s, %2$s, %3$s', $rgb7[0], $rgb7[1], $rgb7[2] ); ?>;
    }

    /*Typography*/
    .site-branding .site-title{
        font-family   : <?php echo wp_kses_post( $siteFontFamily ); ?>;
        font-weight   : <?php echo esc_html( $sitetitle['weight'] ); ?>;
        text-transform: <?php echo esc_html( $sitetitle['transform'] ); ?>;
    }
    
    h1{
        font-family : <?php echo wp_kses_post( $h1FontFamily ); ?>;
        text-transform: <?php echo esc_html( $heading_one['transform'] ); ?>;      
        font-weight: <?php echo esc_html( $heading_one['weight'] ); ?>;
    }
    h2{
        font-family : <?php echo wp_kses_post( $h2FontFamily ); ?>;
        text-transform: <?php echo esc_html( $heading_two['transform'] ); ?>;      
        font-weight: <?php echo esc_html( $heading_two['weight'] ); ?>;
    }
    h3{
        font-family : <?php echo wp_kses_post( $h3FontFamily ); ?>;
        text-transform: <?php echo esc_html( $heading_three['transform'] ); ?>;      
        font-weight: <?php echo esc_html( $heading_three['weight'] ); ?>;
    }
    h4{
        font-family : <?php echo wp_kses_post( $h4FontFamily ); ?>;
        text-transform: <?php echo esc_html( $heading_four['transform'] ); ?>;      
        font-weight: <?php echo esc_html( $heading_four['weight'] ); ?>;
    }
    h5{
        font-family : <?php echo wp_kses_post( $h5FontFamily ); ?>;
        text-transform: <?php echo esc_html( $heading_five['transform'] ); ?>;      
        font-weight: <?php echo esc_html( $heading_five['weight'] ); ?>;
    }
    h6{
        font-family : <?php echo wp_kses_post( $h6FontFamily ); ?>;
        text-transform: <?php echo esc_html( $heading_six['transform'] ); ?>;      
        font-weight: <?php echo esc_html( $heading_six['weight'] ); ?>;
    }

    @media (min-width: 1024px){
        :root{
            --tmp-primary-font-size   : <?php echo absint( $primarydesktopFontSize ); ?>px;
            --tmp-primary-font-height : <?php echo floatval( $primarydesktopHeight ); ?>em;
            --tmp-primary-font-spacing: <?php echo absint( $primarydesktopSpacing ); ?>px;

            --tmp-container-width  : <?php echo absint($container_width); ?>px;
            --tmp-centered-maxwidth: <?php echo absint($fullwidth_centered); ?>px;

            --tmp-btn-font-size   : <?php echo absint( $btndesktopFontSize ); ?>px;
            --tmp-btn-font-height : <?php echo floatval( $btndesktopHeight ); ?>em;
            --tmp-btn-font-spacing: <?php echo absint( $btndesktopSpacing ); ?>px;
        }

        .main-content-wrapper{
            --tmp-sidebar-width: <?php echo absint($sidebar_width); ?>%;
        }

        aside.widget-area {
            --tmp-widget-spacing: <?php echo absint($widgets_spacing); ?>px;
        }

        .to_top{
            --tmp-scroll-to-top-size: <?php echo absint($scroll_top_size); ?>px;
            --tmp-scroll-to-top-bottom-offset: <?php echo absint($scroll_top_bottom_offset); ?>px;
            --tmp-scroll-to-top-side-offset: <?php echo absint($scroll_top_side_offset); ?>px;
        }

        .site-header .site-branding .site-title {
            font-size     : <?php echo absint( $sitedesktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $sitedesktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $sitedesktopSpacing ); ?>px;
        }

        .elementor-page .site-content h1,
        h1{
            font-size   : <?php echo absint( $h1desktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $h1desktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $h1desktopSpacing ); ?>px;
        }

        .elementor-page .site-content h2,
        h2{
            font-size   : <?php echo absint( $h2desktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $h2desktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $h2desktopSpacing ); ?>px;
        }

        .elementor-page .site-content h3,
        h3{
            font-size   : <?php echo absint( $h3desktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $h3desktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $h3desktopSpacing ); ?>px;
        }

        .elementor-page .site-content h4,
        h4{
            font-size   : <?php echo absint( $h4desktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $h4desktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $h4desktopSpacing ); ?>px;
        }

        .elementor-page .site-content h5,
        h5{
            font-size   : <?php echo absint( $h5desktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $h5desktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $h5desktopSpacing ); ?>px;
        }

        .elementor-page .site-content h6,
        h6{
            font-size   : <?php echo absint( $h6desktopFontSize ); ?>px;
            line-height   : <?php echo floatval( $h6desktopHeight ); ?>em;
            letter-spacing: <?php echo absint( $h6desktopSpacing ); ?>px;
        }
    }

    @media (min-width: 767px) and (max-width: 1024px){
        :root{
            --tmp-primary-font-size: <?php echo absint( $primarytabletFontSize ); ?>px;
            --tmp-primary-font-height: <?php echo floatval( $primarytabletHeight ); ?>em;
            --tmp-primary-font-spacing: <?php echo absint( $primarytabletSpacing ); ?>px;

            --tmp-container-width  : <?php echo absint($tablet_container_width); ?>px;
            --tmp-centered-maxwidth: <?php echo absint($tablet_fullwidth_centered); ?>px;

            --tmp-btn-font-size   : <?php echo absint( $btntabletFontSize ); ?>px;
            --tmp-btn-font-height : <?php echo floatval( $btntabletHeight ); ?>em;
            --tmp-btn-font-spacing: <?php echo absint( $btntabletSpacing ); ?>px;
        }

        .main-content-wrapper{
            --tmp-sidebar-width: <?php echo absint($tablet_sidebar_width); ?>%;
        }

        aside.widget-area {            
            --tmp-widget-spacing: <?php echo absint($tablet_widgets_spacing); ?>px;
        }

        .to_top{
            --tmp-scroll-to-top-size: <?php echo absint($tablet_scroll_top_size); ?>px;
            --tmp-scroll-to-top-bottom-offset: <?php echo absint($tablet_scroll_top_bottom_offset); ?>px;
            --tmp-scroll-to-top-side-offset: <?php echo absint($tablet_scroll_top_side_offset); ?>px;
        }

        .site-branding .site-title {
            font-size   : <?php echo absint( $sitetabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $sitetabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $sitetabletSpacing ); ?>px;
        }

        .site-branding .custom-logo-link img{
			width: <?php echo absint( $tablet_logo_width ); ?>px;
        }

        .elementor-page .site-content h1,
        h1{
            font-size   : <?php echo absint( $h1tabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $h1tabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $h1tabletSpacing ); ?>px;
        }

        .elementor-page .site-content h2,
        h2{
            font-size   : <?php echo absint( $h2tabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $h2tabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $h2tabletSpacing ); ?>px;
        }

        .elementor-page .site-content h3,
        h3{
            font-size   : <?php echo absint( $h3tabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $h3tabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $h3tabletSpacing ); ?>px;
        }

        .elementor-page .site-content h4,
        h4{
            font-size   : <?php echo absint( $h4tabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $h4tabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $h4tabletSpacing ); ?>px;
        }

        .elementor-page .site-content h5,
        h5{
            font-size   : <?php echo absint( $h5tabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $h5tabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $h5tabletSpacing ); ?>px;
        }

        .elementor-page .site-content h6,
        h6{
            font-size   : <?php echo absint( $h6tabletFontSize ); ?>px;
            line-height   : <?php echo floatval( $h6tabletHeight ); ?>em;
            letter-spacing: <?php echo absint( $h6tabletSpacing ); ?>px;
        }
    }

    @media (max-width: 767px){
        :root{
            --tmp-primary-font-size: <?php echo absint( $primarymobileFontSize ); ?>px;
            --tmp-primary-font-height: <?php echo floatval( $primarymobileHeight ); ?>em;
            --tmp-primary-font-spacing: <?php echo absint( $primarymobileSpacing ); ?>px;

            --tmp-container-width  : <?php echo absint($mobile_container_width); ?>px;
            --tmp-centered-maxwidth: <?php echo absint($mobile_fullwidth_centered); ?>px;

            --tmp-btn-font-size   : <?php echo absint( $btnmobileFontSize ); ?>px;
            --tmp-btn-font-height : <?php echo floatval( $btnmobileHeight ); ?>em;
            --tmp-btn-font-spacing: <?php echo absint( $btnmobileSpacing ); ?>px;
        }
        
        aside.widget-area {
            --tmp-widget-spacing: <?php echo absint($mobile_widgets_spacing); ?>px;
        }

        .site-branding .site-title{
            font-size   : <?php echo absint( $sitemobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $sitemobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $sitemobileSpacing ); ?>px;
        }

        .to_top{
            --tmp-scroll-to-top-size: <?php echo absint($mobile_scroll_top_size); ?>px;
            --tmp-scroll-to-top-bottom-offset: <?php echo absint($mobile_scroll_top_bottom_offset); ?>px;
            --tmp-scroll-to-top-side-offset: <?php echo absint($mobile_scroll_top_side_offset); ?>px;
        }

        .site-branding .custom-logo-link img{
            width: <?php echo absint( $mobile_logo_width ); ?>px;
        }

        .elementor-page .site-content h1,
        h1{
            font-size   : <?php echo absint( $h1mobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $h1mobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $h1mobileSpacing ); ?>px;
        }

        .elementor-page .site-content h2,
        h2{
            font-size   : <?php echo absint( $h2mobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $h2mobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $h2mobileSpacing ); ?>px;
        }

        .elementor-page .site-content h3,
        h3{
            font-size   : <?php echo absint( $h3mobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $h3mobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $h3mobileSpacing ); ?>px;
        }

        .elementor-page .site-content h4,
        h4{
            font-size   : <?php echo absint( $h4mobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $h4mobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $h4mobileSpacing ); ?>px;
        }

        .elementor-page .site-content h5,
        h5{
            font-size   : <?php echo absint( $h5mobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $h5mobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $h5mobileSpacing ); ?>px;
        }

        .elementor-page .site-content h6,
        h6{
            font-size   : <?php echo absint( $h6mobileFontSize ); ?>px;
            line-height   : <?php echo floatval( $h6mobileHeight ); ?>em;
            letter-spacing: <?php echo absint( $h6mobileSpacing ); ?>px;
        }
    }

	<?php
	
	echo "</style>";
}
add_action( 'wp_head', 'travel_monster_dynamic_css', 101 );

/**
* Function for sanitizing Hex color 
*/
function travel_monster_sanitize_hex_color( $color ){
    if ( '' === $color )
        return '';

// 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
}

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
*/
function travel_monster_hex2rgb($hex) {
    if($hex[0] === '#' ){
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    } else {
        $hex = str_replace("rgba(", "", $hex);
        $hex = str_replace(")", "", $hex);
        $rgb = explode(",", $hex );
        $opacity = array_pop($rgb); //removing opacity value from rgba

        return $rgb;
    }
}
/**
 * Convert '#' to '%23'
*/
function travel_monster_hash_to_percent23( $color_code ){
    $color_code = str_replace( "#", "%23", $color_code );
    return $color_code;
}


if ( ! function_exists( 'travel_monster_gutenberg_inline_style' ) ) : 
    /**
     * Gutenberg Dynamic Style
     */
    function travel_monster_gutenberg_inline_style(){
        
        $typo_defaults   = travel_monster_get_typography_defaults();
        $defaults        = travel_monster_get_color_defaults();
        $button_defaults = travel_monster_get_button_defaults();
        
        $primary_font   = wp_parse_args( get_theme_mod( 'primary_font' ), $typo_defaults['primary_font'] );
        $button         = wp_parse_args( get_theme_mod( 'button' ), $typo_defaults['button'] );

        $primary_font_family       = travel_monster_get_font_family( $primary_font );
        $btn_font_family           = travel_monster_get_font_family( $button );

        $btnFontFamily = $btn_font_family === '"Default Family"' ? 'inherit' : $btn_font_family;

        $primary_color      = get_theme_mod( 'primary_color', $defaults['primary_color'] );
        $rgb                = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $primary_color ) );
        $secondary_color    = get_theme_mod( 'secondary_color', $defaults['secondary_color'] );
        $rgb2               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $secondary_color ) );
        $body_font_color    = get_theme_mod( 'body_font_color', $defaults['body_font_color'] );
        $rgb3               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $body_font_color ) );
        $heading_color      = get_theme_mod( 'heading_color', $defaults['heading_color'] );
        $rgb4               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $heading_color ) );
        $section_bg_color   = get_theme_mod( 'section_bg_color', $defaults['section_bg_color'] );
        $rgb5               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $section_bg_color ) );
        $background_color   = get_theme_mod( 'site_bg_color', $defaults['site_bg_color'] );
        $rgb6               = travel_monster_hex2rgb( travel_monster_sanitize_rgba( $background_color ) );

        $button_roundness = get_theme_mod( 'btn_roundness', $button_defaults['btn_roundness'] );
        $button_padding   = get_theme_mod( 'button_padding', $button_defaults['button_padding'] );
	
        //Button Color
        $btn_text_color         = get_theme_mod( 'btn_text_color_initial', $defaults['btn_text_color_initial'] );
        $btn_bg_color           = get_theme_mod( 'btn_bg_color_initial', $defaults['btn_bg_color_initial'] );
        $btn_text_hover_color   = get_theme_mod( 'btn_text_color_hover', $defaults['btn_text_color_hover'] );
        $btn_bg_hover_color     = get_theme_mod( 'btn_bg_color_hover', $defaults['btn_bg_color_hover'] );
        $btn_border_color       = get_theme_mod( 'btn_border_color_initial', $defaults['btn_border_color_initial'] );
        $btn_border_hover_color = get_theme_mod( 'btn_border_color_hover', $defaults['btn_border_color_hover'] );

        $custom_css = ':root .block-editor-page {
            --tmp-primary-color   : ' . travel_monster_sanitize_rgba( $primary_color ) . ';
            --tmp-primary-color-rgb: ' . $rgb[0] . ',' . $rgb[1] .',' . $rgb[2] . ';
            --tmp-secondary-color : ' . travel_monster_sanitize_rgba( $secondary_color ) . ';
            --tmp-secondary-color-rgb:' . $rgb2[0] . ',' . $rgb2[1] .',' . $rgb2[2] . ';
            --tmp-body-font-color : ' . travel_monster_sanitize_rgba( $body_font_color ) . ';
            --tmp-body-font-color-rgb:' . $rgb3[0] . ',' . $rgb3[1] .',' . $rgb3[2] . ';
            --tmp-heading-color   : ' . travel_monster_sanitize_rgba( $heading_color ) . ';
            --tmp-heading-color-rgb:' . $rgb4[0] . ',' . $rgb4[1] .',' . $rgb4[2] . ';
            --tmp-section-bg-color: ' . travel_monster_sanitize_rgba( $section_bg_color ) . ';
            --tmp-section-bg-color-rgb:' . $rgb5[0] . ',' . $rgb5[1] .',' . $rgb5[2] . ';
            --tmp-background-color: ' . travel_monster_sanitize_rgba( $background_color ) . ';
            --tmp-background-color-rgb:' . $rgb6[0] . ',' . $rgb6[1] .',' . $rgb6[2] . ';

            --tmp-btn-text-initial-color  : ' . travel_monster_sanitize_rgba( $btn_text_color ) . ';
            --tmp-btn-text-hover-color    : ' . travel_monster_sanitize_rgba( $btn_text_hover_color ) . ';
            --tmp-btn-bg-initial-color    : ' . travel_monster_sanitize_rgba( $btn_bg_color ) . ';
            --tmp-btn-bg-hover-color      : ' . travel_monster_sanitize_rgba( $btn_bg_hover_color ) . ';
            --tmp-btn-border-initial-color: ' . travel_monster_sanitize_rgba( $btn_border_color ) . ';
            --tmp-btn-border-hover-color  : ' . travel_monster_sanitize_rgba( $btn_border_hover_color ) . ';

            --tmp-primary-font-family   : ' . wp_kses_post( $primary_font_family ) . ';
            --tmp-primary-font-weight   : ' . esc_html( $primary_font['weight'] ) . ';
            --tmp-primary-font-transform: ' . esc_html( $primary_font['transform'] ) . ';

            --tmp-btn-font-family     : ' . wp_kses_post( $btnFontFamily ) . ';
            --tmp-btn-font-weight     : ' . esc_html( $button['weight'] ) . ';
            --tmp-btn-font-transform  : ' . esc_html( $button['transform'] ) . ';
            --tmp-btn-roundness-top   : ' . absint( $button_roundness['top'] ) . 'px;
            --tmp-btn-roundness-right : ' . absint( $button_roundness['right'] ) . 'px;
            --tmp-btn-roundness-bottom: ' . absint( $button_roundness['bottom'] ) . 'px;
            --tmp-btn-roundness-left  : ' . absint( $button_roundness['left'] ) . 'px;
            --tmp-btn-padding-top     : ' . absint( $button_padding['top'] ) . 'px;
            --tmp-btn-padding-right   : ' . absint( $button_padding['right'] ) . 'px;
            --tmp-btn-padding-bottom  : ' . absint( $button_padding['bottom'] ) . 'px;
            --tmp-btn-padding-left    : ' . absint( $button_padding['left'] ) . 'px;
        }';
    
        return $custom_css;
    }
endif;
    