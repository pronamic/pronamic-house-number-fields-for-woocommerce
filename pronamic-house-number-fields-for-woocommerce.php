<?php
/**
 * Pronamic House Number Fields for WooCommerce
 *
 * @package   PronamicWooCommercePaymentGatewaysCountriesCondition
 * @author    Pronamic
 * @copyright 2023 Pronamic
 * 
 * @wordpress-plugin
 * Plugin Name: Pronamic House Number Fields for WooCommerce
 * Plugin URI: https://pronamic.shop/products/pronamic-house-number-fields-for-woocommerce/
 * Description: This WordPress plugin adds separate house number fields to the WooCommerce checkout fields.
 * Version: 2.0.1
 * Requires at least: 6.1
 * Requires PHP: 8.0
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 * License: Proprietary
 * License URI: https://pronamic.shop/products/pronamic-house-number-fields-for-woocommerce/
 * Text Domain: pronamic-house-number-fields-for-woocommerce
 * Domain Path: /languages/
 * Update URI: https://wp.pronamic.directory/plugins/pronamic-house-number-fields-for-woocommerce/
 * WC requires at least: 8.0
 * WC tested up to: 8.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoload.
 */
require_once __DIR__ . '/vendor/autoload_packages.php';

/**
 * Bootstrap.
 */
add_action(
	'plugins_loaded',
	function () {
		load_plugin_textdomain(
			'pronamic-house-number-fields-for-woocommerce',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		); 
	}
);

\Pronamic\WooCommerceHouseNumberFields\Plugin::instance()->setup();

\Pronamic\WordPress\Updater\Plugin::instance()->setup();

add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, false );
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);
