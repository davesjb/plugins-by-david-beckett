<?php

/*
 * Plugin Name: Woo Product Option
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
 * Text Domain: woo-product-option
 */

//  woo_product_option

defined('ABSPATH') || exit();


function ebay_product_type_register()
{
	class WC_Product_Ebay extends WC_Product
	{
		public function __construct($product)
		{
			$this->product_type = 'ebay';
			parent::__construct($product);
		}
	}
	function ebay_product_type_add_to_types($types)
	{
		$types["ebay"] = "eBay Products";
		return $types;
	}

	add_filter('product_type_selector', 'ebay_product_type_add_to_types');
}

add_action('woocommerce_register_taxonomy', 'ebay_product_type_register');
