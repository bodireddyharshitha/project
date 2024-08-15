<?php
/**
 * Map Widget Render.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

?>
<div class="post-data">
	<?php
	$attributes               = (object) $attributes;
	$show_image               = isset( $attributes->show_image ) ? $attributes->show_image : true;
	$is_elementor_editor_page = $this->is_elementor_editor_page();
	$show_iframe              = $attributes->show_iframe;
	$demo_location            = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28071.354613157022!2d86.8528655!3d28.0022779!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e9a9327a984be7%3A0x1f5047197a212375!2sEverest%20Base%20Camp!5e1!3m2!1sen!2snp!4v1691386767162!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
	$map_location             = isset( $attributes->map_location ) ? $attributes->map_location : '';
	if ( empty( $map_location ) && $is_elementor_editor_page ) {
		$map_location = $demo_location;
	}

	$show_tab_titles = apply_filters( 'wpte_show_tab_titles_inside_tabs', true );
	if ( ! $show_tab_titles ) {
		return;
	}
	global $post;
	$trip_id       = $post->ID;
	$trip_settings = get_post_meta( $trip_id, 'wp_travel_engine_setting', true );

	?>
	<div class="content">
		<?php if ( ! empty( $show_iframe ) && $show_iframe && '' !== $map_location ) { ?>
			<div class="trip-map iframe">
				<?php
				$height         = $attributes->map_height['size'];
				$is_iframe_code = strpos( $map_location, '<iframe' ) !== false;

				if ( $is_iframe_code ) {
					$map_location = preg_replace( '/height=".*?"/', 'height="' . $height . '"', $map_location );
				} elseif ( preg_match( '/^https?:/', $map_location ) ) {
					$map_location = "<iframe loading=\"lazy\" src=\"{$map_location}\" height=\"{$height}\"></iframe>";
				} else {
					$src          = "https://maps.google.com/maps?q={$map_location}&t=m&output=embed&iwloc=near";
					$map_location = "<iframe loading=\"lazy\" title=\"{$map_location}\" aria-label='{$map_location}' src=\"{$src}\" height=\"{$height}\"></iframe>";
				}

				echo wp_kses(
					$map_location,
					array(
						'iframe' => array(
							'src'             => array(),
							'width'           => array(),
							'height'          => array(),
							'style'           => array(),
							'frameborder'     => array(),
							'allowfullscreen' => array(),
							'loading'         => array(),
							'aria-label'      => array(),
							'title'           => array(),
						),
					)
				);
				?>
			</div>
			<?php
		}
		$src = isset( $trip_settings['map']['image_url'] ) ? wp_get_attachment_image_src( $trip_settings['map']['image_url'], 'full' ) : null;
		if ( ! empty( $show_image ) && $show_image && isset( $src[0] ) ) {
			?>
			<div class="trip-map image">
				<img src="<?php echo esc_url( $src[0] ); ?>">
			</div>
		<?php } ?>
	</div>
</div>
