<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://geekcodelab.com/
 * @since      1.0.0
 *
 * @package    Conditional_Fields_In_Elementor_Form
 * @subpackage Conditional_Fields_In_Elementor_Form/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Conditional_Fields_In_Elementor_Form
 * @subpackage Conditional_Fields_In_Elementor_Form/includes
 * @author     Geek Code Lab <support@geekcodelab.com>
 */
class Conditional_Fields_In_Elementor_Form_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'conditional-fields-in-elementor-form',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
