<?php

/*
 * Plugin Name: Woo Compare Prices API
 * Description: This plugin is for displaying a list of prices matching products
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
 * Text Domain: woo-compare-prices-api
 */

//  woo_compare_prices_api

// https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/

// http://localhost/wordpress-plugin-test/wp-json/woo-compare-prices-api/v1/prices

// WordPress REST API – custom routes and endpoints https://www.youtube.com/watch?v=v1CRoQVwuOU

if (!defined('ABSPATH')) {
    exit;
}

function register_custom_routes()
{
    // (string $route_namespace, string $route, array $args = array(), bool $override = false)
    //  http://localhost/wordpress-plugin-test/wp-json/woo-compare-prices-api/v1/prices
    // register_rest_route(the namespace, the route we want, and the options)

    register_rest_route('woo-compare-prices-api/v1', '/prices/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_prices',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('woo-compare-prices-api/v1', '/prices', array(
        'methods' => 'GET',
        'callback' => 'get_all_prices',
        'permission_callback' => '__return_true'
    ));
}

add_action('rest_api_init', 'register_custom_routes', 10);



function get_prices($data)
{
    $product_id = $data['id'];
    $product = wc_get_product($product_id);
    if (!$product) {
        return new WP_Error('product_not_found', 'product not found', ['status' => 404]);
    }

    $response = [
        'name' => $product->get_name(),
        'price' => $product->get_price()
    ];

    return rest_ensure_response($response);


    // echo $product_id;

    // print_r($product);
    // exit;
}

function get_all_prices()
{

    $prices = [];
    $products = wc_get_products([
        'status' => 'publish',
        'limit' => -1,
        'return' => 'objects'
    ]);
    foreach ($products as $product) {
        $prices[] = [
            'name' => $product->get_name(),
            'price' => $product->get_price()
        ];
    }


    return rest_ensure_response($prices);
}

register_activation_hook(__FILE__, 'woo_compare_prices_api_display_prices');

function woo_compare_prices_api_display_prices()
{
    global $wpdb;
    $table_name =  $wpdb->prefix . 'form_prices';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        product_name VARCHAR(255) NOT NULL,
        prices DECIMAL (10,2) NOT NULL,
        PRIMARY KEY (id)

        )";

    require_once(ABSPATH .  'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


// function initialize_woocommerce()
// {
//     // Check if WooCommerce is active
//     if (class_exists('WooCommerce')) {
//         // Initialize WooCommerce
//         $woocommerce = WC();

//         $products = wc_get_products(array(
//             'status' => 'publish', // Retrieve only published products
//             'limit' => -1, // Retrieve all products
//         ));

//         // Now you can use $woocommerce to access WooCommerce functionality
//         echo "<pre>";
//         print_r($products);
//         die;
//     } else {
//         // WooCommerce is not active, handle this case accordingly
//         echo 'WooCommerce is not active';
//         die;
//     }
// }

// add_action('init', 'initialize_woocommerce');

function woo_compare_prices_api_before_woocommerce_hpos()
{
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility("custom_order_tables", __FILE__, true);
    }
}

add_action('before_woocommerce_init', 'woo_compare_prices_api_before_woocommerce_hpos');
