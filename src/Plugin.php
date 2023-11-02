<?php
/**
 * Pronamic House Number Fields for WooCommerce
 *
 * @package   PronamicWooCommerceHouseNumberFields
 * @author    Pronamic
 * @copyright 2023 Pronamic
 */

namespace Pronamic\WooCommerceHouseNumberFields;

use WC_Order;

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
		if ( ! \function_exists( '\WC' ) ) {
			return;
		}

		\add_filter( 'woocommerce_checkout_fields', [ $this, 'woocommerce_checkout_fields' ] );

		\add_action( 'woocommerce_checkout_create_order', [ $this, 'woocommerce_checkout_create_order' ], 10, 2 );

		\add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
	}

	/**
	 * WooCommerce checkout fields.
	 * 
	 * @link https://woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
	 * @link https://github.com/woocommerce/woocommerce/blob/8.2.1/plugins/woocommerce/includes/wc-template-functions.php#L2774-L3030
	 * @param array $fields Fields.
	 * @return array
	 */
	public function woocommerce_checkout_fields( $fields ) {
		$field_street = [
			'label'       => \sprintf(
				'<span title="%s">%s</span>',
				\esc_attr__( 'Street', 'pronamic-house-number-fields-for-woocommerce' ),
				\esc_html__( 'Street', 'pronamic-house-number-fields-for-woocommerce' )
			),
			'placeholder' => \_x( 'Street', 'placeholder', 'pronamic-house-number-fields-for-woocommerce' ),
			'required'    => true,
			'class'       => [
				'pronamic-address-field',
				'pronamic-street-field',
			],
			'clear'       => false,
		];

		$field_house_number = [
			'label'       => \sprintf(
				'<span title="%s">%s</span>',
				\esc_attr__( 'House number', 'pronamic-house-number-fields-for-woocommerce' ),
				\esc_html__( 'House number', 'pronamic-house-number-fields-for-woocommerce' )
			),
			'placeholder' => \_x( 'Number', 'placeholder', 'pronamic-house-number-fields-for-woocommerce' ),
			'required'    => true,
			'class'       => [
				'pronamic-address-field',
				'pronamic-house-number-field'
			],
			'clear'       => false,
		];

		$field_house_number_extra = [
			'label'       => \sprintf(
				'<span title="%s">%s</span>',
				\esc_attr__( 'House number addition', 'pronamic-house-number-fields-for-woocommerce' ),
				\esc_html__( 'Addition', 'pronamic-house-number-fields-for-woocommerce' )
			),
			'placeholder' => \_x( 'Extra', 'placeholder', 'pronamic-house-number-fields-for-woocommerce' ),
			'required'    => false,
			'class'       => [
				'pronamic-address-field',
				'pronamic-house-number-addition-field'
			],
			'clear'       => true,
		];

		$position = 3;

		if ( isset( $fields['billing'] ) ) {
			$fields_billing = &$fields['billing'];

			unset( $fields_billing['billing_address_1'] );

			$fields_billing_new                               = [];
			$fields_billing_new['billing_street']             = $field_street;
			$fields_billing_new['billing_house_number']       = $field_house_number;
			$fields_billing_new['billing_house_number_extra'] = $field_house_number_extra;

			$fields_billing = \array_slice( $fields_billing, 0, $position, true ) + $fields_billing_new + \array_slice( $fields_billing, $position, null, true );
		}
 
		if ( isset( $fields['shipping'] ) ) {
			$fields_shipping = &$fields['shipping'];

			unset( $fields_shipping['shipping_address_1'] );

			$fields_shipping_new                                = [];
			$fields_shipping_new['shipping_street']             = $field_street;
			$fields_shipping_new['shipping_house_number']       = $field_house_number;
			$fields_shipping_new['shipping_house_number_extra'] = $field_house_number_extra;

			$fields_shipping = \array_slice( $fields_shipping, 0, $position, true ) + $fields_shipping_new + \array_slice( $fields_shipping, $position, null, true );
		}

		return $fields;
	}

	/**
	 * WooCommerce checkout update order meta.
	 *
	 * @link https://github.com/woocommerce/woocommerce/blob/8.2.1/plugins/woocommerce/includes/class-wc-checkout.php#L451-L456
	 * @param WC_Order $order Order.
	 * @param array    $data  Post data.
	 * @return void
	 */
	public function woocommerce_checkout_create_order( $order, $data ) {
		$street             = \array_key_exists( 'billing_street', $data ) ? $data['billing_street'] : '';
		$house_number       = \array_key_exists( 'billing_house_number', $data ) ? $data['billing_house_number'] : '';
		$house_number_extra = \array_key_exists( 'billing_house_number_extra', $data ) ? $data['billing_house_number_extra'] : '';

		$billing_address_1 = \trim(
			\sprintf( 
				'%s %s %s', 
				$street, 
				$house_number,
				$house_number_extra
			) 
		);

		$order->update_meta_data( '_billing_address_1', $billing_address_1 );

		$street             = \array_key_exists( 'shipping_street', $data ) ? $data['shipping_street'] : '';
		$house_number       = \array_key_exists( 'shipping_house_number', $data ) ? $data['shipping_house_number'] : '';
		$house_number_extra = \array_key_exists( 'shipping_house_number_extra', $data ) ? $data['shipping_house_number_extra'] : '';

		$shipping_address_1 = \trim(
			\sprintf(
				'%s %s %s',
				$street,
				$house_number,
				$house_number_extra
			) 
		);

		if ( empty( $shipping_address_1 ) ) {
			$shipping_address_1 = $billing_address_1;
		}

		$order->update_meta_data( '_shipping_address_1', $shipping_address_1 );
	}

	/**
	 * Enqueue scripts.
	 * 
	 * @return void
	 */
	public function wp_enqueue_scripts() {
		$file = '../style.css';

		\wp_enqueue_style(
			'pronamic-house-number-fields-for-woocommerce',
			\plugins_url( $file, __FILE__ ),
			[],
			\hash_file( 'crc32b', __DIR__ . '/' . $file )
		);
	}
}
