<?php
/*
Plugin Name: Buildertrend Pro Websites
Description: Our required plugin for sharing common functionality across our client sites. 
Version: 1.0.3
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


// Dashboard Widget Content
function bt_pro_websites_dashboard_widget_content()
{
    // You can add any content or settings before the iframe
    echo '<div class="bt-dashboard-iframe-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;">';
    echo '<iframe src="https://www.wrike.com/form/eyJhY2NvdW50SWQiOjI1NzEyNTEsInRhc2tGb3JtSWQiOjcwMzkxNX0JNDgxMjA5OTQ0MjUxNAkwMGZhMDZjZjk5YjBiNDRkY2ZjNWUwYzJiM2M0OTJmZTgyMTJhNmJlNzJhMWM1MjI1N2Y1NDVmOTUwYWRlZWJi" width="100%" height="1400" frameborder="0"><span data-mce-type="bookmark" style="display: inline-block; width: 0px; overflow: hidden; line-height: 0;" class="mce_SELRES_start">﻿</span></iframe>';
    echo '</div>';

    // Optional: Add some content after the iframe
    echo '<p><small>Powered by Buildertrend Pro Websites</small></p>';
}