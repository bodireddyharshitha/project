<?php
/**
 * Review Form Widget Template.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$attributes   = (object) $attributes;
$review_text  = isset( $attributes->{'reviewTitle'} ) ? $attributes->{'reviewTitle'} : __( 'Write a Review.', 'wptravelengine-elementor-widgets' );
$submit_text  = isset( $attributes->{'buttonText'} ) ? $attributes->{'buttonText'} : __( 'Submit', 'wptravelengine-elementor-widgets' );
$rating_title = isset( $attributes->{'rating_title'} ) ? $attributes->{'rating_title'} : __( 'Overall Trip Rating', 'wptravelengine-elementor-widgets' );

global $post;
$post_meta    = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$review_title = isset( $post_meta['review']['review_title'] ) && '' !== $post_meta['review']['review_title'] ? $post_meta['review']['review_title'] : '';
?>

<div class="post-data">
	<div class="content">
		<?php
		if ( ! defined( 'WTE_TRIP_REVIEW_VERSION' ) ) :
			?>
		<div class="wpte-info-block">
			<p>
				<?php
						echo wp_kses(
							sprintf(
								// translators: %1$s: opening anchor tag, %2$s: closing anchor tag.
								__( 'Trip - Review Form Widget requires WP Travel Engine - Trip Reviews to work. %1$sGet Trip Reviews extension now%2$s.', 'wptravelengine-elementor-widgets' ),
								'<a target="_blank" href="https://wptravelengine.com/plugins/trip-reviews/?utm_source=setting&amp;utm_medium=customer_site&amp;utm_campaign=setting_addon">',
								'</a>'
							),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
								),
							)
						);
				?>
			</p>
		</div>
			<?php
		else :
			if ( ! empty( $review_title ) ) {
				echo '<h3>' . esc_attr( $review_title ) . '</h3>';
			}

			$obj                       = new Wte_Trip_Review_Init();
			$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', true );
			$review_form_hide          = isset( $wp_travel_engine_settings['trip_reviews']['hide_form'] ) ? esc_attr( $wp_travel_engine_settings['trip_reviews']['hide_form'] ) : '';
			if ( empty( $review_form_hide ) ) {
				$comments_args        = array(
					'label_submit' => $submit_text,
				);
				$post->comment_status = 'open';
				if ( 'trip' === get_post_type() || 'elementor_library' === get_post_type() ) {
					comment_form( $comments_args, $post );
				}
			}
			?>
	</div>
</div>
			<?php
endif;
		/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
