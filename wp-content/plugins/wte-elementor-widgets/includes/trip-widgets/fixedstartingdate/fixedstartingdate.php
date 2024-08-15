<?php
/**
 * Trip FSD table template.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */
wp_enqueue_script( 'parsley' );
wp_enqueue_script( 'jquery-fancy-box' );
wp_enqueue_script( 'wte-select2' );
wp_enqueue_style( 'wte-select2' );
global $post;
$tab_content = false;
$args        = array(
	'post_id'       => $post->ID,
	'is_tab_conent' => $tab_content,
);

// Retrieve attributes value from elementor.
$attributes         = (object) $attributes;
$date_label         = isset( $attributes->{'dateLabel'} ) ? $attributes->{'dateLabel'} : __( 'TRIP DATES', 'wptravelengine-elementor-widgets' );
$availability_label = isset( $attributes->{'availabilityLabel'} ) ? $attributes->{'availabilityLabel'} : __( 'AVAILABILITY', 'wptravelengine-elementor-widgets' );
$price_label        = isset( $attributes->{'priceLabel'} ) ? $attributes->{'priceLabel'} : __( 'PRICE', 'wptravelengine-elementor-widgets' );
$space_label        = isset( $attributes->{'spaceLabel'} ) ? $attributes->{'spaceLabel'} : __( 'SPACE LEFT', 'wptravelengine-elementor-widgets' );

$loadmore_label = isset( $attributes->{'loadMore'} ) ? $attributes->{'loadMore'} : __( 'Load More', 'wptravelengine-elementor-widgets' );
$showless_label = isset( $attributes->{'showLess'} ) ? $attributes->{'showLess'} : __( 'Show Less', 'wptravelengine-elementor-widgets' );
$html_tag       = isset( $attributes->{'html_tag'} ) ? $attributes->{'html_tag'} : 'h2';
$trip_id        = isset( $args['post_id'] ) ? $args['post_id'] : false;
$is_tab_content = isset( $args['is_tab_conent'] ) && $args['is_tab_conent'] ? '-tab-content' : '';

if ( ! $trip_id ) {
	return;
}
$fsd_functions = new WTE_Fixed_Starting_Dates_Functions();
$sorted_fsd    = call_user_func(
	array( new WTE_Fixed_Starting_Dates_Shortcodes(), 'generate_fsds' ),
	$trip_id,
	array(
		'year'  => '',
		'month' => '',
	)
);
$months_arr    = array_unique(
	array_map(
		function ( $fsd ) {
			return gmdate( 'Y-m', strtotime( $fsd['start_date'] ) );
		},
		$sorted_fsd
	)
);
?>
<div id="wte-fixed-departure-dates<?php echo esc_attr( $is_tab_content ); ?>" class="fixed-starting dates wte-fsd-list-container" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wte-fsd' ) ); ?>">
	<div class="wte-fsd-list-header">
		<!-- FILTER -->
		<div class="wte-user-input">
			<input type = 'hidden' class="hidden-id" value="<?php echo esc_attr( $trip_id ); ?>">
			<select class="date-select wpte-enhanced-select" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wte-fsd' ) ); ?>" name="date-select" data-placeholder="<?php esc_attr_e( 'Choose a date&hellip;', 'wptravelengine-elementor-widgets' ); ?>" class="wc-enhanced-select">
				<option value=" "><?php esc_html_e( 'Choose a date&hellip;', 'wptravelengine-elementor-widgets' ); ?></option>
				<?php foreach ( $months_arr as $key => $val ) : ?>
					<option data-month="<?php echo esc_attr( date_i18n( 'm', strtotime( $val ) ) ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( date_i18n( 'F, Y', strtotime( $val ) ) ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="wte-fsd-frontend-holder-dd dd" id="nestable1">
		<?php
		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings' );
		$hide_availability_column  = isset( $wp_travel_engine_settings['departure']['hide_availability_column'] ) && 'yes' === $wp_travel_engine_settings['departure']['hide_availability_column'];
		$hide_price_column         = isset( $wp_travel_engine_settings['departure']['hide_price_column'] ) && 'yes' === $wp_travel_engine_settings['departure']['hide_price_column'];
		$hide_space_left_column    = isset( $wp_travel_engine_settings['departure']['hide_space_left_column'] ) && 'yes' === $wp_travel_engine_settings['departure']['hide_space_left_column'];
		?>
		<div class="dd-list outer">
			<table>
				<thead>
					<tr>
						<th><?php echo esc_attr( $date_label ); ?></th>
						<?php if ( ! $hide_availability_column ) { ?>
							<th><?php echo esc_attr( $availability_label ); ?></th>
						<?php } ?>
						<?php if ( ! $hide_price_column ) { ?>
							<th><?php echo esc_attr( $price_label ); ?></th>
						<?php } ?>
						<?php if ( ! $hide_space_left_column ) { ?>
							<th><?php echo esc_attr( $space_label ); ?></th>
						<?php } ?>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$today = gmdate( 'Y-m-d' );
					if ( ! empty( $sorted_fsd ) ) {
						$trip_duration_unit = null;
						foreach ( $sorted_fsd as $key => $fsd ) {
							if ( is_null( $trip_duration_unit ) ) {
								$trip_settings      = get_post_meta( $fsd['trip_id'], 'wp_travel_engine_setting', true );
								$trip_duration_unit = ! empty( $trip_settings['trip_duration_unit'] ) ? $trip_settings['trip_duration_unit'] : 'days';
							}
							if ( strtotime( $today ) <= strtotime( $fsd['start_date'] ) ) {
								$fsd['trip_duration_unit'] = $trip_duration_unit;
								wte_fsd_get_template( 'table-row.php', $fsd );
							}
						}
					} else {
						?>
						<tr style="display: table-row;">
							<td colspan="5"><?php echo esc_html__( 'No Fixed Departure Dates available.', 'wptravelengine-elementor-widgets' ); ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php
			$globals_settings = wp_travel_engine_get_settings();

			$pagination_num = isset( $globals_settings['trip_dates']['pagination_number'] ) && ! empty( $globals_settings['trip_dates']['pagination_number'] ) ? $globals_settings['trip_dates']['pagination_number'] : 10;

			$count = count( $sorted_fsd );

			if ( $count > $pagination_num ) :
				?>
					<button class="loadMore"><?php echo esc_html( $loadmore_label, 'wptravelengine-elementor-widgets' ); ?></button>
					<button style="display:none;" class="showLess" ><?php echo esc_html( $showless_label, 'wptravelengine-elementor-widgets' ); ?></button>
				<?php
				endif;
			?>
			<div id="loader" style="display: none">
				<div class="table">
					<div class="table-row">
						<div class="table-cell">
							<i class="fa fa-spinner fa-spin"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
