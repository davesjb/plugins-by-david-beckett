<?php

/*
 * Plugin Name: Custom Payment Gateway 
 * Description: Extends Custom Payment Gateway 
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
 * Text Domain: custom-payment-gateway
 */

//  https://webkul.com/blog/how-to-create-a-payment-gateway-extension-in-woocommerce/

defined('ABSPATH') || exit();

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

	add_action('plugins_loaded', 'init_custom_payment_gateway');

	function init_custom_payment_gateway()
	{
		class Custom_Payment_Gateway extends WC_Payment_Gateway
		{
			// Constructor for initializing the payment gateway
			public function __construct()
			{
				$this->id = 'custom_payment_gateway';
				$this->method_title = 'Custom Payment Gateway';
				$this->method_description = 'Add a custom description here.';
				$this->has_fields = true;
				$this->init_form_fields();
				$this->init_settings();
				$this->title = $this->get_option('title');
				$this->description = $this->get_option('description');
				// Add more settings here
				// ...
				add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
			}

			public function init_form_fields()
			{
				$this->form_fields = array(
					'title' => array(
						'title' => __('Title', 'woocommerce'),
						'type' => 'text',
						'description' => __('This controls the title displayed during checkout'),
						'default' => __('Custom Payment Gateway', 'woocommerce'),
						'desc_tip' => true,
					),
					'description' => array(
						'title' => __('Description', 'woocommerce'),
						'type' => 'textarea',
						'description' => __('This controls the description displayed during checkout.', 'woocommerce'),
						'default' => __('Pay using Custom Payment Gateway', 'woocommerce'),
						'desc_tip' => true,
					),
				);
			}

			public function process_payment($order_id)
			{
				// Handle payment processing logic here
				// ...
			}
			// Display payment fields during checkout
			public function payment_fields()
			{
				// Display payment fields such as credit card info or other required info
				// ...
			}
			// Validate payment fields
			public function validate_fields()
			{
				// Validate payment fields submitted by the customer
				// ...
			}
		}

		// Add custom payment gateway to available payment gateways in checkout
		add_filter('woocommerce_payment_gateways', 'add_custom_payment_gateway');
		function add_custom_payment_gateway($gateways)
		{
			$gateways[] = 'Custom_Payment_Gateway';
			return $gateways;
		}
	}
}
