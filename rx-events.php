<?php
/**
 * Plugin Name: RX Events
 * Plugin URI:  https://rovadex.com/
 * Description: A plugin for WordPress.
 * Version:     1.0.0
 * Author:      Rovadex Team
 * Author URI:  https://rovadex.com/
 * Text Domain: rx-events
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Rx_Events` doesn't exists yet.
if ( ! class_exists( 'Rx_Events' ) ) {
	/**
	 * Sets up and initializes the RX Events.
	 */
	class Rx_Events {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @access private
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// Set the constants needed by the plugin.
			add_action( 'after_setup_theme', array( $this, 'constants' ), -50 );

			// Internationalize the text strings used.
			add_action( 'plugins_loaded', array( $this, 'lang' ), 1 );

			// Initialization of modules.
			add_action( 'after_setup_theme', array( $this, 'framework_loader' ), -20 );

			// Load the include files.
			add_action( 'after_setup_theme', array( $this, 'includes' ), 11 );

			// Register assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_assets' ), 10 );

			// Enqueue assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 11 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_assets' ), 11 );

		}

		/**
		 * Defines constants for the plugin.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function constants() {

			/**
			 * Set the version number of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'RX_EVENTS_VERSION', '1.0.0' );

			/**
			 * Set the slug of the plugin.
			 *
			 * @since 1.0.0
			 */
			define( 'RX_EVENTS_SLUG', basename( dirname( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin directory.
			 *
			 * @since 1.0.0
			 */
			define( 'RX_EVENTS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

			/**
			 * Set constant path to the plugin URI.
			 *
			 * @since 1.0.0
			 */
			define( 'RX_EVENTS_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		/**
		 * Run initialization of modules.
		 *
		 * @since 1.0.0
		 */
		public function framework_loader() {
			require_once ( RX_EVENTS_DIR . 'cherry-x-framework/loader.php' );

			new CX_Loader(
				array(
					RX_EVENTS_DIR . 'cherry-x-framework/cherry-x-interface-builder/cherry-x-interface-builder.php',
					RX_EVENTS_DIR . 'cherry-x-framework/cherry-x-post-meta/cherry-x-post-meta.php',
				)
			);
		}

		/**
		 * Loads admin files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function includes() {
			if ( is_admin() ) {
				require_once( RX_EVENTS_DIR . 'admin\class-rx-register-post-type.php' );
				require_once( RX_EVENTS_DIR . 'admin\class-rx-event-post-meta.php' );
			} else {

			}
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'rx-events', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Register assets.
		 *
		 * @since 1.0.0
		 */
		public function register_assets() {
			// Register Style Sheets.
			wp_register_style( 'rx-events', esc_url( RX_EVENTS_URI . 'assets/css/min/rx-events.min.css' ), array(), CHERRY_SEARCH_VERSION, 'all' );
			// Register JavaScripts.
			wp_register_script( 'rx-events',esc_url( RX_EVENTS_URI . 'assets/js/min/rx-events.min.js' ), array(), CHERRY_SEARCH_VERSION, true );
		}

		/**
		 * Register admin assets.
		 *
		 * @since 1.0.0
		 */
		public function admin_register_assets() {
			// Register Style Sheets.
			wp_register_style( 'admin-rx-events', esc_url( RX_EVENTS_URI . 'assets/css/min/admin-rx-events.min.css' ), array(), CHERRY_SEARCH_VERSION, 'all' );
			// Register JavaScripts.
			wp_register_script( 'admin-rx-events',esc_url( RX_EVENTS_URI . 'assets/js/min/admin-rx-events.min.js' ), array(), CHERRY_SEARCH_VERSION, true );
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_assets() {
			wp_enqueue_script('rx-events');
			wp_enqueue_style('rx-events');
		}

		/**
		 * Enqueue admin assets.
		 *
		 * @since 1.0.0
		 */
		public function admin_enqueue_assets() {
			wp_enqueue_script('admin-rx-events');
			wp_enqueue_style('admin-rx-events');
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

if ( ! function_exists( 'rx_events' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function rx_events() {
		return Rx_Events::get_instance();
	}

	rx_events();
}
