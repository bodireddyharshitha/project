<?php
/**
 * This file contains the Assets class.
 * All the assets related functions are defined here.
 *
 * @package WPTravelEngine\Core
 * @since 6.0.0
 */

namespace WPTravelEngine;

use WPTravelEngine\Abstracts\AssetsAbstract;
use WPTravelEngine\Core\Functions;
use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Settings\PluginSettings;
use WPTravelEngine\Helpers\Asset;
use WPTravelEngine\Helpers\AssetLib;
use WPTravelEngine\Traits\Singleton;

/**
 * Class Assets
 *
 * @since 5.3.1
 */
class Assets extends AssetsAbstract {

	use Singleton;

	/**
	 * @var string Plugin version.
	 */
	protected string $version;

	/**
	 * @var string Plugin name.
	 */
	protected string $plugin_name = 'wp-travel-engine';

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->version = WP_TRAVEL_ENGINE_VERSION;

		add_action( 'wp_enqueue_scripts', array( $this, 'plugin_scripts' ) );
		add_action( 'wp_print_scripts', array( $this, 'dequeue_assets' ), 11 );
		add_action( 'wp_print_styles', array( $this, 'dequeue_assets' ), 11 );
	}

	/**
	 * Localize Required Data.
	 */
	public function localize( $handle, $object_name ): AssetsAbstract {
		global $post;

		// phpcs:disable
		$post_id = 0;
		if ( isset( $_GET[ 'action' ] ) && 'partial-payment' === wp_unslash( $_GET[ 'action' ] ) && ! empty( $_GET[ 'booking_id' ] ) ) :
			$post_id = (int) $_GET[ 'booking_id' ];
		elseif ( is_object( $post ) && ! is_404() ) :
			$post_id = $post->ID;
		endif;

		$currency_code_js = apply_filters( 'wpte_cc_allow_payment_with_switcher', true ) ? wp_travel_engine_get_currency_code() : wte_currency_code_in_db();

		$data = [
			'wtePreFetch'      => array(
				'tripID' => $post_id,
				'wpapi'  => array(
					'root'          => esc_url_raw( rest_url() ),
					'nonce'         => wp_create_nonce( 'wp_rest' ),
					'versionString' => 'wp/v2/',
				),
			),
			'wte_account_page' => array(
				'ajax_url'                => admin_url( 'admin-ajax.php' ),
				'change_user_profile_msg' => __( 'Click here or Drop new image to update your profile picture', 'wp-travel-engine' ),
			),
			'wteL10n'          => $this->get_global_localize_data(),
			'wte'              => array(
				'personFormat'    => wte_get_person_format(),
				'bookNow'         => wte_get_book_now_text(),
				'totaltxt'        => wte_get_total_text(),
				'currency'        => array(
					'code'   => apply_filters( 'wpte_cc_allow_payment_with_switcher', true ) ? \wp_travel_engine_get_currency_code() : wte_currency_code_in_db(),
					'symbol' => \wp_travel_engine_get_currency_symbol( $currency_code_js ),
				),
				'payments'        => $this->get_payment_localize_data(),
				'single_showtabs' => apply_filters( 'wte_single_trip_show_all_tabs', false ),
				'pax_labels'      => wte_multi_pricing_labels( $post_id ),
				'booking_cutoff'  => wpte_get_booking_cutoff( $post_id ),
			),
			'WTEAjaxData'      => array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wp_rest' ),
			),
		];

		$objects = explode( ',', $object_name );

		foreach ( $objects as $object_name ) {
			$this->localize_script( $handle, $object_name, $data[ $object_name ] ?? [] );
		}

		return $this;
	}

	/**
	 * Register Plugin Scripts.
	 */
	public function plugin_scripts() {
		add_filter( 'script_loader_tag', array( $this, 'add_script_attributes' ), 10, 3 );
		add_filter( 'style_loader_tag', array( $this, 'add_style_attributes' ), 10, 3 );
		$this->register_dependency_libraries();
		$this->register_plugin_scripts();

		wp_set_script_translations('trip-booking-modal', 'wp-travel-engine', plugin_dir_path(WP_TRAVEL_ENGINE_FILE_PATH) . '/languages/');
	}

	/**
	 * Register Plugin Scripts.
	 */
	protected function register_plugin_scripts() {
		global $post;

		// phpcs:disable
		$post_id = 0;
		if ( isset( $_GET[ 'action' ] ) && 'partial-payment' === wp_unslash( $_GET[ 'action' ] ) && ! empty( $_GET[ 'booking_id' ] ) ) :
			$post_id = (int) $_GET[ 'booking_id' ];
		elseif ( is_object( $post ) && ! is_404() ) :
			$post_id = $post->ID;
		endif;

		/* @var PluginSettings $plugin_settings */
		$this->register_style( Asset::register( 'single-trip', 'public/single-trip.css' ) );
		$this->register_style( Asset::register( 'wte-blocks-index', 'blocks/index.css' ) );
		$this->register_script(
			Asset::register( 'trip-booking-modal', 'public/components/trip-booking-modal.js' )->dependencies( [
				'single-trip',
				'wte-fpickr',
			] )
		);
		$this->register_script(
			Asset::register( 'single-trip', 'public/single-trip.js' )
			     ->dependencies( [ 'wp-dom-ready', 'wp-api-fetch', 'lodash', 'jquery', ] )
		)->localize( 'single-trip', 'wtePreFetch,wteL10n,rtl' );

		global $wte_cart;
		$this->register_style( Asset::register( $this->plugin_name, 'public/wte-public.css' ) )
		     ->register_script(
			     Asset::register( $this->plugin_name, 'public/wte-public.js' )
			          ->dependencies( 'jquery' )
		     )->localize( 'wp-travel-engine', 'wte,wte_account_page,rtl,wtePreFetch,WTEAjaxData,wteL10n' );

		$this->enqueue_script( 'wp-travel-engine' )
		     ->enqueue_style( 'wp-travel-engine' );

		// Adds cart data to the checkout page.
		if ( wp_travel_engine_is_checkout_page() && isset( $wte_cart ) ) {
			$cart_data           = array(
				'cart_items'  => $wte_cart->getItems(),
				'cart_totals' => $wte_cart->get_total(),
			);
			$wptravelengine_cart = sprintf( "window['wptravelengineCart'] = %s;", wp_json_encode( $cart_data ) );
			wp_add_inline_script( 'wp-travel-engine', $wptravelengine_cart );
		}

		//My Account Page.
		$this->register_style( Asset::register( 'my-account', 'public/my-account.css' ) )
		     ->register_script( Asset::register( 'my-account', 'public/my-account.js' ) )
		     ->localize( 'my-account', 'wte_account_page' );

		//Checkout Page.
		$this->register_style( Asset::register( 'trip-checkout', 'public/trip-checkout.css' ) );
		//Wishlist Page.
		$this->register_style( Asset::register( 'trip-wishlist', 'public/trip-wishlist.css' ) );
		$this->register_script( Asset::register( 'trip-wishlist', 'public/trip-wishlist.js' )->dependencies( [ 'wp-travel-engine' ] ) );

	}

	/**
	 * Register External Assets.
	 */
	protected function register_dependency_libraries() {
		// Owl Carousel.
		$this->register_script( AssetLib::register( 'owl-carousel', 'owl-carousel-2.3.4/owl.carousel.js' )->dependencies( [ 'jquery' ] )->version( '2.3.4' ) )
		     ->register_style( AssetLib::register( 'owl-carousel', 'owl-carousel-2.3.4/owl.carousel.css' ) );

		// Slick Slider.
		$this->register_script( AssetLib::register( 'slick', 'slick/slick-min-js.js' )->dependencies( [ 'jquery' ] )->version( '2.3.4' ) )
		     ->register_style( AssetLib::register( 'slick', 'slick/slick.min.css' ) );

		// Nouislider.
		$this->register_script( AssetLib::register( 'wte-nouislider', 'nouislider/nouislider.min.js' )->version( '2.3.4' ) )
		     ->register_style( AssetLib::register( 'wte-nouislider', 'nouislider/nouislider.min.css' )->dependencies( [ 'wp-travel-engine' ] )->version( '2.3.4' ) );

		// Parsley.
		$this->register_script( AssetLib::register( 'parsley', 'parsley-min.js' )->dependencies( [ 'jquery' ] )->version( '2.9.2' ) );

		// Fancy Box.
		$this->register_script( AssetLib::register( 'jquery-fancy-box', 'fancybox/jquery.fancybox.min.js' )->dependencies( [ 'jquery-core' ] )->version( '3.5.7' ) )
		     ->register_style( AssetLib::register( 'jquery-fancy-box', 'fancybox/jquery.fancybox.min.css' )->version( '3.5.7' ) );

		// jQuery Steps.
		$this->register_script(
			AssetLib::register( 'jquery-steps', 'jquery-steps.min.js' )
			        ->dependencies( [ 'jquery', 'jquery-ui-core', ] )
			        ->version( $this->version )
		);

		// jQuery Validate.
		$this->register_script( AssetLib::register( 'jquery-validate', 'jquery.validate.min.js' )->dependencies( [ 'jquery' ] )->version( '1.19.1' ) );

		// Font Awesome.
//		$this->register_script( AssetLib::register( 'wte-fontawesome-all', 'fontawesome/all.min.js' )->version( '5.6.3' ) )
//		     ->register_script( AssetLib::register( 'v4-shims', 'fontawesome/v4-shims.min.js' )->version( '5.6.3' ) )
//		     ->register_script( AssetLib::register( 'wte-fontawesome', 'fontawesome/fontawesome.bundle.js' )->version( '5.6.3' ) );

		// Sticky Kit.
		$this->register_script( AssetLib::register( 'jquery-sticky-kit', 'jquery.sticky-kit.js' )->dependencies( [ 'jquery' ] ) );

		// Toastr.
		$this->register_script( AssetLib::register( 'toastr', 'toastr/toastr.min.js' )->dependencies( [ 'jquery' ] ) )
		     ->register_style( AssetLib::register( 'toastr', 'toastr/toastr.min.css' )->version( $this->version ) );

		// Select2.
		$this->register_script( AssetLib::register( 'wte-select2', 'select2-4.0.13/select2.js' )->dependencies( [ 'jquery' ] )->version( '4.0.13' ) )
		     ->register_style( AssetLib::register( 'wte-select2', 'select2-4.0.13/select2.css' )->version( '4.0.13' ) );

		// RRule.
		$this->register_script( AssetLib::register( 'wte-rrule', 'rrule.min.js' )->dependencies( [ 'jquery' ] )->version( '3.3.2' ) );

		// Flatpickr.
		$this->register_script( AssetLib::register( 'wte-fpickr-lib', 'flatpickr-4.6.9/fpickr.js' )->version( '4.6.9' ) )
		     ->register_style( AssetLib::register( 'wte-fpickr', 'flatpickr-4.6.9/fpickr.css' )->version( '4.6.9' ) );

		$flatpickr = explode( '_', get_locale() )[0] ?? 'default';
		$this->enqueue_script(
			AssetLib::register( 'wte-fpickr', "flatpickr-4.6.9/l10n/{$flatpickr}.js" )
               ->version( '4.6.9' )
               ->dependencies( [ 'wte-fpickr-lib' ] )
               ->in_footer(true)
		);

		// Highlight JS.
		$this->register_script( AssetLib::register( 'wte-highlightjs', 'highlightjs-10.5.0/highlight.pack.js' )->version( '10.5.0' ) )
		     ->register_style( AssetLib::register( 'wte-highlightjs', 'highlightjs-10.5.0/highlight.pack.css' )->version( '10.5.0' ) );

		// Redux.
		$this->register_script( AssetLib::register( 'wte-redux', 'redux.min.js' )->dependencies( [ 'wp-redux-routine' ] )->version( '4.0.5' )->in_footer( false ) );

		// RxJS.
		$this->register_script( AssetLib::register( 'wte-rxjs', 'rxjs.umd.js' )->version( '6.6.6' ) );

		// Moment Timezone.
		$this->register_script( AssetLib::register( 'wte-moment-tz', 'moment/moment-tz.js' )->dependencies( [ 'moment' ] )->version( '0.5.33' ) );

		// Custom Nice Select.
		$this->register_script( AssetLib::register( 'wte-custom-niceselect', 'nice-select/jquery.nice-select.min.js' )->dependencies( [ 'jquery' ] )->version( '1.0' ) )
		     ->register_style( AssetLib::register( 'wte-custom-niceselect', 'nice-select/nice-select.css' )->version( '1.0' ) );

		// Custom Scrollbar.
		$this->register_script( AssetLib::register( 'wte-custom-scrollbar', 'custom-scrollbar/jquery.mCustomScrollbar.concat.min.js' )->dependencies( [ 'jquery' ] )->version( '3.1.13' ) )
		     ->register_style( AssetLib::register( 'wte-custom-scrollbar', 'custom-scrollbar/jquery.mCustomScrollbar.min.css' )->version( '3.1.13' ) );

		// Datepicker Style.
		$this->register_style( AssetLib::register( 'datepicker-style', 'datepicker/datepicker-style.css' )->version( '1.11.4' ) );

		// Animate.
		$this->register_style( AssetLib::register( 'animate', 'animate.css' )->version( '3.5.2' ) );

		// jQuery UI.
		$this->register_style( AssetLib::register( 'jquery-ui', 'jquery-ui.css' )->version( '1.12.1' ) );

		// WTE Icons.
		$this->register_style( AssetLib::register( 'wte-icons', 'wte-icons/style.css' )->version( '1.0.0' ) );

		// Dropzone.
		$this->register_script( AssetLib::register( 'wte-dropzone', 'dropzone/dropzone.min.js' )->version( '5.9.2' ) )
		     ->register_style( AssetLib::register( 'wte-dropzone', 'dropzone/dropzone.min.css' )->version( '5.9.2' ) );

		// Popper.
		$this->register_script( AssetLib::register( 'wte-popper', 'tippy/popper.js' )->version( '1.0.0' ) );

		// Tippy JS.
		$this->register_script( AssetLib::register( 'wte-tippyjs', 'tippy/tippy.js' )->version( '5.0.0' ) );

	}

	/**
	 * Dequeue Scripts.
	 */
	public function dequeue_assets(): Assets {
		foreach ( static::$to_be_dequeued_scripts as $handle ) {
			wp_dequeue_script( $handle );
		}

		foreach ( static::$to_be_dequeued_styles as $handle ) {
			wp_dequeue_style( $handle );
		}

		return $this;
	}

	public function is_fontawesome_enabled() {
		$settings = get_option( 'wp_travel_engine_settings', array() );

		return apply_filters( 'wte_enable_fontawesome', ! isset( $settings[ 'disable_fa_icons_js' ] ) || ( $settings[ 'disable_fa_icons_js' ] !== 'yes' ) );
	}

	/**
	 * Register Libraries.
	 */
	public function get_external_libraries() {
		$url_prefix = apply_filters( 'wte_vendors_directory', plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . 'assets/lib/' );
		$libs       = array(
			'owl-carousel'          => array(
				'js'  => array( $url_prefix . 'owl-carousel-2.3.4/owl.carousel.js', array( 'jquery' ), '2.3.4', true ),
				'css' => array( $url_prefix . 'owl-carousel-2.3.4/owl.carousel.css', array(), '2.3.4' ),
			),
			'slick'                 => array(
				'js'  => array( $url_prefix . 'slick/slick-min-js.js', array( 'jquery' ), '2.3.4', true ),
				'css' => array( $url_prefix . 'slick/slick.min.css', array(), '2.3.4' ),
			),
			'wte-nouislider'        => array(
				'js'  => array( $url_prefix . 'nouislider/nouislider.min.js', array(), '2.3.4', false ),
				'css' => array( $url_prefix . 'nouislider/nouislider.min.css', array( 'wp-travel-engine' ), '2.3.4' ),
			),
			'parsley'               => array(
				'js' => array(
					$url_prefix . 'parsley-min.js',
					array( 'jquery' ),
					'2.9.2',
					true,
				),
			),
			'jquery-fancy-box'      => array(
				'css' => array( $url_prefix . 'fancybox/jquery.fancybox.min.css', array(), '3.5.7' ),
				'js'  => array( $url_prefix . 'fancybox/jquery.fancybox.min.js', array( 'jquery' ), '3.5.7', true ),
			),
			'jquery-steps'          => array(
				'js' => array(
					$url_prefix . 'jquery-steps.min.js',
					array( 'jquery', 'jquery-ui-core' ),
					$this->version,
					true,
				),
			),
			'jquery-validate'       => array(
				'js' => array(
					$url_prefix . 'jquery.validate.min.js',
					array( 'jquery' ),
					'1.19.1',
					true,
				),
			),
			'wte-fontawesome-all'   => array(
				'js' => array(
					$url_prefix . 'fontawesome/all.min.js',
					array(),
					'5.6.3',
					true,
				),
			),
			'v4-shims'              => array(
				'js' => array(
					$url_prefix . 'fontawesome/v4-shims.min.js',
					array(),
					'5.6.3',
					true,
				),
			),
			'wte-fontawesome'       => array(
				'js' => array(
					$url_prefix . 'fontawesome/fontawesome.bundle.js',
					array(),
					'5.6.3',
					false,
				),
			),
			'jquery-sticky-kit'     => array(
				'js' => array(
					$url_prefix . 'jquery.sticky-kit.js',
					array( 'jquery' ),
					null,
					true,
				),
			),
			'toastr'                => array(
				'js'  => array( $url_prefix . 'toastr/toastr.min.js', array( 'jquery' ), null, true ),
				'css' => array( $url_prefix . 'toastr/toastr.min.css', array(), $this->version ),
			),
			'wte-select2'           => array(
				'js'  => array( $url_prefix . 'select2-4.0.13/select2.js', array( 'jquery' ), '4.0.13', true ),
				'css' => array( $url_prefix . 'select2-4.0.13/select2.css', array(), '4.0.13' ),
			),
			'wte-rrule'             => array(
				'js' => array(
					$url_prefix . 'rrule.min.js',
					array( 'jquery' ),
					'3.3.2',
					true,
				),
			),
			'wte-fpickr'            => array(
				'js'  => array( $url_prefix . 'flatpickr-4.6.9/fpickr.js', array(), '4.6.9', true ),
				'css' => array( $url_prefix . 'flatpickr-4.6.9/fpickr.css', array(), '4.6.9' ),
			),
			'wte-fpickr-l10n'       => array(
				'js' => array( $url_prefix . 'flatpickr-4.6.9/l10n/default.js', array( 'wte-fpickr' ), '4.6.9', true ),
			),
			'wte-highlightjs'       => array(
				'js'  => array( $url_prefix . 'highlightjs-10.5.0/highlight.pack.js', array(), '10.5.0', true ),
				'css' => array( $url_prefix . 'highlightjs-10.5.0/highlight.pack.css', array(), '10.5.0' ),
			),
			'wte-redux'             => array(
				'js' => array(
					$url_prefix . 'redux.min.js',
					array( 'wp-redux-routine' ),
					'4.0.5',
					true,
				),
			),
			'wte-rxjs'              => array( 'js' => array( $url_prefix . 'rxjs.umd.js', array(), '6.6.6', ! 0 ) ),
			'wte-moment-tz'         => array(
				'js' => array(
					$url_prefix . 'moment/moment-tz.js',
					array( 'moment' ),
					'0.5.33',
					true,
				),
			),
			'wte-custom-niceselect' => array(
				'js'  => array( $url_prefix . 'nice-select/jquery.nice-select.min.js', array( 'jquery' ), '1.0', true ),
				'css' => array( $url_prefix . 'nice-select/nice-select.css', array(), '1.0' ),
			),
			'wte-custom-scrollbar'  => array(
				'js'  => array(
					$url_prefix . 'custom-scrollbar/jquery.mCustomScrollbar.concat.min.js',
					array( 'jquery' ),
					'3.1.13',
					true,
				),
				'css' => array( $url_prefix . 'custom-scrollbar/jquery.mCustomScrollbar.min.css', array(), '3.1.13' ),
			),
			'datepicker-style'      => array(
				'css' => array(
					$url_prefix . 'datepicker/datepicker-style.css',
					array(),
					'1.11.4',
				),
			),
			'animate'               => array( 'css' => array( $url_prefix . 'animate.css', array(), '3.5.2' ) ),
			'jquery-ui'             => array(
				'css' => array(
					$url_prefix . 'jquery-ui.css',
					array(),
					'1.12.1',
					'all',
				),
			),
			'wte-icons'             => array( 'css' => array( $url_prefix . 'wte-icons/style.css', array(), '1.0.0' ) ),
			'wte-dropzone'          => array(
				'js'  => array( $url_prefix . 'dropzone/dropzone.min.js', array(), '5.9.2', true ),
				'css' => array( $url_prefix . 'dropzone/dropzone.min.css', array(), '5.9.2' ),
			),
			'wte-popper'            => array(
				'js' => array( $url_prefix . 'tippy/popper.js', array(), '1.0.0', true ),
			),
			'wte-tippyjs'           => array(
				'js' => array( $url_prefix . 'tippy/tippy.js', array(), '5.0.0', true ),
			),
			'chartjs'               => array(
				'js' => array( $url_prefix . 'chartjs/Chart.min.js', array(), '2.9.4', true ),
			),
			'chartjs-datalabels'    => array(
				'js' => array(
					$url_prefix . 'chartjs/chartjs-plugin-datalabels.min.js',
					array( 'chartjs' ),
					'0.7.0',
					true,
				),
			),
		);

		if ( ! $this->is_fontawesome_enabled() ) {
			unset( $libs[ 'wte-fontawesome-all' ] );
			unset( $libs[ 'v4-shims' ] );
		}

		return apply_filters( 'wte_external_libraries', $libs );
	}

	/**
	 * Common assets shared between Admin and Client Side.
	 */
	public function get_common_assets() {
		$url_prefix = apply_filters( 'wte_common_assets_directory', plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) );

		$development = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		$suffix = $development ? '' : '';
		$assets = array(
			'regenerator-runtime' => array(
				'js' => array(
					$url_prefix . "dist/global/regenerator-runtime{$suffix}.js",
					array(),
					'0.13.7',
					true,
				),
			),
			'wte-global'          => array(
				'js'            => array(
					$url_prefix . "dist/global/wte-global{$suffix}.js",
					array( 'lodash', 'regenerator-runtime' ),
					filemtime( plugin_dir_path( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/global/wte-global{$suffix}.js" ),
					true,
				),
				'localize_data' => array( 'wteL10n', array( $this, 'get_global_localize_data' ) ),
				'css'           => array(
					$url_prefix . "dist/global/wte-global{$suffix}.css",
					array(),
					filemtime( plugin_dir_path( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/global/wte-global{$suffix}.css" ),
				),
			),
		);

		return apply_filters( 'wte_common_assets', $assets, $suffix, $this->version );
	}

	public static function append_dependency( $handle, $dependency ) {
		global $wp_scripts;

		$script = $wp_scripts->query( $handle, 'registered' );
		if ( ! $script ) {
			return false;
		}

		if ( ! in_array( $dependency, $script->deps ) ) {
			$script->deps[] = $dependency;
		}

		return true;
	}

	/**
	 * Registers all the required Scripts.
	 *
	 * @param array $assets Assets to be registered.
	 */
	public function register_scripts( $assets = array() ) {
		// Library Scripts Registration.
		$libs          = $this->get_external_libraries();
		$common_assets = $this->get_common_assets();

		$registering_assets = array_merge( $libs, $common_assets, $assets );
		foreach ( $registering_assets as $handle => $params_array ) {

			foreach ( $params_array as $type => $_args ) {
				switch ( $type ) {
					case 'js':
						list( $url, $dependencies, $version, $in_footer ) = $_args;
						$in_footer = isset( $in_footer ) && $in_footer;
						wp_register_script( $handle, $url, $dependencies, $version, $in_footer );
						break;
					case 'css':
						list( $url, $dependencies, $version ) = $_args;

						$media = isset( $_args[ 3 ] ) ? $_args[ 3 ] : 'all';
						wp_register_style( $handle, $url, $dependencies, $version, $media );
						break;
					case 'localize_data':
						list( $object_name, $data ) = $_args;

						$data = is_callable( $data ) ? call_user_func( $data, $this ) : $data;
						wp_localize_script( $handle, $object_name, $data );
						break;
				}
			}
		}

	}

	/**
	 * Localize Scripts.
	 */
	public function get_global_localize_data() {
		$settings = get_option( 'wp_travel_engine_settings', array() );

		$base_currency = wte_array_get( $settings, 'currency_code', 'USD' );
		$currency      = apply_filters( 'wp_travel_engine_currency_code', $base_currency, ! 1 );

		$extensions = array();
		foreach (
			array(
				'wte-extra-services'            => 'WTE_EXTRA_SERVICES_VERSION',
				'wte-trip-reviews'              => 'WTE_TRIP_REVIEW_VERSION',
				'wte-trip-fixed-starting-dates' => 'WTE_FIXED_DEPARTURE_VERSION',
				'wte-currency-converter'        => 'WTE_CURRENCY_CONVERTER_VERSION',
			) as $slug => $constant_name
		) {
			if ( defined( $constant_name ) ) {
				$extensions[ $slug ] = \constant( $constant_name );
			}
		}

		$l10n = array(
			'version'            => $this->version,
			'baseCurrency'       => $base_currency,
			'baseCurrencySymbol' => Functions::currency_symbol_by_code( $base_currency ),
			'currency'           => $currency,
			'currencySymbol'     => Functions::currency_symbol_by_code( $currency ),
			'home_url'           => get_bloginfo( 'url' ),
			'_nonces'            => array(
				'addtocart'          => wp_create_nonce( 'wte_add_trip_to_cart' ),
				'downloadSystemInfo' => wp_create_nonce( 'wte_download_system_info' ),
			),
			'wpapi'              => array(
				'root'          => esc_url_raw( rest_url() ),
				'nonce'         => wp_create_nonce( 'wp_rest' ),
				'versionString' => 'wp/v2/',
			),
			'wpxhr'              => array(
				'root'  => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
				'nonce' => wp_create_nonce( 'wp_xhr' ),
			),
			'format'             => array(
				'number'   => array(
					'decimal'           => wte_array_get( $settings, 'decimal_digits', 0 ),
					'decimalSeparator'  => wte_array_get( $settings, 'decimal_separator', '.' ),
					'thousandSeparator' => wte_array_get( $settings, 'thousands_separator', ',' ),
				),
				'price'    => wte_array_get( $settings, 'amount_display_format', '%CURRENCY_SYMBOL%%FORMATED_AMOUNT%' ),
				'date'     => get_option( 'date_format', 'Y-m-d' ),
				'time'     => get_option( 'time_format', 'g:i a' ),
				'datetime' => array(
					'date'      => get_option( 'date_format', 'Y-m-d' ),
					'time'      => get_option( 'time_format', 'g:i a' ),
					'GMTOffset' => wte_get_timezone_info(),
					'timezone'  => get_option( 'timezone_string', '' ),
				),
			),
			'extensions'         => apply_filters( 'wte_active_extensions', $extensions ),
			'locale'             => get_locale(),
			'l10n'               => wp_parse_args(
				wte_default_labels(),
				array(
					// Translators: %s: Minimum Number of Traveller.
					'invalidCartTraveler'  => __( 'No. of Travellers\' should be at least %s', 'wp-travel-engine' ),
					// Translators: %s: Maximum Number of Traveller.
					'availableSeatsExceed' => __( 'The number of pax can not exceed more than %s', 'wp-travel-engine' ),
					// Translators: %s: Minimum Number of Extra Services.
					'invalidCartExtraReq'  => __( '%s selection is essential. Please specify a number.', 'wp-travel-engine' ),
					// Translators: Required Extra Services.
					'invalidCartExtra'     => __( 'Extra Services marked with * is essential. Please specify a number.', 'wp-travel-engine' ),
				)
			),
			'layout'             => array(
				'showFeaturedTripsOnTop' => ! isset( $settings[ 'show_featured_trips_on_top' ] ) || 'yes' === $settings[ 'show_featured_trips_on_top' ],
				'showoptionfilter'       => ! isset( $settings[ 'search_filter_option' ] ) || 'yes' === $settings[ 'search_filter_option' ],

			),
			'rtl'                => is_rtl(),
		);

		if ( function_exists( 'pll_current_language' ) && \pll_current_language() ) {
			$l10n[ 'locale' ] = \pll_current_language();
		}

		if ( is_admin() ) {
			$l10n[ 'admin_url' ] = admin_url( '/' );
		}

		global $post;
		global $wtetrip;
		if ( $post instanceof \WP_Post && ( \WP_TRAVEL_ENGINE_POST_TYPE === $post->post_type ) ) {
			$trip_version = get_post_meta( $post->ID, 'trip_version', true );
			if ( empty( $trip_version ) ) {
				$trip_version = '0.0.0';
			}
			$l10n[ 'tripID' ]      = (int) $post->ID;
			$l10n[ 'tripVersion' ] = $trip_version;
			$l10n[ 'legacy' ]      = $wtetrip->use_legacy_trip ?? false;
		}

		return apply_filters( 'wtel10n', $l10n );
	}

	/**
	 *
	 * @since __release_version__
	 */
	public function add_script_attributes( $tag, $handle, $source ) {
		$handles = array(
			'wte-fontawesome',
			'wte-nouislider',
		);
		if ( in_array( $handle, $handles, true ) ) {
			$tag = str_replace( 'src=', 'defer async src=', $tag );

		}

		return $tag;
	}

	/**
	 *
	 * @since 5.5.0
	 */
	public function add_style_attributes( $tag, $handle, $source ) {

		// onload='this.onload=null;this.rel=\'stylesheet\''
		$handles = array( 'wp-travel-engine' );
		if ( in_array( $handle, $handles, true ) ) {
			$tag = str_replace( "rel='stylesheet'", "rel='preload' as=\"style\" onload=\"this.onload=null;this.rel='stylesheet'\"", $tag );
		}

		return $tag;
	}

	/**
	 *
	 * @since 5.5.0
	 */
	public function backward_compatibility_dependencies( $default = array() ) {
		$deps = array();
		if ( defined( 'WTE_TRIP_REVIEW_VERSION' ) && version_compare( WTE_TRIP_REVIEW_VERSION, '2.1.3', '<' ) ) {
			$deps[] = 'jquery-ui-datepicker';
		}

		return array_merge( $default, $deps );
	}

	/**
	 * Retrieves the localized data for the payment process.
	 *
	 * @return array The payment localize data.
	 */
	public function get_payment_localize_data(): array {
		global $wte_cart;

		$booking_id = $wte_cart->get_booking_ref();
		$locale = get_locale();
		$total = round( $wte_cart->get_cart_total(), 2 );
		$total_partial = round( $wte_cart->get_total_partial(), 2 );
		$remaining_payment = $total - $total_partial;

		/* @var Core\Models\Post\Booking $booking */
		$booking = wptravelengine_get_booking( $booking_id );
		if ( $booking ) {
			$remaining_payment = round( $booking->get_due_amount(), 2 );
		}

		$data = compact( 'booking_id', 'locale', 'total', 'total_partial', 'remaining_payment' );

		if ( ( $_GET[ 'action' ] ?? false ) === 'partial-payment' && ! empty( $_GET[ 'booking_id' ] ) ) {
			$booking = wptravelengine_get_booking( (int) $_GET[ 'booking_id' ] );
			$data[ 'total' ]         = round( $booking->get_cart_info( 'total' ) ?? 0, 2 );
			$data[ 'total_partial' ] = round( $booking->get_cart_info( 'cart_partial' ) ?? 0, 2 );
		}

		return $data;
	}

	/**
	 * Public Assets.
	 */
	public function wp_enqueue_scripts() {
		add_filter( 'script_loader_tag', array( $this, 'add_script_attributes' ), 10, 3 );
		add_filter( 'style_loader_tag', array( $this, 'add_style_attributes' ), 10, 3 );

		$this->register_scripts();

		global $post;

		// phpcs:disable
		$post_id = 0;
		if ( isset( $_GET[ 'action' ] ) && 'partial-payment' === wp_unslash( $_GET[ 'action' ] ) && ! empty( $_GET[ 'booking_id' ] ) ) :
			$post_id = (int) $_GET[ 'booking_id' ];
		elseif ( is_object( $post ) && ! is_404() ) :
			$post_id = $post->ID;
		endif;

		$development = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		$suffix = $development ? '' : '';

		// $public_script_dependencies

		$public_script_dependencies = $this->backward_compatibility_dependencies( array(
			"jquery",
			"lodash",
			"regenerator-runtime",
		) );

		$this->register_scripts( [
			$this->plugin_name => array(
				'js'            => array(
					plugin_dir_url( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/wte-public{$suffix}.js",
					$public_script_dependencies,
					filemtime( plugin_dir_path( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/wte-public{$suffix}.js" ),
					true,
				),
				'localize_data' => array( 'wteL10n', array( $this, 'get_global_localize_data' ) ),
				'css'           => array(
					plugin_dir_url( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/wte-public{$suffix}.css",
					// array( 'animate', 'jquery-ui', 'owl-carousel', 'wte-global' ),
					array(),
					filemtime( plugin_dir_path( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/wte-public{$suffix}.css" ),
				),
			),
		] );

		if ( is_singular( WP_TRAVEL_ENGINE_POST_TYPE ) ) {
			global $post;
			wp_register_script(
				'wte-prefetch',
				plugin_dir_url( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/prefetch.js",
				array( 'wp-api-fetch' ),
				filemtime( plugin_dir_path( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/prefetch.js" )
			);
			wp_localize_script(
				'wte-prefetch',
				'wtePreFetch',
				array(
					'tripID' => $post->ID,
					'wpapi'  => array(
						'root'          => esc_url_raw( rest_url() ),
						'nonce'         => wp_create_nonce( 'wp_rest' ),
						'versionString' => 'wp/v2/',
					),
				)
			);
			wp_enqueue_script( 'wte-prefetch' );
		}

		wp_add_inline_script( 'wte-dropzone', 'Dropzone.autoDiscover = false;' );

		global $wte_cart;

		$currency_code_js = apply_filters( 'wpte_cc_allow_payment_with_switcher', ! 0 ) ? wp_travel_engine_get_currency_code() : wte_currency_code_in_db();

		$settings = get_option( 'wp_travel_engine_settings', array() );

		$to_be_localized = array(
			'wte_currency_vars' => array(
				'handle' => $this->plugin_name,
				'l10n'   => array(
					'code_or_symbol' => wte_array_get( $settings, 'currency_option', 'symbol' ),
				),
			),
			'WTEAjaxData'       => array(
				'handle' => $this->plugin_name,
				'l10n'   => array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'wp_rest' ),
				),
			),
			'wte_strings'       => array(
				'handle' => $this->plugin_name,
				'l10n'   => array(
					'bookNow'         => wte_get_book_now_text(),
					// Translators: 1. Selected Pax Number 2. Minimum number of travellers 3. Maximum Number of Traveller.
					'pax_validation'  => __( 'Number of pax (%1$s) is not eligible for booking. Please choose travellers number between %2$s and %3$s for this trip.', 'wp-travel-engine' ),
					'bookingContinue' => _x( 'Continue', 'Booking continue button Label', 'wp-travel-engine' ),
				),
			),
			'wte'               => array(
				'handle' => $this->plugin_name,
				'l10n'   => array(
					'personFormat'    => wte_get_person_format(),
					'bookNow'         => wte_get_book_now_text(),
					'totaltxt'        => wte_get_total_text(),
					'currency'        => array(
						'code'   => apply_filters( 'wpte_cc_allow_payment_with_switcher', true ) ? \wp_travel_engine_get_currency_code() : wte_currency_code_in_db(),
						'symbol' => \wp_travel_engine_get_currency_symbol( $currency_code_js ),
					),
					'trip'            => array(
						'id'                 => $post_id,
						'salePrice'          => wp_travel_engine_get_sale_price( $post_id ),
						'regularPrice'       => wp_travel_engine_get_prev_price( $post_id ),
						'isSalePriceEnabled' => wp_travel_engine_is_trip_on_sale( $post_id ),
						'price'              => wp_travel_engine_get_actual_trip_price( $post_id ),
						'travellersCost'     => wp_travel_engine_get_actual_trip_price( $post_id ),
						'extraServicesCost'  => 0.0,
					),
					'payments'        => $this->get_payment_localize_data(),
					'single_showtabs' => apply_filters( 'wte_single_trip_show_all_tabs', ! 1 ),
					'pax_labels'      => wte_multi_pricing_labels( $post_id ),
					'booking_cutoff'  => wpte_get_booking_cutoff( $post_id ),
				),
			),
		);

		$to_be_localized[ 'wte_cart' ] = array(
			'handle' => $this->plugin_name,
			'l10n'   => $wte_cart->getItems(),
		);

		$to_be_localized[ 'rtl' ] = array(
			'handle' => $this->plugin_name,
			'l10n'   => array( 'enable' => is_rtl() ? '1' : '0' ),
		);

		$to_be_localized[ 'Url' ] = array(
			'handle' => $this->plugin_name,
			'l10n'   => array(
				'paypalurl' => defined( 'WP_TRAVEL_ENGINE_PAYMENT_DEBUG' ) && \WP_TRAVEL_ENGINE_PAYMENT_DEBUG ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr',
				'normalurl' => esc_url( wte_array_get( $settings, 'pages.wp_travel_engine_confirmation_page', '' ) ),
			),
		);

		$to_be_localized[ 'wp_travel_engine' ] = array(
			'handle' => $this->plugin_name,
			'l10n'   => array(
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
				'cartURL'     => '',
				'CheckoutURL' => add_query_arg( 'wte_id', time(), wp_travel_engine_get_checkout_url() ),
			),
		);

		// Localization.
		foreach (
			$to_be_localized as $object_name => $load
		) {
			wp_localize_script(
				$load[ 'handle' ],
				$object_name,
				$load[ 'l10n' ]
			);
		}

		// wp_register_style(
		// 	$this->plugin_name,
		// 	plugin_dir_url( \WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/public/wte-public{$suffix}.css",
		// 	array( 'animate', 'jquery-ui', 'owl-carousel', 'wte-global' ),
		// 	$this->version
		// );

		global $wte_cart;
		$wptravelengine_cart = '';
		if ( wp_travel_engine_is_checkout_page() && isset( $wte_cart ) ) {
			$cart_data = array(
				'cart_items'  => $wte_cart->getItems(),
				'cart_totals' => $wte_cart->get_total(),
			);

			$wptravelengine_cart = "window['wptravelengineCart'] = %s;";
			wp_add_inline_script( $this->plugin_name, sprintf( $wptravelengine_cart, wp_json_encode( $cart_data ) ) );
		}
		// wp_enqueue_script( 'wte-fpickr-l10n' );
		wp_enqueue_script( $this->plugin_name );
		wp_add_inline_script( $this->plugin_name, 'var WPTE_Price_Separator = "' . wte_array_get( $settings, 'thousands_separator', '' ) . '"; // Backward compatibility.' );
		wp_enqueue_style( $this->plugin_name );
		$wte_account_arr = array(
			'ajax_url'                => admin_url( 'admin-ajax.php' ),
			'change_user_profile_msg' => __( 'Click here or Drop new image to update your profile picture', 'wp-travel-engine' ),
		);
		wp_localize_script( $this->plugin_name, 'wte_account_page', $wte_account_arr );
	}

	/**
	 * Admin Assets.
	 */
	public function admin_enqueue_scripts() {
		// $this->register_scripts();
		// Admin Scripts.
		$screens        = array( 'trip', 'enquiry', 'booking', 'customer', 'wte-coupon', 'downloadfile' );
		$current_screen = get_current_screen();

		if ( ! $current_screen ) {
			return;
		}

		$screen_ids = array( 'trip_page_class-wp-travel-engine-admin' );

		$development = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		$suffix = $development ? '' : '';

		wp_enqueue_style( 'wte-plugins-php', plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/plugins-php{$suffix}.css", array(), $this->version );

		$dependencies = array(
			'jquery',
			'jquery-ui-core',
			'jquery-ui-datepicker',
			'jquery-ui-tabs',
			'jquery-ui-sortable',
			'toastr',
			'parsley',
			'wte-select2',
			'jquery-fancy-box',
			'wte-fpickr',
			'moment',
		);

		if ( $this->is_fontawesome_enabled() ) {
			$dependencies[] = 'wte-fontawesome-all';
			$dependencies[] = 'v4-shims';
		}

		if ( $current_screen && WP_TRAVEL_ENGINE_POST_TYPE === $current_screen->id ) {
			$dependencies[] = 'wte-redux';
			$dependencies[] = 'wte-rxjs';
		}

		$to_be_localized = array(
			'WTE_UI' => array(
				'handle' => "{$this->plugin_name}",
				'l10n'   => array(
					'suretodel'        => __( 'Sure to delete? This action cannot be reverted.', 'wp-travel-engine' ),
					'validation_error' => esc_html__( 'Validation Error. Settings could not be saved.', 'wp-travel-engine' ),
					'copied'           => esc_html__( 'Text copied to clipboard.', 'wp-travel-engine' ),
					'novid'            => esc_html__( 'No video URL supplied.', 'wp-travel-engine' ),
					'invalid_url'      => esc_html__( 'Invalid URL supplied. Please make sure to add valid YouTube or Vimeo video URL', 'wp-travel-engine' ),
				),
			),
		);

		$dashboard_assets           = require plugin_dir_path( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/dashboard/index.asset.php";
		$analytics_dashboard_assets = require plugin_dir_path( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/dashboard-analytics/index.asset.php";

		$this->register_scripts( [
			'wte-edit--coupon'                   => [
				'js' => [
					plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/coupon{$suffix}.js",
					array( 'jquery', 'wte-fpickr' ),
					$this->version,
					true,
				],
			],
			$this->plugin_name                   => [
				'js' => [
					plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/wte-admin{$suffix}.js",
					$dependencies,
					$this->version,
					true,
				],
			],
			"wptravelengine-dashboard"           => [
				'js' => [
					plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/dashboard/index.js",
					$dashboard_assets[ 'dependencies' ],
					$dashboard_assets[ 'version' ],
					true,
				],
			],
			"wptravelengine-dashboard-analytics" => [
				'js' => [
					plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/dashboard-analytics/index.js",
					$analytics_dashboard_assets[ 'dependencies' ],
					$analytics_dashboard_assets[ 'version' ],
					true,
				],
			],
		] );

		foreach ( apply_filters( 'wte_admin_localize_data', $to_be_localized ) as $object_name => $load ) {
			wp_localize_script( $load[ 'handle' ], $object_name, $load[ 'l10n' ] );
		}
		wp_register_style( $this->plugin_name . '_core_ui', plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . "dist/admin/wte-admin{$suffix}.css", array(
			'wte-select2',
			'wte-global',
			'datepicker-style',
			'animate',
			'toastr',
		), filemtime( WP_TRAVEL_ENGINE_ABSPATH . "dist/admin/wte-admin{$suffix}.css" ) );

		if ( in_array( $current_screen->post_type, $screens, true ) || ( isset( $_GET[ 'page' ] ) && 'class-wp-travel-engine-admin.php' === wp_unslash( $_GET[ 'page' ] ) ) || in_array( $current_screen->id, $screen_ids, true ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_enqueue_editor();
			wp_enqueue_media();
			wp_enqueue_script( 'wte-global' );
			wp_enqueue_style( 'wte-fpickr' );
			// wp_enqueue_script( 'wte-fpickr-l10n' );
			wp_enqueue_script( $this->plugin_name );

			// Styles.
			wp_enqueue_style( $this->plugin_name . '_core_ui' );
		}

		wp_register_style( 'wte-plugins-php', plugin_dir_url( WP_TRAVEL_ENGINE_FILE_PATH ) . 'dist/admin/plugins-php.css', array(), filemtime( WP_TRAVEL_ENGINE_ABSPATH . 'dist/admin/plugins-php.css' ) );
	}
}
