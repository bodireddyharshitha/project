<?php
/**
 * Review Widget Template.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$attributes                = $this->get_settings_for_display();
$post_meta                 = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$review_title              = isset( $post_meta['review']['review_title'] ) && '' != $post_meta['review']['review_title'] ? $post_meta['review']['review_title'] : '';
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
?>

<div class="post-data">
	<div class="content">
		<?php
		if ( ! empty( $review_title ) ) {
			echo '<h3>' . esc_attr( $review_title ) . '</h3>';
		}
		if ( ! defined( 'WTE_TRIP_REVIEW_VERSION' ) ) {
			?>
				<div class="wpte-info-block">
						<p>
							<?php
							echo wp_kses(
								sprintf(
									// translators: %1$s: opening anchor tag, %2$s: closing anchor tag.
									__( 'Trip - Ratings Widget requires WP Travel Engine - Trip Reviews to work. %1$sGet Trip Reviews extension now%2$s.', 'wptravelengine-elementor-widgets' ),
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
		} else {
			ob_start();
			$review_libray = new WTE_Trip_Review_Library();
			$data          = wptravelengine_reviews_get_trip_reviews( $post->ID );
			$comment_datas = $review_libray->pull_comment_data( $post->ID );
			if ( ! empty( $comment_datas ) ) {
				?>
					<div class="aggregate-rating">
						<span class="stars">
							<span class="rating-star">
								<div class="wpte-trip-review-stars">
									<?php do_action( 'wte_average_review_range_emoticons' ); ?>
									<div class="stars-group-wrapper">
										<div class="stars-placeholder-group">
											<?php
											echo implode(
												'',
												array_map(
													function () {
														return '<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M6.41362 0.718948C6.77878 -0.0301371 7.84622 -0.0301371 8.21138 0.718948L9.68869 3.74946C9.83326 4.04602 10.1148 4.25219 10.4412 4.3005L13.7669 4.79272C14.5829 4.91349 14.91 5.91468 14.3227 6.49393L11.902 8.88136C11.6696 9.1105 11.5637 9.4386 11.6182 9.76034L12.1871 13.1191C12.3258 13.9378 11.464 14.559 10.7311 14.1688L7.78252 12.5986C7.4887 12.4421 7.1363 12.4421 6.84248 12.5986L3.89386 14.1688C3.16097 14.559 2.29922 13.9378 2.43789 13.1191L3.0068 9.76034C3.06129 9.4386 2.95537 9.1105 2.72303 8.88136L0.302324 6.49393C-0.285 5.91468 0.0420871 4.91349 0.85811 4.79272L4.18383 4.3005C4.5102 4.25219 4.79174 4.04602 4.93631 3.74946L6.41362 0.718948Z" fill="#EBAD34"></path></svg>';
													},
													range( 0, 4 )
												)
											);
											?>
										</div>
										<div
											class="stars-rated-group"
											style="width: <?php echo (int) $data['average'] / 5 * 100; ?>%"
										>
											<?php
											echo implode(
												'',
												array_map(
													function () {
														return '<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M6.41362 0.718948C6.77878 -0.0301371 7.84622 -0.0301371 8.21138 0.718948L9.68869 3.74946C9.83326 4.04602 10.1148 4.25219 10.4412 4.3005L13.7669 4.79272C14.5829 4.91349 14.91 5.91468 14.3227 6.49393L11.902 8.88136C11.6696 9.1105 11.5637 9.4386 11.6182 9.76034L12.1871 13.1191C12.3258 13.9378 11.464 14.559 10.7311 14.1688L7.78252 12.5986C7.4887 12.4421 7.1363 12.4421 6.84248 12.5986L3.89386 14.1688C3.16097 14.559 2.29922 13.9378 2.43789 13.1191L3.0068 9.76034C3.06129 9.4386 2.95537 9.1105 2.72303 8.88136L0.302324 6.49393C-0.285 5.91468 0.0420871 4.91349 0.85811 4.79272L4.18383 4.3005C4.5102 4.25219 4.79174 4.04602 4.93631 3.74946L6.41362 0.718948Z" fill="#EBAD34"></path></svg>';
													},
													range( 0, 4 )
												)
											);
											?>
										</div>
									</div>
								</div>
							</span>
							<span class="review-based-on-wrap">
								<?php
									echo number_format( (float) $data['average'], 1 );
								?>
								- <?php esc_html_e( 'Based on ', 'wptravelengine-elementor-widgets' ); ?>
								<span>
									<?php printf( _nx( '%s travel review', '%s travel reviews', absint( $comment_datas['i'] ), 'review count', 'wptravelengine-elementor-widgets' ), number_format_i18n( $comment_datas['i'] ) ); ?>
								</span>
							</span>
						</span>
					</div>
				<?php
			}
			$output = ob_get_clean();
			echo $output;
		}
		?>
	</div>
</div>

<?php

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
