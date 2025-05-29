<?php
/*
Plugin Name: Buildertrend Pro Websites
Description: Our required plugin for sharing common functionality across our client sites. 
Version: 1.1.1
Author: BT Pro Websites Team
License: GPLv2 or later
Plugin URI:        https://github.com/buildertrend/bt-pro-websites
GitHub Plugin URI: https://github.com/buildertrend/bt-pro-websites
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}


require_once plugin_dir_path(__FILE__) . 'includes/check-for-updates.php';
require_once plugin_dir_path(__FILE__) . 'includes/enable-auto-updates.php';
require_once plugin_dir_path(__FILE__) . 'includes/format-numbers.php';
require_once plugin_dir_path(__FILE__) . 'includes/matterport.php';
require_once plugin_dir_path(__FILE__) . 'includes/platmap.php';
require_once plugin_dir_path(__FILE__) . 'includes/sitemap-utilities.php';
require_once plugin_dir_path(__FILE__) . 'includes/required-plugins.php';


// bt contcact form
// bt login box
// format prices
// required plugins
