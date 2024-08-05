<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://geekcodelab.com/
 * @since             1.0.0
 * @package           Conditional_Fields_In_Elementor_Form
 *
 * @wordpress-plugin
 * Plugin Name:       Conditional Fields in Elementor Form
 * Plugin URI:        https://geekcodelab.com/
 * Description:       Conditional Fields in Elementor Form helps you apply conditional logic to Elementor form fields. You can hide or show fields based on the input values from other form fields.
 * Version:           1.0.0
 * Author:            Geek Code Lab
 * Author URI:        https://geekcodelab.com//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       conditional-fields-in-elementor-form
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CONDITIONAL_FIELDS_IN_ELEMENTOR_FORM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-conditional-fields-in-elementor-form-activator.php
 */
function activate_conditional_fields_in_elementor_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-conditional-fields-in-elementor-form-activator.php';
	Conditional_Fields_In_Elementor_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-conditional-fields-in-elementor-form-deactivator.php
 */
function deactivate_conditional_fields_in_elementor_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-conditional-fields-in-elementor-form-deactivator.php';
	Conditional_Fields_In_Elementor_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_conditional_fields_in_elementor_form' );
register_deactivation_hook( __FILE__, 'deactivate_conditional_fields_in_elementor_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-conditional-fields-in-elementor-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_conditional_fields_in_elementor_form() {

	$plugin = new Conditional_Fields_In_Elementor_Form();
	$plugin->run();

}
run_conditional_fields_in_elementor_form();
