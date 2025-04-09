<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// https://yourwebsite.com/wp-admin/index.php?reset_dashboard=1
function reset_my_dashboard_layout()
{
	// Check if the reset parameter is present and that the current user is allowed to reset it.
	if (isset($_GET['reset_dashboard']) && current_user_can('manage_options')) {
		$current_user = get_current_user_id();
		// Delete the ordering setting.
		delete_user_meta($current_user, 'meta-box-order_dashboard');
		// Delete the open/closed state setting.
		delete_user_meta($current_user, 'closedpostboxes_dashboard');

		// Redirect back to the dashboard to prevent resubmission.
		wp_redirect(admin_url('index.php'));
		exit;
	}
}
add_action('admin_init', 'reset_my_dashboard_layout');