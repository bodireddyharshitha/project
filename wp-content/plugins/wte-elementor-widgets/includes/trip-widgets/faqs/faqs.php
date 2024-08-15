<?php
/**
 * Trip FAQs Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$post_meta = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
$data      = array(
	'faq' => isset( $post_meta['faq'] ) ? $post_meta['faq'] : '',
);
$faq       = $data['faq'];

$attributes = (object) $attributes;

$show_title       = isset( $attributes->{'show_title'} ) ? $attributes->{'show_title'} : 'yes';
$show_expand_all  = isset( $attributes->{'show_expand_all'} ) ? $attributes->{'show_expand_all'} : 'yes';
$expand_all_label = isset( $attributes->{'expand_all_label'} ) ? $attributes->{'expand_all_label'} : '';
$html_tag         = isset( $attributes->{'html_tag'} ) ? $attributes->{'html_tag'} : 'h2';
?>
<div class="post-data faq">
	<div class="wp-travel-engine-faq-tab-header">
		<div class="wpte-faq-button-toggle expand-all-button">
			<?php if ( ! empty( $faq ) ) { ?>
				<?php if ( ! empty( $show_expand_all ) && $show_expand_all ) { ?>
					<label for="faq-toggle-btn" class="wpte-faq-button-label"><?php echo esc_html( $expand_all_label ); ?></label>
					<input id="faq-toggle-btn" type="checkbox" class="checkbox">
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<div class="wp-travel-engine-faq-tab-content">
	<?php
	if ( isset( $faq['faq_title'] ) && ! empty( $faq['faq_title'] ) ) {
		$maxlen   = max( array_keys( $faq['faq_title'] ) );
		$arr_keys = array_keys( $faq['faq_title'] );
		foreach ( $arr_keys as $key => $value ) {
			if ( array_key_exists( $value, $faq['faq_title'] ) ) {
				?>
					<div id="faq-tabs<?php echo esc_attr( $value ); ?>"
						data-id="<?php echo esc_attr( $value ); ?>" class="faq-row">
						<a class="accordion-tabs-toggle" href="javascript:void(0);">
							<span class="dashicons dashicons-arrow-down custom-toggle-tabs rotator"></span>
							<div class="faq-title">
							<?php echo ( isset( $faq['faq_title'][ $value ] ) ? esc_attr( $faq['faq_title'][ $value ] ) : '' ); ?>
							</div>
						</a>
							<div class="faq-content">
								<p>
								<?php
									$faq_content = isset( $faq['faq_content'][ $value ] ) ? $faq['faq_content'][ $value ] : '';
									echo wp_kses_post( wpautop ( $faq_content ) );
								?>
								</p>
							</div>
					</div>
				<?php
			}
		}
	}
	?>
	</div>
</div>
<?php
do_action( 'wte_after_faq_content' );
