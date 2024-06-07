<?php

/*
 * Plugin Name: Shortcode form plugin
 * Description: This plugin is for generating a shortcode form plugin
 * Version: 1.0.0
 * Requires at least: 4.6
 * Requires PHP: 5.5
 * Tested up to: 6.4
 * Author: David Beckett
 * Author URI: https://www.webgenesis.co.uk/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: shortcode-form-plugin
 */

if (!defined('WPINC')) {
    die;
}

require_once(plugin_dir_path(__FILE__) . 'inc/scripts.php');
require_once(plugin_dir_path(__FILE__) . 'inc/shortcode.php');
require_once(plugin_dir_path(__FILE__) . 'inc/database.php');
