<?php
/**
 * Class for the building datepicker elements.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'CX_Control_Datepicker' ) ) {

	/**
	 * Class for the building CX_Control_Datepicker elements.
	 */
	class CX_Control_Datepicker extends CX_Controls_Base {

		/**
		 * Default settings.
		 *
		 * @since 1.0.0
		 * @var array
		 */
		public $defaults_settings = array(
			'id'     => 'cx-datepicker-id',
			'name'   => 'cx-datepicker-name',
			'value'  => '',
			'label'  => '',
			'class'  => '',

			'minDate'  => '',
			'maxDate'  => '',
		);

		/**
		 * Register control dependencies
		 *
		 * @return [type] [description]
		 */
		public function register_depends() {
			wp_register_script(
				'cx-datepicker',
				$this->base_url . 'assets/lib/datepicker/datepicker.min.js',
				array( 'jquery' ),
				'2.2.3',
				true
			);

			wp_register_style(
				'cx-datepicker',
				$this->base_url . 'assets/lib/datepicker/datepicker.min.css',
				array(),
				'2.2.3',
				'all'
			);
		}

		/**
		 * Retrun scripts dependencies list for current control.
		 *
		 * @return array
		 */
		public function get_script_depends() {
			return array( 'cx-datepicker' );
		}

		/**
		 * Retrun styles dependencies list for current control.
		 *
		 * @return array
		 */
		public function get_style_depends() {
			return array( 'cx-datepicker' );
		}

		/**
		 * Render html CX_Control_Datepicker.
		 *
		 * @since 1.0.0
		 */
		public function render() {

			$html  = '';
			$class = implode( ' ',
				array(
					$this->settings['class'],
				)
			);

			$html .= '<div class="cx-ui-container ' . esc_attr( $class ) . '">';
				if ( '' !== $this->settings['label'] ) {
					$html .= '<label class="cx-label" for="' . esc_attr( $this->settings['id'] ) . '">' . esc_html( $this->settings['label'] ) . '</label> ';
				}
				$html .= '<div class="cx-ui-datepicker-wrapper">';
					$html .= '<input type="text" id="' . esc_attr( $this->settings['id'] ) . '" class="cx-ui-datepicker" name="' . esc_attr( $this->settings['name'] ) . '" value="' . esc_html( $this->settings['value'] ) . '"/>';
				$html .= '</div>';
			$html .= '</div>';

			return $html;
		}
	}
}
