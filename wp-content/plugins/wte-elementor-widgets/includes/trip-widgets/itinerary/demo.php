<?php
/**
 * Itinerary Widget Template Demo.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;

$show_tab_titles = apply_filters( 'wpte_show_tab_titles_inside_tabs', true );
if ( ! $show_tab_titles ) {
	return;
}

$trip_id                   = $post->ID;
$trip_settings             = array(
	'itinerary' => array(
		'itinerary_title'   => array(
			__( 'Day 0', 'wptravelengine-elementor-widgets' ),
			__( 'Arrival in Kathmandu', 'wptravelengine-elementor-widgets' ),
			__( 'Kathmandu to Lukla, Trek to Phakding (2,652m)', 'wptravelengine-elementor-widgets' ),
			__( 'Phakding to Namche Bazaar (3,440m)', 'wptravelengine-elementor-widgets' ),
			__( 'Acclimatization Day in Namche Bazaar', 'wptravelengine-elementor-widgets' ),
			__( 'Namche Bazaar to Tengboche (3,870m)', 'wptravelengine-elementor-widgets' ),
			__( 'Tengboche to Dingboche (4,360m)', 'wptravelengine-elementor-widgets' ),
			__( 'Acclimatization Day in Dingboche', 'wptravelengine-elementor-widgets' ),
			__( 'Dingboche to Lobuche (4,940m)', 'wptravelengine-elementor-widgets' ),
			__( 'Lobuche to Gorak Shep (5,170m), Visit Everest Base Camp (5,364m)', 'wptravelengine-elementor-widgets' ),
			__( 'Gorak Shep to Kala Patthar (5,545m), Descend to Pheriche (4,371m)', 'wptravelengine-elementor-widgets' ),
			__( 'Pheriche to Namche Bazaar', 'wptravelengine-elementor-widgets' ),
			__( 'Namche Bazaar to Lukla', 'wptravelengine-elementor-widgets' ),
			__( 'Lukla to Kathmandu', 'wptravelengine-elementor-widgets' ),
			__( 'Departure from Kathmandu', 'wptravelengine-elementor-widgets' ),
		),
		'itinerary_content' => array(
			__( 'You haven\'t arrived yet!', 'wptravelengine-elementor-widgets' ),
			__( 'Arrive in Kathmandu, meet your trekking guide, and have a trip briefing.', 'wptravelengine-elementor-widgets' ),
			__( 'Early morning flight to Lukla. Begin trekking towards Phakding.', 'wptravelengine-elementor-widgets' ),
			__( 'Continue trekking along the Dudh Koshi River. Cross suspension bridges and ascend to Namche Bazaar.', 'wptravelengine-elementor-widgets' ),
			__( 'Acclimatization hike to Everest View Hotel or Khumjung Village. Explore Namche Bazaar, its market, and monasteries.', 'wptravelengine-elementor-widgets' ),
			__( 'Descend to the Dudh Koshi River and ascend through forests. Reach Tengboche with its famous monastery.', 'wptravelengine-elementor-widgets' ),
			__( 'Descend through forests and cross the Imja Khola. Trek through Pangboche village and reach Dingboche.', 'wptravelengine-elementor-widgets' ),
			__( 'Acclimatization hike to Nangkartshang Peak for panoramic views. Rest and prepare for higher altitudes.', 'wptravelengine-elementor-widgets' ),
			__( 'Trek through Dughla and witness memorials for climbers. Ascend to Lobuche village.', 'wptravelengine-elementor-widgets' ),
			__( 'Trek to Gorak Shep. Continue to Everest Base Camp.', 'wptravelengine-elementor-widgets' ),
			__( 'Early morning hike to Kala Patthar for sunrise views. Descend to Pheriche.', 'wptravelengine-elementor-widgets' ),
			__( 'Descend through Pangboche and Tengboche. Continue to Namche Bazaar.', 'wptravelengine-elementor-widgets' ),
			__( 'Descend through forests and cross suspension bridges. Arrive in Lukla, reflecting on your journey.', 'wptravelengine-elementor-widgets' ),
			__( 'Morning flight back to Kathmandu. Rest and relax or explore the city.', 'wptravelengine-elementor-widgets' ),
			__( 'Depending on your departure time, you may have some free time for last-minute shopping or sightseeing before heading to the airport.', 'wptravelengine-elementor-widgets' ),
		),
	),
);
$tab_title                 = 'Itinerary';
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
$enabled_expand_all        = ! isset( $wp_travel_engine_settings['wte_advance_itinerary']['enable_expand_all'] ) || 'yes' == $wp_travel_engine_settings['wte_advance_itinerary']['enable_expand_all'] ? 'enabled' : '';

// Get the attributes from the widget.
$show_title      = isset( $attributes['show_title'] ) ? $attributes['show_title'] : 'yes';
$_title          = isset( $attributes['title'] ) ? $attributes['title'] : $tab_title;
$html_tag        = isset( $attributes['html_tag'] ) ? $attributes['html_tag'] : 'h2';
$show_expand_all = isset( $attributes['show_expand_all'] ) ? $attributes['show_expand_all'] : 'yes';
$expand_all_text = isset( $attributes['expand_all_text'] ) ? $attributes['expand_all_text'] : '';
$expand_all      = isset( $attributes['expand_all'] ) ? $attributes['expand_all'] : $enabled_expand_all;
$first_day_icon  = isset( $attributes['first_day_icon']['value'] ) && ! empty( $attributes['first_day_icon']['value'] ) ? 'has-custom-icon' : '';
$last_day_icon   = isset( $attributes['last_day_icon']['value'] ) && ! empty( $attributes['last_day_icon']['value'] ) ? ' has-custom-icon' : '';
$expand_on_icon  = isset( $attributes['expand_on_icon']['value'] ) && ! empty( $attributes['expand_on_icon']['value'] ) ? 'custom-expand-on-icon' : '';
$expand_off_icon = isset( $attributes['expand_off_icon']['value'] ) && ! empty( $attributes['expand_off_icon']['value'] ) ? ' custom-expand-off-icon' : '';
$show_chart      = isset( $attributes['show_chart'] ) ? $attributes['show_chart'] : 'yes';

?>
<div class="wte-itinerary-header-wrapper">
	<div class="wp-travel-engine-itinerary-header">
		<?php
		printf( '<%1$s class="wpte-itinerary-title">%2$s</%1$s>', esc_html( $html_tag ), esc_html( ( $show_title && $_title ) ? esc_html( $_title ) : '' ) );
		if ( $show_expand_all ) {
			?>
		<div class="aib-button-toggle toggle-button expand-all-button">
			<label for="itinerary-toggle-button" class="aib-button-label"><?php echo esc_html( $expand_all_text ); ?></label>
			<input id="itinerary-toggle-button" type="checkbox" class="checkbox" <?php echo '' !== $expand_all ? 'checked' : ''; ?>>
		</div>
		<?php } ?>
	</div>
</div>

<div class="post-data itinerary wte-trip-itinerary-v2">
	<?php
	$arr_keys = array();
	if ( isset( $trip_settings['itinerary'] ) && ! empty( $trip_settings['itinerary'] ) ) {
		$maxlen   = max( array_keys( $trip_settings['itinerary']['itinerary_title'] ) );
		$arr_keys = array_keys( $trip_settings['itinerary']['itinerary_title'] );
	}
	foreach ( $arr_keys as $key => $value ) {
		if ( array_key_exists( $value, $trip_settings['itinerary']['itinerary_title'] ) && ! empty( $value ) ) {
			?>
			<div class="itinerary-row <?php echo ! empty( $expand_all ) ? 'active' : ''; ?>">
				<div class="wte-itinerary-head-wrap">
					<div class="title 
					<?php
					echo 1 === $key ? esc_attr( $first_day_icon ) : '';
					echo count( $arr_keys ) - 1 === $key ? esc_attr( $last_day_icon ) : '';
					?>
					">
					<?php
					if ( isset( $attributes['first_day_icon']['value'] ) && '' !== $attributes['first_day_icon']['value'] && 1 === $key ) {
						echo "<span class='custom-icon'>";
						\Elementor\Icons_Manager::render_icon( $attributes['first_day_icon'] );
						echo '</span>';
					}
					if ( isset( $attributes['last_day_icon']['value'] ) && '' !== $attributes['last_day_icon']['value'] && count( $arr_keys ) - 1 === $key ) {
						echo "<span class='custom-icon'>";
						\Elementor\Icons_Manager::render_icon( $attributes['last_day_icon'] );
						echo '</span>';
					}
					?>
						<?php
						// translators: %s: Day number.
						echo wp_kses_post( sprintf( __( 'Day %s : ', 'wptravelengine-elementor-widgets' ), esc_attr( $value ) ) );
						?>
					</div>
					<a class="accordion-tabs-toggle <?php echo ! empty( $expand_all ) ? 'active' : ''; ?>" href="javascript:void(0);">
						<?php if ( $show_expand_all ) { ?>
							<span class="dashicons dashicons-arrow-down custom-toggle-tabs rotator <?php echo ! empty( $expand_all ) ? 'open' : ''; ?> <?php
							echo esc_attr( $expand_on_icon );
							echo esc_attr( $expand_off_icon );
							?>
							">
							<?php
							if ( isset( $attributes['expand_on_icon']['value'] ) && '' !== $attributes['expand_on_icon']['value'] ) {
								echo "<span class='icon-on'>";
								\Elementor\Icons_Manager::render_icon( $attributes['expand_on_icon'] );
								echo '</span>';
							}
							if ( isset( $attributes['expand_off_icon']['value'] ) && '' !== $attributes['expand_off_icon']['value'] ) {
								echo "<span class='icon-off'>";
								\Elementor\Icons_Manager::render_icon( $attributes['expand_off_icon'] );
								echo '</span>';
							}
							?>
							</span>
						<?php } ?>
						<div class="itinerary-title">
							<?php $_title = isset( $trip_settings['itinerary']['itinerary_title'][ $value ] ) ? esc_attr( $trip_settings['itinerary']['itinerary_title'][ $value ] ) : ''; ?>
							<span>
							<?php
							echo wp_kses(
								$_title,
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
				<?php echo ! empty( $expand_all ) ? '<style id="itinerary-content-show"> .itinerary-content{ disply:block!important; } </style>' : ''; ?>
				<div class="itinerary-content <?php echo ! empty( $expand_all ) ? 'show' : ''; ?>" <?php echo ! empty( $expand_all ) ? 'style="display:block;"' : 'style="max-height:0px;"'; ?>>
					<div class="content">
						<?php
						$content = wte_array_get( $trip_settings, 'itinerary.itinerary_content_inner.' . $value, '' );
						if ( empty( $content ) ) {
							$content = wte_array_get( $trip_settings, 'itinerary.itinerary_content.' . $value, '' );
						}
						echo wp_kses_post( wpautop( $content ) );
						?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	?>
</div>
<script>
	;(function() {
		var toggleTab = function(row, force = null) {
			var content = row.querySelector(".itinerary-content")
			var toggler = row.querySelector(".accordion-tabs-toggle")
			var condition = force === null ? ! toggler.classList.contains("active") : force
			var height = content.scrollHeight
			content.classList.toggle("active", condition)
			if(condition) content.style.maxHeight = height + "px"
			else content.style.maxHeight = "0px"
			toggler.classList.toggle("active", condition)
		}

		var handleToggleClick = function(row) {
			return function(event) {
				var target =  event.target
				if(!!target.closest(".wte-itinerary-head-wrap")) {
					toggleTab(row)
				}
			}
		}

		var setContentHeight = function(row) {
			var content = row.querySelector(".itinerary-content")
			var scrollHeight = content.scrollHeight
			if(content.classList.contains("active"))
				content.style.maxHeight = (scrollHeight) + "px"
			else	content.style.maxHeight = "0px"
		}

		var wrapper = document.querySelector(".wte-trip-itinerary-v2")
		if ( wrapper ) {
			var expandall = document.getElementById('itinerary-toggle-button')
			var rows = wrapper.querySelectorAll('.itinerary-row')
			if(expandall) {
				expandall.addEventListener("change", function() {
					if(rows) rows.forEach(row => {
						toggleTab(row, this.checked)
					})
				})
			}
			if ( rows ) {
				rows.forEach(function(row) {
					// setContentHeight(row)
					row.addEventListener('click', handleToggleClick(row))
				});
			}
		}
	})();
</script>
<?php
