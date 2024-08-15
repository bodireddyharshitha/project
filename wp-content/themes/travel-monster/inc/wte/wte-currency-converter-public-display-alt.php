<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wptravelengine.com
 * @since      1.0.0
 *
 * @package    Wte_Currency_Converter
 * @subpackage Wte_Currency_Converter/public/partials
 */
?>
<div class="wte-currency-switcher-drpdown" id="wte-cc-currency-list-container">
    <select class="wte-cc-currency-list-display lp-bf-altd tmp-theme">
        <?php foreach( $currencies['code'] as $index => $code ) : 
            $symbol   = wp_travel_engine_get_currency_symbol( $code );
            $obj      = new Wp_Travel_Engine_Functions();
            $currency = $obj->wp_travel_engine_currencies();
            $cur_name = isset( $currency[$code] ) ? $currency[$code] : '';

            $defaults           = travel_monster_get_general_defaults();
            $ed_currency_code   = get_theme_mod( 'ed_currency_code', $defaults['ed_currency_code'] );
            $ed_currency_symbol = get_theme_mod( 'ed_currency_symbol', $defaults['ed_currency_symbol'] );
            $ed_currency_name   = get_theme_mod( 'ed_currency_name', $defaults['ed_currency_name'] );
            ?>
            <option data-display="<?php echo esc_html( $symbol ) . ' ' . esc_html( $code ); ?>" value="<?php echo esc_attr( $code ); ?>"
                <?php echo esc_attr( $default_code === $code ? 'selected' : '' ); ?> >
                    <?php 
                        if( $ed_currency_symbol ) echo esc_html( $symbol ) . ' ';
                        if( $ed_currency_code ) echo esc_html( $code ) . '  ';
                        if( $ed_currency_name ) echo esc_html( $cur_name );
                    ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>