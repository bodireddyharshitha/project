<?php
/**
 * Trip Selector Elementor Control.
 *
 * @since 1.1.0
 */
namespace WPTRAVELENGINEEB\Controls;

/**
 * Custom Trip Selector.
 */
class Trip_Selector_Control extends \Elementor\Base_Data_Control {
	/**
	 * Get Type.
	 */
	public function get_type() {
		return 'tripselector';
	}

	public function enqueue() {
		wp_register_script( 'wptravelengineeb-control', plugins_url( '/dist/controls.js', WPTRAVELENGINEEB_FILE__ ), array(), '1.0.0' );
		wp_enqueue_style( 'wptravelengineeb-control', plugins_url( '/dist/controls.css', WPTRAVELENGINEEB_FILE__ ), array(), '1.0.0' );
		wp_enqueue_script( 'wptravelengineeb-control' );
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();

		$trips   = get_posts(
			array(
				'post_type'      => WP_TRAVEL_ENGINE_POST_TYPE,
				'posts_per_page' => '-1',
				'post_status'    => 'publish',
			)
		);
		$options = array();
		if ( is_array( $trips ) ) {
			foreach ( $trips as $trip ) {
				$options[ $trip->ID ] = $trip->post_title;
			}
		}
		?>
		<div class="elementor-control-field wptravelengineeb-control-field">

			<# if ( data.label ) {#>
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>

			<div class="elementor-control-input-wrapper">
				<# if(data.multiple) { #>
					<select data-setting="{{ data.name }}" class="wptravelengineeb-select2" multiple id="<?php echo esc_attr( $control_uid ); ?>">
					<# }else{ #>
					<select class="wptravelengineeb-select2">
				<# } #>
					<?php
					foreach ( $options as $key => $value ) {
						echo wp_kses( "<option value=\"$key\">{$value}</option>", array( 'option' => array( 'value' => array() ) ) );
					}
					?>
				</select>
			</div>

		</div>
		<?php
	}

}
