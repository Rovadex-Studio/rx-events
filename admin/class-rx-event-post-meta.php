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

// If class `Rx_Event_Post_Meta` doesn't exists yet.
if ( ! class_exists( 'Rx_Event_Post_Meta' ) ) {

	/**
	 * Rx_Event_Post_Meta class.
	 */
	class Rx_Event_Post_Meta {

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
			// Metaboxes rendering.
			//add_action( 'load-post.php',     array( $this, 'init' ), 10 );
			//add_action( 'load-post-new.php', array( $this, 'init' ), 10 );
			$this->init();
		}

		/**
		 * Init event post meta.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function init() {
			new Cherry_X_Post_Meta( array(
					'id'            => 'event-settings',
					'title'         => esc_html__( 'Event Settings', 'rx-events' ),
					'page'          => array( RX_EVENTS_SLUG ),
					'context'       => 'normal',
					'priority'      => 'high',
					'builder_cb'    => array( $this, 'get_interface_builder' ),
					'fields'        => $this->get_post_meta_fields(),
				)
			);
		}

		/**
		 * Return the interface builder instance .
		 *
		 * @since 1.0.0
		 * @access public
		 * @return o
		 */
		public function get_interface_builder() {
			return new CX_Interface_Builder(
				array(
					'path' => RX_EVENTS_DIR . 'cherry-x-framework/cherry-x-interface-builder/',
					'url'  => RX_EVENTS_URI . 'cherry-x-framework/cherry-x-interface-builder/',
				)
			);
		}

		/**
		 * Return the post meta fields.
		 *
		 * @since 1.0.0
		 * @access private
		 * @return o
		 */
		private function get_post_meta_fields() {
			$controll = apply_filters( 'rx_event_meta_controll', array(
				'settings_tab'   => array(
					'type'           => 'component-tab-vertical',
				),
			));

			$tabs = apply_filters( 'rx_event_meta_tabs', array(
				'information' => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Information', 'rx-events' ),
				),
				'date'  => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Date And Time', 'rx-events' ),
				),
				'schedule'  => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Schedule', 'rx-events' ),
				),
				'participant' => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Participant', 'rx-events' ),
				),
				'location' => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Location', 'rx-events' ),
				),
				'media' => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Media', 'rx-events' ),
				),
				/*'custom_fields' => array(
					'type'   => 'settings',
					'parent' => 'settings_tab',
					'title'  => esc_html__( 'Custom Fields', 'rx-events' ),
				),*/
			));

			$settings = apply_filters( 'rx_event_meta', array(

// Information
				'event_description'      => array(
					'type'        => 'textarea',
					'parent'      => 'information',
					'title'       => esc_html__( 'Event Description:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'event_website'      => array(
					'type'        => 'text',
					'parent'      => 'information',
					'title'       => esc_html__( 'Event Website:', 'rx-events' ),

					'placeholder' => esc_html__( 'your-website.com', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'contact_phone'      => array(
					'type'        => 'text',
					'parent'      => 'information',
					'title'       => esc_html__( 'Сontact Phone:', 'rx-events' ),
					'placeholder' => esc_html__( '+1 ( 415 ) 555 26 71', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),

// Date
				'time_format' => array(
					'type'        => 'select',
					'parent'      => 'date',
					'title'       => esc_html__( 'Time Format:', 'rx-events' ),
					//'description' => esc_html__( 'The frequency of repeat events.', 'rx-events' ),
					'value'       => 'hours_24',
					'options'     => array(
						'hours_24' => esc_html__( '24 hours', 'rx-events' ),
						'hours_12' => esc_html__( '12 hours', 'rx-events' ),

					),
					'conditions' => array(
						'repeat_event' => 'not_repeat',
					),
				),
				'repeat_event' => array(
					'type'        => 'select',
					'parent'      => 'date',
					'title'       => esc_html__( 'Repeat Event:', 'rx-events' ),
					//'description' => esc_html__( 'The frequency of repeat events.', 'rx-events' ),
					'value'       => 'not_repeat',
					'options'     => array(
						'not_repeat' => esc_html__( 'Not Repeat', 'rx-events' ),
						'every_day' => esc_html__( 'Every Day', 'rx-events' ),
						'every_week' => esc_html__( 'Every Week', 'rx-events' ),
						'every_month' => esc_html__( 'Every Month', 'rx-events' ),
						'every_year' => esc_html__( 'Every Year', 'rx-events' ),
					),
				),
				'start_event' => array(
					'type'   => 'settings',
					'parent' => 'date',
					'scroll' => false,
					'title'  => esc_html__( 'Start Event', 'rx-events' ),
				),
				'start_date'      => array(
					'type'        => 'datepicker',
					'parent'      => 'start_event',
					'view_wrapping' => false,
					'label'       => esc_html__( 'Start Date:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
					'value'       => '',
				),
				'start_day_of_the_week' => array(
					'type'        => 'select',
					'parent'      => 'start_event',
					'view_wrapping' => false,
					'label'       => esc_html__( 'Day of the week:', 'rx-events' ),
					//'description' => esc_html__( 'The frequency of repeat events.', 'rx-events' ),
					'value'       => 'not_repeat',
					'multiple'     => true,
					'filter'       => true,
					'options'     => array(
						'sunday'      => esc_html__( 'Sunday', 'rx-events' ),
						'monday'    => esc_html__( 'Monday', 'rx-events' ),
						'tuesday'  => esc_html__( 'Tuesday', 'rx-events' ),
						'wednesday' => esc_html__( 'Wednesday', 'rx-events' ),
						'thursday'  => esc_html__( 'Thursday', 'rx-events' ),
						'friday'  => esc_html__( 'Friday', 'rx-events' ),
						'saturday'  => esc_html__( 'Saturday', 'rx-events' ),
					),
					'conditions' => array(
						'repeat_event' => 'every_week',
					),
				),
				'start_hours'      => array(
					'type'        => 'stepper',
					'parent'      => 'start_event',
					'view_wrapping' => false,
					'value'       => '0',
					'max_value'   => '23',
					'min_value'   => '0',
					'step_value'  => '1',
					'label'       => esc_html__( 'Hours:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
					'value'       => '',
				),
				'start_minutes'      => array(
					'type'        => 'stepper',
					'parent'      => 'start_event',
					'view_wrapping' => false,
					'value'       => '0',
					'max_value'   => '59',
					'min_value'   => '0',
					'step_value'  => '1',
					'label'       => esc_html__( 'Minutes:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
					'value'       => '',
				),
				'start_time_of_day' => array(
					'type'        => 'select',
					'parent'      => 'start_event',
					'view_wrapping' => false,
					'label'       => esc_html__( 'Time Of Day:', 'rx-events' ),
					//'description' => esc_html__( 'The frequency of repeat events.', 'rx-events' ),
					'value'       => 'hours_24',
					'options'     => array(
						'am' => esc_html__( 'AM', 'rx-events' ),
						'pm' => esc_html__( 'PM', 'rx-events' ),
					),
				),

				'end_event' => array(
					'type'   => 'settings',
					'parent' => 'date',
					'scroll' => false,
					'title'  => esc_html__( 'End Event', 'rx-events' ),
				),
				'end_date'      => array(
					'type'        => 'text',
					'parent'      => 'end_event',
					'view_wrapping' => false,
					'label'       => esc_html__( 'Start Date:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
					'value'       => '',
				),
				'end_day_of_the_week' => array(
					'type'        => 'select',
					'parent'      => 'end_event',
					'view_wrapping' => false,
					'label'       => esc_html__( 'Day of the week:', 'rx-events' ),
					//'description' => esc_html__( 'The frequency of repeat events.', 'rx-events' ),
					'value'       => 'not_repeat',
					'options'     => array(
						'sunday'      => esc_html__( 'Sunday', 'rx-events' ),
						'monday'    => esc_html__( 'Monday', 'rx-events' ),
						'tuesday'  => esc_html__( 'Tuesday', 'rx-events' ),
						'wednesday' => esc_html__( 'Wednesday', 'rx-events' ),
						'thursday'  => esc_html__( 'Thursday', 'rx-events' ),
						'friday'  => esc_html__( 'Friday', 'rx-events' ),
						'saturday'  => esc_html__( 'Saturday', 'rx-events' ),
					),
				),
				'end_hours'      => array(
					'type'        => 'stepper',
					'parent'      => 'end_event',
					'view_wrapping' => false,
					'value'       => '0',
					'max_value'   => '23',
					'min_value'   => '0',
					'step_value'  => '1',
					'label'       => esc_html__( 'Hours:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
					'value'       => '',
				),
				'end_minutes'      => array(
					'type'        => 'stepper',
					'parent'      => 'end_event',
					'view_wrapping' => false,
					'value'       => '0',
					'max_value'   => '59',
					'min_value'   => '0',
					'step_value'  => '1',
					'label'       => esc_html__( 'Minutes:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
					'value'       => '',
				),
				'end_time_of_day' => array(
					'type'        => 'select',
					'parent'      => 'end_event',
					'view_wrapping' => false,
					'label'       => esc_html__( 'Time Of Day:', 'rx-events' ),
					//'description' => esc_html__( 'The frequency of repeat events.', 'rx-events' ),
					'value'       => 'hours_24',
					'options'     => array(
						'am' => esc_html__( 'AM', 'rx-events' ),
						'pm' => esc_html__( 'PM', 'rx-events' ),
					),
				),

// Schedule
				'event_schedule'      => array(
					'type'        => 'repeater',
					'parent'      => 'schedule',
					'label'       => esc_html__( 'Event Stages', 'rx-events' ),
					'add_label'   => esc_html__( 'Add Stage', 'rx-events' ),
					'title_field' => 'stage_title',
					'fields'      => array(
						'stage_start_hours'      => array(
							'type'          => 'stepper',
							'name'          => 'stage_start_hours',
							'id'            => 'stage_start_hours',
							'class'         => 'stages-time',
							'view_wrapping' => false,
							'value'         => '0',
							'max_value'     => '23',
							'min_value'     => '0',
							'step_value'    => '1',
							'label'         => esc_html__( 'Hours:', 'rx-events' ),
							'value'         => '0',
						),
						'stage_start_minutes'      => array(
							'type'        => 'stepper',
							'name'        => 'stage_start_minutes',
							'id'        => 'stage_start_minutes',
							'view_wrapping' => false,
							'value'       => '0',
							'max_value'   => '59',
							'min_value'   => '0',
							'step_value'  => '1',
							'label'       => esc_html__( 'Minutes:', 'rx-events' ),
							'value'       => '0',
						),
						'stage_start_time_of_day' => array(
							'type'        => 'select',
							'name'        => 'stage_start_time_of_day',
							'id'        => 'stage_start_time_of_day',
							'view_wrapping' => false,
							'label'       => esc_html__( 'Time Of Day:', 'rx-events' ),
							'value'       => 'am',
							'options'     => array(
								'am' => esc_html__( 'AM', 'rx-events' ),
								'pm' => esc_html__( 'PM', 'rx-events' ),
							),
						),
						'stage_end_hours'      => array(
							'type'        => 'stepper',
							'name'        => 'stage_end_hours',
							'id'        => 'stage_end_hours',
							'view_wrapping' => false,
							'value'       => '0',
							'max_value'   => '23',
							'min_value'   => '0',
							'step_value'  => '1',
							'label'       => esc_html__( 'Hours:', 'rx-events' ),
							//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
							'value'       => '',
						),
						'stage_end_minutes'      => array(
							'type'        => 'stepper',
							'name'        => 'stage_end_minutes',
							'id'        => 'stage_end_minutes',
							'view_wrapping' => false,
							'value'       => '0',
							'max_value'   => '59',
							'min_value'   => '0',
							'step_value'  => '1',
							'label'       => esc_html__( 'Minutes:', 'rx-events' ),
							'value'       => '',
						),
						'stage_end_time_of_day' => array(
							'type'        => 'select',
							'name'        => 'stage_end_time_of_day',
							'id'        => 'stage_end_time_of_day',
							'view_wrapping' => false,
							'label'       => esc_html__( 'Time Of Day:', 'rx-events' ),
							'value'       => 'am',
							'options'     => array(
								'am' => esc_html__( 'AM', 'rx-events' ),
								'pm' => esc_html__( 'PM', 'rx-events' ),
							),
						),
						'stage_title' => array(
							'type'        => 'text',
							'name'        => 'stage_title',
							'id'        => 'stage_title',
							'label'       => esc_html__( 'Title:', 'rx-events' ),
						),
						'stage_description' => array(
							'type'        => 'textarea',
							'name'        => 'stage_description',
							'id'        => 'stage_description',
							'label'       => esc_html__( 'Description:', 'rx-events' ),
						),
					),
				),

// Location
				'venue_name'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'Venue Name:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'address'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'Address:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'city'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'City:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'country'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'Country:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'state'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'State or Province:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'postal_code'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'Postal Code:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),
				'google_map'      => array(
					'type'        => 'text',
					'parent'      => 'location',
					'title'       => esc_html__( 'Google Map:', 'rx-events' ),
					//'description' => esc_html__( 'Label displayed before the date, for example, this may be the text "Start events".', 'rx-events' ),
				),

// Participant
				'organizers_title'      => array(
					'type'        => 'text',
					'parent'      => 'participant',
					'title'       => esc_html__( 'Organizers Title:', 'rx-events' ),
				),
				'organizers'      => array(
					'type'        => 'repeater',
					'parent'      => 'participant',
					'label'       => esc_html__( 'Event Organizers', 'rx-events' ),
					'add_label'   => esc_html__( 'Add People', 'rx-events' ),
					'title_field' => 'stage_title',
					'fields'      => array(
						'organizer_label'      => array(
							'type'        => 'text',
							'name'        => 'organizer_label',
							'id'          => 'organizer_label',
							'label'       => esc_html__( 'Organizer Label:', 'rx-events' ),
						),
						'organizer' => array(
							'type'        => 'select',
							'name'        => 'organizer',
							'id'          => 'organizer',
							'multiple'     => true,
							'filter'       => true,
							'label'       => esc_html__( 'Organizer:', 'rx-events' ),
							'options'     => array(),
						),
					),
				),

				'participants_title'      => array(
					'type'        => 'text',
					'parent'      => 'participant',
					'title'       => esc_html__( 'Participants Title:', 'rx-events' ),
				),
				'participants'      => array(
					'type'        => 'repeater',
					'parent'      => 'participant',
					'label'       => esc_html__( 'Event Participants', 'rx-events' ),
					'add_label'   => esc_html__( 'Add Participant', 'rx-events' ),
					'title_field' => 'stage_title',
					'fields'      => array(
						'participant_label'      => array(
							'type'        => 'text',
							'name'        => 'participants_label',
							'id'          => 'participants_label',
							'label'       => esc_html__( 'Participant Label:', 'rx-events' ),
						),
						'participant' => array(
							'type'        => 'select',
							'name'        => 'participant',
							'id'          => 'participant',
							'multiple'    => true,
							'filter'      => true,
							'label'       => esc_html__( 'Participant:', 'rx-events' ),
							'options'     => array(),
						),
					),
				),

				'sponsors_title'      => array(
					'type'        => 'text',
					'parent'      => 'participant',
					'title'       => esc_html__( 'Sponsors Title:', 'rx-events' ),
				),
				'sponsors'      => array(
					'type'        => 'repeater',
					'parent'      => 'participant',
					'label'       => esc_html__( 'Event Sponsors', 'rx-events' ),
					'add_label'   => esc_html__( 'Add Sponsor', 'rx-events' ),
					'title_field' => 'stage_title',
					'fields'      => array(
						'sponsors_label'      => array(
							'type'        => 'text',
							'name'        => 'sponsor_label',
							'id'          => 'sponsor_label',
							'label'       => esc_html__( 'Sponsor Label:', 'rx-events' ),
						),
						'sponsors' => array(
							'type'        => 'select',
							'name'        => 'sponsor',
							'id'          => 'sponsor',
							'multiple'    => true,
							'filter'      => true,
							'label'       => esc_html__( 'Sponsor:', 'rx-events' ),
							'options'     => array(),
						),
					),
				),

			));


			return array_merge( $controll, $tabs, $settings );
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
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
