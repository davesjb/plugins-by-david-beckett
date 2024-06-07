<?php

/*
 * Plugin Name: WP Head & Footer 
 * Description: This plugin is for adding header and footer code into wp
 * Version: 1.0.0
 * Requires at least: 4.6
 * Requires PHP: 5.5
 * Tested up to: 6.4
 * Author: David Beckett
 * Author URI: https://www.webgenesis.co.uk/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-head-and-footer
 */

if (!defined('WPINC')) {
    die;
}

function wp_head_and_footer_plugin_links($links)
{
    $plugin_links = [
        '<a href="options-general.php?page=wp-head-and-footer-settings">Settings</a>'
    ];
    return array_merge($plugin_links, $links);
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_head_and_footer_plugin_links');



require_once(plugin_dir_path(__FILE__) . 'inc/settings.php');
require_once(plugin_dir_path(__FILE__) . 'inc/display.php');
