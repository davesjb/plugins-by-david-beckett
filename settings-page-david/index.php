<?php

/*
 * Plugin Name: Settings Page David
 * Description: This plugin is for additional settings
 * Version: 1.0
 * Author: David Beckett
 * 
 */

if (!defined('WPINC')) {
    die;
}

function wpplugin_settings_page()
{
    add_menu_page(
        'Plugin Name',
        'Plugin Menu',
        'manage_options',
        'wpplugin',
        'wpplugin_settings_page_markup',
        'dashicons-wordpress-alt',
        100
    );

    // Added to tools menu
    add_submenu_page(
        'tools.php',
        __('Plugin Feature 1', 'wpplugin'),
        __('Feature 1', 'wpplugin'),
        'manage_options',
        'wpplugin-feature-1',
        'wpplugin_settings_subpage_markup'
    );

    add_submenu_page(
        'wpplugin',
        __('Plugin Feature 2', 'wpplugin'),
        __('Feature 2', 'wpplugin'),
        'manage_options',
        'wpplugin-feature-2',
        'wpplugin_settings_subpage_markup'
    );
}

add_action('admin_menu', 'wpplugin_settings_page');

function wpplugin_settings_page_markup()
{
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
        <p><?php esc_html_e('Some content.', 'wpplugin'); ?></p>
    </div>
<?php
}

// Add a link to your settings page in your plugin

function wpplugin_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=wpplugin">' . __('Settings', 'wpplugin') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$filter_name = "plugin_action_links_" . plugin_basename(__FILE__);
add_filter($filter_name, 'wpplugin_add_settings_link');

function wpplugin_settings_subpage_markup()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $wpplugin_plugin_basename = plugin_basename(__FILE__);
    $wpplugin_plugin_dir_path = plugin_dir_path(__FILE__);
?>
    <div class="wrap">
        <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
        <p><?php esc_html_e('Some content.', 'wpplugin'); ?></p>
        <h2>Plugin paths</h2>
        <ul>
            <li>plugin_basename: <?php echo $wpplugin_plugin_basename; ?></li>
            <li>plugin_dir_path: <?php echo $wpplugin_plugin_dir_path; ?></li>
            <li>plugin_url()</li>
            <li>plugin_dir_url('includes', __FILE__)</li>
            <li>include file test</li>
        </ul>
    </div>
<?php
}

?>