<?php
namespace WPTRAVELENGINEEB;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Widgets.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Widgets.
 *
 * @since 1.0.0
 */
class Widget extends Widget_Base {

	/**
	 * Constructor.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	/**
	 * Widget Name.
	 */
	public function get_name() {
		return $this->widget_name;
	}

	/**
	 * Widget Title.
	 */
	public function get_title() {
		return Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'title' );
	}

	/**
	 * Widget Icon.
	 */
	public function get_icon() {
		return Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'icon' );
	}

	/**
	 * Style dependencies.
	 */
	public function get_style_depends() {
		return array( 'wte-blocks-index', 'wte-fonts-style' );
	}

	/**
	 * Javascripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'wptravelengineeeb-trips' );
	}

	/**
	 * Widget categories.
	 */
	public function get_categories() {
		return array( 'wptravelengine' );
	}

	/**
	 * Get the image size options for the image size dropdown.
	 *
	 * @return array
	 */
	public function get_image_size_options( $block = false ) {
		$wp_image_sizes = $this->get_all_image_sizes();
		$image_sizes    = array();

		foreach ( $wp_image_sizes as $size_name => $size_attrs ) {
			$image_size_name = ucwords( str_replace( '_', ' ', $size_name ) );
			if ( is_array( $size_attrs ) ) {
				$image_size_name .= sprintf( ' - %d x %d', $size_attrs['width'], $size_attrs['height'] );
			}
			$image_sizes[ $size_name ] = $image_size_name;
		}

		// Add full and custom image sizes.
		$image_sizes['full'] = _x( 'Full', 'Image Size Control', 'wptravelengine-elementor-widgets' );

		if ( ! $block ) {
			$image_sizes['custom'] = _x( 'Custom', 'Image Size Control', 'wptravelengine-elementor-widgets' );
		}
		return $image_sizes;
	}

	/**
	 * Get all image size options
	 *
	 * @return array
	 */
	public function get_all_image_sizes() {
		global $_wp_additional_image_sizes;

		$default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );

		$image_sizes = array();

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ] = array(
				'width'  => (int) get_option( $size . '_size_w' ),
				'height' => (int) get_option( $size . '_size_h' ),
				'crop'   => (bool) get_option( $size . '_crop' ),
			);
		}

		if ( $_wp_additional_image_sizes ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		return apply_filters( 'wte_blocks_image_sizes', $image_sizes );
	}

	/**
	 * Get the image width and height values for custom image size.
	 *
	 * @param string $image_custom_size Image size array.
	 *
	 * @return array
	 */
	public static function wte_get_custom_image_size( $image_custom_size ) {
		$attachment_size = array(
			0 => null, // Width.
			1 => null, // Height.
		);

		if ( is_array( $image_custom_size ) ) {
			if ( ! empty( $image_custom_size['width'] ) ) {
				$attachment_size[0] = $image_custom_size['width'];
			}

			if ( ! empty( $image_custom_size['height'] ) ) {
				$attachment_size[1] = $image_custom_size['height'];
			}
		} else {
			$attachment_size = 'full';
		}

		return $attachment_size;
	}

	/**
	 * Adds controls from
	 */
	protected function _wte_add_controls( $controls ) {
		foreach ( $controls as $id => $args ) {
			$args  = (object) $args;
			$label = isset( $args->label ) ? $args->label : __( 'Untitled', 'wptravelengine-elementor-widgets' );

			if ( ! isset( $args->type ) ) {
				continue;
			}
			if ( isset( $args->is_responsive ) && $args->is_responsive == true ) {
				$args->name = $id;
				if ( ! isset( $args->default ) ) {
					$args->default = '';
				}
				if ( ! isset( $args->condition ) ) {
					$args->condition = '';
				}
				$this->add_responsive_control(
					$args->name,
					array(
						'type'      => $args->type,
						'label'     => $args->label,
						'default'   => $args->default,
						'condition' => $args->condition,
					)
				);
				continue;
			}
			if ( 'control_section' === $args->type ) {
				if ( isset( $args->subcontrols ) ) {
					if ( ! isset( $args->condition ) ) {
						$args->condition = '';
					}
					$this->start_controls_section(
						$id,
						array(
							'label'     => $args->label,
							'condition' => $args->condition,
						)
					);
					$this->_wte_add_controls( $args->subcontrols );
					$this->end_controls_section();
				}
				continue;
			}
			$control_args = array();
			switch ( $args->type ) {
				case \Elementor\Controls_Manager::TAB_STYLE:
					if ( ! isset( $args->condition ) ) {
						$args->condition = '';
					}
					$this->start_controls_section(
						$id,
						array(
							'label'     => $args->label,
							'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
							'condition' => $args->condition,
						)
					);
						$this->_wte_add_controls( $args->subcontrols );
					$this->end_controls_section();
					continue 2;
				case 'start_controls_tabs':
					$this->start_controls_tabs( $id );
						$this->_wte_add_controls( $args->tabs );
					$this->end_controls_tabs();
					continue 2;
				case 'start_controls_tab':
					$this->start_controls_tab(
						$id,
						array(
							'label' => $args->label,
						)
					);
						$this->_wte_add_controls( $args->subcontrols );
					$this->end_controls_tab();
					continue 2;
				case \Elementor\Controls_Manager::COLOR:
					if ( ! isset( $args->label ) ) {
						$args->label = __( 'Background Color', 'wptravelengine-elementor-widgets' );
					}
					break;
				case \Elementor\Controls_Manager::WYSIWYG:
					break;
				case \Elementor\Controls_Manager::URL:
					break;
				case \Elementor\Controls_Manager::NUMBER:
					break;
				case \Elementor\Controls_Manager::SWITCHER:
					break;
				case \Elementor\Controls_Manager::ICONS:
					break;
				case \Elementor\Controls_Manager::DIMENSIONS:
					$args->name = $id;
					$this->add_responsive_control(
						$id,
						(array) $args
					);
					continue 2;
				case \Elementor\Controls_Manager::CHOOSE:
					break;
				case \Elementor\Controls_Manager::SLIDER:
					$args->name = $id;
					$this->add_responsive_control(
						$id,
						(array) $args
					);
					continue 2;
				case \Elementor\Group_Control_Box_Shadow::get_type():
					if ( ! isset( $args->label ) ) {
						$args->label = __( 'Box Shadow', 'wptravelengine-elementor-widgets' );
					}
					$args->name = $id;
					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						(array) $args
					);
					continue 2;
				case \Elementor\Group_Control_Text_Stroke::get_type():
					if ( ! isset( $args->label ) ) {
						$args->label = __( 'Text Stroke', 'wptravelengine-elementor-widgets' );
					}
					$args->name = $id;
					$this->add_group_control(
						\Elementor\Group_Control_Text_Stroke::get_type(),
						(array) $args
					);
					continue 2;
				case \Elementor\Group_Control_Text_Shadow::get_type():
					if ( ! isset( $args->label ) ) {
						$args->label = __( 'Text Shadow', 'wptravelengine-elementor-widgets' );
					}
					$args->name = $id;
					$this->add_group_control(
						\Elementor\Group_Control_Text_Shadow::get_type(),
						(array) $args
					);
					continue 2;
				case \Elementor\Group_Control_Border::get_type():
					if ( ! isset( $args->label ) ) {
						$args->label = __( 'Box Shadow', 'wptravelengine-elementor-widgets' );
					}
					$args->name = $id;
					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						(array) $args
					);
					continue 2;
				case \Elementor\Group_Control_Typography::get_type():
					if ( ! isset( $args->label ) ) {
						$args->label = __( 'Typography', 'wptravelengine-elementor-widgets' );
					}
					$args->name = $id;
					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						(array) $args
					);
					continue 2;
				case 'TAXONOMY_TERMS_SELECT2':
					if ( ! isset( $args->taxonomy_name ) ) {
						break;
					}
					$options       = \wte_get_terms_by_id(
						$args->taxonomy_name,
						array(
							'number'     => 100,
							'hide_empty' => true,
						)
					);
					$args->type    = \Elementor\Controls_Manager::SELECT2;
					$args->options = array();
					if ( is_array( $options ) ) {
						foreach ( $options as $option ) {
							$args->options[ $option->term_id ] = $option->name;
						}
					}
					break;
				case 'tripselector':
					$args->type  = 'tripselector';
					$args->label = 'Select Trips';
					break;
				case 'TRIP_SELECT2':
					$trips         = get_posts(
						array(
							'post_type'      => WP_TRAVEL_ENGINE_POST_TYPE,
							'posts_per_page' => '-1',
							'post_status'    => 'publish',
						)
					);
					$args->type    = \Elementor\Controls_Manager::SELECT2;
					$args->options = array();
					if ( is_array( $trips ) ) {
						foreach ( $trips as $trip ) {
							$args->options[ $trip->ID ] = $trip->post_title;
						}
					}
					break;
				default:
					if ( defined( "\Elementor\Controls_Manager::{$args->type}" ) ) {
						$args->type = \constant( "\Elementor\Controls_Manager::{$args->type}" );
						break;
					}
					$args->type = \Elementor\Controls_Manager::TEXT;
					break;
			}

			$this->add_control(
				$id,
				(array) $args
			);
		}
	}

	/**
	 * Widget Settigs.
	 */
    protected function register_controls() { // phpcs:ignore
		wp_enqueue_style( 'wte-fonts-style' );
		$settings = Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'controls' );
		$controls = isset( $settings['controls'] ) && is_array( $settings['controls'] ) ? $settings['controls'] : array();
		$this->_wte_add_controls( $settings );
	}

	/**
	 * Final output.
	 */
	protected function render() {
		$attributes                       = $this->get_settings_for_display();
		$attributes['default_taxonomies'] = array(
			'destination',
			'activities',
			'trip_types',
			'difficulty',
			'trip_tag',
		);

		$settings = Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name );

		if ( isset( $settings['render'] ) && \is_callable( $settings['render'] ) ) {
			\call_user_func( $settings['render'], $attributes );
		} else {
			echo __( '<p>Oops! No preview/output available for this widget.</p>', 'wptravelengine-elementor-widgets' );
		}
	}

	/**
	 * Checks if is elementor editor page.
	 *
	 * @return boolean
	 */
	protected function is_elementor_editor_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing.
		$post_editor_id = isset( $_POST['editor_post_id'] ) ? absint( wp_unslash( $_POST['editor_post_id'] ) ) : null;
		$get_action     = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : null;
		$get_post       = isset( $_GET['post'] ) ? sanitize_text_field( wp_unslash( $_GET['post'] ) ) : null;
		return $post_editor_id || ( $get_post && 'elementor' === $get_action );
	}
}
