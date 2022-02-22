<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Earnings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->initialize_earnings();
    }

    //get earnings count
    public function get_earnings_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('earnings');
        return $query->num_rows();
    }

    //get paginated earnings
    public function get_paginated_earnings($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('earnings.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('earnings');
        return $query->result();
    }

    //add seller earnings
    public function add_seller_earnings($order_product)
    {   
        if (!empty($order_product)) {
            $order = $this->order_model->get_order($order_product->order_id);
            if (!empty($order)) {
                $earned_amount = $this->calculate_earned_amount($order_product);

                //add earning
                $data = array(
                    'order_number' => $order->order_number,
                    'user_id' => $order_product->seller_id,
                    'price' => $order_product->product_unit_price * $order_product->product_quantity,
                    'commission_rate' => $order_product->commission_rate,
                    'shipping_cost' => $order_product->product_shipping_cost,
                    'earned_amount' => $earned_amount,
                    'currency' => $order_product->product_currency,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->db->insert('earnings', $data);

                //update seller balance and number of sales
                $user = get_user($order_product->seller_id);
                if (!empty($user)) {
                    
                    $earned_amount = currency_convert($earned_amount,$order_product->product_currency,'EUR');

                    $new_balance = $user->balance;
                    if ($order->payment_method != "Cash On Delivery") {
                        $new_balance = $user->balance + $earned_amount;
                    }
                    $sales = $user->number_of_sales;
                    $sales = $sales + 1;
                    $data = array(
                        'balance' => $new_balance,
                        'number_of_sales' => $sales
                    );
                    $this->db->where('id', $user->id);
                    $this->db->update('users', $data);
                }
            }
        }
    }

    //remove seller earnings
    public function remove_seller_earnings($order_product)
    {
        if (!empty($order_product)) {
            $order = $this->order_model->get_order($order_product->order_id);
            if (!empty($order)) {
                $earned_amount = $this->calculate_earned_amount($order_product);
                // echo $earned_amount;
                // echo '<br>';
                // echo $earned_amount = currency_convert($earned_amount,$order_product->product_currency,'EUR');
                // exit;
                $this->db->where('order_number', $order->order_number);
                $this->db->where('user_id', $order_product->seller_id);
                $this->db->delete('earnings');

                //update seller balance and number of sales
                $user = get_user($order_product->seller_id);
                if (!empty($user)) {

                    $earned_amount = currency_convert($earned_amount,$order_product->product_currency,'EUR');

                    $balance = $user->balance;
                    $new_balance = $balance - $earned_amount;
                    $sales = $user->number_of_sales;
                    $sales = $sales - 1;
                    $data = array(
                        'balance' => $new_balance,
                        'number_of_sales' => $sales
                    );
                    $this->db->where('id', $user->id);
                    $this->db->update('users', $data);
                }
            }
        }
    }

    //calculate earned amount
    public function calculate_earned_amount($order_product)
    {
        if (!empty($order_product)) {
            $price = $order_product->product_unit_price * $order_product->product_quantity;
            $earned = $price - (($price * $order_product->commission_rate) / 100);
            $total_earned_amount = $earned + $order_product->product_shipping_cost;
            return $total_earned_amount;
        }
        return 0;
    }

    //get order earning by user id
    public function get_earning_by_user_id($user_id, $order_number)
    {
        $this->db->where('order_number', $order_number);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('earnings');
        return $query->row();
    }

    //get user payout account
    public function get_user_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_payout_accounts');
        $row = $query->row();

        if (!empty($row)) {
            return $row;
        } else {
            $data = array(
                'user_id' => $user_id,
                'payout_paypal_email' => "",
                'iban_full_name' => "",
                'iban_country_id' => "",
                'iban_bank_name' => "",
                'iban_number' => "",
                'swift_full_name' => "",
                'swift_address' => "",
                'swift_state' => "",
                'swift_city' => "",
                'swift_postcode' => "",
                'swift_country_id' => "",
                'swift_bank_account_holder_name' => "",
                'swift_iban' => "",
                'swift_code' => "",
                'swift_bank_name' => "",
                'swift_bank_branch_city' => "",
                'swift_bank_branch_country_id' => ""
            );
            $this->db->insert('user_payout_accounts', $data);

            $this->db->where('user_id', $user_id);
            $query = $this->db->get('user_payout_accounts');
            return $query->row();
        }
    }

    //set paypal payout account
    public function set_paypal_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'payout_paypal_email' => $this->input->post('payout_paypal_email', true)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('user_payout_accounts', $data);
    }

    // set other payout account
    public function set_other_payout_account($user_id)
    {   
        // $this->settings_model->add_payout_account_model();  
        $user_id = clean_number($user_id);
        if($this->input->post('id') == ''){
            $data = array(
                'user_id'       => $user_id,
                'payout_id'     => $this->input->post('payout_id'),
                'payout_name'   => $this->input->post('payout_name'),
                'email'         => $this->input->post('payout_other_email', true),
                'phone'         => $this->input->post('payout_other_phone', true),
            );
            if($this->db->insert('user_other_payout_accounts', $data)){
                return true;
            }
        }else{
            $data = array(
                'email'     => $this->input->post('payout_other_email', true),
                'phone'     => $this->input->post('payout_other_phone', true),
            );
            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('user_other_payout_accounts', $data);
        }
        return false;
    }

    // set other payout account
    // public function set_other_payout_account($user_id)
    // {
    //     $user_id = clean_number($user_id);
    //     $data = array(
    //         'payout_other_email' => $this->input->post('payout_other_email', true),
    //         'payout_other_phone' => $this->input->post('payout_other_phone', true),
    //     );
    //     $this->db->where('user_id', $user_id);
    //     return $this->db->update('user_payout_accounts', $data);
    // }

    //set iban payout account
    public function set_iban_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'iban_full_name' => $this->input->post('iban_full_name', true),
            'iban_country_id' => $this->input->post('iban_country_id', true),
            'iban_bank_name' => $this->input->post('iban_bank_name', true),
            'iban_number' => $this->input->post('iban_number', true),
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('user_payout_accounts', $data);
    }

    //set swift payout account
    public function set_swift_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'swift_full_name' => $this->input->post('swift_full_name', true),
            'swift_address' => $this->input->post('swift_address', true),
            'swift_state' => $this->input->post('swift_state', true),
            'swift_city' => $this->input->post('swift_city', true),
            'swift_postcode' => $this->input->post('swift_postcode', true),
            'swift_country_id' => $this->input->post('swift_country_id', true),
            'swift_bank_account_holder_name' => $this->input->post('swift_bank_account_holder_name', true),
            'swift_iban' => $this->input->post('swift_iban', true),
            'swift_code' => $this->input->post('swift_code', true),
            'swift_bank_name' => $this->input->post('swift_bank_name', true),
            'swift_bank_branch_city' => $this->input->post('swift_bank_branch_city', true),
            'swift_bank_branch_country_id' => $this->input->post('swift_bank_branch_country_id', true)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('user_payout_accounts', $data);
    }

    //set swift payout account
    public function initialize_earnings()
    {
        if (@SITE_MDS_KEY != @sha1(gt_sys_suffx() . gt_dmn_cd())) {
            @subclass_prf_pst();
        }
    }

    //get payouts count
    public function get_payouts_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('payouts');
        return $query->num_rows();
    }

    //get paginated payouts
    public function get_paginated_payouts($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('payouts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //get active payouts
    public function get_active_payouts($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('payouts.created_at', 'DESC');
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //withdraw money
    public function withdraw_money($data)
    {
        return $this->db->insert('payouts', $data);
    }

    //withdraw money
    public function last_withdrawn_date($user_id)
    {   
        $this->db->select();
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->limit(1)->order_by('id',"DESC");
        $query = $this->db->get('payouts')->row();
        if(!empty($query)){
            return date('Y-m-d',strtotime($query->created_at));
        }
        return false;
    }

}
