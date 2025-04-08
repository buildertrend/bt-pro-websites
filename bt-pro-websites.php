<?php
/*
Plugin Name: Buildertrend Pro Websites
Description: Our required plugin for sharing common functionality across our client sites. 
Version: 1.0.2.4
Author: John Stuifbergen
License: GPLv2 or later
Plugin URI:        https://github.com/buildertrend/bt-pro-websites
GitHub Plugin URI: https://github.com/buildertrend/bt-pro-websites
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the settings page code
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';


require plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/buildertrend/bt-pro-websites',
    __FILE__,
    'bt-pro-websites'
);

// Required for private repos:
// $updateChecker->setAuthentication('your_github_personal_access_token');

// Optional if you’re using a branch other than “master” (e.g., main)
$updateChecker->setBranch('main');

