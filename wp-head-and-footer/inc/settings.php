<?php

if (!defined('WPINC')) {
    die;
}

function wp_head_and_footer_menu()
{
    add_options_page(
        'WP Head & Footer',
        'WP Head & Footer',
        'manage_options',
        'wp-head-and-footer-settings',
        'wp_head_and_footer_settings_page'
    );
}

add_action('admin_menu', 'wp_head_and_footer_menu');


function wp_head_and_footer_initialise_settings()
{
    register_setting('wp-head-and-footer-group', 'wp_head_code');
    register_setting('wp-head-and-footer-group', 'wp_footer_code');
}

add_action('admin_init', 'wp_head_and_footer_initialise_settings');


function wp_head_and_footer_settings_page()
{
    include(plugin_dir_path(__FILE__) . 'settings-page.php');
}
