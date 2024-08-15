<?php
/**
 * Enquiry Widget Render.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

/**
 * Enqueue Scripts
 */
wp_enqueue_script( 'parsley' );

global $post;
$_post_id                  = $post->ID;
$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', array() );

// Retrieve attributes value form elementor.
$attributes   = (object) $attributes;
$enquiry_text = isset( $attributes->{'enquiryTitle'} ) ? $attributes->{'enquiryTitle'} : __( 'You can send your enquiry via the form below.', 'wptravelengine-elementor-widgets' );
$button_text  = isset( $attributes->{'buttonText'} ) ? $attributes->{'buttonText'} : __( 'Send Email', 'wptravelengine-elementor-widgets' );

// Include the form class - framework.
require_once WP_TRAVEL_ENGINE_ABSPATH . '/includes/lib/wte-form-framework/class-wte-form.php';

// Form fields initialize.
$form_field          = new \WP_Travel_Engine_Form_Field();
$fields              = new \WP_Travel_Engine_Enquiry_Form_Shortcodes();
$enquiry_form_fields = $fields->get_enquiry_form_fields( $_post_id, $args = array() );

$privacy_policy_fields = array();
if ( function_exists( 'get_privacy_policy_url' ) && get_privacy_policy_url() ) {
	$privacy_policy_fields[ 'enquiry_confirmation' ] = array(
		'type'              => 'checkbox',
		'label'             => __( 'Privacy Policy', 'wptravelengine-elementor-widgets' ),
		// translators: %s: privacy policy link.
		'options' => array( 'on' => isset( $wp_travel_engine_settings[ 'gdpr_msg' ] ) ? esc_attr( $wp_travel_engine_settings[ 'gdpr_msg' ] ) . get_the_privacy_policy_link() . '.' : sprintf( __( 'By contacting us, you agree to our <a href="%1$s">Privacy Policy</a>', 'wptravelengine-elementor-widgets' ), get_privacy_policy_url() ) ),
		'name'              => 'enquiry_confirmation',
		'wrapper_class'     => 'row-form confirm-holder',
		'id'                => 'enquiry_confirmation',
		'validations'       => array(
			'required' => true,
		),
		'option_attributes' => array(
			'required' => true,
		),
		'priority'          => 80,
	);
} else if ( current_user_can( 'edit_theme_options' ) ) {
	// translators: %1$s: opening p tag, %2$s: closing p tag.
	$privacy_policy_lbl = sprintf( __( '%1$sPrivacy Policy page not set or not published, please check Admin Dashboard > Settings > Privacy.%2$s', 'wptravelengine-elementor-widgets' ), '<p style="color:red;">', '</p>' );

	$privacy_policy_fields[ 'enquiry_confirmation' ] = array(
		'type'     => 'text_info',
		'label'    => __( 'Privacy Policy', 'wptravelengine-elementor-widgets' ),
		'id'       => 'enquiry_confirmation',
		'default'  => $privacy_policy_lbl,
		'priority' => 80,
	);
}
?>
<div class="wte_enquiry_contact_form-wrap" id="wte_enquiry_form_scroll_wrapper">
    <form name="wte_enquiry_contact_form" action="#" method="post" id="wte_enquiry_contact_form"
          class="wte_enquiry_contact_form">
		<?php
		// Print display fields.
		$form_field->init( $enquiry_form_fields )->render();

		$privacy_policy_fields = apply_filters( 'wte_enquiry_privacy_fields', $privacy_policy_fields );

		// Print privacy policy fields.
		if ( ! isset( $privacy_policy_lbl ) ) {
			$form_field->init( $privacy_policy_fields )->render();
		}
		wp_nonce_field( 'wte_enquiry_send_mail', 'nonce' );
		?>
        <input type="hidden" name="action" value="wte_enquiry_send_mail">
		<?php
		do_action( 'wte_enquiry_contact_form_before_submit_button' );
		?>
        <input type="submit" class="enquiry-submit" name="enquiry_submit_button" id="enquiry_submit_button"
               value="<?php echo esc_attr( $button_text ); ?>">
		<?php
		do_action( 'wte_enquiry_contact_form_after_submit_button' );
		?>
    </form>
</div>
