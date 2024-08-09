<?php
/**
 * Plugin Name:       Conditional Fields in Elementor Form
 * Description:       Conditional Fields in Elementor Form helps you to show or hide fields based on input values from other fields using conditional logic.
 * Version:           1.0.0
 * Author:            Geek Code Lab
 * Author URI:        https://geekcodelab.com/
 * Requires Plugins:  elementor, elementor-pro
 * License:           GPLv2 or later
 * Text Domain:       conditional-fields-in-elementor-form
 * Elementor tested up to:     3.24.0
 * Elementor Pro tested up to: 3.24.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Defines plugin version.
 */
define( 'CFIEF_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-conditional-fields-form.php';

/**
 * Begins execution of the plugin.
 */
function run_conditional_fields_in_elementor_form() {

	$plugin = new Conditional_Fields_In_Elementor_Form();
	$plugin->run();
}
run_conditional_fields_in_elementor_form();