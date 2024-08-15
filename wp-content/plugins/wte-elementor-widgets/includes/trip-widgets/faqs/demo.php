<?php
/**
 * Trip FAQs Widget Demo.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

$faq = array(
	'faq_title'   => array(
		'1' => __( 'What is Everest Base Camp (EBC)?', 'wptravelengine-elementor-widgets' ),
		'2' => __( 'How do I get to Everest Base Camp?', 'wptravelengine-elementor-widgets' ),
		'3' => __( 'Do I need previous trekking experience to reach EBC?', 'wptravelengine-elementor-widgets' ),
		'4' => __( 'When is the best time to trek to Everest Base Camp?', 'wptravelengine-elementor-widgets' ),
	),
	'faq_content' => array(
		'1' => __( 'Everest Base Camp is the starting point for climbers attempting to summit Mount Everest, the highest peak in the world. It is located at an altitude of approximately 5,364 meters (17,598 feet) above sea level in the Khumbu region of Nepal.', 'wptravelengine-elementor-widgets' ),
		'2' => __( 'The most common way to reach Everest Base Camp is by trekking from Lukla, a small mountain airstrip in Nepal. You can take a flight from Kathmandu to Lukla and start your trek from there. The trek usually takes around 12-14 days round trip.', 'wptravelengine-elementor-widgets' ),
		'3' => __( 'While previous trekking experience can be helpful, it is not mandatory. The Everest Base Camp trek is challenging but can be undertaken by anyone with a good level of fitness and a strong determination to complete the journey.', 'wptravelengine-elementor-widgets' ),
		'4' => __( 'The best time for the Everest Base Camp trek is during the pre-monsoon (spring) season (March to May) and post-monsoon (autumn) season (September to November). During these months, the weather is relatively stable, and the skies are clear, providing breathtaking views of the Himalayas.', 'wptravelengine-elementor-widgets' ),
	),
);

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
									echo wp_kses_post( wpautop( $faq_content ) );
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
