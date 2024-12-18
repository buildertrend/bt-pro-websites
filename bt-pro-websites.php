<?php
/*
Plugin Name: Buildertrend Pro Websites
Description: Our required plugin for sharing common functionality across our client sites. 
Version: 1.0.2.1
Author: John Stuifbergen
License: GPLv2 or later
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the settings page code
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';


add_filter('auto_update_plugin', 'bt_force_auto_update', 10, 2);

function bt_force_auto_update($update, $item) {
    if (isset($item->slug) && $item->slug === 'buildertrend-pro-websites') {
        return true;  // Enable auto-updates for this plugin
    }
    return $update;
}