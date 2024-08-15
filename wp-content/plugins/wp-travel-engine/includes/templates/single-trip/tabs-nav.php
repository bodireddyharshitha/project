<?php
/**
 * Trip Tabs Nav Template
 *
 * Closing "tabs-container" div is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/wp-travel-engine/single-trip/tabs-nav.php.
 *
 * @package Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'wp_travel_engine_before_trip_tabs' );

$make_tabs_sticky = wte_array_get( get_option( 'wp_travel_engine_settings' ), 'wte_sticky_tabs', 'no' ) === 'yes';
if ( ! empty( $tabs['id'] ) ) : ?>
	<div id="tabs-container" class="wpte-tabs-container <?php echo $make_tabs_sticky ? 'wpte-tabs-sticky wpte-tabs-scrollable' : ''; ?> clearfix">
		<div class="nav-tab-wrapper">
			<div class="tab-inner-wrapper">
				<?php foreach ( array_values( $tabs['id'] ) as $index => $values ) : ?>
					<div class="tab-anchor-wrapper">
						<h2 class="wte-tab-title">
							<a href="javascript:void(0);"
								class="nav-tab nb-tab-trigger <?php $index === 0 && print esc_attr( 'nav-tab-active' ); ?>"
								data-configuration="<?php echo esc_attr( $values ); ?>">
								<?php
								if ( isset( $tabs['icon'][ $values ] ) && $tabs['icon'][ $values ] !== '' ) {
									echo '<span class="tab-icon">' . wptravelengine_svg_by_fa_icon( $tabs['icon'][ $values ], false ) . '</span>';
								}
								echo esc_attr( $tabs['name'][ $values ] );
								?>
							</a>
						</h2>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- ./nav-tab-wrapper -->
	<?php
endif;
