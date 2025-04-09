<?php
// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

function remove_extra_dashboard_widgets()
{
    // Removing default widgets
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
    remove_action('welcome_panel', 'wp_welcome_panel');

    // Removing plugin-added dashboard widgets (ensure IDs match your setup)
    remove_meta_box('e-dashboard-overview', 'dashboard', 'normal');
    remove_meta_box('dashboard_last_modified_posts', 'dashboard', 'normal');
    remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');
    remove_meta_box('dashboard_widget', 'dashboard', 'normal');
    remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');
    remove_meta_box('wpseo-wincher-dashboard-overview', 'dashboard', 'normal');
}
add_action('admin_init', 'remove_extra_dashboard_widgets', 999);
