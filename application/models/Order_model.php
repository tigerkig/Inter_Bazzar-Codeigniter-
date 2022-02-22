<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model
{
    //add order
    public function add_order($data_transaction)
    {
        $cart_total = $this->cart_model->get_sess_cart_total();
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => $cart_total->subtotal,
                'price_vat' => $cart_total->vat,
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $cart_total->total,
                'price_currency' => $cart_total->currency,
                'status' => 0,
                'payment_method' => $data_transaction["payment_method"],
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            //if cart does not have physical product
            if ($this->cart_model->check_cart_has_physical_product() != true) {
                $data["status"] = 1;
            }

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, 'payment_received');

                //add digital sales
                $this->add_digital_sales($order_id);

                //add seller earnings
                $this->add_digital_sales_seller_earnings($order_id);

                //add payment transaction
                $this->add_payment_transaction($data_transaction, $order_id);

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                // New Order Placed
                $this->send_new_order_mail($order_id);

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //add order offline payment
    public function add_order_offline_payment($payment_method)
    {   
        $order_status = "awaiting_payment";
        $payment_status = "awaiting_payment";
        if ($payment_method == 'Cash On Delivery') {
            $order_status = "order_processing";
        }

        $cart_total = $this->cart_model->get_sess_cart_total();
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => $cart_total->subtotal,
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $cart_total->total,
                'price_currency' => $cart_total->currency,
                'status' => 0,
                'payment_method' => $payment_method,
                'payment_status' => $payment_status,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, $order_status);
                

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                $this->send_new_order_mail($order_id);

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //update order number
    public function update_order_number($order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'order_number' => $order_id + 10000
        );
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }

    //add order shipping
    public function add_order_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        if ($this->cart_model->check_cart_has_physical_product() == true && $this->form_settings->shipping == 1) {
            $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
            $data = array(
                'order_id' => $order_id,
                'shipping_first_name' => $shipping_address->shipping_first_name,
                'shipping_last_name' => $shipping_address->shipping_last_name,
                'shipping_email' => $shipping_address->shipping_email,
                'shipping_phone_number' => $shipping_address->shipping_phone_number,
                'shipping_address_1' => $shipping_address->shipping_address_1,
                'shipping_address_2' => $shipping_address->shipping_address_2,
                'shipping_country' => $shipping_address->shipping_country_id,
                'shipping_state' => $shipping_address->shipping_state,
                'shipping_city' => $shipping_address->shipping_city,
                'shipping_zip_code' => $shipping_address->shipping_zip_code,
                'billing_first_name' => $shipping_address->billing_first_name,
                'billing_last_name' => $shipping_address->billing_last_name,
                'billing_email' => $shipping_address->billing_email,
                'billing_phone_number' => $shipping_address->billing_phone_number,
                'billing_address_1' => $shipping_address->billing_address_1,
                'billing_address_2' => $shipping_address->billing_address_2,
                'billing_country' => $shipping_address->billing_country_id,
                'billing_state' => $shipping_address->billing_state,
                'billing_city' => $shipping_address->billing_city,
                'billing_zip_code' => $shipping_address->billing_zip_code
            );

            $country = get_country($shipping_address->shipping_country_id);
            if (!empty($country)) {
                $data["shipping_country"] = $country->name;
            }
            $country = get_country($shipping_address->billing_country_id);
            if (!empty($country)) {
                $data["billing_country"] = $country->name;
            }
            $this->db->insert('order_shipping', $data);
        }
    }

    //add order products
    public function add_order_products($order_id, $order_status)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                $product = get_available_product($cart_item->product_id);
                $variation_option_ids = @serialize($cart_item->options_array);
                if (!empty($product)) {
                    $data = array(
                        'order_id' => $order_id,
                        'seller_id' => $product->user_id,
                        'buyer_id' => 0,
                        'buyer_type' => "guest",
                        'product_id' => $product->id,
                        'product_type' => $product->product_type,
                        'product_title' => $cart_item->product_title,
                        'product_slug' => $product->slug,
                        'product_unit_price' => $cart_item->unit_price,
                        'product_quantity' => $cart_item->quantity,
                        'product_currency' => $cart_item->currency,
                        'product_vat_rate' => $product->vat_rate,
                        'product_vat' => $cart_item->product_vat,
                        'product_shipping_cost' => $cart_item->shipping_cost,
                        'product_total_price' => $cart_item->total_price,
                        'variation_option_ids' => $variation_option_ids,
                        'commission_rate' => $this->general_settings->commission_rate,
                        'order_status' => $order_status,
                        'is_approved' => 0,
                        'shipping_tracking_number' => "",
                        'shipping_tracking_url' => "",
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->auth_check) {
                        $data["buyer_id"] = $this->auth_user->id;
                        $data["buyer_type"] = "registered";
                    }
                    //approve if digital product
                    if ($product->product_type == 'digital') {
                        $data["is_approved"] = 1;
                        if ($order_status == 'payment_received') {
                            $data["order_status"] = 'completed';
                        } else {
                            $data["order_status"] = $order_status;
                        }
                    }


                    $data["product_total_price"] = $cart_item->total_price + $cart_item->product_vat + $cart_item->shipping_cost;
                    
                    // Seller New Order Receive
                    $this->send_new_order_receive_mail_seller($data);

                    $this->db->insert('order_products', $data);
                }
            }
        }
    }

    //add digital sales
    public function add_digital_sales($order_id)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->cart_model->get_sess_cart_items();
        $order = $this->get_order($order_id);
        if (!empty($cart_items) && $this->auth_check && !empty($order)) {
            foreach ($cart_items as $cart_item) {
                $product = get_available_product($cart_item->product_id);
                if (!empty($product) && $product->product_type == 'digital') {
                    $data_digital = array(
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'product_title' => $product->title,
                        'seller_id' => $product->user_id,
                        'buyer_id' => $order->buyer_id,
                        'license_key' => '',
                        'purchase_code' => generate_purchase_code(),
                        'currency' => $product->currency,
                        'price' => $product->price,
                        'purchase_date' => date('Y-m-d H:i:s')
                    );

                    $license_key = $this->product_model->get_unused_license_key($product->id);
                    if (!empty($license_key)) {
                        $data_digital['license_key'] = $license_key->license_key;
                    }

                    $this->db->insert('digital_sales', $data_digital);

                    //set license key as used
                    if (!empty($license_key)) {
                        $this->product_model->set_license_key_used($license_key->id);
                    }
                }
            }
        }
    }

    //add digital sale
    public function add_digital_sale($product_id, $order_id)
    {
        $product_id = clean_number($product_id);
        $order_id = clean_number($order_id);
        $product = get_available_product($product_id);
        $order = $this->get_order($order_id);
        if (!empty($product) && $product->product_type == 'digital' && !empty($order)) {
            $data_digital = array(
                'order_id' => $order_id,
                'product_id' => $product->id,
                'product_title' => $product->title,
                'seller_id' => $product->user_id,
                'buyer_id' => $order->buyer_id,
                'license_key' => '',
                'purchase_code' => generate_purchase_code(),
                'currency' => $product->currency,
                'price' => $product->price,
                'purchase_date' => date('Y-m-d H:i:s')
            );

            $license_key = $this->product_model->get_unused_license_key($product->id);
            if (!empty($license_key)) {
                $data_digital['license_key'] = $license_key->license_key;
            }

            $this->db->insert('digital_sales', $data_digital);

            //set license key as used
            if (!empty($license_key)) {
                $this->product_model->set_license_key_used($license_key->id);
            }
        }
    }

    //add digital sales seller earnings
    public function add_digital_sales_seller_earnings($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->product_type == 'digital') {
                    $this->earnings_model->add_seller_earnings($order_product);
                }
            }
        }
    }
	
	//add digital sales seller earnings
    public function add_digital_sales_seller_earnings_d($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                    $this->earnings_model->add_seller_earnings($order_product);
            }
        }
    }

    //add payment transaction
    public function add_payment_transaction($data_transaction, $order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'order_id' => $order_id,
            'user_id' => 0,
            'user_type' => "guest",
            'currency' => $data_transaction["currency"],
            'payment_amount' => $data_transaction["payment_amount"],
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('transactions', $data)) {
            //add invoice
            $this->add_invoice($order_id);
        }
    }

    //update order payment as received
    public function update_order_payment_received($order)
    {
        if (!empty($order)) {
            //update product payment status
            $data_order = array(
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $order_id);
            if ($this->db->update('orders', $data_order)) {
                //update order products payment status
                $order_products = $this->get_order_products($order_id);
                if (!empty($order_products)) {
                    foreach ($order_products as $order_product) {
                        $data = array(
                            'order_status' => "payment_received",
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id', $order_product->id);
                        $this->db->update('order_products', $data);
                    }
                }

                //add invoice
                $this->add_invoice($order_id);
            }
        }
    }

    //get orders count
    public function get_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated orders
    public function get_paginated_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed orders count
    public function get_completed_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }
 public function get_completed_refund_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products','refunds.refund_order_product_id = order_products.id');
        $this->db->where('order_products.buyer_id', $user_id);
        $query = $this->db->get('refunds');
        return $query->num_rows();
    }

        public function get_paginated_refunds($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->select('orders.*, order_products.* , refunds.*, refunds.id as refund_id');
        $this->db->join('order_products','refunds.refund_order_product_id = order_products.id');
        $this->db->join('orders','order_products.order_id = orders.id');
        $this->db->where('order_products.buyer_id', $user_id);
        $this->db->order_by('refunds.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('refunds');
        return $query->result();
    }
    //get paginated completed orders
    public function get_paginated_completed_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get order products
    public function get_order_products($order_id)
    {
        $order_id = clean_number($order_id);
		
		$this->db->select('order_products.*, categories.not_refundable');
		$this->db->from('order_products');
        $this->db->where('order_id', $order_id);
		$this->db->join('products', 'order_products.product_id = products.id', 'left');
		$this->db->join('categories', 'products.category_id = categories.id', 'left');
        $query = $this->db->get();
		
		
        return $query->result();
    }

    //get seller order products
    public function get_seller_order_products($order_id, $seller_id)
    {
        $order_id = clean_number($order_id);
        $seller_id = clean_number($seller_id);
		
		$this->db->select('order_products.*, categories.not_refundable');
		$this->db->from('order_products');
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $seller_id);
		$this->db->join('products', 'order_products.product_id = products.id', 'left');
		$this->db->join('categories', 'products.category_id = categories.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    //get order product
    public function get_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $this->db->where('id', $order_product_id);
        $query = $this->db->get('order_products');
        return $query->row();
    }

    //get order
    public function get_order($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('orders');
        return $query->row();
    }

    //get order by order number
    public function get_order_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('orders');
        return $query->row();
    }

    //update order product status
    public function update_order_product_status($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'order_status' => $this->input->post('order_status', true),
                    'is_approved' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                if ($order_product->product_type == 'digital' && $data["order_status"] == 'payment_received') {
                    $data['order_status'] = 'completed';
                }

                if ($data["order_status"] == 'shipped') {
                    //send email
                    if ($this->general_settings->send_email_order_shipped == 1) {
                        // $email_data = array(
                        //     'email_type' => 'order_shipped',
                        //     'order_product_id' => $order_product->id
                        // );
                        // $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    }
                }
                $this->send_order_status_update($order_product_id);

                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    //add shipping tracking number
    public function add_shipping_tracking_number($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'shipping_tracking_number' => $this->input->post('shipping_tracking_number', true),
                    'shipping_tracking_url' => $this->input->post('shipping_tracking_url', true),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $this->send_shipping_details($data,$order_product);
                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    //add bank transfer payment report
    public function add_bank_transfer_payment_report()
    {
        $data = array(
            'order_number' => $this->input->post('order_number', true),
            'payment_note' => $this->input->post('payment_note', true),
            'receipt_path' => "",
            'user_id' => 0,
            'user_type' => "guest",
            'status' => "pending",
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }

        $this->load->model('upload_model');
        $file_path = $this->upload_model->receipt_upload('file');
        if (!empty($file_path)) {
            $data["receipt_path"] = $file_path;
        }
        $this->send_bank_transfer_payment_update($data);
        return $this->db->insert('bank_transfers', $data);
    }

    //get sales count
    public function get_sales_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status !=', 'completed');
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated sales
    public function get_paginated_sales($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status !=', 'completed');
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed sales count
    public function get_completed_sales_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status', 'completed');
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    public function get_refunded_sales_count($user_id)
    {
        $user_id = clean_number($user_id);

        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->join('refunds', 'refunds.refund_order_product_id = order_products.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
                $this->db->group_start();
        $this->db->where('order_products.order_status', 'refund_pending');
        $this->db->or_where('order_products.order_status', 'refund_completed');
        $this->db->group_end();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }


    //get paginated completed sales
    public function get_paginated_completed_sales($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status', 'completed');
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    public function get_paginated_refunded_sales($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->join('refunds', 'refunds.refund_order_product_id = order_products.id');

        $this->db->select('orders.id as id, order_products.order_status as order_status, refunds.refund_track_code as refund_track_code');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->group_start();
        $this->db->where('order_products.order_status', 'refund_pending');
        $this->db->or_where('order_products.order_status', 'refund_completed');
        $this->db->group_end();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get order shipping
    public function get_order_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_shipping');
        return $query->row();
    }

    //check order seller
    public function check_order_seller($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $result = false;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    //get seller total price
    public function get_seller_total_price($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $total = 0;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    // Code Change for Currency
                    $total += currency_convert($product->product_total_price,$product->product_currency,'EUR');
                }
            }
        }
        return $total;
    }

    //approve order product
    public function approve_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);

        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_product->buyer_id) {
                $data = array(
                    'is_approved' => 1,
                    'order_status' => "completed",
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->order_received_send_email($data,$order_product);

                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }

        return false;
    }

    //decrease product stock after sale
    public function decrease_product_stock_after_sale($order_id)
    {
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                $option_ids = @unserialize($order_product->variation_option_ids);
                if (!empty($option_ids)) {
                    foreach ($option_ids as $option_id) {
                        $option = $this->variation_model->get_variation_option($option_id);
                        if (!empty($option)) {
                            if ($option->is_default == 1) {
                                $product = $this->product_model->get_product_by_id($order_product->product_id);
                                if (!empty($product)) {
                                    $stock = $product->stock - $order_product->product_quantity;
                                    if ($stock < 0) {
                                        $stock = 0;
                                    }
                                    $data = array(
                                        'stock' => $stock
                                    );
                                    $this->db->where('id', $product->id);
                                    $this->db->update('products', $data);
                                }
                            } else {
                                $stock = $option->stock - $order_product->product_quantity;
                                if ($stock < 0) {
                                    $stock = 0;
                                }
                                $data = array(
                                    'stock' => $stock
                                );
                                $this->db->where('id', $option->id);
                                $this->db->update('variation_options', $data);
                            }
                        }
                    }
                } else {
                    $product = $this->product_model->get_product_by_id($order_product->product_id);
                    if (!empty($product)) {
                        $stock = $product->stock - $order_product->product_quantity;
                        if ($stock < 0) {
                            $stock = 0;
                        }
                        $data = array(
                            'stock' => $stock
                        );
                        $this->db->where('id', $product->id);
                        $this->db->update('products', $data);
                    }
                }
            }
        }
    }

    //add invoice
    public function add_invoice($order_id)
    {
        $order = $this->get_order($order_id);
        if (!empty($order)) {
            $invoice = $this->get_invoice_by_order_number($order->order_number);
            if (empty($invoice)) {
                $client = get_user($order->buyer_id);
                if (!empty($client)) {
                    $invoice_items = array();
                    $order_products = $this->order_model->get_order_products($order_id);
                    if (!empty($order_products)) {
                        foreach ($order_products as $order_product) {
                            $seller = get_user($order_product->seller_id);
                            $item = array(
                                'id' => $order_product->id,
                                'seller' => (!empty($seller)) ? $seller->username : ""
                            );
                            array_push($invoice_items, $item);
                        }
                    }
                    $data = array(
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'client_username' => $client->username,
                        'client_first_name' => $client->first_name,
                        'client_last_name' => $client->last_name,
                        'client_address' => get_location($client),
                        'invoice_items' => @serialize($invoice_items),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    return $this->db->insert('invoices', $data);
                }
            }
        }
        return false;
    }

    //get invoice
    public function get_invoice($id)
    {
        $this->db->where('id', clean_number($id));
        $query = $this->db->get('invoices');
        return $query->row();
    }

    //get invoice by order number
    public function get_invoice_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('invoices');
        return $query->row();
    }

    /* New Order Placed - Email */
    public function send_new_order_mail($order_id){
        $order_data = $this->get_order($order_id);
        if(!empty($order_data)){

            if($order_data->buyer_id == 0){
                $shipping = get_order_shipping($order_data->id);
                $name  =  $shipping->shipping_first_name . " " . $shipping->shipping_last_name;
                $phone = $shipping->shipping_phone_number;
                $email = $shipping->shipping_email;
            }else{
                $buyer = get_user($order_data->buyer_id);
                $name  = $buyer->first_name.' '.$buyer->last_name;
                $phone = $buyer->phone_number;
                $email = $buyer->email;
            }

            $order_products = $this->get_order_products($order_id);
            
            $product_html = '';
            if(!empty($order_products)){
                $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
                $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';
                    foreach ($order_products as $item){
                        $product_html .= '<tr>';
                        
                        $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$item->product_title.'</td>';
                        
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted($item->product_unit_price, $item->product_currency).'</td>';

                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$item->product_quantity.'</td>';
                        
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted($item->product_shipping_cost, $item->product_currency).'</td>';

                        if (!empty($order->price_vat)){

                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                            if (!empty($item->product_vat)){
                                $product_html .= price_formatted($item->product_vat, $item->product_currency).' '.($item->product_vat_rate.'%');
                            }
                            $product_html .= '</td>';
                        }else{
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
                        }
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted($item->product_total_price, $item->product_currency).'</td>';
                        $product_html .= '</tr>';
                    }
                $product_html .= '</table>';
            }

            $data_array = array(
                'user' => $name,
                'phone' => $phone,
                'email' => $email,
                'order_id' => $order_data->order_number,
                'payment_status' => trans($order_data->payment_status),
                'payment_method' => $order_data->payment_method,
                'order_status'    => ($order_data->status == 1) ? trans("completed") : trans("order_processing"),
                'products'    => $product_html,
            );
            $template = $this->get_email_templates($this->selected_lang->id,'new_order_placed');
            $this->load->model('email_model');

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }
        }
        return true;
    }
    /* New Order Placed - Email */

    /* New Order Placed Receive - Email */
    public function send_new_order_receive_mail_seller($data){

        $name  = '';
        
        $phone = '';
        
        $email = '';
        
        if($data['seller_id'] > 0){

            $buyer = get_user($data['seller_id']);
            
            $name  = $buyer->first_name.' '.$buyer->last_name;
            
            $phone = $buyer->phone_number;
            
            $email = $buyer->email;
        
        }

        $data_array = array(
            
            'user'                  => $name,
            
            'phone'                 => $phone,
            
            'email'                 => $email,
            
            'order_id'              => $data['order_id'],
            
            'product_id'            => '', // $data['product_id'],
            
            'product_type'          => '', // $data['product_type'],
            
            'product_title'         => $data['product_title'],
            
            'product_slug'          => $data['product_slug'],
            
            'product_unit_price'    => get_price($data['product_unit_price'],'input'),
            
            'product_quantity'      => $data['product_quantity'],
            
            'product_currency'      => $data['product_currency'],
            
            'product_vat_rate'      => get_price($data['product_vat_rate'],'input'),
            
            'product_vat'           => $data['product_vat'],
            
            'product_shipping_cost' => get_price($data['product_shipping_cost'],'input'),
            
            'product_total_price'   => get_price($data['product_total_price'],'input'),
            
            'variation_option_ids'  => '', // $data['variation_option_ids'],
            
            'commission_rate'       => $data['commission_rate'],
            
            'order_status'          => trans($data['order_status']),
            
        );
        
        $this->load->model('email_model');

        $template = $this->get_email_templates($this->selected_lang->id,'new_order_received','seller');

        if(!empty($template)){
            
            $send_mail            = [];
            
            $send_mail['to']      = $data_array['email'];
            
            $send_mail['subject'] = $template->subject;
            
            $send_mail['message'] = email_template_replace($data_array,$template);
            
            $this->email_model->send_email_mail_template($send_mail);
        }
        
        return true;
    }
    /* New Order Placed Receive - Email */

    /* Order Staus Update - Email */
    public function send_order_status_update($product_id){
        $this->load->model('order_admin_model');
        $product = $this->order_admin_model->get_order_product($product_id);
        $order_data = $this->get_order($product->order_id);

        if(!empty($order_data)){

            if($order_data->buyer_id == 0){
                $shipping = get_order_shipping($order_data->id);
                $name  =  $shipping->shipping_first_name . " " . $shipping->shipping_last_name;
                $phone = $shipping->shipping_phone_number;
                $email = $shipping->shipping_email;
            }else{
                $buyer = get_user($order_data->buyer_id);
                $name  = $buyer->first_name.' '.$buyer->last_name;
                $phone = $buyer->phone_number;
                $email = $buyer->email;
            }

            $total_all = 0.00;

            $order_products = $this->get_order_products($product->order_id);
            
            $product_html = '';
            
            if(!empty($order_products)){
            
                $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
            
                $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';
            
                    foreach ($order_products as $item){
            
                        $total_all += currency_convert($item->product_total_price,$item->product_currency);

                        if($item->seller_id != $this->auth_user->id){
                            $this->send_order_status_update_seller($product_id,$seller_id);
                        } 

                        $product_html .= '<tr>';
                        
                        $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$item->product_title.'</td>';
                        
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_unit_price, $item->product_currency,'EUR'),'EUR').'</td>';

                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$item->product_quantity.'</td>';
                        
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_shipping_cost, $item->product_currency,'EUR'),'EUR').'</td>';

                        if (!empty($order->price_vat)){

                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                            if (!empty($item->product_vat)){
                                $product_html .= price_formatted(currency_convert($item->product_vat, $item->product_currency,'EUR').'EUR').' '.($item->product_vat_rate.'%');
                            }
                            $product_html .= '</td>';
                        }else{
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
                        }
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_total_price, $item->product_currency),'EUR').'</td>';
                        $product_html .= '</tr>';
                    }
                $product_html .= '</table>';
            }

            $data_array = array(
                'user' => $name,
                'phone' => $phone,
                'email' => $email,
                'order_id' => $order_data->order_number,
                'payment_status' => trans($order_data->payment_status),
                'payment_method' => $order_data->payment_method,
                'order_status'    => trans($product->order_status),
                'product_name'     => $product->product_title,
                'price' => price_formatted(currency_convert($product->product_unit_price,$product->product_currency,'EUR'),'EUR'),
                'quantity' => $product->product_quantity,
                'currency' => $product->product_currency, 
                // 'total' => price_currency_format(get_price(($product->product_unit_price*$product->product_quantity)),$product->product_currency),
                // 'total' => price_formatted(currency_convert($product->product_unit_price*$product->product_quantity,$product->product_currency,'EUR'),'EUR'), 
                'total'    => price_formatted($total_all,'EUR'),

                'products' => $product_html,
            );
            
            $template = $this->get_email_templates($this->selected_lang->id,'order_status');
            $this->load->model('email_model');

            if(!empty($template)){
                $subject_array        = ['order_status' => trans($product->order_status),'order_id' => $order_data->order_number];

                $send_mail            = [];
                $send_mail['to']      = $email;
                $send_mail['subject'] = email_subject_replace($subject_array,$template->subject);
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }
        }
        return true;
    }
    /* Order Staus Update - Email */

    /* Order Status Update - Seller Email */
    public function send_order_status_update_seller($product_id,$seller_id){
        $this->load->model('order_admin_model');
        $product = $this->order_admin_model->get_order_product($product_id);
        $order_data = $this->get_order($product->order_id);

        if(!empty($order_data)){

            $name = '';
            $phone = '';
            $email = '';

            if($product->seller_id > 0 && $product->seller_id != ''){
                $buyer = get_user($product->seller_id);
                $name  = $buyer->first_name.' '.$buyer->last_name;
                $phone = $buyer->phone_number;
                $email = $buyer->email;
            }

            $order_products = $this->get_order_products($product->order_id);
            $total_all = 0.00;
            
            $product_html = '';
            if(!empty($order_products)){
                $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
                $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';
                    foreach ($order_products as $item){

                        if($item->seller_id == $product->seller_id){

                            $total_all += currency_convert($item->product_total_price,$item->product_currency);
                            
                            $product_html .= '<tr>';
                            
                            $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$item->product_title.'</td>';
                            
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_unit_price, $item->product_currency,'EUR'),'EUR').'</td>';

                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$item->product_quantity.'</td>';
                            
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_shipping_cost, $item->product_currency,'EUR'),'EUR').'</td>';

                            if (!empty($order->price_vat)){

                                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                                if (!empty($item->product_vat)){
                                    $product_html .= price_formatted(currency_convert($item->product_vat,$item->product_currency,'EUR'), 'EUR').' '.($item->product_vat_rate.'%');
                                }
                                $product_html .= '</td>';
                            }else{
                                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
                            }
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_total_price, $item->product_currency),'EUR').'</td>';

                            $product_html .= '</tr>';
                        } 

                    }
                $product_html .= '</table>';
            }

            $data_array = array(
                'user' => $name,
                'phone' => $phone,
                'email' => $email,
                'order_id' => $order_data->order_number,
                'payment_status' => trans($order_data->payment_status),
                'payment_method' => $order_data->payment_method,
                'order_status'    => trans($product->order_status),
                'product_name'     => $product->product_title,
                'price' => price_formatted(currency_convert($product->product_unit_price,$product->product_currency,'EUR'),'EUR'),
                'quantity' => $product->product_quantity,
                'currency' => $product->product_currency, 
                // 'total' => price_currency_format(get_price(($product->product_unit_price*$product->product_quantity)),$product->product_currency),
                // 'total' => price_formatted(currency_convert($product->product_unit_price*$product->product_quantity,$product->product_currency,'EUR'),'EUR'), 
                'total'    => price_formatted($total_all,'EUR'),
                'products' => $product_html
            );
            
            $template = $this->get_email_templates($this->selected_lang->id,'order_status');
            $this->load->model('email_model');

            if(!empty($template) && $email != ''){
                $subject_array        = ['order_status' => trans($product->order_status),'order_id' => $order_data->order_number];

                $send_mail            = [];
                $send_mail['to']      = $email;
                $send_mail['subject'] = email_subject_replace($subject_array,$template->subject);
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }
        }
        return true;
    }
    /* Order Status Update - Seller Email */

    /* Update Bank Payment */
    public function send_bank_transfer_payment_update($data){
        $order_data = $this->get_order_by_order_number($data['order_number']);
        if(!empty($order_data)){
            $user = get_user(1);

            if($order_data->buyer_id == 0){
                $shipping = get_order_shipping($order_data->id);
                $buyer_name  =  $shipping->shipping_first_name . " " . $shipping->shipping_last_name;
                $buyer_phone = $shipping->shipping_phone_number;
                $buyer_email = $shipping->shipping_email;
            }else{
                $buyer = get_user($order_data->buyer_id);
                $buyer_name  = $buyer->first_name.' '.$buyer->last_name;
                $buyer_phone = $buyer->phone_number;
                $buyer_email = $buyer->email;
            }

            $data_array = array(
                'user' => $user->first_name,
                'phone' => $user->phone_number,
                'email' => $user->email,
                'buyer_name' => $buyer_name,
                'buyer_email' => $buyer_phone,
                'buyer_phone' => $buyer_email,
                'order_id' => $data['order_number'],
                'payment_status' => trans($order_data->payment_status),
                'payment_method' => $order_data->payment_method,
                'order_status'    => ($order_data->status == 1) ? trans("completed") : trans("order_processing"),
                'payment_note'  => $data['payment_note'],
            );


            $template = $this->get_email_templates($this->selected_lang->id,'bank_transfer_report_to_admin','admin');
            $this->load->model('email_model');
            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = 'sawanshakya1995@gmail.com';
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }

        }
    }
    /* Update Bank Payment */

    /* Update Order Payment Status */
    public function update_order_payment_status($order_id){

        $order_data = $this->get_order($order_id);

        if(!empty($order_data)){

            if($order_data->buyer_id == 0){
                $shipping = get_order_shipping($order_data->id);
                $name  =  $shipping->shipping_first_name . " " . $shipping->shipping_last_name;
                $phone = $shipping->shipping_phone_number;
                $email = $shipping->shipping_email;
            }else{
                $buyer = get_user($order_data->buyer_id);
                $name  = $buyer->first_name.' '.$buyer->last_name;
                $phone = $buyer->phone_number;
                $email = $buyer->email;
            }

            $total_all = 0.00;
            
            $order_products = $this->get_order_products($order_id);
            
            $product_html = '';
            
            if(!empty($order_products)){
                $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
                $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';
                    foreach ($order_products as $item){
                        
                        $total_all += currency_convert($item->product_total_price,$item->product_currency);
                        
                        if($item->seller_id != $this->auth_user->id){
                            $this->update_order_payment_status_seller($order_id,$item->seller_id);
                        } 

                        $product_html .= '<tr>';
                        
                        $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$item->product_title.'</td>';
                        
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_unit_price, $item->product_currency,'EUR'),'EUR').'</td>';

                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$item->product_quantity.'</td>';
                        
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_shipping_cost, $item->product_currency,'EUR'),'EUR').'</td>';

                        if (!empty($order->price_vat)){

                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                            if (!empty($item->product_vat)){
                                $product_html .= price_formatted(currency_convert($item->product_vat, $item->product_currency,'EUR').'EUR').' '.($item->product_vat_rate.'%');
                            }
                            $product_html .= '</td>';
                        }else{
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
                        }
                        $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_total_price, $item->product_currency),'EUR').'</td>';
                        $product_html .= '</tr>';
                    }
                $product_html .= '</table>';
            }
            
            $data_array = array(
                'user' => $name,
                'phone' => $phone,
                'email' => $email,
                'order_id' => $order_data->order_number,
                'payment_status' => trans('payment_received'),
                'payment_method' => $order_data->payment_method,
                'order_status'    => trans('payment_received'),
                'total'    => price_formatted($total_all,'EUR'),
                // 'product_name'     => $product->product_title,
                // 'price' => price_formatted(currency_convert($product->product_unit_price,$product->product_currency,'EUR'),'EUR'),
                // 'quantity' => $product->product_quantity,
                // 'currency' => $product->product_currency, 
                // 'total' => price_currency_format(get_price(($product->product_unit_price*$product->product_quantity)),$product->product_currency),
                // 'total' => price_formatted(currency_convert($product->product_unit_price*$product->product_quantity,$product->product_currency,'EUR'),'EUR'), 
                'products' => $product_html,
            );
            
            $template = $this->get_email_templates($this->selected_lang->id,'order_status');
            $this->load->model('email_model');

            if(!empty($template) && $email != ''){
                $subject_array        = ['order_status' => trans($product->order_status),'order_id' => $order_data->order_number];

                $send_mail            = [];
                $send_mail['to']      = $email;
                $send_mail['subject'] = email_subject_replace($subject_array,$template->subject);
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }
        }
        return true;
    }
    /* Update Order Payment Status */

    public function update_order_payment_status_seller($order_id,$seller_id){
        $order_data = $this->get_order($order_id);

        if(!empty($order_data)){

            $name  = '';
            $phone = '';
            $email = '';

            if($seller_id > 0 && $seller_id != ''){
                $buyer = get_user($seller_id);
                $name  = $buyer->first_name.' '.$buyer->last_name;
                $phone = $buyer->phone_number;
                $email = $buyer->email;
            }

            $order_products = $this->get_order_products($order_id);
            $total_all = 0.00;
            $product_html = '';
            if(!empty($order_products)){
                $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
                $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';
                    foreach ($order_products as $item){

                        if($item->seller_id == $seller_id){
                        
                            $total_all += currency_convert($item->product_total_price,$item->product_currency);
                            
                            $product_html .= '<tr>';
                            
                            $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$item->product_title.'</td>';
                            
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_unit_price, $item->product_currency),'EUR').'</td>';

                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$item->product_quantity.'</td>';
                            
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_shipping_cost, $item->product_currency),'EUR').'</td>';

                            if (!empty($order->price_vat)){

                                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                                if (!empty($item->product_vat)){
                            
                                    $product_html .= price_formatted(currency_convert($item->product_vat, $item->product_currency).'EUR').' '.($item->product_vat_rate.'%');
                            
                                }
                            
                                $product_html .= '</td>';
                            
                            }else{
                            
                                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
                            
                            }
                            
                            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($item->product_total_price, $item->product_currency),'EUR').'</td>';

                            $product_html .= '</tr>';
                            
                        } 

                    }
                $product_html .= '</table>';
            }

            $data_array = array(
                'user' => $name,
                'phone' => $phone,
                'email' => $email,
                'order_id' => $order_data->order_number,
                'payment_status' => trans('payment_received'),
                'payment_method' => $order_data->payment_method,
                'order_status'    => trans('payment_received'),
                'total'    => price_formatted($total_all,'EUR'),
                'products' => $product_html,
            );
            
            $template = $this->get_email_templates($this->selected_lang->id,'order_status');
            $this->load->model('email_model');

            if(!empty($template) && $email!=''){
                $subject_array        = ['order_status' => trans('payment_received'),'order_id' => $order_data->order_number];

                $send_mail            = [];
                $send_mail['to']      = $email;
                $send_mail['subject'] = email_subject_replace($subject_array,$template->subject);
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }
        }
        return true;
    }

    /* Send Shipping Details - Email*/
    public function send_shipping_details($data,$order_product){

        $name  = '';
        $phone = '';
        $email = '';
        if($order_product->buyer_id > 0 && $order_product->buyer_id != ''){
            $buyer = get_user($order_product->buyer_id);
            $name  = $buyer->first_name.' '.$buyer->last_name;
            $phone = $buyer->phone_number;
            $email = $buyer->email;
        }

        $product_html = '';
        if(!empty($order_product)){
            $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
            $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';

            $product_html .= '<tr>';
                        
            $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$order_product->product_title.'</td>';
            
            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($order_product->product_unit_price, $order_product->product_currency,'EUR'),'EUR').'</td>';

            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$order_product->product_quantity.'</td>';
            
            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($order_product->product_shipping_cost, $order_product->product_currency,'EUR'),'EUR').'</td>';

            if (!empty($order->price_vat)){

                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                if (!empty($order_product->product_vat)){
            
                    $product_html .= price_formatted(currency_convert($order_product->product_vat, $order_product->product_currency,'EUR').'EUR').' '.($order_product->product_vat_rate.'%');
            
                }
            
                $product_html .= '</td>';
            
            }else{
            
                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
            
            }
            
            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($order_product->product_total_price, $order_product->product_currency),'EUR').'</td>';
            
            $product_html .= '</tr>';

            $product_html .= '</table>';
        }

        $data_array = array(
            'user' => $name,
            'phone' => $phone,
            'email' => $email,
            'order_id' => '#'.($order_product->order_id + 10000),
            'shipping_tracking_number' => $data['shipping_tracking_number'],
            'shipping_tracking_url' => $data['shipping_tracking_url'],
            'products' => $product_html,
        );

        $template = $this->get_email_templates($this->selected_lang->id,'shipping_details');
       
        $this->load->model('email_model');

        if(!empty($template) && $email != ''){
            $subject_array        = ['order_status' => trans($order_product->order_status),'order_id' => ($order_product->order_id + 10000)];

            $admin = get_user(1);
            $admin_email = $admin->email;

            $send_mail            = [];
            $send_mail['to']      = $email;
            $send_mail['subject'] = email_subject_replace($subject_array,$template->subject);
            $send_mail['message'] = email_template_replace($data_array,$template);
            $this->email_model->send_email_mail_template($send_mail,$admin_email);
        }

        
    }
    /* Send Shipping Details - Email*/

    /*order_received_send_email*/
    public function order_received_send_email($data,$order_product){

        $name  = '';
        $phone = '';
        $email = '';

        $order = $this->get_order($order_product->order_id);

        if($order_product->seller_id > 0 && $order_product->seller_id != ''){
            $buyer = get_user($order_product->seller_id);
            $name  = $buyer->first_name.' '.$buyer->last_name;
            $phone = $buyer->phone_number;
            $email = $buyer->email;
        }

        $product_html = '';
        if(!empty($order_product)){
            $product_html = '<table  role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">';
            $product_html .= '<tr><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("product").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("unit_price").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("quantity").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("shipping").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("vat").'</th><th style="padding: 10px 0; border-bottom: 2px solid #ddd;">'.trans("total").'</th></tr>';

            $product_html .= '<tr>';
                        
            $product_html .= '<td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;">'.$order_product->product_title.'</td>';
            
            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($order_product->product_unit_price, $order_product->product_currency,'EUR'),'EUR').'</td>';

            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.$order_product->product_quantity.'</td>';
            
            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($order_product->product_shipping_cost, $order_product->product_currency,'EUR'),'EUR').'</td>';

            if (!empty($order->price_vat)){

                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">';

                if (!empty($order_product->product_vat)){
            
                    $product_html .= price_formatted(currency_convert($order_product->product_vat, $order_product->product_currency,'EUR').'EUR').' '.($order_product->product_vat_rate.'%');
            
                }
            
                $product_html .= '</td>';
            
            }else{
            
                $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>';
            
            }
            
            $product_html .= '<td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">'.price_formatted(currency_convert($order_product->product_total_price, $order_product->product_currency),'EUR').'</td>';
            
            $product_html .= '</tr>';

            $product_html .= '</table>';
        }

        $data_array = array(
            'user'      => $name,
            'phone'     => $phone,
            'email'     => $email,
            'order_id'  => $order->order_number,
            'order_status' => trans('completed'),
            'payment_status' => trans('payment_received'),
            'products' => $product_html,
        );

        $template = $this->get_email_templates($this->selected_lang->id,'order_received','seller');
       
        $this->load->model('email_model');

        if(!empty($template) && $email != ''){
            $subject_array        = ['order_status' => trans($order_product->order_status),'order_id' => $order->order_number];

            $admin_email = '';
            
            $admin       = get_user(1);
            
            if($admin){
            
                $admin_email = $admin->email;
            
            }

            $send_mail            = [];
            $send_mail['to']      = $email;
            $send_mail['subject'] = email_subject_replace($subject_array,$template->subject);
            $send_mail['message'] = email_template_replace($data_array,$template);
            $this->email_model->send_email_mail_template($send_mail,$admin_email);
        }
    }

    /* Get Email Templates by Set Language */
    public function get_email_templates($lang_id="",$template_name="",$user_type="user"){
        $this->db->select('*');
        $this->db->where('email_templates.name',$template_name);
        $this->db->where('email_templates.user_type',$user_type);
        $this->db->where('email_templates_messages.language_id',$lang_id);
        $this->db->join('email_templates_messages','email_templates_messages.email_templates_id = email_templates.id','LEFT JOIN');
        return $this->db->get('email_templates')->row();
    }
    /* Get Email Templates by Set Language */

	
public function add_order_d($data_transaction, $cart, $data_ship = [])
    {
	
        $cart_total = $this->cart_model->calculate_cart_total_d($cart);
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => $cart_total->subtotal,
                'price_vat' => $cart_total->vat,
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $cart_total->total,
                'price_currency' => $cart_total->currency,
                'status' => 2,
                'payment_method' => $data_transaction["payment_method"],
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            //if cart does not have physical product
			/*
            if ($this->cart_model->check_cart_has_physical_product_d($cart) != true) {
                $data["status"] = 1;
            }
*/
			
$data["status"] = 2;

            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping_d($order_id, $cart, $data_ship);
                //add order products
                $this->add_order_products_d($order_id, 'payment_received', $cart);

                //add digital sales
                $this->add_digital_sales($order_id);

                //add seller earnings
                $this->add_digital_sales_seller_earnings($order_id);

                //add payment transaction
                $this->add_payment_transaction($data_transaction, $order_id);

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                // New Order Placed
                $this->send_new_order_mail($order_id);

                return $order_id;
            }
            return false;
        }
        return false;
    }
	
public function add_order_shipping_d($order_id, $shipping_address, $data_ship = [])
    {
		$data = $data_ship['billings_details'];
		$names = explode(' ', $data['name']);
        $order_id = clean_number($order_id);
            $data = array(
                'order_id' => $order_id,
                'shipping_first_name' => $names[0],
                'shipping_last_name' => $names[1],
                'shipping_email' => $data['email'],
                'shipping_phone_number' => $data['phone'],
                'shipping_address_1' => $data['address']['line1'],
                'shipping_address_2' => $data['address']['line2'],
                'shipping_country' => $data['address']['country'],
                'shipping_state' => $data['address']['state'],
                'shipping_city' => $data['address']['city'],
                'shipping_zip_code' => $data['address']['postal_code'],
                'billing_first_name' => $names[0],
                'billing_last_name' => $names[1],
                'billing_email' => $data['email'],
                'billing_phone_number' => $data['phone'],
                'billing_address_1' => $data['address']['line1'],
                'billing_address_2' => $data['address']['line2'],
                'billing_country' => $data['address']['country'],
                'billing_state' => $data['address']['state'],
                'billing_city' => $data['address']['city'],
                'billing_zip_code' => $data['address']['postal_code']
				);

            $this->db->insert('order_shipping', $data);
        }
    

public function add_order_products_d($order_id, $order_status, $cart)
    {
        $order_id = clean_number($order_id);
        $cart_items = $cart;
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                $product = $this->product_model->get_product_by_id($cart_item->product_id);
                $variation_option_ids = @serialize($cart_item->options_array);
                if (!empty($product)) {
                    $data = array(
                        'order_id' => $order_id,
                        'seller_id' => $product->user_id,
                        'buyer_id' => 0,
                        'buyer_type' => "guest",
                        'product_id' => $product->id,
                        'product_type' => $product->product_type,
                        'product_title' => $cart_item->product_title,
                        'product_slug' => $product->slug,
                        'product_unit_price' => $cart_item->unit_price,
                        'product_quantity' => $cart_item->quantity,
                        'product_currency' => $cart_item->currency,
                        'product_vat_rate' => $product->vat_rate,
                        'product_vat' => $cart_item->product_vat,
                        'product_shipping_cost' => $cart_item->shipping_cost,
                        'product_total_price' => $cart_item->total_price,
                        'variation_option_ids' => $variation_option_ids,
                        'commission_rate' => $this->general_settings->commission_rate,
                        'order_status' => $order_status,
                        'is_approved' => 0,
                        'shipping_tracking_number' => "",
                        'shipping_tracking_url' => "",
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->auth_check) {
                        $data["buyer_id"] = $this->auth_user->id;
                        $data["buyer_type"] = "registered";
                    }
                    //approve if digital product
                    if ($product->product_type == 'digital') {
                        $data["is_approved"] = 1;
                        if ($order_status == 'payment_received') {
                            $data["order_status"] = 'completed';
                        } else {
                            $data["order_status"] = $order_status;
                        }
                    }


                    $data["product_total_price"] = $cart_item->total_price + $cart_item->product_vat + $cart_item->shipping_cost;
                   

                    $this->db->insert('order_products', $data);
                }
            }
        }
    }

}
