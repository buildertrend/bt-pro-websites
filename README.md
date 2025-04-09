# Buildertrend Pro Websites Plugin

A comprehensive WordPress plugin for Buildertrend websites providing essential functionality, admin customizations, and shortcodes.

## Features

### Admin Customizations

- **Custom Admin Dashboard**: Removes default WordPress dashboard widgets and adds custom Buildertrend widgets
- **Support Form Widget**: Embedded support form to easily request help
- **Admin Options Page**: Provides configuration options for site administrators
- **Auto-Updates**: Plugin configures itself to receive automatic updates from GitHub
- **Deactivation Protection**: Prevents accidental deactivation of this essential plugin

### Shortcodes

- **Matterport Integration** `[matterport]`
  - Embeds Matterport 3D tours into pages and posts
  - Attributes:
    - `src`: URL of the Matterport tour (default: https://my.matterport.com/show/)
    - `width`: Width of the iframe (default: 100%)
    - `height`: Height of the iframe (default: 315px)
  - Example: `[matterport src="https://my.matterport.com/show/?m=AbCdEfGh" width="100%" height="600px"]`

- **Plat Map Integration** `[platmap]`
  - Displays plat maps stored in ACF custom fields
  - Attributes:
    - `field_name`: Custom field name (default: "platmap")
    - `fallback`: Content to display if the field is empty
  - Example: `[platmap fallback="Plat map not available for this property"]`

### Dashboard Management

- **Reset Dashboard**: Visit `/wp-admin/index.php?reset_dashboard=1` to reset dashboard to default state
- **Dashboard Widget Removal**: Automatically removes unnecessary default WordPress dashboard widgets
- **Support Form**: Adds a centralized support request form to the admin dashboard

## Installation

1. Upload the plugin files to the `/wp-content/plugins/bt-pro-websites` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. No additional configuration required - the plugin works automatically

## Updating

The plugin automatically checks for updates from the GitHub repository. Updates will be applied automatically as they become available.

## Support

For support, please use the built-in support form in the WordPress admin dashboard.
