<?php
/*
 * Plugin Name: Wkwc Custom Product Type
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
 * Text Domain: wkwc-custom-product-type
 */

// https://webkul.com/blog/how-to-create-custom-product-type-in-woocommerce/


defined('ABSPATH') || exit(); // Exit if accessed directly.

// Define Constants.
defined('WCPOSGC_PLUGIN_FILE') || define('WCPOSGC_PLUGIN_FILE', plugin_dir_path(__FILE__));

if (!class_exists('Wkwc_Custom_Product_Type')) {

	/**
	 * Custom product type class.
	 */
	class Wkwc_Custom_Product_Type
	{

		/**
		 * Constructor.
		 */
		public function __construct()
		{
			add_action('woocommerce_loaded', array($this, 'wkwc_load_include_custom_product'));

			add_filter('product_type_selector', array($this, 'wkwc_add_custom_product_type'));

			add_filter('woocommerce_product_data_tabs', array($this, 'wkwc_modify_woocommerce_product_data_tabs'));

			add_action('woocommerce_product_data_panels', array($this, 'wkwc_add_product_data_tab_content'));

			add_action('save_post', array($this, 'wkwc_save_custom_product_fields'));

			add_action('woocommerce_wkwc_custom_product_add_to_cart', array($this, 'wkwc_display_add_to_cart_button_on_single'), 30);

			add_filter('woocommerce_product_add_to_cart_text', array($this, 'wkwc_add_to_cart_text'), 10, 2);
		}

		/**
		 * Load custom product.
		 */
		public function wkwc_load_include_custom_product()
		{
			require_once WCPOSGC_PLUGIN_FILE . 'inc/class-wc-product-wkwc-custom-product.php';
		}

		//         /**
		//          * Custom product type.
		//          *
		//          * @param array $types Product types.
		//          *
		//          * @return void
		//          */
		public function wkwc_add_custom_product_type($types)
		{
			$types['wkwc_custom_product'] = esc_html__('Custom Product', 'wkcp');

			return $types;
		}

		//         /**
		//          * Modify product data tabs.
		//          *
		//          * @param array $tabs List of product data tabs.
		//          *
		//          * @return array $tabs Product data tabs.
		//          */
		//         
		public function wkwc_modify_woocommerce_product_data_tabs($tabs)
		{
			if ('product' === get_post_type()) {
?>
				<script type='text/javascript'>
					document.addEventListener('DOMContentLoaded', () => {
						let optionGroupPricing = document.querySelector('.options_group.pricing');
						!!optionGroupPricing && optionGroupPricing.classList.add('show_if_wkwc_custom_product');
						let stockManagement = document.querySelector('._manage_stock_field');
						!!stockManagement && stockManagement.classList.add('show_if_wkwc_custom_product');
						let soldIndividuallyDiv = document.querySelector('.inventory_sold_individually');
						let soldIndividually = document.querySelector('._sold_individually_field');
						!!soldIndividuallyDiv && soldIndividuallyDiv.classList.add('show_if_wkwc_custom_product');
						!!soldIndividually && soldIndividually.classList.add('show_if_wkwc_custom_product');
						<?php if ('yes' === get_option('woocommerce_calc_taxes')) { ?>
							let generalProductData = document.querySelectorAll('#general_product_data > .options_group');
							let taxDiv = !!generalProductData && Array.from(generalProductData).at(-1);
							!!taxDiv && taxDiv.classList.add('show_if_wkwc_custom_product');
						<?php } ?>
					});
				</script>
			<?php
			}
			foreach ($tabs as $key => $val) {
				$product_tabs = array('general', 'inventory');
				if (!in_array($key, $product_tabs)) {
					$tabs[$key]['class'][] = 'hide_if_wkwc_custom_product';
				} else {
					$tabs['inventory']['class'][] = 'show_if_wkwc_custom_product';
				}
			}
			// Add your custom product data tabs.
			$custom_tab = array(
				'wkwc_custom' => array(
					'label'    => __('Custom product settings', 'wkcp'),
					'target'   => 'wkwc_cusotm_product_data_html',
					'class'    => array('show_if_wkwc_custom_product'),
					'priority' => 21,
				),
			);
			return array_merge($tabs, $custom_tab);
		}


		public function wkwc_add_product_data_tab_content()
		{
			global $product_object;
			?>
			<div id="wkwc_cusotm_product_data_html" class="panel woocommerce_options_panel">
				<div class="options_group">
					<?php
					woocommerce_wp_text_input(
						array(
							'id'          => '_wkwc_name',
							'label'       => esc_html__('Name', 'wkcp'),
							'value'       => $product_object->get_meta('_wkwc_name', true),
							'default'     => '',
							'placeholder' => esc_html__('Enter your name', 'wkcp'),
						)
					);
					?>
				</div>
			</div>
<?php
		}


		//         

		//         /**
		//          * Save custom product fields function.
		//          *
		//          * @param int $post_id Post id.
		//          *
		//          * @return void
		//          */
		public function wkwc_save_custom_product_fields($post_id)
		{
			if (!empty($_POST['meta-box-order-nonce']) && wp_verify_nonce(sanitize_text_field($_POST['meta-box-order-nonce']), 'meta-box-order')) {
				$post_data = !empty($_POST) ? wc_clean($_POST) : array();

				if (!empty($post_data['post_type']) && 'product' === $post_data['post_type'] && !empty($post_data['product-type']) && 'wkwc_custom_product' === $post_data['product-type']) {
					$name = !empty($post_data['_wkwc_name']) ? $post_data['_wkwc_name'] : '';

					update_post_meta($post_id, '_wkwc_name', $name);
					update_post_meta($post_id, '_virtual', 'yes');
					update_post_meta($post_id, '_wkwc_custom_product_meta_key', 'yes');
				}
			}
		}

		//         /**
		//          * Display add to cart button on single product page.
		//          *
		//          * @return void
		//          */
		public function wkwc_display_add_to_cart_button_on_single()
		{
			wc_get_template('single-product/add-to-cart/simple.php');
		}

		//         /**
		//          * Add to cart text on the gift card product.
		//          *
		//          * @param string $text Text on add to cart button.
		//          * @param object $product Product data.
		//          *
		//          * @return string $text Text on add to cart button.
		//          */
		public function wkwc_add_to_cart_text($text, $product)
		{
			if ('wkwc_custom_product' === $product->get_type()) {
				$text = $product->is_purchasable() && $product->is_in_stock() ? __('Add to cart', 'wkcp') : $text;
			}

			return $text;
		}
	}
}

new Wkwc_Custom_Product_Type();
