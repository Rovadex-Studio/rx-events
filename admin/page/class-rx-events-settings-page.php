<?php
/**
 * Sets up the plugin option page.
 *
 * @package    Rx_Events
 * @subpackage Admin
 * @author     Rovadex Team
 * @license    GPL-3.0+
 * @copyright  2017, Rovadex Team
 */

// If class `Rx_Events_Settings_Page` doesn't exists yet.
if ( ! class_exists( 'Rx_Events_Settings_Page' ) ) {

	/**
	 * Rx_Events_Settings_Page class.
	 */
	class Rx_Events_Settings_Page extends Rx_Events_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var object
		 */
		private static $instance = null;

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			parent::__construct();
			$this->render_page();
		}

		/**
		 * Build plugin options page.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function render_page( $render = true ) {
			$builder = new CX_Interface_Builder(
				array(
					'path' => RX_EVENTS_DIR . 'cherry-x-framework/cherry-x-interface-builder/',
					'url'  => RX_EVENTS_URI . 'cherry-x-framework/cherry-x-interface-builder/',
				)
			);

			$builder->register_form( $this->form );

			$builder->register_section( $this->section );

			$builder->register_component( $this->component_tab );

			$builder->register_settings( $this->tabs );

			$builder->register_html( $this->info );

			$builder->register_control( $this->settings );

			$builder->register_control( $this->buttons );

			$builder->render();
		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}
