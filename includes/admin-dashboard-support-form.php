<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// Add Dashboard Widget with iframe
function bt_pro_websites_add_dashboard_widget()
{
	wp_add_dashboard_widget(
		'bt_pro_websites_dashboard_widget',      // Widget slug
		'Buildertrend Updates',                  // Title
		'bt_pro_websites_dashboard_widget_content' // Display function
	);

	// Move widget to the top of the right column
	// default to left column
	global $wp_meta_boxes;

	// Options for $context are 'normal', 'side', or 'advanced'
	// Options for $priority are 'high', 'core', 'default', or 'low'
	$context = 'normal';   // Main column
	$priority = 'high';    // Top of the column

	// Backup and remove widget from the 'normal' location
	$widget = $wp_meta_boxes['dashboard'][$context]['core']['bt_pro_websites_dashboard_widget'];
	unset($wp_meta_boxes['dashboard'][$context]['core']['bt_pro_websites_dashboard_widget']);

	// Place the widget in the 'side' location at the top
	$wp_meta_boxes['dashboard'][$context]['core']['bt_pro_websites_dashboard_widget'] = $widget;
}
add_action('wp_dashboard_setup', 'bt_pro_websites_add_dashboard_widget');

// Dashboard Widget Content
function bt_pro_websites_dashboard_widget_content()
{
	echo '<div class="bt-dashboard-iframe-container" style="width: 100%;">';
	echo '<iframe src="https://www.wrike.com/form/eyJhY2NvdW50SWQiOjI1NzEyNTEsInRhc2tGb3JtSWQiOjcwMzkxNX0JNDgxMjA5OTQ0MjUxNAkwMGZhMDZjZjk5YjBiNDRkY2ZjNWUwYzJiM2M0OTJmZTgyMTJhNmJlNzJhMWM1MjI1N2Y1NDVmOTUwYWRlZWJi" width="100%" height="600" frameborder="0" scrolling="auto"></iframe>';
	echo '</div>';
}