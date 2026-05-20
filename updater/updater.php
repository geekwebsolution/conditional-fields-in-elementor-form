<?php

if (!defined('ABSPATH')) exit;

/**
 * License manager module
 */
function cfief_updater_utility() {
    $prefix = 'CFIEFWP_';
    $settings = [
        'prefix' => $prefix,
        'get_base' => CFIEF_PLUGIN_BASENAME,
        'get_slug' => CFIEF_PLUGIN_DIR,
        'get_version' => CFIEF_VERSION,
        'get_api' => 'https://download.geekcodelab.com/',
        'license_update_class' => $prefix . 'Update_Checker'
    ];

    return $settings;
}

function cfief_updater_activate() {

    // Refresh transients
    delete_site_transient('update_plugins');
    delete_transient('cfief_plugin_updates');
    delete_transient('cfief_plugin_auto_updates');
}

require_once(CFIEF_PLUGIN_DIR_PATH . 'updater/class-update-checker.php');
