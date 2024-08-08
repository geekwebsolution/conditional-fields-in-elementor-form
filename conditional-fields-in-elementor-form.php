<?php
/**
 * Plugin Name:       Conditional Fields in Elementor Form
 * Description:       Conditional Fields in Elementor Form helps you apply conditional logic to Elementor form fields. You can hide or show fields based on the input values from other form fields.
 * Version:           1.0.0
 * Author:            Geek Code Lab
 * Author URI:        https://geekcodelab.com/
 * Requires Plugins:  elementor-pro
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       conditional-fields-in-elementor-form
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
define( 'EF_CONDITIONAL_FIELDS_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-conditional-fields-form.php';

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