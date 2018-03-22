<?php
/**
 * Sets up the admin functionality for the plugin.
 *
 * @package    Rx_Events
 * @subpackage Admin
 * @author     Rovadex Team
 * @license    GPL-3.0+
 * @copyright  2017, Rovadex Team
 */

// If class `Rx_Events_Admin` doesn't exists yet.
if ( ! class_exists( 'Rx_Events_Admin' ) ) {

	/**
	 * Rx_Events_Admin class.
	 */
	class Rx_Events_Admin {

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

			// Initialization of modules.
			$this->init_modules();

			// Include libraries from the `includes/admin`
			add_action( 'after_setup_theme', array( $this, 'includes' ), 1 );

			// Load the admin menu.
			add_action( 'admin_menu', array( $this, 'menu' ) );

			// Enqueue assets.
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_assets' ) );

			// Set default options
			add_action( 'admin_init', array( $this, 'set_default_settings' ) );
		}

		/**
		 * Include libraries from the `admin`.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function includes() {
			// Include plugin post and post meta.
			require_once( trailingslashit( RX_EVENTS_DIR ) . 'admin/post/class-rx-event-post-meta.php' );
			require_once( trailingslashit( RX_EVENTS_DIR ) . 'admin/post/class-rx-register-post-type.php' );

			// Include plugin settings and ajax handlers.
			require_once( trailingslashit( RX_EVENTS_DIR ) . 'admin/class-rx-events-settings.php' );

			// Include plugin pages.
			//require_once( trailingslashit( RX_EVENTS_DIR ) . 'admin/page/class-rx-events-ajax-handlers.php' );
			require_once( trailingslashit( RX_EVENTS_DIR ) . 'admin/page/class-rx-events-settings-page.php' );

			/*// Include plugin shortcode.
			require_once( trailingslashit( RX_EVENTS_DIR ) . 'includes/admin/class-rx-events-register-shortcodes.php' );*/
		}

		/**
		 * Register the admin menu.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function menu() {
			global $submenu;

			add_menu_page(
				esc_html__( 'RX Events', 'rx-events' ),
				esc_html__( 'RX Events', 'rx-events' ),
				'edit_theme_options',
				'rx-events',
				'',
				'dashicons-calendar-alt',
				100
			);

			add_submenu_page(
				'rx-events',
				esc_html__( 'Settings', 'rx-events' ),
				esc_html__( 'Settings', 'rx-events' ),
				'edit_theme_options',
				'rx-events-settings-page',
				array( 'Rx_Events_Settings_Page', 'get_instance' )
			);

			unset( $submenu['rx-events'][0] );
		}

		/**
		 * Write default settings to database.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function set_default_settings() {
			//$cherry_search_settings = Rx_Events_Settings::get_instance();
			//$cherry_search_settings -> set_default_settings();
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init_modules() {
			//cherry_search()->get_core()->init_module( 'cherry-utility', array() );
			//cherry_search()->get_core()->init_module( 'cherry-interface-builder', array() );
		}

		/**
		 * Enqueue admin assets.
		 *
		 * @since 1.0.0
		 */
		public function admin_enqueue_assets() {
			if ( self::is_plugin_page() ) {
				wp_enqueue_script('admin-rx-events');
				wp_enqueue_style('admin-rx-events');
			}
		}

		/**
		 * Check current plugin page.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return bool
		 */
		public static function is_plugin_page() {
			$screen = get_current_screen();

			return ( ! empty( $screen->base ) && false !== strpos( $screen->base, RX_EVENTS_SLUG ) ) ? true : false ;
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

if ( ! function_exists( 'rx_events_admin' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function rx_events_admin() {
		return Rx_Events_Admin::get_instance();
	}

	rx_events_admin();
}
