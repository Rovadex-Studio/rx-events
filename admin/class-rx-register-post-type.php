<?php
/**
 * Sets up the admin functionality for the plugin.
 *
 * @package    Rx_Event
 * @subpackage Admin
 * @author     Rovadex Team
 * @license    GPL-3.0+
 * @copyright  2017, Rovadex Team
 */

// If class `Rx_Registe_Event_Post` doesn't exists yet.
if ( ! class_exists( 'Rx_Registe_Event_Post' ) ) {

	/**
	 * Rx_Registe_Event_Post class.
	 */
	class Rx_Registe_Event_Post {

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
			add_action( 'init', array( $this, 'register_event_tags' ), 0 );
			add_action( 'init', array( $this, 'register_event_categories' ), 1 );
			add_action( 'init', array( $this, 'register_post_types' ), 2 );
			//add_action( 'init', array( $this, 'init_post_meta' ), 3 );
			$this->init_post_meta();
		}

		/**
		 * Register new post types - events.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function register_post_types() {
			register_post_type( RX_EVENTS_SLUG, array(
				'labels'            => array(
					'menu_name'          => esc_html( 'Events', 'rx-events' ),
					'name'               => esc_html( 'Events', 'rx-events' ),
					'singular_name'      => esc_html( 'Event', 'rx-events' ),
					'add_new'            => esc_html( 'Add Event', 'rx-events' ),
					'add_new_item'       => esc_html( 'Your Event', 'rx-events' ),
					'edit_item'          => esc_html( 'Edit Event', 'rx-events' ),
					'new_item'           => esc_html( 'New Event', 'rx-events' ),
					'view_item'          => esc_html( 'View Event', 'rx-events' ),
					'search_items'       => esc_html( 'Serch Event', 'rx-events' ),
					'not_found'          => esc_html( 'Event not found', 'rx-events' ),
					'not_found_in_trash' => esc_html( 'Event not found in basket', 'rx-events' ),
				),
				'description'       => '',
				'supports'          => array(
					'title',
					'editor',
					//'excerpt',
					'comments',
					'thumbnail',
					'revisions',
				),
				'show_in_nav_menus' => true,
				'show_in_admin_bar' => true,
				'menu_icon'         => 'dashicons dashicons-carrot',
				'show_in_rest'      => true,
				'public'            => true,
				'rewrite'           => true,
				'query_var'         => true,
				'has_archive'       => true,
				//'taxonomies'          => array( RX_EVENTS_SLUG . '_tag', RX_EVENTS_SLUG . '_category' ),
			) );
		}

		/**
		 * Register new event tags.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function register_event_tags() {
			/*register_taxonomy( RX_EVENTS_SLUG . '_tag', array( RX_EVENTS_SLUG ), array(
					'label'                 => 'tags', // определяется параметром $labels->name
					'labels'                => array(
						'name'              => 'Genres',
						'singular_name'     => 'Genre',
						'search_items'      => 'Search Genres',
						'all_items'         => 'All Genres',
						'view_item '        => 'View Genre',
						'parent_item'       => 'Parent Genre',
						'parent_item_colon' => 'Parent Genre:',
						'edit_item'         => 'Edit Genre',
						'update_item'       => 'Update Genre',
						'add_new_item'      => 'Add New Genre',
						'new_item_name'     => 'New Genre Name',
						'menu_name'         => 'Genre',
					),
					'description'           => '', // описание таксономии
					'public'                => true,
				)
			);*/
		}

		/**
		 * Register new event tags.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function register_event_categories() {

		}

		/**
		 * Init post meta.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init_post_meta() {
			Rx_Event_Post_Meta::get_instance();
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

if ( ! function_exists( 'Rx_Registe_Event_Post' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function rx_registe_event_post() {
		return Rx_Registe_Event_Post::get_instance();
	}

	rx_registe_event_post();
}
