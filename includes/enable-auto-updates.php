<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Enable auto-updates for this plugin
 */
function bt_pro_websites_enable_auto_updates()
{
	$plugin_file = plugin_basename(dirname(__DIR__) . '/bt-pro-websites.php');

	// For WordPress 5.5 and later
	if (
		function_exists('wp_is_auto_update_enabled_for_type') &&
		wp_is_auto_update_enabled_for_type('plugin')
	) {

		// Enable auto-updates for this plugin
		add_filter('auto_update_plugin', function ($update, $item) use ($plugin_file) {
			// If it's our plugin, return true to enable auto-updates
			if ($item->plugin === $plugin_file) {
				return true;
			}
			// Don't modify update behavior for other plugins
			return $update;
		}, 10, 2);
	}
}
add_action('admin_init', 'bt_pro_websites_enable_auto_updates');