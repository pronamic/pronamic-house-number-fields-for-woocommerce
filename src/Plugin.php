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

		\add_filter( 'woocommerce_checkout_fields', [ $this, 'woocommerce_checkout_fields' ] );
		\add_action( 'woocommerce_checkout_update_order_meta', [ $this, 'woocommerce_checkout_update_order_meta' ], 10, 2 );
		\add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
	}

	/**
	 * WooCommerce house number checkout fields
	 * 
	 * @param array $fields
	 * @return array
	 */
	function woocommerce_checkout_fields( $fields ) {
		// Fields
		$field_street = array(
			'label'       => __( 'Street', 'wc_hn' ),
			'placeholder' => _x( 'Street', 'placeholder', 'wc_hn' ),
			'required'    => true,
			'class'       => array( 'form-row-first', 'street-field' ),
			'clear'       => false
		);

		$field_house_number = array(
			'label'       => __( 'House Number', 'wc_hn' ),
			'placeholder' => _x( 'Number', 'placeholder', 'wc_hn' ),
			'required'    => true,
			'class'       => array( 'form-row-first', 'house-number-field' ),
			'clear'       => false
		);

		$field_house_number_extra = array(
			'label'       => __( 'Extra', 'wc_hn' ),
			'placeholder' => _x( 'Extra', 'placeholder', 'wc_hn' ),
			'required'    => false,
			'class'       => array( 'form-row-last', 'house-number-extra-field' ),
			'clear'       => true
		);

		// Position
		$position = 3;

		// Billing fields
		if ( isset( $fields['billing'] ) ) {
			$fields_billing = &$fields['billing'];

			// Remove the deafult address fields
			unset( $fields_billing['billing_address_1'] );
			unset( $fields_billing['billing_address_2'] );

			// Add the new address fields
			$fields_billing_new = array();
			$fields_billing_new['billing_street']             = $field_street;
			$fields_billing_new['billing_house_number']       = $field_house_number;
			$fields_billing_new['billing_house_number_extra'] = $field_house_number_extra;

			$fields_billing = array_slice( $fields_billing, 0, $position, true ) + $fields_billing_new + array_slice( $fields_billing, $position, null, true );
		}

		// Shipping fields 
		if ( isset( $fields['shipping'] ) ) {
			$fields_shipping = &$fields['shipping'];

			// Remove the default address fields
			unset( $fields_shipping['shipping_address_1'] );
			unset( $fields_shipping['shipping_address_2'] );

			// Add the new address fields
			$fields_shipping_new = array();
			$fields_shipping_new['shipping_street']             = $field_street;
			$fields_shipping_new['shipping_house_number']       = $field_house_number;
			$fields_shipping_new['shipping_house_number_extra'] = $field_house_number_extra;

			$fields_shipping = array_slice( $fields_shipping, 0, $position, true ) + $fields_shipping_new + array_slice( $fields_shipping, $position, null, true );
		}

		return $fields;
	}

	/**
	 * Update order meta
	 * @see https://github.com/woothemes/woocommerce/blob/v2.0.12/classes/class-wc-checkout.php#L359
	 * @see https://github.com/woothemes/woocommerce/blob/v2.0.12/classes/class-wc-checkout.php#L15
	 * 
	 * @param string $order_id
	 * @param array $posted array of posted form data
	 */
	public function woocommerce_checkout_update_order_meta( $order_id, $posted ) {
		// Billing address 1
		$street             = isset( $posted['billing_street'] ) ? woocommerce_clean( $posted['billing_street'] ) : '';
		$house_number       = isset( $posted['billing_house_number'] ) ? woocommerce_clean( $posted['billing_house_number'] ) : '';
		$house_number_extra = isset( $posted['billing_house_number_extra'] ) ? woocommerce_clean( $posted['billing_house_number_extra'] ) : '';

		$billing_address_1 = trim( sprintf( 
			'%s %s %s', 
			$street, 
			$house_number,
			$house_number_extra
		) );

		// @see https://github.com/woothemes/woocommerce/blob/v2.0.12/admin/post-types/writepanels/writepanel-order_data.php#L721
		update_post_meta( $order_id, '_billing_address_1', $billing_address_1 );

		// Shipping address 1
		$street             = isset( $posted['shipping_street'] ) ? woocommerce_clean( $posted['shipping_street'] ) : '';
		$house_number       = isset( $posted['shipping_house_number'] ) ? woocommerce_clean( $posted['shipping_house_number'] ) : '';
		$house_number_extra = isset( $posted['shipping_house_number_extra'] ) ? woocommerce_clean( $posted['shipping_house_number_extra'] ) : '';

		$shipping_address_1 = trim( sprintf(
			'%s %s %s',
			$street,
			$house_number,
			$house_number_extra
		) );

		if ( empty( $shipping_address_1 ) ) {
			// Use billing address as shipping adres 1
			$shipping_address_1 = $billing_address_1;
		}

		// @see https://github.com/woothemes/woocommerce/blob/v2.0.12/admin/post-types/writepanels/writepanel-order_data.php#L732
		update_post_meta( $order_id, '_shipping_address_1', $shipping_address_1 );
	}

	/**
	 * Enqueue plugin style-file
	 */
	public function wp_enqueue_scripts() {
		\wp_enqueue_style( 'wc-hn-style', \plugins_url( 'style.css', __FILE__ ) );
	}
}
