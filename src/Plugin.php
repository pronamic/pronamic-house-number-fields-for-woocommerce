<?php
/**
 * Pronamic House Number Fields for WooCommerce
 *
 * @package   PronamicWooCommerceHouseNumberFields
 * @author    Pronamic
 * @copyright 2023 Pronamic
 */

namespace Pronamic\WooCommerceHouseNumberFields;

/**
 * Pronamic House Number Fields for WooCommerce class
 */
class Plugin {
	/**
	 * Instance of this class.
	 *
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return self A single instance of this class.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Setup.
	 * 
	 * @return void
	 */
	public function setup() {
		if ( \has_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] ) ) {
			return;
		}

		\add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );
	}

	/**
	 * Plugins loaded.
	 * 
	 * @return void
	 */
	public function plugins_loaded() {
		if ( ! \function_exists( 'WC' ) ) {
			return;
		}
	}
}
