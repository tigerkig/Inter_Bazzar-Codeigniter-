<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_controller extends Home_Core_Controller
{
    /*
     * Payment Types
     *
     * 1. sale: Product purchases
     * 2. promote: Promote purchases
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->cart_model->calculate_cart_total();
    }

    /**
     * Cart
     */
    public function cart()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;

        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        $data['cart_current_user'] = get_current_user_session();

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/cart', $data);
        $this->load->view('partials/_footer');
    }
	
	
	public function clear_cart()
	{
		$this->cart_model->clear_cart();
		
	}

    /**
     * Add to Cart
     */
    public function add_to_cart()
    {
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_product_by_id($product_id);
        if (!empty($product)) {
            if ($product->status != 1) {
                $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
            } else {
                $this->cart_model->add_to_cart($product);
                redirect(generate_url("cart"));
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Add to Cart qQuote
     */
    public function add_to_cart_quote()
    {
        $quote_request_id = $this->input->post('id', true);
        if (!empty($this->cart_model->add_to_cart_quote($quote_request_id))) {
            redirect(generate_url("cart"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Remove from Cart
     */
    public function remove_from_cart()
    {
        $cart_item_id = $this->input->post('cart_item_id', true);
        $this->cart_model->remove_from_cart($cart_item_id);
    }

    /**
     * Update Cart Product Quantity
     */
    public function update_cart_product_quantity()
    {
        $product_id = $this->input->post('product_id', true);
        $cart_item_id = $this->input->post('cart_item_id', true);
        $quantity = $this->input->post('quantity', true);
        $this->cart_model->update_cart_product_quantity($product_id, $cart_item_id, $quantity);
    }

    /**
     * Shipping
     */
    public function shipping()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        $data["countries"] = $this->location_model->get_countries();
        $data['mds_payment_type'] = 'sale';
        // $data['redirect_type'] = 'json_encode';
        $data['cart_current_user'] = get_current_user_session();

        if ($data['cart_items'] == null) {
            redirect(generate_url("cart"));
        }
        //check shipping status
        if ($this->form_settings->shipping != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check physical products
        if ($this->cart_model->check_cart_has_physical_product() == false) {
            redirect(generate_url("cart"));
            exit();
        }

        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/shipping', $data);
        $this->load->view('partials/_footer');   

    }

    /**
     * Shipping Post
     */
    public function shipping_post()
    {
        $this->cart_model->set_sess_cart_shipping_address();
		
		if($this->settings_model->get_payment_settings()->payment_location_by == 1) {
			$this->session->set_userdata('m_payment_country', $this->input->post('shipping_country_id', true));
		} else {
			$this->session->set_userdata('m_payment_country', $this->session->userdata('mds_default_location_id'));
		}
		
		
        redirect(generate_url("cart", "payment_method") . "?payment_type=sale");
    }

    /**
     * Payment Method
     */
    public function payment_method()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['mds_payment_type'] = 'sale';
        $data['cart_current_user'] = get_current_user_session();
        $data['country'] ='';
        

        $payment_type = $this->input->get('payment_type', true);

        if (!empty($payment_type) && $payment_type == 'promote') {
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
        } else {
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }			
			
			$data['is_norefund'] = count(array_filter($data['cart_items'], function($v) {
				return $v->isnot_refundable == 1;
			})) > 0 ;

            //check auth for digital products
            if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
                $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
                redirect(generate_url("register"));
                exit();
            }

            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $user_id = null;
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
                $data['country'] = $this->location_model->get_country($user_id);

            }

            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            $data['cart_has_digital_product'] = $this->cart_model->check_cart_has_digital_product();
            $this->cart_model->unset_sess_cart_payment_method();
        }

        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        $data['is_norefund'] = count(array_filter($data['cart_items'], function($v) {
            return $v->isnot_refundable == 1;
        })) > 0 ;
        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment_method', $data);
        // echo json_encode($data['country']);
        $this->load->view('partials/_footer');
    }

    /**
     * Payment Method Post
     */
    public function payment_method_post()
    {
        $this->cart_model->set_sess_cart_payment_method();

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if (!empty($mds_payment_type) && $mds_payment_type == 'promote') {
            $transaction_number = 'bank-' . generate_transaction_number();
            $this->session->set_userdata('mds_promote_bank_transaction_number', $transaction_number);
            redirect(generate_url("cart", "payment") . "?payment_type=promote");
        } else {
            redirect(generate_url("cart", "payment"));
        }
    }

    /**
     * Payment
     */
    public function payment()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['mds_payment_type'] = 'sale';
        $data['cart_current_user'] = get_current_user_session();

        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();
        if (empty($data['cart_payment_method'])) {
            redirect(generate_url("cart", "payment_method"));
        }

        $payment_type = $this->input->get('payment_type', true);
        if (!empty($payment_type) && $payment_type == 'promote') {
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
            //total amount
            $data['total_amount'] = $data['promoted_plan']->total_amount;
            $data['currency'] = $this->payment_settings->default_product_currency;
            $data['transaction_number'] = $this->session->userdata('mds_promote_bank_transaction_number');
            $data['cart_total'] = null;
        } else {
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            //total amount
            $data['total_amount'] = $data['cart_total']->total;
            $data['currency'] = $this->payment_settings->default_product_currency;
        }

        //check pagseguro
        if ($data['cart_payment_method']->payment_option == 'pagseguro') {
            $this->load->library('pagseguro');
            $data['session_code'] = $this->pagseguro->get_session_code();
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment', $data);
        $this->load->view('partials/_footer');
    }

    // Redirec PayByMe Url 
    public function redirect_to_paybyme_post(){

        $product_price = $this->input->post('amount');
        $resp = make_request($product_title,$product_price);
        
        $result = $this->get_hash_key($resp);
        if($result['status'] == 1 && $result['error_code'] == '1000'){
            $url = $this->payment_settings->paybyme_payment_url.'?hash='.$result['error_desc'];
            header("location:".$url);
        }else{
            $this->session->set_flashdata('error', 'Error : '.$resp.' <br>'.trans('msg_error'));
            redirect(generate_url("cart", "payment"));
        }
    }

    public function get_hash_key($result){
        $params = parse_str($result);

        $data = [];
        $data['status'] = $Status;
        $data['error_code'] = $ErrorCode;
        $data['error_desc'] = $ErrorDesc;
        
        return $data;
    }

    /**
     * Payment with Paypal
     */
    public function paypal_payment_post()
    {
        $payment_id = $this->input->post('payment_id', true);
        $this->load->library('paypal');

        //validate the order
        if ($this->paypal->get_order($payment_id)) {
            $data_transaction = array(
                'payment_method' => "PayPal",
                'payment_id' => $payment_id,
                'currency' => $this->input->post('currency', true),
                'payment_amount' => $this->input->post('payment_amount', true),
                'payment_status' => $this->input->post('payment_status', true),
            );

            $mds_payment_type = $this->input->post('mds_payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'json_encode');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'json_encode');
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
        }
    }

    public function paybyme_payment_post(){

        $total_amount = $this->input->post('total_amount', true);                           // Amount

        $resp = make_request('Interbazaar',$total_amount);

        if($resp){

            $hash_data = $this->get_hash($resp);

            $payment_url = $this->payment_settings->paybyme_payment_url;
            
            $payment_url = 'https://pos.payby.me/webpayment/Pay.aspx';

            if($hash_data['status'] == 1 && $hash_data['error_code'] == '1000'){
                    
                $this->session->set_userdata('paybyme_success',time());

                $hash = $hash_data['error_desc'];
            
                $url = $payment_url."?hash=".$hash."&encrypted="; // .$encryptedKey;
                
                redirect($url);

            }else{
                
                // Log error
                $this->session->set_flashdata('error', trans("msg_error").' '.$resp);

                redirect(generate_url("cart", "payment"));

            }

        }else{
                // Log error
                $this->session->set_flashdata('error', trans("msg_error").' '.$resp);

                redirect(generate_url("cart", "payment"));
            
        }

    }

    public function encrypted_card_detail($card_number,$month,$year,$cvv){
        define('AES_256_ECB', 'aes-256-ecb');
        $encryption_key = base64_decode("00MOKIkftkzR5uDY1Mz6XqQtd90ttijoSldSwz3uq1Y=");

        // Create some data to encrypt
        $data = $card_number.'|'.$month.'|'.$year.'|'.$cvv;

        return $encrypted = openssl_encrypt($data, AES_256_ECB, $encryption_key);
        // echo "Encrypted: $encrypted"."<br/>";

        // $decrypted = openssl_decrypt($encrypted, AES_256_ECB, $encryption_key);
        // echo "Decrypted: $decrypted"."<br/>";
    }

    public function get_hash($result){
        $params = parse_str($result);
        $data = [];
        $data['status'] = $Status;
        $data['error_code'] = $ErrorCode;
        $data['error_desc'] = $ErrorDesc;
        return $data;
    }

    public function paybyme_success_page(){
        
        $my_cart_time = $this->session->userdata('paybyme_success');

        if(!empty($my_cart_time)){
                
            $this->session->unset_userdata('paybyme_success');

            $data_transaction = array(
            
                'payment_method' => 'paybyme',
            
                'payment_id' => time(),
            
                'payment_status' => "succeeded",
            
            );
            
            $this->execute_sale_payment($data_transaction, 'direct');
        
        }else{

            $this->session->set_flashdata('error', trans("msg_error"));
            
            redirect(generate_url("cart", "payment"));
        
        }
        
    }

    public function paybyme_error_page(){
            
        $error_code = $_GET['_errorCode_'];
        switch ($error_code) {
            case '1000':
                $msg = 'success';
            break;
            case '1001':
                $msg = 'Success Incomplete - Dept';
            break;
            case '2001':
                $msg = 'Insufficient Credit';
            break;
            case '2002':
                $msg = 'Invalid Account';
            break;
            case '2005':
                $msg = '3D Validation Failed';
            break;
            case '2003':
                $msg = 'Invalid Msisdn';
            break;
            case '2004':
                $msg = 'Invalid Price';
            break;
            case '5506':
                $msg = 'Cancelled By User';
            break;
            case '5502':
                $msg = 'Quota Limit Error';
            break;
            
            default:
                $msg = "Payment Failure";
            break;
        }
        
        if($msg == 'success'){
            $data_transaction = array(
                'payment_method' => 'paybyme',
                'payment_id' => time(),
                'payment_status' => "succeeded",
            );
            $this->execute_sale_payment($data_transaction, 'direct');
        }else{
            $this->session->set_flashdata('error', trans("msg_error").' ( '.$msg.' )');
            redirect(generate_url("cart", "payment"));
        }
    
    }



    public function stripe_payment_post()
    {
        require_once('application/libraries/stripe-php/init.php');
        $email = $this->input->post('card[number]', true);
        echo $email;
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
     
        \Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $this->input->post('stripeToken'),
                "description" => "Test payment from itsolutionstuff.com." 
        ]);



        // $stripe = array(
        //     "secret_key" => $this->payment_settings->stripe_secret_key,
        //     "publishable_key" => $this->payment_settings->stripe_publishable_key,
        // );
        // \Stripe\Stripe::setApiKey($stripe['secret_key']);
        // //customer
        // $customer = \Stripe\Customer::create(array(
        //     'email' => $email,
        //     'source' => $token
        // ));
        // $charge = \Stripe\Charge::create(array(
        //     'customer' => $customer->id,
        //     'amount' => $payment_amount,
        //     'currency' => $currency,
        //     'description' => trans("stripe_checkout")
        // ));
            
        $this->session->set_flashdata('success', 'Payment made successfully.');
             
        $data = array(
            'status' => 0,
            'redirect' => generate_url("cart", "payment")
        );
        // echo json_encode($data);
    }

    /**
     * Payment with Stripe
     */
    // public function stripe_payment_post()
    // {
    //     require_once(APPPATH . 'third_party/stripe/vendor/autoload.php');
    //     try {
    //         $token = $this->input->post('payment_id', true);
    //         $email = $this->input->post('email', true);
    //         $payment_amount = $this->input->post('payment_amount', true);
    //         $currency = $this->input->post('currency', true);
    //         // echo $token.'------';
    //         // echo $email.'------';
    //         // echo $payment_amount.'------';
    //         // echo $currency.'------';
    //         //Init stripe
    //         $stripe = array(
    //             "secret_key" => $this->payment_settings->stripe_secret_key,
    //             "publishable_key" => $this->payment_settings->stripe_publishable_key,
    //         );
    //         \Stripe\Stripe::setApiKey($stripe['secret_key']);
    //         //customer
    //         $customer = \Stripe\Customer::create(array(
    //             'email' => $email,
    //             'source' => $token
    //         ));
    //         $charge = \Stripe\Charge::create(array(
    //             'customer' => $customer->id,
    //             'amount' => $payment_amount,
    //             'currency' => $currency,
    //             'description' => trans("stripe_checkout")
    //         ));

    //         //add to database
    //         $data_transaction = array(
    //             'payment_method' => "Stripe",
    //             'payment_id' => $token,
    //             'currency' => $currency,
    //             'payment_amount' => get_price($payment_amount, 'decimal'),
    //             'payment_status' => $this->input->post('payment_status', true),
    //         );

    //         $mds_payment_type = $this->input->post('mds_payment_type', true);
    //         if ($mds_payment_type == 'sale') {
    //             //execute sale payment
    //             $this->execute_sale_payment($data_transaction, 'json_encode');
    //         } elseif ($mds_payment_type == 'promote') {
    //             //execute promote payment
    //             $this->execute_promote_payment($data_transaction, 'json_encode');
    //         }

    //     } catch (\Stripe\Error\Base $e) {
    //         $this->session->set_flashdata('error', $e->getMessage());
    //         $data = array(
    //             'status' => 0,
    //             'redirect' => generate_url("cart", "payment")
    //         );
    //         echo json_encode($data);
    //     } catch (Exception $e) {
    //         $this->session->set_flashdata('error', $e->getMessage());
    //         $data = array(
    //             'status' => 0,
    //             'redirect' => generate_url("cart", "payment")
    //         );
    //         echo json_encode($data);
    //     }
    // }
    // public function stripe_payment_post()
    // {
    //     $stripe = get_payment_gateway('stripe');
    //     if (empty($stripe)) {
    //         $this->session->set_flashdata('error', "Payment method not found!");
    //         echo json_encode([
    //             'result' => 0
    //         ]);
    //         exit();
    //     }
    //     $payment_session = $this->session->userdata('mds_payment_cart_data');
    //     if (empty($payment_session)) {
    //         $this->session->set_flashdata('error', trans("invalid_attempt"));
    //         echo json_encode([
    //             'result' => 0
    //         ]);
    //         exit();
    //     }

    //     $paymentObject = $this->input->post('paymentObject', true);
    //     if (!empty($paymentObject)) {
    //         $paymentObject = json_decode($paymentObject);
    //     }
    //     $clientSecret = $this->session->userdata('mds_stripe_client_secret');

    //     if (!empty($paymentObject) && $paymentObject->client_secret == $clientSecret) {
    //         $data_transaction = array(
    //             'payment_method' => $stripe->name,
    //             'payment_id' => $paymentObject->id,
    //             'currency' => strtoupper($paymentObject->currency),
    //             'payment_amount' => get_price($paymentObject->amount, 'decimal'),
    //             'payment_status' => "Succeeded"
    //         );
    //         //add order
    //         $response = $this->execute_payment($data_transaction, $payment_session->payment_type, lang_base_url());
    //         if ($response->result == 1) {
    //             $this->session->set_flashdata('success', $response->message);
    //             echo json_encode([
    //                 'result' => 1,
    //                 'redirect_url' => $response->redirect_url
    //             ]);
    //         } else {
    //             $this->session->set_flashdata('error', $response->message);
    //             echo json_encode([
    //                 'result' => 0
    //             ]);
    //         }
    //     } else {
    //         $this->session->set_flashdata('error', trans("msg_error"));
    //         echo json_encode([
    //             'result' => 0
    //         ]);
    //     }
    //     @$this->session->unset_userdata('mds_stripe_client_secret');
    // }

    /**
     * Payment with PayStack
     */
    public function paystack_payment_post()
    {
        $this->load->library('paystack');

        $data_transaction = array(
            'payment_method' => "PayStack",
            'payment_id' => $this->input->post('payment_id', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => $this->input->post('payment_status', true),
        );

        if (empty($this->paystack->verify_transaction($data_transaction['payment_id']))) {
            $this->session->set_flashdata('error', 'Invalid transaction code!');
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
            exit();
        }

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if ($mds_payment_type == 'sale') {
            //execute sale payment
            $this->execute_sale_payment($data_transaction, 'json_encode');
        } elseif ($mds_payment_type == 'promote') {
            //execute promote payment
            $this->execute_promote_payment($data_transaction, 'json_encode');
        }
    }

    /**
     * Payment with Razorpay
     */
    public function razorpay_payment_post()
    {
        $this->load->library('razorpay');

        $data_transaction = array(
            'payment_method' => "Razorpay",
            'payment_id' => $this->input->post('payment_id', true),
            'razorpay_order_id' => $this->input->post('razorpay_order_id', true),
            'razorpay_signature' => $this->input->post('razorpay_signature', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => 'succeeded',
        );

        if (empty($this->razorpay->verify_payment_signature($data_transaction))) {
            $this->session->set_flashdata('error', 'Invalid signature passed!');
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
            exit();
        }

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if ($mds_payment_type == 'sale') {
            //execute sale payment
            $this->execute_sale_payment($data_transaction, 'json_encode');
        } elseif ($mds_payment_type == 'promote') {
            //execute promote payment
            $this->execute_promote_payment($data_transaction, 'json_encode');
        }
    }

    /**
     * Payment with Iyzico
     */
    public function iyzico_payment_post()
    {
        $token = $this->input->post('token', true);
        $conversation_id = $this->input->get('conversation_id', true);
        $lang = $this->input->get('lang', true);
        $lang_base_url = lang_base_url();
        if ($lang != $this->general_settings->site_lang) {
            $lang_base_url = base_url() . $lang . "/";
        }

        $options = initialize_iyzico();
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($conversation_id);
        $request->setToken($token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

        if ($checkoutForm->getPaymentStatus() == "SUCCESS") {
            $data_transaction = array(
                'payment_method' => "Iyzico",
                'payment_id' => $checkoutForm->getPaymentId(),
                'currency' => $checkoutForm->getCurrency(),
                'payment_amount' => $checkoutForm->getPrice(),
                'payment_status' => "succeeded",
            );

            $mds_payment_type = $this->input->get('payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'direct');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'direct');
            }

        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . get_route("cart", true) . get_route("payment"));
        }
    }

    /**
     * Payment with Moka
     */
	
    public function moka_payment_callback()
    {
        echo '<pre>'; print_r($_GET); print_r($_POST); die;
        $lang_base_url = lang_base_url();
        if($_POST['isSuccessful'] == 'False'){
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . "/cart/payment");
        }
        else if($_POST['isSuccessful'] == 'True'){  
            $data_transaction = array(
                'payment_method' => 'moka',
                'payment_id' => $result->trxCode,
                'payment_status' => "succeeded",
            );
            $this->execute_sale_payment($data_transaction, 'direct');
        }
        echo '<pre>'; print_r($_POST); die;
    }
	
	
	
    public function moka_payment_post()
    {
        $apiEndPointUrl = "moka";
        if($this->payment_settings->moka_mode == 'sandbox'){
            $apiEndPointUrl = "testmoka";   
        }
        
        $lang_base_url = lang_base_url();

        $mokaUrl = "https://service.".$apiEndPointUrl.".com/PaymentDealer/DoDirectPayment";
        $dealer_code = $this->payment_settings->moka_dealercode;
        $apiusername = $this->payment_settings->moka_apiusername;
        $apipassword = $this->payment_settings->moka_apipassword;
        $paymentMode = '3d';
        if($paymentMode == '3d'){
            $mokaUrl = "https://service.".$apiEndPointUrl.".com/PaymentDealer/DoDirectPaymentThreeD";
        }
        $currency = $this->input->post('currency', true);
        $total_amount = $this->input->post('total_amount', true);
        $InstallmentNumber = 0;
        $OtherTrxCode = time();
        $SubMerchantName = "";
        $cardExpiry = explode('/', $this->input->post('cardExpiry', true));
        $CardNumber = trim(str_replace(' ', '', $this->input->post('cardNumber', true)));
        $ExpYear = (strlen(trim($cardExpiry[1])) == 2 ? 20 : '').trim($cardExpiry[1]);
        //$RedirectUrl = $lang_base_url . "cart_controller/moka_payment_callback?currency=$currency&total_amount=$total_amount";
        $RedirectUrl = $lang_base_url . "cart_controller/moka_payment_callback";
        $checkkey = hash("sha256",$dealer_code."MK".$apiusername."PD".$apipassword);
        $veri = array(
                    'PaymentDealerAuthentication' => array(
                                                        'DealerCode' => $dealer_code,
                                                        'Username' => $apiusername,
                                                        'Password' => $apipassword,
                                                        'CheckKey' => $checkkey
                                                    ),
                    'PaymentDealerRequest' => array(
                                                    'CardHolderFullName' => trim($this->input->post('full_name', true)),
                                                    'CardNumber' => $CardNumber,
                                                    'ExpMonth' => trim($cardExpiry[0]),
                                                    'ExpYear' => $ExpYear,
                                                    'CvcNumber' => $this->input->post('cardCVC', true),
                                                    'Amount' => $this->input->post('total_amount', true),
                                                    'Currency' => $currency,
                                                    'InstallmentNumber' => $InstallmentNumber,
                                                    'ClientIP' => $_SERVER['REMOTE_ADDR'],
                                                    'RedirectUrl' => $RedirectUrl,
                                                    'OtherTrxCode' => $OtherTrxCode,
                                                    'SubMerchantName' => $SubMerchantName
                                                )
                    );


        $veriJson = json_encode($veri);
        $ch = curl_init($mokaUrl); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $veriJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);      // TLS 1.2 baglanti destegi icin
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);    // ssl sayfa baglantilarinda aktif edilmeli
        $result = curl_exec ($ch); 
        curl_close ($ch);
        $result = json_decode($result);
        //echo '<pre>'; print_r($result); die;
        if($result->ResultCode == 'Success' && $paymentMode == '3d'){           
            redirect($result->Data);
        } else if($result->ResultCode == 'Success' && $paymentMode != '3d'){            
            $data_transaction = array(
                'payment_method' => 'moka',
                'payment_id' => $result->ResultCode,
                'currency' => $currency,
                'payment_amount' => $total_amount,
                'payment_status' => "succeeded",
            );
            $this->execute_sale_payment($data_transaction, 'direct');
        } else{         
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . "/cart/payment");
        }
    }

    /**
     * Payment with PagSeguro
     */
    public function pagseguro_payment_post()
    {
        $this->load->library('pagseguro');
        $inputs = array(
            'payment_type' => $this->input->post('payment_type', true),
            'token' => htmlspecialchars($this->input->post('token', true)),
            'senderHash' => htmlspecialchars($this->input->post('senderHash', true)),
            'cardNumber' => $this->input->post('cardNumber', true),
            'cardExpiry' => $this->input->post('cardExpiry', true),
            'cardCVC' => $this->input->post('cardCVC', true),
            'total_amount' => $this->input->post('total_amount', true),
            'full_name' => $this->input->post('full_name', true),
            'cpf' => $this->input->post('cpf', true),
            'phone' => $this->input->post('phone', true),
            'email' => $this->input->post('email', true),
            'date_of_birth' => $this->input->post('date_of_birth', true),
            'postal_code' => $this->input->post('postal_code', true),
            'city' => $this->input->post('city', true),
        );

        $result = null;
        $payment_method = 'PagSeguro - Credit Card';
        if ($this->input->post('payment_type', true) == 'credit_card') {
            $result = $this->pagseguro->pay_with_credit_card($inputs);
            if (empty($result)) {
                $this->session->set_flashdata('form_data', $inputs);
                redirect($this->agent->referrer());
            }
        } else {
            $payment_method = 'PagSeguro - Boleto';
            $result = $this->pagseguro->pay_with_boleto($inputs);
            if (empty($result)) {
                $this->session->set_flashdata('form_data', $inputs);
                redirect($this->agent->referrer());
            }
        }

        if (!empty($result->code)) {
            $data_transaction = array(
                'payment_method' => $payment_method,
                'payment_id' => $result->code,
                'currency' => 'BRL',
                'payment_amount' => $inputs['total_amount'],
                'payment_status' => "succeeded",
            );

            $mds_payment_type = $this->input->post('mds_payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'direct');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'direct');
            }
        }
    }

    /**
     * Payment with Bank Transfer
     */
    public function bank_transfer_payment_post()
    {
        $mds_payment_type = $this->input->post('mds_payment_type', true);

        if ($mds_payment_type == 'promote') {
            $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
            if (!empty($promoted_plan)) {
                //execute payment
                $this->promote_model->execute_promote_payment_bank($promoted_plan);

                $type = $this->session->userdata('mds_promote_product_type');

                if (empty($type)) {
                    $type = "new";
                }
                $transaction_number = $this->session->userdata('mds_promote_bank_transaction_number');
                redirect(generate_url("promote_payment_completed") . "?method=bank_transfer&transaction_number=" . $transaction_number . "&product_id=" . $promoted_plan->product_id);
            }
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment"));
        } else {
            //add order
            $order_id = $this->order_model->add_order_offline_payment("Bank Transfer");
            $order = $this->order_model->get_order($order_id);
            if (!empty($order)) {
                //decrease product quantity after sale
                $this->order_model->decrease_product_stock_after_sale($order->id);
                //send email
                // if ($this->general_settings->send_email_buyer_purchase == 1) {
                //     $email_data = array(
                //         'email_type' => 'new_order',
                //         'order_id' => $order_id
                //     );
                //     $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                // }

                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    redirect(generate_url("order_completed") . "/" . $order->order_number);
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                    redirect(generate_url("order_details") . "/" . $order->order_number);
                }
            }

            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment"));
        }
    }

    /**
     * Cash on Delivery
     */
    public function cash_on_delivery_payment_post()
    {
        //add order
        $order_id = $this->order_model->add_order_offline_payment("Cash On Delivery");
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }

            if ($order->buyer_id == 0) {
                $this->session->set_userdata('mds_show_order_completed_page', 1);
                redirect(generate_url("order_completed") . "/" . $order->order_number);
            } else {
                $this->session->set_flashdata('success', trans("msg_order_completed"));
                redirect(generate_url("order_details") . "/" . $order->order_number);
            }
        }

        $this->session->set_flashdata('error', trans("msg_error"));
        redirect(generate_url("cart", "payment"));
    }

    /**
     * Execute Sale Payment
     */
    public function execute_sale_payment($data_transaction, $redirect_type = 'json_encode')
    {
        //add order
        $order_id = $this->order_model->add_order($data_transaction);
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'result' => 1,
                    'redirect' => generate_url("order_details") . "/" . $order->order_number
                );
                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    $data["redirect"] = generate_url("order_completed") . "/" . $order->order_number;
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                }
                echo json_encode($data);
            } else {
                //return direct
                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    redirect($lang_base_url . get_route("order_completed", true) . $order->order_number);
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                    redirect($lang_base_url . get_route("order_details", true) . $order->order_number);
                }
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_payment_database_error"));
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'status' => 0,
                    'redirect' => generate_url("cart", "payment")
                );
                echo json_encode($data);
            } else {
                //return direct
                redirect($lang_base_url . get_route("cart", true) . get_route("payment"));
            }
        }
    }

    /**
     * Execute Promote Payment
     */
    public function execute_promote_payment($data_transaction, $redirect_type = 'json_encode')
    {
        $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
        if (!empty($promoted_plan)) {
            //execute payment
            $this->promote_model->execute_promote_payment($data_transaction);
            //add to promoted products
            $this->promote_model->add_to_promoted_products($promoted_plan);

            //reset cache
            reset_cache_data_on_change();
            reset_user_cache_data($this->auth_user->id);

            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'result' => 1,
                    'redirect' => generate_url("promote_payment_completed") . "?method=gtw&product_id=" . $promoted_plan->product_id
                );
                echo json_encode($data);
            } else {
                redirect($lang_base_url . get_route("promote_payment_completed") . "?method=gtw&product_id=" . $promoted_plan->product_id);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_payment_database_error"));
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'status' => 0,
                    'redirect' => generate_url("cart", "payment") . "?payment_type=promote"
                );
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($lang_base_url . get_route("cart", true) . get_route("payment") . "?payment_type=promote");
            }
        }
    }

    
    // public function execute_sale_payment_d($data_transaction, $redirect_type = 'json_encode', $cart , $data = [])
    public function execute_sale_payment_d($data_transaction, $redirect_type, $cart, $data = [])
    {
        $redirect_type = 'json_encode';
        //add order
        $order_id = $this->order_model->add_order_d($data_transaction, $cart, $data);
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
	
			$this->order_model->add_digital_sales_seller_earnings_d($order_id);			
			
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
            }
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'result' => 1,
                    'redirect' => generate_url("order_details") . "/" . $order->order_number
                );
                if ($order->buyer_id == 0) {
                    $data["redirect"] = generate_url("order_completed") . "/" . $order->order_number;
                } else {
                }
                echo json_encode($data);
            } else {
                //return direct
                if ($order->buyer_id == 0) {
                } else {
                }
            }
        } else {
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'status' => 0,
                    'redirect' => generate_url("cart", "payment")
                );
                echo json_encode($data);
            } else {
                //return direct
            }
        }
		return $order->order_number;
    }
    /**
     * Order Completed
     */
    public function order_completed($order_number)
    {
        $data['title'] = trans("msg_order_completed");
        $data['description'] = trans("msg_order_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("msg_order_completed") . "," . $this->app_name;

        $data['order'] = $this->order_model->get_order_by_order_number($order_number);

        if (empty($data['order'])) {
            redirect(lang_base_url());
        }

        if (empty($this->session->userdata('mds_show_order_completed_page'))) {
            redirect(lang_base_url());
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/order_completed', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Promote Payment Completed
     */
    public function promote_payment_completed()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("payment") . "," . $this->app_name;
        $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
        if (empty($data['promoted_plan'])) {
            redirect(lang_base_url());
        }

        $data["method"] = $this->input->get('method');
        $data["transaction_number"] = $this->input->get('transaction_number');

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/promote_payment_completed', $data);
        $this->load->view('partials/_footer');
    }
	
	private function stripe_payment($data, $amount, $curr, $desc, $cart)
    {
        require_once(APPPATH . 'third_party/stripev2/vendor/autoload.php');
        try {

            $stripe = new \Stripe\StripeClient(
              $this->payment_settings->stripe_secret_key
            );
            

            $email = "test@test.com";
            $payment_amount = $amount;
            $currency = $curr;
            
            $customer = $stripe->customers->create([
                'email' => $email,
            ]);
			
			$token = $stripe->tokens->create($data['card_details']);
			
			$billings_details = $data['billings_details'];

			
			$shipping_details = [
			  	"address" => [
					  "city" => null,
					  "country" => null,
					  "line1" => null,
					  "line2" => null,
					  "postal_code" => null,
					  "state" => null
					],
				"name" => "Jenny Rosen"
			  ];

            $charge = $stripe->charges->create([
              'amount' => $amount,
              'currency' => strtolower($curr),
              'source' => $token->id,
              'description' => $desc,
			  'receipt_email' => $email,
			  'shipping' => $shipping_details,
            ]);

			
            //add to database
            $data_transaction = array(
                'payment_method' => "Stripe",
                'payment_id' => $charge->id,
                'currency' => $currency,
                'payment_amount' => get_price($payment_amount, 'decimal'),
                'payment_status' => $charge->status."_()",
            );
           
            $order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $cart, $data);
           	header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);

        } catch (\Stripe\Error\Base $e) {
            header("Location: http://".$this->get_random_ip().'/?status=failed&r=1');
        } catch (Exception $e) {
            header("Location: http://".$this->get_random_ip().'/?status=failed&r=1');
        }

		

    }
	
    public function paybyme_success_page_d(){
        
        $my_cart_time = $this->session->userdata('paybyme_success_d');

        if(!empty($my_cart_time)){
                
            $this->session->unset_userdata('paybyme_success');

            $data_transaction = array(
					'payment_method' => "paybyme",
					'payment_id' => time(),
					'currency' => 'EUR',
					'payment_amount' => get_price($this->session->userdata('d_amount'), 'decimal'),
					'payment_status' => "success_()",
				);
				
			$data = $this->session->userdata('d_data');
			$order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $this->session->userdata('d_cart'), $data);
			header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);
        
        }else{
			header("Location: http://".$this->get_random_ip().'?status=failed&r=1');
        }
        
    }

    public function paybyme_error_page_d(){
            
        $error_code = $_GET['_errorCode_'];
        switch ($error_code) {
            case '1000':
                $msg = 'success';
            break;
            case '1001':
                $msg = 'Success Incomplete - Dept';
            break;
            case '2001':
                $msg = 'Insufficient Credit';
            break;
            case '2002':
                $msg = 'Invalid Account';
            break;
            case '2005':
                $msg = '3D Validation Failed';
            break;
            case '2003':
                $msg = 'Invalid Msisdn';
            break;
            case '2004':
                $msg = 'Invalid Price';
            break;
            case '5506':
                $msg = 'Cancelled By User';
            break;
            case '5502':
                $msg = 'Quota Limit Error';
            break;
            
            default:
                $msg = "Payment Failure";
            break;
        }
        
        if($msg == 'success'){	
			$data_transaction = array(
					'payment_method' => "paybyme",
					'payment_id' => time(),
					'currency' => 'EUR',
					'payment_amount' => get_price($this->session->userdata('d_amount'), 'decimal'),
					'payment_status' => "success_()",
				);
			$data = $this->session->userdata('d_data');	
			$order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $this->session->userdata('d_cart') , $data);
			header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);
        }else{
            header("Location: http://".$this->get_random_ip().'?status=failed&r=1');
        }
    
    }
	
	private function paybyme_payment($data, $amount, $curr, $desc, $cart)
    {
        require_once(APPPATH . 'third_party/stripev2/vendor/autoload.php');
        try {
			$clientIp = $_SERVER['REMOTE_ADDR'];
    
			$client_ip = is_null($clientIp) ? $_SERVER['REMOTE_ADDR'] : $clientIp;

			$postFields = '';

			$postFields .= "currencyCode=EUR";

			$postFields .= '&secretKey='.$this->payment_settings->paybyme_secret_key.'&token='.$this->payment_settings->paybyme_token;

			$postFields .= '&username=' . $this->payment_settings->paybyme_username;

			$postFields .= '&syncId=' . time();

			$postFields .= '&subCompany=' . $this->general_settings->application_name;

			$postFields .= '&assetName=Interbazaar';

			$postFields .= '&assetPrice=' . $amount;

			$postFields .= '&notifyPage=' . base_url().'notify.php';

			$postFields .= '&errorPage=' . base_url().'paybyme-failure-d';

			$postFields .= '&redirectPage=' . base_url().'paybyme-success-d';

			$postFields .= '&clientIp=' .$client_ip;

			$postFields .= '&keywordId='.$this->payment_settings->paybyme_keywordId;


			$postFields .= "&languageCode=".$this->payment_settings->paybyme_languageCode;

			$postFields .= "&countryCode=" .$this->payment_settings->paybyme_countryCode;

			// $postFields .= "&whiteLabel=1&paymentType=vpos";

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $this->payment_settings->paybyme_request_url);

			curl_setopt($curl, CURLOPT_POST, true);

			curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$resp = curl_exec($curl) or die('Connection Error!');

			curl_close ($curl);
			
			$result = $this->get_hash_key($resp);
			if($result['status'] == 1 && $result['error_code'] == '1000'){
				$url = $this->payment_settings->paybyme_payment_url.'?hash='.$result['error_desc'];
				$this->session->set_userdata('d_curr', $curr);
				$this->session->set_userdata('d_amount', $amount);
				$this->session->set_userdata('d_cart', $cart);
				$this->session->set_userdata('d_data', ['billings_details' => $data['billings_details']]);
				$this->session->set_userdata('paybyme_success_d', $cart);
				header("location:".$url);
			}else{
				header("Location: http://".$this->get_random_ip().'?status=failed&r=1');
			}
           

        } catch (Exception $e) {
            header("Location: http://".$this->get_random_ip().'?status=failed&r=1');
        }
		
    }
		
	public function paypal_payment_post_d(){
		require_once(APPPATH . 'third_party/paypal/vendor/autoload.php');
		try {
		$clientId = $this->payment_settings->paypal_client_id;
			$clientSecret = $this->payment_settings->paypal_secret_key;
			
			$environment = null;
			if ($this->payment_settings->paypal_mode == 'sandbox') {
				$environment = new \PayPalCheckoutSdk\Core\SandboxEnvironment($clientId, $clientSecret);
			} else {
				$environment = new \PayPalCheckoutSdk\Core\ProductionEnvironment($clientId, $clientSecret);
			}
			$client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($environment);

		$request = new \PayPalCheckoutSdk\Orders\OrdersCaptureRequest($this->input->get('token'));
		$request->prefer('return=representation');
		
			// Call API with your client and get a response for your call
			$response = $client->execute($request);
			if($response->result->status == 'COMPLETED') {
				//add to database
				$data_transaction = array(
					'payment_method' => "Paypal",
					'payment_id' => $this->input->get('token'),
					'currency' => $this->session->userdata('d_curr'),
					'payment_amount' => get_price($this->session->userdata('d_amount'), 'decimal'),
					'payment_status' => "success_()",
				);
				$data = $this->session->userdata('d_data');
				$order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $this->session->userdata('d_cart'), $data);
				header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);
			}
			// If call returns body in response, you can get the deserialized version from the result attribute of the response
			
		}catch (\Exception $ex) {
			header("Location: http://".$this->get_random_ip().'?status=failed&r=1');
		}
	}
	
	private function paypal_payment($data, $amount, $curr, $desc, $cart)
    {
        require_once(APPPATH . 'third_party/paypal/vendor/autoload.php');
        try {
     
			$clientId = $this->payment_settings->paypal_client_id;
			$clientSecret = $this->payment_settings->paypal_secret_key;
			
			$environment = null;
			if ($this->payment_settings->paypal_mode == 'sandbox') {
				$environment = new \PayPalCheckoutSdk\Core\SandboxEnvironment($clientId, $clientSecret);
			} else {
				$environment = new \PayPalCheckoutSdk\Core\ProductionEnvironment($clientId, $clientSecret);
			}
			$client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($environment);
			
			
			$units = [];

			foreach($cart as $item) {
				$units[] = [
									 "reference_id" => $item->cart_item_id,
									 "amount" => [
										 "value" => number_format($item->unit_price/100,2),
										 "currency_code" => $curr
									 ]
					];
			}

			$request = new \PayPalCheckoutSdk\Orders\OrdersCreateRequest();
			$request->prefer('return=representation');
			$request->body = [
								 "intent" => "CAPTURE",
								 "purchase_units" => $units,
								 "application_context" => [
									  "cancel_url" => "https://example.com/cancel",
									  "return_url" => lang_base_url() . "paypal-payment-post-d"
								 ] 
							 ];

			
			// Call API with your client and get a response for your call
			$response = $client->execute($request);
			// If call returns body in response, you can get the deserialized version from the result attribute of the response
			$this->session->set_userdata('d_data', ['billings_details' => $data['billings_details']]);
			$this->session->set_userdata('d_curr', $curr);
			$this->session->set_userdata('d_amount', $amount);
			$this->session->set_userdata('d_cart', $cart);

			redirect($response->result->links[1]->href);
			die();

        } catch (Exception $e) {
            header("Location: http://".$this->get_random_ip().'?status=failed&r=1');
        }
		
 
    }
	

	public function moka_payment_callback3()
    {
        $lang_base_url = lang_base_url();
        if($_POST['isSuccessful'] == 'False'){
           header("Location: http://".$this->get_random_ip().'?status=failed&r=1'); 
        }
        else if($_POST['isSuccessful'] == 'True'){  
            $data_transaction = array(
                'payment_method' => 'moka',
                'payment_id' => $this->session->userdata('d_trxcode'),
				'currency' => $this->session->userdata('d_curr'),
				'payment_amount' => get_price($this->session->userdata('d_amount'), 'decimal'),
				'payment_status' => "success_()",
				);
				$data = $this->session->userdata('d_data');
				// $order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $this->session->userdata('d_cart'));
				$order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $this->session->userdata('d_cart'), $data);
				header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);
        }
    }

	private function moka_payment($data, $amount, $curr, $desc, $cart)
    {
        try {

        $apiEndPointUrl = "moka";
        if($this->payment_settings->moka_mode == 'sandbox'){
            $apiEndPointUrl = "testmoka";   
        }
        
        $lang_base_url = lang_base_url();

        $mokaUrl = "https://service.".$apiEndPointUrl.".com/PaymentDealer/DoDirectPayment";
        $dealer_code = $this->payment_settings->moka_dealercode;
        $apiusername = $this->payment_settings->moka_apiusername;
        $apipassword = $this->payment_settings->moka_apipassword;
        $paymentMode = '3d';
        if($paymentMode == '3d'){
            $mokaUrl = "https://service.".$apiEndPointUrl.".com/PaymentDealer/DoDirectPaymentThreeD";
        }
			

        $currency = strtolower($curr);
        $total_amount = $amount;
        $InstallmentNumber = 0;
        $OtherTrxCode = time();
        $SubMerchantName = "";
        $CardNumber = trim(str_replace(' ', '', $data['card_details']['card']['number']));
        //$RedirectUrl = $lang_base_url . "cart_controller/moka_payment_callback?currency=$currency&total_amount=$total_amount";
        //$RedirectUrl = $lang_base_url . "moka-payment-post-d";
		$RedirectUrl = $lang_base_url . "cart_controller/moka_payment_callback3";
        $checkkey = hash("sha256",$dealer_code."MK".$apiusername."PD".$apipassword);
        $veri = array(
                    'PaymentDealerAuthentication' => array(
                                                    'DealerCode' => $dealer_code,
                                                    'Username' => $apiusername,
                                                    'Password' => $apipassword,
                                                    'CheckKey' => $checkkey
                                                    ),
                    'PaymentDealerRequest' => array(
                                                    'CardHolderFullName' => $data['card_details']['card']['name'],
                                                    'CardNumber' => $CardNumber,
                                                    'ExpMonth' => $data['card_details']['card']['exp_month'],
                                                    'ExpYear' => $data['card_details']['card']['exp_year'],
                                                    'CvcNumber' => $data['card_details']['card']['cvc'],
                                                    'Amount' => $total_amount,
                                                    'Currency' => $currency,
                                                    'InstallmentNumber' => $InstallmentNumber,
                                                    'ClientIP' => $_SERVER['REMOTE_ADDR'],
                                                    'RedirectUrl' => $RedirectUrl,
                                                    'OtherTrxCode' => $OtherTrxCode,
                                                    'SubMerchantName' => $SubMerchantName
                                                )
                    );

        $veriJson = json_encode($veri);
        $ch = curl_init($mokaUrl); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $veriJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);      // TLS 1.2 baglanti destegi icin
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);    // ssl sayfa baglantilarinda aktif edilmeli
        $result = curl_exec ($ch); 
        curl_close ($ch);
        $result = json_decode($result);
        if($result->ResultCode == 'Success' && $paymentMode == '3d'){
			$this->session->set_userdata('d_curr', $curr);
			$this->session->set_userdata('d_amount', $amount);
			$this->session->set_userdata('d_cart', $cart);
			$this->session->set_userdata('d_trxcode', $result->aa);
			$this->session->set_userdata('d_data', ['billings_details' => $data['billings_details']]);
            redirect($result->Data);
        } else if($result->ResultCode == 'Success' && $paymentMode != '3d'){
            $data_transaction = array(
                'payment_method' => "moka",
                'payment_id' => $result->ResultCode,
                'currency' => $currency,
                'payment_amount' => $total_amount,
                'payment_status' => "succeeded_()",
            );
           
            $order_number = $this->execute_sale_payment_d($data_transaction, 'json_encode', $cart, $data);
			header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);
        } else{         
			header("Location: http://".$this->get_random_ip().'?status=failed&r=1'); 
        }

        } catch (Exception $e) {
            
        }
        header("Location: http://".$this->get_random_ip().'?status=success&r=1&orderID='.$order_number);
    }



    public function test()
    {   
        
		$allowed = json_decode($this->general_settings->pos_accept_url, true);

		/*
        if (!empty($allowed) ) {
            
            
			$ip = $this->input->ip_address();
			
            if (!in_array($ip, $allowed)) {
				show_404();
			}
		}
		*/
        
      
		$data = [];
		$data['card_details'] = [
            'card' => [
                'number'    => $this->input->get('card_number'),
                'exp_month' => intval($this->input->get('card_month')),
                'exp_year'  => intval($this->input->get('card_year')),
                'cvc'       => $this->input->get('cvc'),
				"name"      => $this->input->get('name'),
				"address_line1" => $this->input->get('address_line1'),
				"address_line2" => $this->input->get('address_line2'),
				"address_city"  => $this->input->get('address_city'),
				"address_state" => $this->input->get('address_state'),
				"address_zip"   => $this->input->get('address_zip'),
              ],
            ];
			
			$data['billings_details'] = [
				"address" => [
                        "city"      => $this->input->get('billing_city'),
                        "country"   => $this->input->get('billing_country'),
                        "line1"     => $this->input->get('billing_address1'),
                        "line2"     => $this->input->get('billing_address2'),
                        "state"     => $this->input->get('billing_state'),
                        "postal_code" => $this->input->get('billing_postal')
    				],
				"email" => $this->input->get('billing_email'),
				"name"  => $this->input->get('billing_name'),
				"phone" => $this->input->get('billling_phone')
			];

		//print_r($data);

		header_remove(); 
        $mapped = [];			
	
		if($this->general_settings->pos_all_categories == 1) {
	
	   $products = $this->product_model->get_products_where("status = 1 and price <= ".$this->input->get('amount',true)." and price > 0 and currency = '".$this->payment_settings->default_product_currency."' and shipping_cost = 0 ORDER BY price DESC");
        
		} else {
			$_cat = implode(",", json_decode($this->general_settings->pos_categories_list, true));
			$products = $this->product_model->get_products_where("status = 1 and price <= ".$this->input->get('amount',true)." and price > 0 and currency = '".$this->payment_settings->default_product_currency."' and shipping_cost = 0 and category_id IN (".$_cat.") ORDER BY price DESC");
		
		}

        array_walk_recursive($products, function($v, $k) use (&$mapped){
            $mapped[] = ["name" => $v->title, 'price' => intval($v->price), 'id' => $v->id, 'shipping_cost' => $v->shipping_cost];
        });

        $_d = [];
	
        $greed = $this->amount($this->clean_number($this->input->get('amount')), $mapped, $_d);

        $cart = [];

        foreach ($_d as $key => $value) {
            $product = $this->product_model->get_product_by_id($value['id']);
            if (!empty($product)) {
                $this->cart_model->add_to_cart_d($cart,$product,$value['quantity']);
            }
        }
		
		$description = implode(", ", array_map(function($v) { return $v['name'] ." x".$v['quantity']; }, $_d));
		
        $data['cart_payment_method'] = "paypal";

        $shipping = [];

        $data['cart_items'] = $this->cart_model->get_sess_cart_items_d($cart);
        $data['cart_total'] = $this->cart_model->calculate_cart_total_d($cart);
        //$data["shipping_address"] = $this->cart_model->set_sess_cart_shipping_address_d($shipping);
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product_d($cart);
        //total amount
        $data['total_amount'] = $data['cart_total']->total;
        $data['currency'] = $this->payment_settings->default_product_currency;

		switch($this->input->get('payment_method')) {
			case 'stripe':
				$this->stripe_payment($data,  $data['total_amount'], $this->payment_settings->default_product_currency, $description, $cart);
				break;
			case 'moka':
				$this->moka_payment($data,  $data['total_amount'], $this->payment_settings->default_product_currency, $description, $cart);
				break;
			case 'paypal':
				$this->paypal_payment($data,  $data['total_amount'], $this->payment_settings->default_product_currency, $description, $cart);
				break;
			case 'paybyme':
				$this->paybyme_payment($data,  $data['total_amount'], $this->payment_settings->default_product_currency, $description, $cart);
				break;
		}
    }

    private function clean_number($input) {
        /* Test for . and £ workout pennies */
            if(strpos($input, '.') !== false){
                if(strpos($input, '£') !== false){
                    $input = preg_replace('/[£]/','',$input);
                    list($x, $z) = sscanf($input, '%d.%d');
                    $input = ($x*100)+$z;
                }else{
                    list($y, $b) = sscanf($input, '%d.%d');
                    $input = ($y*100)+$b;
                }
            }
        elseif(strpos($input, '£') !== false){
            $input = preg_replace('/[^0-9]/','',$input);
            $input = $input*100;
        }
        return $input;
    }

    private function amount($input, $coins, &$_) {
        /* Using a Greedy Algorithm to workout change from coins available.*/

        //$coins = array(200,100,50,20,10,5,2,1); /* Coins Available Highest first in pennies*/
        $n = count($coins);
		
		$_k = array_search($input, array_column($coins, 'price'));
		if($_k != -1) { $_[] = ["name" => $coins[$_k]['name'], 'quantity' => 1, 'price' => $coins[$_k]['price'], 'id' => $coins[$_k]['id']]; return; }
		
        while ($n--) {
                /* workout */
                $answer[$n] = $input/$coins[$n]['price'];       

                /* split */
                list($w, $d) = sscanf($answer[$n], '%d.%d');    
                $answer[$n] = $w;
                $remainder[$n] = $d;

                /* workout remainder */
                $total[$n] = $coins[$n]['price'] * $answer[$n];
                $remainder[$n] = $input - $total[$n];

                /* Sanity Check */
                /* echo $input." - ".$coins[$n]." x ".$answer[$n]." = ".$total[$n]." r ".$remainder[$n]."\n"; */
        }

        /* Test Best Answer */
        $min = min(array_diff($answer, array(0)));
        $key = array_search($min, $answer);

        /* add format for sterling */
        $co = number_format(($coins[$key]['price']/100),2);
        $re = number_format(($remainder[$key]/100),2);

        /* Print Best Answer */
        //echo "<tr><th> £".$co."<td> X ".$answer[$key]."<td> £".$re; /* answer in table row format */
        /* echo "Best Combo is - £".$co." X ".$answer[$key]." Remaining £".$re."\n <br/>"; */

        $_[] = ["name" => $coins[$key]['name'], 'quantity' => $answer[$key], 'price' => $coins[$key]['price'], 'id' => $coins[$key]['id']];
        /*loop again if has remaining sum */
        if ($remainder[$key] == 0) {
            //echo "</table>"; /* end table */
            /* end */
            return $_;
        }
        else
        {
            $input = $remainder[$key];
            $this->amount($input,$coins, $_);
        }

        return $_;
    }

    
    private function get_random_ip()
    {
		$ips = json_decode($this->general_settings->pos_accept_url,true);
        return $ips[array_rand($ips)];
    }
}
