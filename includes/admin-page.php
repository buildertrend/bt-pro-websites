<?php

// Hook into the WordPress admin menu
add_action('admin_menu', 'bt_options_menu');

// Create the settings page
function bt_options_menu() {
    add_menu_page(
        'BT Options',               // Page title
        'BT Options',               // Menu title
        'manage_options',           // Capability required
        'bt-options',               // Menu slug
        'bt_options_page_content',  // Callback function
        'dashicons-admin-generic',  // Icon (optional)
        25                          // Position (optional)
    );
}

// Settings page content
function bt_options_page_content() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Save the form data
    if (isset($_POST['bt_options_save'])) {
        check_admin_referer('bt_options_nonce_action', 'bt_options_nonce_field');

        $bt_custom_option = sanitize_text_field($_POST['bt_custom_option']);
        update_option('bt_custom_option', $bt_custom_option);

        echo '<div class="updated"><p>Options saved!</p></div>';
    }

    // Get the current value
    $bt_custom_option = get_option('bt_custom_option', '');

    ?>
    <div class="wrap">
        <h1>BT Options</h1>
        <form method="post" action="">
            <?php wp_nonce_field('bt_options_nonce_action', 'bt_options_nonce_field'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="bt_custom_option">Custom Option</label>
                    </th>
                    <td>
                        <input type="text" name="bt_custom_option" id="bt_custom_option" value="<?php echo esc_attr($bt_custom_option); ?>" class="regular-text" />
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Options', 'primary', 'bt_options_save'); ?>
        </form>
    </div>
    <?php
}