<?php

/*
 * Plugin Name: Custom Product Summary
 * Description: This plugin is displays custom summary
 * Version: 1.0.0
 * Requires at least: 4.6
 * WC requires at least: 8.8.2
 * Requires PHP: 5.5
 * WC tested up to: 8.8.2
 * Requires Plugins: woocommerce
 * Tested up to: 6.4
 * Author: David Beckett
 * Author URI: https://www.webgenesis.co.uk/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-product-summary
 */

//  custom_product_summary

if (!defined('ABSPATH')) {
    exit;
}
// echo "<pre>";
// print_r(wp_get_active_and_valid_plugins());
// die;
$plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';
if (in_array($plugin_path, wp_get_active_and_valid_plugins()) || in_array($plugin_path, wp_get_active_network_plugins())) {

    function custom_product_summary_display_summary()
    {
        echo "<h2>Black Friday Sale</h2>";
    }

    add_action('woocommerce_single_product_summary', 'custom_product_summary_display_summary');
}

function before_woocommerce_hpos()
{
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility("custom_order_tables", __FILE__, true);
    }
}

add_action('before_woocommerce_init', 'before_woocommerce_hpos');
