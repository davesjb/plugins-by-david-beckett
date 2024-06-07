<?php

if (!defined('WPINC')) {
    die;
}

function custom404_page_menu()
{
    add_options_page(
        'Custom 404 page settings',
        'Custom 404 page',
        'manage_options',
        'custom404-page-settings', //Slug
        'custom404_page_settings_callback'

    );
}

add_action('admin_menu', 'custom404_page_menu');

function custom404_page_settings_callback()
{
    include(plugin_dir_path(__FILE__) . 'settings-page.php');
}

function custom404_page_settings()
{
    register_setting('custom404-page-settings-group', 'custom404_page_message');
    register_setting('custom404-page-settings-group', 'custom404_page_redirect');

    add_settings_section(
        'custom404-page-settings-section',
        '404 Error Page Settings',
        'custom404_page_settings_section_callback',
        'custom404-page-settings'
    );

    add_settings_field(
        'custom404-page-settings-message',
        'Custom 404 Message',
        'custom404_page_settings_message_callback',
        'custom404-page-settings',
        'custom404-page-settings-section'
    );

    add_settings_field(
        'custom404-page-settings-redirect',
        'Redirect 404 Error to',
        'custom404_page_settings_redirect_callback',
        'custom404-page-settings',
        'custom404-page-settings-section'
    );
}

add_action('admin_init', 'custom404_page_settings');

function custom404_page_settings_section_callback()
{
    echo 'Customise your 404 error page settings below:';
}
function custom404_page_settings_message_callback()
{
    $message = get_option('custom404_page_message', 'Oops page not found!');

    echo '<textarea name="custom404_page_message" rows="4" cols="50"> ' . $message . ' </textarea>';
}
function custom404_page_settings_redirect_callback()
{
    $redirect = get_option('custom404_page_redirect', '');

    echo '<input type="text" name="custom404_page_redirect" value=" ' . $redirect . ' "> ';
}
