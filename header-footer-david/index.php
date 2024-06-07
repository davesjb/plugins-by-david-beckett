<?php

/*
 * Head & Footer Code plugin for WordPress
 *
 * @link        https://www.webgenesis.co.uk/
 * @since       1.0.0
 * @package     Head_Footer_Snips
 * Plugin Name: Snips David
 * Description: This plugin is for adding scripts for testing and production
 * You can choose location using simple radio buttons
 * Version: 1.0
 * Author: David Beckett
 * 
 */

if (!defined('WPINC')) {
    die;
}
define('CFS_WP_ADMIN_VERSION', '1.0.0');
define('CFS_WP_ADMIN_DIR', 'cfs-wp-admin-form');

/**
 * Helpers
 */
require plugin_dir_path(__FILE__) . 'inc/helpers.php';

require plugin_dir_path(__FILE__) . 'inc/class-cfs-wp-admin-form.php';
function run_cfs_wp_admin_form()
{
    $plugin = new Cfs_admin_form();
    $plugin->init();
}

run_cfs_wp_admin_form();
