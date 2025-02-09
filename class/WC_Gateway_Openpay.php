<?php

if (!class_exists('WC_Gateway_Openpay')) {

    class WC_Gateway_Openpay extends WC_Payment_Gateway {

        protected static $instance = null;
        protected $endpointUrl = '';

        public function __construct() {
            $this->include_path	= dirname(__FILE__) . '/WC_Gateway_Openpay';
            $this->id = 'openpay';         
	        $this->description = !empty( $this->get_option( 'description' ) ) ? sanitize_text_field( $this->get_option( 'description' ) ) : "";
            $this->title = !empty( $this->get_option( 'title' ) ) ? sanitize_text_field( $this->get_option( 'title' ) ) : "";
            $this->method_title = "Openpay";
            $this->method_description = __('An alternative interest-free payment method available for customers at checkout.');            
            $this->enabled = !empty( $this->get_option( 'enabled' ) ) ? sanitize_text_field( $this->get_option( 'enabled' ) ) : "";
            $this->max_amount = !empty( $this->get_option( 'maximum' ) ) ? sanitize_text_field( $this->get_option( 'maximum' ) ) : "";
            $this->min_amount = !empty( $this->get_option( 'maximum' ) ) ? sanitize_text_field( $this->get_option( 'minimum' ) ) : "";
            $this->order_button_text = __('Proceed to Openpay');
            $this->supports = array( 'products','refunds' );
            $this->log = new WC_Logger();
            include "{$this->include_path}/form-fields.php";

            $this->init_settings();
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self;
            }
            return self::$instance;
        }
        
        public function add_openpay_gateway( $methods ) {
            $methods[] = 'WC_Gateway_Openpay';
            return $methods;
        }

        public function getBackendParams() {
            $backendParams = [
                'payment_mode' => $this->get_option( 'payment_mode' ),
                'auth_user' => $this->get_option( 'auth_user' ),
                'auth_token' => $this->get_option( 'auth_token' ),
                'minimum' => $this->get_option( 'minimum' ),
                'maximum' => $this->get_option( 'maximum' ),
                'job_frequency' => $this->get_option( 'job_frequency' ),
                'region' => $this->get_option( 'region' )
            ];
            return $backendParams;
        } 
        
        public function override_order_creation( $null, $checkout ) {
            global $woocommerce;
            $data = $checkout->get_posted_data();
            $payment_method = $data['payment_method'];
            if ( $payment_method != 'openpay' ) {
                return;
            }
            $post_id = wp_insert_post( array(
                'post_content' => 'Redirecting to Openpay to complete payment...',
                'post_title' => 'Openpay Order',
                'post_status' => 'publish',
                'post_type' => 'openpay_quote'
            ), true );
           
            if (!is_wp_error( $post_id )) {
                $cart = $woocommerce->cart;

                $cart_hash = $cart->get_cart_hash();
                $available_gateways = WC()->payment_gateways->get_available_payment_gateways();

                $chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
                $shipping_packages = WC()->shipping()->get_packages();

                $customer_id = apply_filters( 'woocommerce_checkout_customer_id', get_current_user_id() );
                $order_vat_exempt = ( $cart->get_customer()->get_is_vat_exempt() ? 'yes' : 'no' );
                $currency = get_option('woocommerce_currency');
                $prices_include_tax = ( get_option( 'woocommerce_prices_include_tax' ) === 'yes' );
                $customer_note = ( isset( $data['order_comments'] ) ? $data['order_comments'] : '' );
                $payment_method = ( isset( $available_gateways[ $data['payment_method'] ] ) ? $available_gateways[ $data['payment_method'] ] : $data['payment_method'] );
                $shipping_total = $cart->get_shipping_total();
                $discount_total = $cart->get_discount_total();
                $discount_tax = $cart->get_discount_tax();
                $cart_tax = $cart->get_cart_contents_tax() + $cart->get_fee_tax();
                $shipping_tax = $cart->get_shipping_tax();
                $total = $cart->get_total( 'edit' );
                $backofficeParams = $this->getBackendParams();
                $others = new stdClass();
                $others->origin = "Online";
                $others->planCreationType = "pending";
                $others->cartId = $post_id;
				$resideUrl = admin_url( 'admin-ajax.php?action=reside_action' );
                $others->merchantRedirectUrl = $resideUrl;
                $others->cancleUrl = $resideUrl;
                $others->merchantFailUrl = $resideUrl;
                try {
                    $paymentmanager = new BusinessLayer\Openpay\PaymentManager( $backofficeParams );
                    $paymentmanager->setShopdata($cart, $others, null, null, null);
                    $token = $paymentmanager->getToken();
                    $paymentmanager->setShopdata(null, null, $token, null, $backofficeParams);
                    $paymentPage = $paymentmanager->getPaymentPage('redirect', false, 'GET');
                    $this->endpointUrl = $paymentPage->endpointUrl;


                    add_post_meta( $post_id, 'status', 'pending' );

                    add_post_meta( $post_id, 'created_via', 'order_creation_from_openpay' );

                    add_post_meta( $post_id, 'posted', $this->special_encode($data) );
                    add_post_meta( $post_id, 'cart', $this->special_encode($cart) );

                    add_post_meta( $post_id, 'cart_hash', $this->special_encode($cart_hash) );

                    add_post_meta( $post_id, 'chosen_shipping_methods', $this->special_encode($chosen_shipping_methods) );
                    add_post_meta( $post_id, 'shipping_packages', $this->special_encode($shipping_packages) );

                    add_post_meta( $post_id, 'customer_id', $this->special_encode($customer_id) );
                    add_post_meta( $post_id, 'order_vat_exempt', $this->special_encode($order_vat_exempt) );
                    add_post_meta( $post_id, 'currency', $this->special_encode($currency) );
                    add_post_meta( $post_id, 'prices_include_tax', $this->special_encode($prices_include_tax) );
                    add_post_meta( $post_id, 'customer_note', $this->special_encode($customer_note) );
                    add_post_meta( $post_id, 'payment_method', $this->special_encode($payment_method) );
                    add_post_meta( $post_id, 'shipping_total', $this->special_encode($shipping_total) );
                    add_post_meta( $post_id, 'discount_total', $this->special_encode($discount_total) );
                    add_post_meta( $post_id, 'discount_tax', $this->special_encode($discount_tax) );
                    add_post_meta( $post_id, 'cart_tax', $this->special_encode($cart_tax) );
                    add_post_meta( $post_id, 'shipping_tax', $this->special_encode($shipping_tax) );
                    add_post_meta( $post_id, 'total', $this->special_encode($total) );


                    $this->process_payment( $post_id );


                } catch ( \Exception $e ) { 
                    $this->log->add( 'openpay', $e->getMessage() );
                    return new WP_Error( 'checkout-error', 'There is some problem on processing order.' );
                }
            }
        }

        public function process_payment( $order_id ) {
            return wp_send_json( array(
                'result'   => 'success',
                'redirect' =>  $this->endpointUrl
            ) );
        }

        public function reside_action() {
            session_start();
            global $wpdb;
            if ( WC()->cart->is_empty() === false && !empty($_GET) ) {
                $params = $_GET;
                $status = isset($params['status']) ? sanitize_text_field( $params['status'] ) : "";
                $plan_id = isset($params['planid']) ? sanitize_text_field( $params['planid'] ) : "";
                $post_id = isset($params['orderid']) ? sanitize_text_field( $params['orderid'] ) : "";

               // $table_name = $wpdb->prefix . 'openpay';

                if ( $status == 'LODGED' ) {
                   if ( isset($_SESSION['openpay_order_'.$plan_id]) ) {
                       return;
                   }

                   $_SESSION['openpay_order_'.$plan_id] = true;

                   // validate if the order does not exist with the same plan ID
                   $existingOrder = $wpdb->get_results( 
                        $wpdb->prepare("SELECT plan_id FROM {$wpdb->prefix}openpay WHERE plan_id=%s", $plan_id) 
                    );

                   if(!empty($existingOrder)){
                       unset($_SESSION['openpay_order_'.$plan_id]);                  
                       return;
                   }

                    $purchasePrice = 0;
                    $backofficeParams = $this->getBackendParams();
                    try {
                        $paymentmanager = new BusinessLayer\Openpay\PaymentManager( $backofficeParams );
                        $paymentmanager->setUrlAttributes([$plan_id]);
                        $response = $paymentmanager->getOrder();
                        $purchasePrice = $response->purchasePrice;
                    } catch ( \Exception $e ) {
                        $this->log->add( 'openpay', $e->getMessage() );
                        unset($_SESSION['openpay_order_'.$plan_id]);
                    }
                    //$totalFromCart = $this->special_decode(get_post_meta( $post_id, 'total', true ));
                    $totalFromCart = WC()->cart->total;
                    $total = round((float)$totalFromCart, 2);
                    if ((int)round($total * 100) == $purchasePrice ) {
                        $table_name = $wpdb->prefix . 'openpay';
                        $order = $this->create_wc_order_from_openpay( $post_id );
                        $wpdb->insert( $table_name, array('plan_id' => $plan_id, 'order_id' => $order->get_id()) );

                        //payment capture
                        try {
                            $ids = [$plan_id];
                            $others = new stdClass();
                            $others->orderid = $order->get_id();
                            $paymentmanager = new BusinessLayer\Openpay\PaymentManager( $backofficeParams );
                            $paymentmanager->setUrlAttributes($ids);
                            $paymentmanager->setShopdata(null, $others);
                            $response = $paymentmanager->getCapture();
                        } catch ( \Exception $e ) {
                            $this->log->add( 'openpay', $e->getMessage() ); 
                            unset($_SESSION['openpay_order_'.$plan_id]);
                        }
                        $order->add_order_note( sprintf(__('Openpay payment approved (Plan ID: %1$s)', 'openpay'), $plan_id) );
                        $transaction_id = $plan_id;
                        $order->payment_complete($transaction_id);
                        $order->update_status( 'processing', __( 'Processing Openpay payment', 'openpay' ) );

                        if ( !is_wp_error($order) ) {
                            unset($_SESSION['openpay_order_'.$plan_id]);
                            if (wp_redirect( $order->get_checkout_order_received_url() )) {
                                exit;
                            }
                        }
                    } else {
                        unset($_SESSION['openpay_order_'.$plan_id]);
                        wc_add_notice( __( 'Cart price is different to Openpay plan amount.', 'openpay' ), 'error' );
                        if (wp_redirect( wc_get_checkout_url() )) {
                            exit;
                        }
                    }

                } else {
                    wc_add_notice( __( 'Openpay transaction was cancelled.', 'openpay' ), 'error' );
                    unset($_SESSION['openpay_order_'.$plan_id]);
                    //wp_delete_post( $post_id, true );
                    # Redirect back the the checkout.
                    if (wp_redirect( wc_get_checkout_url() )) {
                        exit;
                    }
                }
            } else {
                if (wp_redirect( wc_get_checkout_url() )) {
                    exit;
                }
            }
        }

        public function create_wc_order_from_openpay( $post_id ) {
            $checkout = WC()->checkout;
            $data = $this->special_decode(get_post_meta( $post_id, 'posted', true ));
            $cart = $this->special_decode(get_post_meta( $post_id, 'cart', true ));
            $cart_hash = $this->special_decode(get_post_meta( $post_id, 'cart_hash', true ));
            $chosen_shipping_methods = $this->special_decode(get_post_meta( $post_id, 'chosen_shipping_methods', true ));
            $shipping_packages = $this->special_decode(get_post_meta( $post_id, 'shipping_packages', true ));
            $customer_id = $this->special_decode(get_post_meta( $post_id, 'customer_id', true ));
            $order_vat_exempt = $this->special_decode(get_post_meta( $post_id, 'order_vat_exempt', true ));
            $currency = $this->special_decode(get_post_meta( $post_id, 'currency', true ));
            $prices_include_tax = $this->special_decode(get_post_meta( $post_id, 'prices_include_tax', true ));
            $customer_ip_address = $this->special_decode(get_post_meta( $post_id, 'customer_ip_address', true ));
            $customer_user_agent = $this->special_decode(get_post_meta( $post_id, 'customer_user_agent', true ));
            $customer_note = $this->special_decode(get_post_meta( $post_id, 'customer_note', true ));
            $payment_method = $this->special_decode(get_post_meta( $post_id, 'payment_method', true ));
            $shipping_total = $this->special_decode(get_post_meta( $post_id, 'shipping_total', true ));
            $discount_total = $this->special_decode(get_post_meta( $post_id, 'discount_total', true ));
            $discount_tax = $this->special_decode(get_post_meta( $post_id, 'discount_tax', true ));
            $cart_tax = $this->special_decode(get_post_meta( $post_id, 'cart_tax', true ));
            $shipping_tax = $this->special_decode(get_post_meta( $post_id, 'shipping_tax', true ));
            $total = $this->special_decode(get_post_meta( $post_id, 'total', true ));
            try {

                //wp_delete_post( $post_id, true );

                /**
                 * @see WC_Checkout::create_order
                 */

                $order = new WC_Order();

                $fields_prefix = array(
                    'shipping' => true,
                    'billing'  => true,
                );

                $shipping_fields = array(
                    'shipping_method' => true,
                    'shipping_total'  => true,
                    'shipping_tax'    => true,
                );
                foreach ( $data as $key => $value ) {
                    if ( is_callable( array( $order, "set_{$key}" ) ) ) {
                        $order->{"set_{$key}"}( $value );
                    } elseif ( isset( $fields_prefix[ current( explode( '_', $key ) ) ] ) ) {
                        if ( ! isset( $shipping_fields[ $key ] ) ) {
                            $order->update_meta_data( '_' . $key, $value );
                        }
                    }
                }

                $order->set_created_via( 'checkout' );
                $order->set_cart_hash( $cart_hash );
                $order->set_customer_id( $customer_id );
                $order->add_meta_data( 'is_vat_exempt', $order_vat_exempt );
                $order->set_currency( $currency );
                $order->set_prices_include_tax( $prices_include_tax );
                $order->set_customer_ip_address( $customer_ip_address );
                $order->set_customer_user_agent( $customer_user_agent );
                $order->set_customer_note( $customer_note );
                $order->set_payment_method( $payment_method );
                $order->set_shipping_total( $shipping_total );
                $order->set_discount_total( $discount_total );
                $order->set_discount_tax( $discount_tax );
                $order->set_cart_tax( $cart_tax );
                $order->set_shipping_tax( $shipping_tax );
                $order->set_total( $total );

                $checkout->create_order_line_items( $order, $cart );
                $checkout->create_order_fee_lines( $order, $cart );
                $checkout->create_order_shipping_lines( $order, $chosen_shipping_methods, $shipping_packages );
                $checkout->create_order_tax_lines( $order, $cart );
                $checkout->create_order_coupon_lines( $order, $cart );


                do_action( 'woocommerce_checkout_create_order', $order, $data );

                $order_id = $order->save();

                do_action( 'woocommerce_checkout_update_order_meta', $order_id, $data );

                return $order;
            } catch ( \Exception $e ) {
                $this->log->add( 'openpay', $e->getMessage() );
                return new WP_Error( 'checkout-error', $e->getMessage() );
            }
        }

        private function special_encode( $data ) {
            return base64_encode(serialize($data));
        }

        private function special_decode( $string ) {
            return unserialize(base64_decode($string));
        }

        public function process_refund( $order_id, $amount = null, $reason = '' ) {
            global $wpdb; 
            $isFullRefund = false;
        //    $table_name = $wpdb->prefix . "openpay";
            
            $token = $wpdb->get_results( 
                $wpdb->prepare("SELECT plan_id FROM {$wpdb->prefix}openpay WHERE order_id=%d", $order_id) 
             );
            
            $order = wc_get_order($order_id);
            $planID = "";
            
            if($token){            
                $planID = $token[0]->plan_id;
            } else {
                // To refund the OLD orders placed using the XML based plugin
                $planID = get_post_meta($order_id, '_openpay_planid', true);
            }      

            if ( $order->has_status( 'pending' ) || $order->has_status( 'failed' ) ) {
                return new WP_Error( 'error', 'Order was not paid and cannot be refunded' );
            }
            $remainingAmount = $order->get_remaining_refund_amount();
            
            if ( round($remainingAmount, 6) == 0 ) {
                $isFullRefund = true;
            }
            $reduce = round((float)$amount, 2);
            $prices = [
                'newPrice' => 0,
                'reducePriceBy'=> (int)round( $reduce * 100 ),
                'isFullRefund' => $isFullRefund
            ];
                                                
            try {
                $backofficeParams = $this->getBackendParams();
                $paymentmanager = new BusinessLayer\Openpay\PaymentManager( $backofficeParams );
                $paymentmanager->setUrlAttributes([$planID]);
                $paymentmanager->setShopdata(null, $prices);
                $response = $paymentmanager->refund();
                $newPrice = "";        
                $currencySymbol = get_woocommerce_currency_symbol();
                $refundedAmount = $currencySymbol . "" . $reduce;
                $newPrice = $currencySymbol . "" . $remainingAmount;                                                               

                $order->add_order_note( sprintf(__('Refunded: %1$s, Openpay Plan ID: %2$s, New Purchase Price: %3$s', 'openpay'), $refundedAmount, $planID, $newPrice) );
            } catch ( \Exception $e ) {
                $this->log->add( 'openpay', $e->getMessage() );  
                return new WP_Error( 'error', 'Sorry! There is a problem with Openpay refund. Please contact us.' );
            }
            return true;
        }

        public function min_max_price() {
            $backofficeParams = $this->getBackendParams();
            $result = [];
            try {
                if ( array_key_exists('action', $_POST) && $_POST['action'] == 'openpay_minmax' ) {
                    $backofficeParams = [
                        'auth_user' => isset( $_POST['auth_user'] ) ? sanitize_text_field( $_POST['auth_user'] ) : $this->get_option( 'auth_user' ),
                        'auth_token' => isset( $_POST['auth_token'] ) ? sanitize_text_field( $_POST['auth_token'] ) : $this->get_option( 'auth_token' ),
                        'region' => isset( $_POST['region'] ) ? sanitize_text_field( $_POST['region'] ) : $this->get_option( 'region' ),
                        'payment_mode' => isset( $_POST['payment_mode'] ) ? sanitize_text_field( $_POST['payment_mode'] ) :  $this->get_option( 'payment_mode' )
                    ];
                }


                // get existing value of min and max from backofficeparams
                $min = $this->get_option( 'minimum' );
                $max = $this->get_option( 'maximum' );

                $paymentmanager = new BusinessLayer\Openpay\PaymentManager( $backofficeParams );
                $paymentmanager->setUrlAttributes(array('online'));
                $config = $paymentmanager->getConfiguration();

                // get values from openpay pay api
                $minValue = ( (int)$config->minPrice )/100;
                $maxValue = ( (int)$config->maxPrice )/100;

                if ( $min == '' || $min != $minValue ) {
                    $this->update_option( 'minimum' , $minValue );
                }

                if ( $max == '' || $max!= $maxValue ) {
                        $this->update_option( 'maximum' , $maxValue );
                }
                if ( array_key_exists('action', $_POST) && $_POST['action'] == 'openpay_minmax' ) {
                    
                    if( !empty($_POST['auth_user']) )
                        $this->update_option( 'auth_user' , sanitize_text_field( $_POST['auth_user'] ) );                    
                    if( !empty($_POST['auth_token']) )
                        $this->update_option( 'auth_token' , sanitize_text_field( $_POST['auth_token'] ) );
                    if( !empty($_POST['payment_mode']) )
                        $this->update_option( 'payment_mode' , sanitize_text_field( $_POST['payment_mode'] ) );
                    if( !empty($_POST['region']) )
                        $this->update_option( 'region' , sanitize_text_field( $_POST['region'] ) );

                    $result = [
                        'success' => true,
                        'auth_user' => $this->get_option( 'auth_user' ),
                        'auth_token' => $this->get_option( 'auth_token' ),
                        'payment_mode' => $this->get_option( 'payment_mode' ),
                        'region' => $this->get_option( 'region' ),
                        'minimum' => $this->get_option('minimum'),
                        'maximum' => $this->get_option( 'maximum' )
                    ];
                    wp_send_json($result);
                }
                        $this->log->add( 'openpay', 'Updated min/max successfully!!' );		
            } catch ( \Exception $e ) {
                if ( array_key_exists('action', $_POST) && $_POST['action'] == 'openpay_minmax' ) {
                    if( !empty($_POST['auth_user']) )
                        $this->update_option( 'auth_user' , sanitize_text_field( $_POST['auth_user'] ) );
                    if( !empty($_POST['auth_token']) )
                        $this->update_option( 'auth_token' , sanitize_text_field( $_POST['auth_token'] ) );
                    if( !empty($_POST['payment_mode']) )
                        $this->update_option( 'payment_mode' , sanitize_text_field( $_POST['payment_mode'] ) );
                    if( !empty($_POST['region']) )
                        $this->update_option( 'region' , sanitize_text_field( $_POST['region'] ) );
                    $result = [
                        'success' => false,
                        'auth_user' => $this->get_option( 'auth_user' ),
                        'auth_token' => $this->get_option( 'auth_token' ),
                        'payment_mode' => $this->get_option( 'payment_mode' ),
                        'region' => $this->get_option( 'region' ),
                    ];
                    wp_send_json($result);
                }
                $this->log->add( 'openpay', $e->getMessage() );
            }
        }

        public function is_available() {
            global $woocommerce;
            $unset = false;
            $is_available = ( 'yes' === $this->enabled );
            $min = $this->min_amount;
            $max = $this->max_amount;
            $total = $this->get_order_total();
            if ( $total < $min || $total > $max ) {
                return false;
            }
            //Don't show Openpay if Products/Categories were excluded
            $excludedProducts = explode( ',', $this->get_option( 'disable_products' ) );
            if ( $this->get_option( '0' ) ) {
                $excludedCategories = $this->get_option( '0' );
            } else {
                $excludedCategories = [];
            }
            $allExcludedCategiries = [];
            foreach ( $excludedCategories as $categoryid ) {
                $allExcludedCategiries[] = (int)$categoryid;
                $subcategories = get_term_children( (int)$categoryid, 'product_cat' );
                $allExcludedCategiries = array_merge( $allExcludedCategiries, $subcategories );
            }
            
            $uniqueCategories = array_unique( $allExcludedCategiries );

            if ( isset($woocommerce->cart) && $woocommerce->cart->cart_contents ) {
                foreach ( $woocommerce->cart->cart_contents as $key => $values ) {
                    $terms = get_the_terms( $values['product_id'], 'product_cat' );
                    foreach ( $terms as $term ) {
                        if ( in_array( $term->term_id, $uniqueCategories ) ) {
                            return false;
                        }
                    }
                }
            }

            if( isset($woocommerce->cart) && $woocommerce->cart->get_cart()) {
                foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item_values ) {
                    if ( in_array( $cart_item_values['product_id'] , $excludedProducts ) ) {
                        return false;
                    }
                }
            }

            return $is_available;
        }
	
        function get_terms( $args ) {
            if ( ! is_array( $args ) ) {
                $_taxonomy = $args;
                $args = array(
                    'taxonomy'   => $_taxonomy,
                    'orderby'    => 'name',
                    'hide_empty' => false,
                );
            }
            global $wp_version;
            if ( version_compare( $wp_version, '4.5.0', '>=' ) ) {
                $_terms = get_terms( $args );
            } else {
                $_taxonomy = $args['taxonomy'];
                unset( $args['taxonomy'] );
                $_terms = get_terms( $_taxonomy, $args );
            }
            $_terms_options = array();
            if ( ! empty( $_terms ) && ! is_wp_error( $_terms ) ){
                foreach ( $_terms as $_term ) {
                    $_terms_options[ $_term->term_id ] = $_term->name;
                }
            }
            return $_terms_options;
        }

        function getcategories() {
            $taxonomy     = 'product_cat';
            $orderby      = 'name';  
            $show_count   = 0;
            $pad_counts   = 0;
            $hierarchical = 1;
            $title        = '';  
            $empty        = 0;
            $options = array();
            $args = array(
                'taxonomy'     => $taxonomy,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
            );
            $all_categories = get_categories( $args );
            foreach ( $all_categories as $cat ) {
                if ( $cat->category_parent == 0 ) {
                    $category_id = $cat->term_id;
                    $options[$category_id] = $cat->name;
                    self::getcatsubs( $cat, $options );
                }       
            }
            return $options;
        }

        function getcatsubs( $items, &$arg, $level=1 ) {
            $taxonomy     = 'product_cat';
            $orderby      = 'name';
            $show_count   = 0;
            $pad_counts   = 0;
            $hierarchical = 1;
            $title        = '';
            $empty        = 0;
            if ( $items ) {
                $category_id = $items->term_id;
                $args = array(
                    'taxonomy' => $taxonomy,
                    'parent' => $category_id,
                    'orderby' => $orderby,
                    'show_count' => $show_count,
                    'pad_counts' => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li' => $title,
                    'hide_empty' => $empty
                );
                $sub_cats = get_categories( $args );
                if ( $sub_cats ) {
                    foreach ( $sub_cats as $sub ) {
                        $arg[$sub->term_id] = str_repeat( "-", $level ) . $sub->name;
                        self::getcatsubs( $sub,$arg,$level+1 );
                    }
                } else {
                    return;
                }
            } else {
                return;
            }
        }

        public function removeConfiguration() {
            delete_option('woocommerce_openpay_settings');
            return;
        }

        public function openpay_gateway_icon( $icon, $id ) {
            if ( $id === 'openpay' ) {
                return "<img src='" . esc_url( plugins_url( 'assets/amber-lozenge-logo.svg', dirname(__FILE__) ) ) . "' 
                alt='Openpay Logo' style='width:80px;'/>"; 
            } else {
                return $icon;
            }
        }

        public function hide_wc_refund_button() {
            global $post;
            if (strpos($_SERVER['REQUEST_URI'], 'post.php?post=') === false) {
                return;
            }
            if (empty($post) || $post->post_type != 'shop_order') {
                return;
            }
            $order_id  = isset($_GET['post']) ? sanitize_text_field( $_GET['post'] ) : "";
            $order = wc_get_order( $order_id );
            $order_data = $order->get_data();
            $payment_method = $order_data['payment_method'];
            if ($payment_method == 'openpay') {
                $order_refunds = $order->get_refunds();
                if ( $order_refunds ) {
                    $total_refunded = 0;
                    $order_total = $order_data['total'];
                    foreach( $order_refunds as $refund ) {
                        $total_refunded = $total_refunded + $refund->get_amount(); 
                    }
                    if ($order_total == $total_refunded) {
                        echo "<script>
                            jQuery(function () {
                                jQuery('.refund-items').hide();
                                jQuery('.order_actions option[value=send_email_customer_refunded_order]').remove();
                                if (jQuery('#original_post_status').val()=='wc-refunded') {
                                    jQuery('#s2id_order_status').html('Refunded');
                                } else {
                                    jQuery('#order_status option[value=wc-refunded]').remove();
                                }
                            });
                        </script>";
                    }
                }
            }
        }
    }
}