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

		\add_action( 'customize_register', [ $this, 'customize_register' ] );
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
	 * @link https://github.com/woocommerce/woocommerce/blob/8.2.1/plugins/woocommerce/includes/class-wc-countries.php#L768-L776
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
			'required'    => 'required' === get_option( 'pronamic_woocommerce_house_number_field' ),
			'class'       => [
				'pronamic-address-field',
				'pronamic-house-number-field',
			],
			'clear'       => false,
		];

		$field_house_number_addition = [
			'label'       => \sprintf(
				'<span title="%s">%s</span>',
				\esc_attr__( 'House number addition', 'pronamic-house-number-fields-for-woocommerce' ),
				\esc_html__( 'Addition', 'pronamic-house-number-fields-for-woocommerce' )
			),
			'placeholder' => \_x( 'Addition', 'placeholder', 'pronamic-house-number-fields-for-woocommerce' ),
			'required'    => 'required' === \get_option( 'pronamic_woocommerce_house_number_addition_field' ),
			'class'       => [
				'pronamic-address-field',
				'pronamic-house-number-addition-field',
			],
			'clear'       => true,
		];

		$position = 3;

		$types = [
			'billing',
			'shipping',
		];

		foreach ( $types as $type ) {
			if ( ! array_key_exists( $type, $fields ) ) {
				continue;
			}

			$address_fields = &$fields[ $type ];

			unset( $address_fields[ $type . '_address_1' ] );

			$fields_new = [];

			$fields_new[ $type . '_street' ]       = $field_street;
			$fields_new[ $type . '_house_number' ] = $field_house_number;

			if ( 'hidden' !== \get_option( 'pronamic_woocommerce_house_number_addition_field' ) ) {
				$fields_new[ $type . '_house_number_addition' ] = $field_house_number_addition;
			}

			$address_fields = \array_slice( $address_fields, 0, $position, true ) + $fields_new + \array_slice( $address_fields, $position, null, true );
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
		$types = [
			'billing',
			'shipping',
		];

		foreach ( $types as $type ) {
			$key_street                = $type . '_street';
			$key_house_number          = $type . '_house_number';
			$key_house_number_addition = $type . '_house_number_addition';

			$street                = \array_key_exists( $key_street, $data ) ? $data[ $key_street ] : '';
			$house_number          = \array_key_exists( $key_house_number, $data ) ? $data[ $key_house_number ] : '';
			$house_number_addition = \array_key_exists( $key_house_number_addition, $data ) ? $data[ $key_house_number_addition ] : '';

			$address_1 = \trim(
				\sprintf( 
					'%s %s %s', 
					$street, 
					$house_number,
					$house_number_addition
				) 
			);

			switch ( $type ) {
				case 'billing':
					$order->set_billing_address_1( $address_1 );
					break;
				case 'shipping':
					$order->set_shipping_address_1( $address_1 );
					break;
			}
		}
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

	/**
	 * Customize register.
	 * 
	 * @link https://developer.wordpress.org/reference/hooks/customize_register/
	 * @link https://github.com/woocommerce/woocommerce/blob/8.2.0/plugins/woocommerce/includes/customizer/class-wc-shop-customizer.php
	 * @param WP_Customize_Manager $manager Customize manager.
	 * @return void
	 */
	public function customize_register( $manager ) {
		$manager->add_setting(
			'pronamic_woocommerce_house_number_field',
			[
				'default'           => 'required',
				'type'              => 'option',
				'capability'        => 'manage_woocommerce',
				'sanitize_callback' => [ $this, 'sanitize_checkout_field_display' ],
			]
		);

		$manager->add_control(
			'pronamic_woocommerce_house_number_field',
			[
				'label'    => \__( 'House number field', 'pronamic-house-number-fields-for-woocommerce' ),
				'section'  => 'woocommerce_checkout',
				'settings' => 'pronamic_woocommerce_house_number_field',
				'type'     => 'select',
				'choices'  => [
					'optional' => \__( 'Optional', 'pronamic-house-number-fields-for-woocommerce' ),
					'required' => \__( 'Required', 'pronamic-house-number-fields-for-woocommerce' ),
				],
			]
		);

		$manager->add_setting(
			'pronamic_woocommerce_house_number_addition_field',
			[
				'default'           => 'optional',
				'type'              => 'option',
				'capability'        => 'manage_woocommerce',
				'sanitize_callback' => [ $this, 'sanitize_checkout_field_display' ],
			]
		);

		$manager->add_control(
			'pronamic_woocommerce_house_number_addition_field',
			[
				'label'    => \__( 'House number addition field', 'pronamic-house-number-fields-for-woocommerce' ),
				'section'  => 'woocommerce_checkout',
				'settings' => 'pronamic_woocommerce_house_number_addition_field',
				'type'     => 'select',
				'choices'  => [
					'hidden'   => \__( 'Hidden', 'pronamic-house-number-fields-for-woocommerce' ),
					'optional' => \__( 'Optional', 'pronamic-house-number-fields-for-woocommerce' ),
					'required' => \__( 'Required', 'pronamic-house-number-fields-for-woocommerce' ),
				],
			]
		);
	}

	/**
	 * Sanitize field display.
	 *
	 * @link https://github.com/woocommerce/woocommerce/blob/8.2.0/plugins/woocommerce/includes/customizer/class-wc-shop-customizer.php#L858C1-L867C3
	 * @param string $value Value.
	 * @return string
	 */
	public function sanitize_checkout_field_display( $value ) {
		$options = [
			'hidden',
			'optional',
			'required',
		];

		return \in_array( $value, $options, true ) ? $value : '';
	}
}
