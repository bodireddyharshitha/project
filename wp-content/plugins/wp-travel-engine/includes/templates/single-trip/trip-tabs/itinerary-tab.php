<?php
/**
 * Itinerary Template
 *
 * This template can be overridden by copying it to yourtheme/wp-travel-engine/single-trip/trip-tabs/itinerary-tab.php.
 *
 * @package Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$tabs                    = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$wptravelengine_settings = get_option( 'wp_travel_engine_settings' );
$inner_content           = ! empty( $tabs ['itinerary']['itinerary_content_inner'] ) ? $tabs ['itinerary']['itinerary_content_inner'] : $tabs ['itinerary']['itinerary_content'];
$itineraries             = $tabs ['itinerary']['itinerary_title'];
$enabled_expand_all      = ! isset( $wptravelengine_settings['wte_advance_itinerary']['enable_expand_all'] ) || $wptravelengine_settings['wte_advance_itinerary']['enable_expand_all'] === 'yes';
$active_check            = $enabled_expand_all ? 'active' : '';

do_action( 'wte_before_itinerary_content' );

/* Hook - Display tab content title, left for themes. */
do_action( 'wte_itinerary_tab_title' );
?>
<div class="post-data itinerary wte-trip-itinerary-v2">
	<?php
	if ( empty( $itineraries ) ) {
		return;
	}
	foreach ( $itineraries as $key => $value ) :
		?>
		<div class="itinerary-row <?php echo ( esc_attr( $active_check ) ); ?>">
			<div class="wte-itinerary-head-wrap">
				<div class="title">
					<?php
					/* translators: %s: Day number */
					printf( __( 'Day %s : ', 'wp-travel-engine' ), esc_attr( $key ) );
					?>
				</div>
				<a class="accordion-tabs-toggle <?php echo ( esc_attr( $active_check ) ); ?>" href="javascript:void(0);">
					<span class="dashicons dashicons-arrow-down custom-toggle-tabs rotator <?php echo $enabled_expand_all ? 'open' : ''; ?>"></span>
					<div class="itinerary-title">
						<span>
						<?php
						echo wp_kses(
							$value,
							array(
								'span'   => array(),
								'strong' => array(),
							)
						);
						?>
						</span>
					</div>
				</a>
			</div>
			<div class="itinerary-content <?php echo $enabled_expand_all ? 'show' : ''; ?>">
				<div class="content">
					<?php echo wp_kses_post( wpautop( $inner_content[ $key ] ) ); ?>
				</div>
			</div>
		</div>
		<?php
	endforeach;
	?>
</div>
<?php
do_action( 'wte_after_itinerary_content' );
