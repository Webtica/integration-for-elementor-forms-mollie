<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

class Mollie_Integration_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

	/**
	 * Get Name
	 *
	 * Return the action name
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'mollie integration';
	}

	/**
	 * Get Label
	 *
	 * Returns the action label
	 *
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return __( 'Mollie', 'mollie-elementor-integration' );
	}

	/**
	 * Register Settings Section
	 *
	 * Registers the Action controls
	 *
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {
		// Check if user has capability to manage options (admin only)
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$widget->start_controls_section(
			'section_mollie-elementor-integration',
			[
				'label' => __( 'Mollie', 'mollie-elementor-integration' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'mollie_api_key',
			[
				'label' => __( 'Mollie API Key', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'APIKEY',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter your mollie API key', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_redirect_url',
			[
				'label' => __( 'Mollie Redirect URL', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://website.com/thank-you',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the url you want to redirect to after the user paid', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_webhook_url',
			[
				'label' => __( 'Mollie Webhook URL', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://website.com/mywebhook',
				'label_block' => true,
				'description' => __( 'Enter the url you want to send data to after the user paid', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_dynamic_pricing_switcher',
			[
				'label' => __( 'Dynamic pricing', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'separator' => 'before'
			]
		);

		$widget->add_control(
			'mollie_payment_amount',
			[
				'label' => __( 'Payment Amount', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'placeholder' => '10',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the amount the client needs to pay', 'mollie-elementor-integration' ),
				'condition' => array(
    				'mollie_payment_dynamic_pricing_switcher!' => 'yes',
    			),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_dynamic_field_id',
			[
				'label' => __( 'Payment Amount', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'pricingvaluefieldid',
				'separator' => 'before',
				'description' => __( 'Enter the dynamic pricing field id this will use the value after the pipe symbol - you can find this under the fields advanced tab', 'mollie-elementor-integration' ),
				'condition' => array(
    				'mollie_payment_dynamic_pricing_switcher' => 'yes',
    			),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_description',
			[
				'label' => __( 'Payment Description', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'This is a description',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the payment description', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_payment_currency',
			[
				'label' => __( 'Payment Currency', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'EUR',
				'options' => [
					'AED' => __( 'AED - UAE Dirham', 'mollie-elementor-integration' ),
					'AUD' => __( 'AUD - Australian Dollar', 'mollie-elementor-integration' ),
					'BGN' => __( 'BGN - Bulgarian Lev', 'mollie-elementor-integration' ),
					'BRL' => __( 'BRL - Brazilian Real', 'mollie-elementor-integration' ),
					'CAD' => __( 'CAD - Canadian Dollar', 'mollie-elementor-integration' ),
					'CHF' => __( 'CHF - Swiss Franc', 'mollie-elementor-integration' ),
					'CZK' => __( 'CZK - Czech Koruna', 'mollie-elementor-integration' ),
					'DKK' => __( 'DKK - Danish Krone', 'mollie-elementor-integration' ),
					'EUR' => __( 'EUR - Euro', 'mollie-elementor-integration' ),
					'GBP' => __( 'GBP - Pound Sterling', 'mollie-elementor-integration' ),
					'HKD' => __( 'HKD - Hong Kong Dollar', 'mollie-elementor-integration' ),
					'HUF' => __( 'HUF - Hungarian Forint', 'mollie-elementor-integration' ),
					'ILS' => __( 'ILS - Israeli Shekel', 'mollie-elementor-integration' ),
					'ISK' => __( 'ISK - Icelandic Króna', 'mollie-elementor-integration' ),
					'JPY' => __( 'JPY - Japanese Yen', 'mollie-elementor-integration' ),
					'MXN' => __( 'MXN - Mexican Peso', 'mollie-elementor-integration' ),
					'MYR' => __( 'MYR - Malaysian Ringgit', 'mollie-elementor-integration' ),
					'NOK' => __( 'NOK - Norwegian Krone', 'mollie-elementor-integration' ),
					'NZD' => __( 'NZD - New Zealand Dollar', 'mollie-elementor-integration' ),
					'PHP' => __( 'PHP - Philippine Peso', 'mollie-elementor-integration' ),
					'PLN' => __( 'PLN - Polish Złoty', 'mollie-elementor-integration' ),
					'RON' => __( 'RON - Romanian Leu', 'mollie-elementor-integration' ),
					'SEK' => __( 'SEK - Swedish Krona', 'mollie-elementor-integration' ),
					'SGD' => __( 'SGD - Singapore Dollar', 'mollie-elementor-integration' ),
					'THB' => __( 'THB - Thai Baht', 'mollie-elementor-integration' ),
					'TWD' => __( 'TWD - Taiwan Dollar', 'mollie-elementor-integration' ),
					'USD' => __( 'USD - US Dollar', 'mollie-elementor-integration' ),
					'ZAR' => __( 'ZAR - South African Rand', 'mollie-elementor-integration' ),
				],
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Select the payment currency (ISO 4217)', 'mollie-elementor-integration' ),
			]
		);

		//Create metadatarepeater
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'mollie_custom_metadata_name', [
				'label' => __( 'Metadata name', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'metadata name' , 'mollie-elementor-integration' ),
				'label_block' => true,
				'description' => __( 'Enter the metadata name', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'mollie_custom_metadata_value', [
				'label' => __( 'Metadata value', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'metadata value' , 'mollie-elementor-integration' ),
				'label_block' => true,
				'description' => __( 'Enter the metadata value', 'mollie-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'mollie_custom_metadata_list',
			[
				'label' => __( 'Mollie Metadata Mapping', 'mollie-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'separator' => 'before',
				'default' => [
					[
						'mollie_custom_metadata_name' => __( 'clientname', 'mollie-elementor-integration' ),
						'mollie_custom_metadata_value' => __( 'john', 'mollie-elementor-integration' ),
					],
					[
						'mollie_custom_metadata_name' => __( 'clientlastname', 'mollie-elementor-integration' ),
						'mollie_custom_metadata_value' => __( 'doe', 'mollie-elementor-integration' ),
					],
				],
				'title_field' => '{{{ mollie_custom_metadata_name }}}',
			]
		);

		$widget->end_controls_section();

	}

	/**
	 * On Export
	 *
	 * Clears form settings on export
	 * @access Public
	 * @param array $element
	 */
	public function on_export( $element ) {
		unset(
			$element['mollie_api_key'],
			$element['mollie_redirect_url'],
			$element['mollie_webhook_url'],
			$element['mollie_payment_dynamic_pricing_switcher'],
			$element['mollie_payment_dynamic_field_id'],
			$element['mollie_payment_amount'],
			$element['mollie_payment_description'],
			$element['mollie_payment_currency'],
			$element['mollie_custom_metadata_name'],
			$element['mollie_custom_metadata_value']
		);

		return $element;
	}

	/**
	 * Run
	 *
	 * Runs the action after submit
	 *
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		// Get submitted Form data
		$raw_fields = $record->get( 'fields' );

		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Validate required settings
		if ( empty( $settings['mollie_api_key'] ) ) {
			$ajax_handler->add_error_message( __( 'Mollie API key is missing. Please configure the payment settings.', 'mollie-elementor-integration' ) );
			return;
		}

		// Sanitize and validate API key
		$api_key = sanitize_text_field( $settings['mollie_api_key'] );
		if ( ! preg_match( '/^(live|test)_[a-zA-Z0-9]{30,}$/', $api_key ) ) {
			$ajax_handler->add_error_message( __( 'Invalid Mollie API key format.', 'mollie-elementor-integration' ) );
			return;
		}

		// Sanitize and validate redirect URL
		$redirect_url = esc_url_raw( $settings['mollie_redirect_url'] );
		if ( empty( $redirect_url ) || ! filter_var( $redirect_url, FILTER_VALIDATE_URL ) ) {
			$ajax_handler->add_error_message( __( 'Invalid or missing redirect URL.', 'mollie-elementor-integration' ) );
			return;
		}

		// Sanitize webhook URL (optional field)
		$webhook_url = '';
		if ( ! empty( $settings['mollie_webhook_url'] ) ) {
			$webhook_url = esc_url_raw( $settings['mollie_webhook_url'] );
			if ( ! filter_var( $webhook_url, FILTER_VALIDATE_URL ) ) {
				$ajax_handler->add_error_message( __( 'Invalid webhook URL format.', 'mollie-elementor-integration' ) );
				return;
			}
		}

		// Process custom metadata mapping with sanitization
		$metadatasettings = isset( $settings['mollie_custom_metadata_list'] ) ? $settings['mollie_custom_metadata_list'] : array();
		$metadata = array();
		foreach ( $metadatasettings as $metadatasetting ) {
			$metadataname = sanitize_key( $metadatasetting['mollie_custom_metadata_name'] );
			$metadatavalue_key = sanitize_text_field( $metadatasetting['mollie_custom_metadata_value'] );

			// Get the value from form fields and sanitize it
			$valuetosend = isset( $fields[ $metadatavalue_key ] ) ? sanitize_text_field( $fields[ $metadatavalue_key ] ) : '';

			// Only add non-empty metadata
			if ( ! empty( $metadataname ) && ! empty( $valuetosend ) ) {
				$metadata[ $metadataname ] = $valuetosend;
			}
		}

		// Sanitize payment settings
		$dynamicprice = isset( $settings['mollie_payment_dynamic_pricing_switcher'] ) ? $settings['mollie_payment_dynamic_pricing_switcher'] : 'no';
		$currency = isset( $settings['mollie_payment_currency'] ) ? sanitize_text_field( $settings['mollie_payment_currency'] ) : 'EUR';
		$description = isset( $settings['mollie_payment_description'] ) ? sanitize_text_field( $settings['mollie_payment_description'] ) : '';

		// Validate currency (ISO 4217 currency codes supported by Mollie)
		$allowed_currencies = array(
			'AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK',
			'EUR', 'GBP', 'HKD', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN',
			'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'SEK', 'SGD',
			'THB', 'TWD', 'USD', 'ZAR'
		);
		if ( ! in_array( $currency, $allowed_currencies, true ) ) {
			$ajax_handler->add_error_message( __( 'Invalid payment currency.', 'mollie-elementor-integration' ) );
			return;
		}

		// Calculate and validate payment amount
		if ( $dynamicprice === 'yes' ) {
			$dynamic_field_id = sanitize_text_field( $settings['mollie_payment_dynamic_field_id'] );
			$amount_raw = isset( $fields[ $dynamic_field_id ] ) ? $fields[ $dynamic_field_id ] : 0;

			// Extract numeric value (handle formats like "10.50" or "price|10.50")
			if ( strpos( $amount_raw, '|' ) !== false ) {
				$parts = explode( '|', $amount_raw );
				$amount_raw = end( $parts );
			}

			$paymentvalue = number_format( (float) filter_var( $amount_raw, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ), 2, '.', '' );
		} else {
			$paymentvalue = number_format( (float) $settings['mollie_payment_amount'], 2, '.', '' );
		}

		// If dynamic price is 0, skip payment and redirect
		if ( $dynamicprice === 'yes' && $paymentvalue === '0.00' ) {
			$ajax_handler->add_response_data( 'redirect_url', $redirect_url );
			return;
		}

		// Validate minimum amount (Mollie requires minimum €0.01)
		if ( (float) $paymentvalue < 0.01 ) {
			$ajax_handler->add_error_message( __( 'Payment amount must be at least 0.01.', 'mollie-elementor-integration' ) );
			return;
		}

		// Create Mollie payment with error handling
		try {
			$mollie = new \Mollie\Api\MollieApiClient();
			$mollie->setApiKey( $api_key );

			$payment_data = array(
				'amount' => array(
					'currency' => $currency,
					'value' => $paymentvalue
				),
				'description' => $description,
				'redirectUrl' => $redirect_url,
				'metadata' => $metadata,
			);

			// Add webhook URL if provided
			if ( ! empty( $webhook_url ) ) {
				$payment_data['webhookUrl'] = $webhook_url;
			}

			$payment = $mollie->payments->create( $payment_data );

			// Get checkout URL and redirect
			$redirect_to = $payment->getCheckoutUrl();
			if ( empty( $redirect_to ) ) {
				throw new \Exception( __( 'Failed to retrieve payment checkout URL.', 'mollie-elementor-integration' ) );
			}

			$ajax_handler->add_response_data( 'redirect_url', $redirect_to );

		} catch ( \Mollie\Api\Exceptions\ApiException $e ) {
			// Log the error for debugging
			error_log( 'Mollie API Error: ' . $e->getMessage() );

			$ajax_handler->add_error_message(
				sprintf(
					/* translators: %s: Error message */
					__( 'Payment processing failed: %s', 'mollie-elementor-integration' ),
					esc_html( $e->getMessage() )
				)
			);
		} catch ( \Exception $e ) {
			// Log the error for debugging
			error_log( 'Mollie Integration Error: ' . $e->getMessage() );

			$ajax_handler->add_error_message(
				__( 'An unexpected error occurred while processing your payment. Please try again.', 'mollie-elementor-integration' )
			);
		}
	}
}