<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Install and activate required plugins for Buildertrend sites
 */
class BT_Required_Plugins {

    // List of required plugins in format: 'plugin-slug' => 'Plugin Name'
    private $required_plugins = [
        // Premium plugins
        'advanced-custom-fields-pro' => 'Advanced Custom Fields Pro',
        'elementor-pro' => 'Elementor Pro',
        'gravityforms' => 'Gravity Forms',
        
        // Free plugins
        'elementor' => 'Elementor',
        'wordpress-seo' => 'Yoast SEO',
        'wp-mail-smtp' => 'WP Mail SMTP',
        'user-role-editor' => 'User Role Editor',
        'disable-gutenberg' => 'Disable Gutenberg',
        'bt-website-support' => 'Buildertrend Website Support', // GitHub plugin
    ];
    
    // Define GitHub plugins with their repository URLs
    private $github_plugins = [
        'bt-website-support' => 'https://github.com/buildertrend/bt-website-support',
    ];
    
    // Define premium plugins
    private $premium_plugins = [
        'advanced-custom-fields-pro' => 'https://www.advancedcustomfields.com/pro/',
        'elementor-pro' => 'https://elementor.com/pro/',
        'gravityforms' => 'https://www.gravityforms.com/my-account/licenses/',
    ];

    /**
     * Constructor
     */
    public function __construct() {
        // Hook into admin_init to check for required plugins
        add_action('admin_init', array($this, 'check_required_plugins'));
        
        // Add admin notice if plugins need installation
        add_action('admin_notices', array($this, 'plugin_notice'));
        
        // Handle plugin installation request
        add_action('admin_post_install_bt_required_plugins', array($this, 'handle_plugin_installation'));
    }

    /**
     * Check if all required plugins are installed and activated
     */
    public function check_required_plugins() {
        // Only show to administrators
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $this->missing_plugins = $this->get_missing_plugins();
        
        if (!empty($this->missing_plugins)) {
            // Show admin notice
            add_action('admin_notices', array($this, 'plugin_notice'));
        }
    }
    
    /**
     * Get list of missing plugins
     */
    public function get_missing_plugins() {
        $missing_plugins = [];
        
        foreach ($this->required_plugins as $slug => $name) {
            if (!$this->is_plugin_active($slug)) {
                $missing_plugins[$slug] = $name;
            }
        }
        
        return $missing_plugins;
    }
    
    /**
     * Check if a plugin is active
     */
    private function is_plugin_active($plugin_slug) {
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        // Special cases for specific plugins
        switch ($plugin_slug) {
            case 'advanced-custom-fields-pro':
                return is_plugin_active('advanced-custom-fields-pro/acf.php');
                
            case 'elementor-pro':
                return is_plugin_active('elementor-pro/elementor-pro.php');
                
            case 'wordpress-seo':
                return is_plugin_active('wordpress-seo/wp-seo.php');
                
            case 'wp-mail-smtp':
                return is_plugin_active('wp-mail-smtp/wp_mail_smtp.php') || 
                       is_plugin_active('wp-mail-smtp-pro/wp_mail_smtp.php');
                
            case 'elementor':
                return is_plugin_active('elementor/elementor.php');
                
            case 'bt-website-support':
                return is_plugin_active('bt-website-support/bt-website-support.php');
                
            case 'gravityforms':
                return is_plugin_active('gravityforms/gravityforms.php');
                                
            case 'user-role-editor':
                return is_plugin_active('user-role-editor/user-role-editor.php');
                
            case 'disable-gutenberg':
                return is_plugin_active('disable-gutenberg/disable-gutenberg.php');
                
            default:
                // Standard check for other plugins
                $plugin_patterns = [
                    "$plugin_slug/$plugin_slug.php",
                    "$plugin_slug/index.php"
                ];
                
                foreach ($plugin_patterns as $pattern) {
                    if (is_plugin_active($pattern)) {
                        return true;
                    }
                }
                
                return false;
        }
    }
    
    /**
     * Display admin notice for missing plugins
     */
    public function plugin_notice() {
        $missing_plugins = $this->get_missing_plugins();
        
        if (empty($missing_plugins)) {
            return;
        }
        
        // Separate premium plugins from regular plugins
        $missing_premium = [];
        $missing_regular = [];
        
        foreach ($missing_plugins as $slug => $name) {
            if (isset($this->premium_plugins[$slug])) {
                $missing_premium[$slug] = $name;
            } else {
                $missing_regular[$slug] = $name;
            }
        }
        
        ?>
        <div class="notice notice-warning">
            <p><strong>Buildertrend Pro Websites:</strong> The following required plugins are missing:</p>
            
            <?php if (!empty($missing_regular)): ?>
                <h4 style="margin-bottom: 5px;">Free Plugins:</h4>
                <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                    <?php foreach ($missing_regular as $slug => $name): ?>
                        <li><?php echo esc_html($name); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p>
                    <a href="<?php echo esc_url(admin_url('admin-post.php?action=install_bt_required_plugins')); ?>" 
                       class="button button-primary">Install Free Plugins</a>
                </p>
            <?php endif; ?>
            
            <?php if (!empty($missing_premium)): ?>
                <h4 style="margin-bottom: 5px; margin-top: 15px;">Premium Plugins (Manual Installation Required):</h4>
                <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                    <?php foreach ($missing_premium as $slug => $name): ?>
                        <li>
                            <?php echo esc_html($name); ?> - 
                            <a href="<?php echo esc_url($this->premium_plugins[$slug]); ?>" target="_blank">
                                Purchase and download here
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p>
                    <em>Premium plugins require purchase and manual installation</em>
                </p>
            <?php endif; ?>
        </div>
        <?php
    }
    
    /**
     * Install a plugin from GitHub
     */
    private function install_github_plugin($slug, $repo_url) {
        // Download GitHub repository as zip
        $download_url = trailingslashit($repo_url) . 'archive/refs/heads/main.zip';
        $temp_file = download_url($download_url);
        
        if (is_wp_error($temp_file)) {
            return false;
        }
        
        // Extract and install
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($temp_file);
        
        // Clean up temp file
        @unlink($temp_file);
        
        if ($result) {
            // Get the plugin file from the extracted folder
            // GitHub repositories are extracted to a folder with the format {repo-name}-{branch}
            $repo_name = basename($repo_url);
            $plugin_dir = WP_PLUGIN_DIR . '/' . $repo_name . '-main';
            
            // Rename the folder to match the expected plugin slug
            if (is_dir($plugin_dir)) {
                rename($plugin_dir, WP_PLUGIN_DIR . '/' . $slug);
            
                // Now the plugin files should be in /wp-content/plugins/bt-website-support/
                $plugin_file = $slug . '/' . $slug . '.php';
                
                // Activate the plugin
                if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
                    activate_plugin($plugin_file);
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Handle plugin installation
     */
    public function handle_plugin_installation() {
        // Security check
        if (!current_user_can('install_plugins')) {
            wp_die('You do not have sufficient permissions to install plugins on this site.');
        }
        
        // Make sure we have the necessary plugin installation functions
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        
        // Get list of missing plugins
        $missing_plugins = $this->get_missing_plugins();
        
        // Install each plugin
        foreach ($missing_plugins as $slug => $name) {
            // Skip premium plugins
            if (isset($this->premium_plugins[$slug])) {
                continue;
            }
            
            // Check if this is a GitHub plugin
            if (isset($this->github_plugins[$slug])) {
                // Install from GitHub
                $this->install_github_plugin($slug, $this->github_plugins[$slug]);
            } 
            // Standard plugin from WordPress.org
            else {
                // Get plugin download URL
                $api = plugins_api('plugin_information', [
                    'slug' => $slug,
                    'fields' => [
                        'short_description' => false,
                        'sections' => false,
                        'requires' => false,
                        'rating' => false,
                        'ratings' => false,
                        'downloaded' => false,
                        'last_updated' => false,
                        'added' => false,
                        'tags' => false,
                        'compatibility' => false,
                        'homepage' => false,
                        'donate_link' => false,
                    ],
                ]);
                
                if (is_wp_error($api)) {
                    continue;
                }
                
                // Install the plugin
                $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
                $result = $upgrader->install($api->download_link);
                
                if ($result) {
                    // Activate the plugin
                    $activate = activate_plugin($upgrader->plugin_info());
                }
            }
        }
        
        // Redirect back to plugins page
        wp_redirect(admin_url('plugins.php'));
        exit;
    }
}

// Initialize the class
new BT_Required_Plugins();