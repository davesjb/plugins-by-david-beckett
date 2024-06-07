<?php

/*
 * Plugin Name: Dashboard to dev
 * Description: This plugin is for creating a dev list on the wp dashboard
 * Version: 1.0.0
 * Requires at least: 4.6
 * Requires PHP: 5.5
 * Tested up to: 6.4
 * Author: David Beckett
 * Author URI: https://www.webgenesis.co.uk/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dashboard-to-dev
 */

//  dashboard_to_dev

if (!defined('WPINC')) {
    die;
}


require_once(plugin_dir_path(__FILE__) . 'inc/database.php');
require_once(plugin_dir_path(__FILE__) . 'inc/scripts.php');
require_once(plugin_dir_path(__FILE__) . 'inc/handler.php');


// Function to display the content of the dashboard widget
function dashboard_to_dev_widget_content()
{
    require_once(plugin_dir_path(__FILE__) . 'inc/dev-list.php');
}

// Function to add the dashboard widget
function dashboard_to_dev_dashboard_widget()
{
    wp_add_dashboard_widget(
        'dashboard_to_dev_widget',         // Widget slug
        'My Dashboard Widget',         // Widget title
        'dashboard_to_dev_widget_content'  // Display function
    );
}

// Hook into the 'wp_dashboard_setup' action to add the dashboard widget
add_action('wp_dashboard_setup', 'dashboard_to_dev_dashboard_widget');
