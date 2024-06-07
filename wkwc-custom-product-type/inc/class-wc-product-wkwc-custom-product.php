<?php

/**
 * Define custom product type.
 *
 * @package WooCommerce Custom Product Type
 */

defined('ABSPATH') || exit(); // Exit if accessed directly.

if (!class_exists('WC_Product_Wkwc_Custom_Product')) {

	/**
	 * Custom Product class.
	 */
	class WC_Product_Wkwc_Custom_Product extends WC_Product
	{

		/**
		 * Constructor of this class.
		 *
		 * @param object $product product.
		 */
		public function __construct($product)
		{
			$this->product_type = 'wkwc_custom_product';
			$this->virtual      = 'yes';
			$this->supports[]   = 'ajax_add_to_cart';

			parent::__construct($product);
		}

		/**
		 * Return the product type.
		 *
		 * @return string
		 */
		public function get_type()
		{
			return 'wkwc_custom_product';
		}
	}
}
