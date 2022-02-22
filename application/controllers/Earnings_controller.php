<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Earnings_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }
        if (!is_sale_active()) {
            redirect(lang_base_url());
        }
        $this->earnings_per_page = 15;
        $this->user_id = $this->auth_user->id;
    }

    /**
     * Earnings
     */
    public function earnings()
    {
        $data['title'] = trans("earnings");
        $data['description'] = trans("earnings") . " - " . $this->app_name;
        $data['keywords'] = trans("earnings") . "," . $this->app_name;
        $data["active_tab"] = "earnings";
        $data['user'] = $this->auth_user;
        $data['current_user_session'] = get_user_session();

        $pagination = $this->paginate(generate_url("earnings"), $this->earnings_model->get_earnings_count($this->user_id), $this->earnings_per_page);
        $data['earnings'] = $this->earnings_model->get_paginated_earnings($this->user_id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('earnings/earnings', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Payouts
     */
    public function payouts()
    {
        $data['title'] = trans("payouts");
        $data['description'] = trans("payouts") . " - " . $this->app_name;
        $data['keywords'] = trans("payouts") . "," . $this->app_name;
        $data["active_tab"] = "payouts";
        $data['user'] = $this->auth_user;
        $data['current_user_session'] = get_user_session();
        $pagination = $this->paginate(generate_url("earnings"), $this->earnings_model->get_payouts_count($this->user_id), $this->earnings_per_page);
        $data['payouts'] = $this->earnings_model->get_paginated_payouts($this->user_id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('earnings/payouts', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Set Payout Account
     */
    public function set_payout_account()
    {
        
        $data['title'] = trans("set_payout_account");
        $data['description'] = trans("set_payout_account") . " - " . $this->app_name;
        $data['keywords'] = trans("set_payout_account") . "," . $this->app_name;
        $data["active_tab"] = "set_payout_account";
        $data["countries"] = $this->location_model->get_countries();
        $data['states'] = $this->location_model->get_states();
        $data['user'] = $this->auth_user;
        $data['current_user_session'] = get_user_session();
        $data['user_payout'] = $this->earnings_model->get_user_payout_account($data['user']->id);

        if (empty($this->session->flashdata('msg_payout'))) {
            if ($this->payment_settings->payout_paypal_enabled) {
                $this->session->set_flashdata('msg_payout', "paypal");
            } elseif ($this->payment_settings->payout_iban_enabled) {
                $this->session->set_flashdata('msg_payout', "iban");
            } elseif ($this->payment_settings->payout_swift_enabled) {
                $this->session->set_flashdata('msg_payout', "swift");
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('earnings/set_payout_account', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Set Paypal Payout Account Post
     */
    public function set_paypal_payout_account_post()
    {
        if ($this->earnings_model->set_paypal_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "paypal");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "paypal");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Set IBAN Payout Account Post
     */
    public function set_iban_payout_account_post()
    {
        if ($this->earnings_model->set_iban_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Set SWIFT Payout Account Post
     */
    public function set_swift_payout_account_post()
    {
        if ($this->earnings_model->set_swift_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "swift");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "swift");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Other Payout Post
     */
    public function set_other_payout_account_post()
    {   
        $payour_name = $this->input->post('payout_name');
        if ($this->earnings_model->set_other_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', $payour_name);
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', $payour_name);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    /**
     * Withdraw Money Post
     */
    public function withdraw_money_post()
    {       
        $payout_id = $this->input->post('payout_method', true); 

        $this->db->where('id', $payout_id);
        $this->db->select('input_data');
        $this->db->select('set_input_data');
        $query = $this->db->get('payout_settings');
        $data = array(
            'user_id' => $this->user_id,
            // 'payout_method' => str_replace(' ','_',strtolower(get_payout_name($payout_id))),
            'payout_method' => get_payout_name($payout_id),
            'amount' => $this->input->post('amount', true),
            'currency' => $this->input->post('currency', true),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'input_data_new' => $query->row()->input_data,
            'set_input_data_new' => $query->row()->set_input_data
        );
        $data["amount"] = get_price($data["amount"], 'database');

        //check active payouts
        $active_payouts = $this->earnings_model->get_active_payouts($this->user_id);
        if (!empty($active_payouts)) {
            $this->session->set_flashdata('error', trans("active_payment_request_error"));
            redirect($this->agent->referrer());
        }

        $min = 0;

        if(!empty($this->payout_settings)){
            foreach ($this->payout_settings as $key => $setting) {

                /* Paypal Payout Method */
                if ($payout_id == $setting->id && strtolower($setting->name) == 'paypal') {
                    //check PayPal email
                    $payment_method = $setting->name;
                    $payout_paypal_email = $this->earnings_model->get_user_payout_account($this->auth_user->id);
                    if (empty($payout_paypal_email) || empty($payout_paypal_email->payout_paypal_email)) {
                        $this->session->set_flashdata('error', trans("msg_payout_paypal_error"));
                        redirect($this->agent->referrer());
                    }
                    $min = $setting->minimum_amount;
                    /* Paypal Payout Method */
                    break;
                }else if ($payout_id == $setting->id && strtolower($setting->name) == "iban") {
                
                    /* IBAN Payout Method */
                    $min = $setting->minimum_amount;
                    // $min = $this->payment_settings->min_payout_iban;
                    /* IBAN Payout Method */
                    break;
                }else if ($payout_id == $setting->id && strtolower($setting->name) == "swift") {
                
                    /* SWIFT Payout Method */
                    $min = $setting->minimum_amount;
                    // $min = $this->payment_settings->min_payout_swift;
                    /* SWIFT Payout Method */
                    break;
                }else if($payout_id == $setting->id){

                    /* Other Payout Methods */
                    /* Other Payout Methods */
                    $min = $setting->minimum_amount;
                    /* Other Payout Methods */
                    break;
                }

            }
        }

        /* Old Code */
        /*
            if (strtolower($data["payout_method"]) == "paypal") {
                //check PayPal email
                $payout_paypal_email = $this->earnings_model->get_user_payout_account($this->auth_user->id);
                if (empty($payout_paypal_email) || empty($payout_paypal_email->payout_paypal_email)) {
                    $this->session->set_flashdata('error', trans("msg_payout_paypal_error"));
                    redirect($this->agent->referrer());
                }
                $min = $this->payment_settings->min_payout_paypal;
            }
            if (strtolower($data["payout_method"]) == "iban") {
                $min = $this->payment_settings->min_payout_iban;
            }
            if (strtolower($data["payout_method"]) == "swift") {
                $min = $this->payment_settings->min_payout_swift;
            }
        */
        /* Old Code */

        if ($data["amount"] <= 0) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        if ($data["amount"] < $min) {
            $this->session->set_flashdata('error', trans("invalid_withdrawal_amount"));
            redirect($this->agent->referrer());
        }
        if ($data["amount"] > $this->auth_user->balance) {
            $this->session->set_flashdata('error', trans("invalid_withdrawal_amount"));
            redirect($this->agent->referrer());
        }
        if (!$this->earnings_model->withdraw_money($data)) {
            $this->session->set_flashdata('error', trans("msg_error"));
        }else{

            $this->send_payout_request_mail_to_admin($data);

            $this->send_payout_request_mail_to_seller($data);

            $this->session->set_flashdata('success', trans("payment_request_success"));
        }
        redirect($this->agent->referrer());
        
    }

    public function send_payout_request_mail_to_admin($data){
        
        $user = '';
        $email = '';
        $phone = '';

        $admin = get_user(1);

        if($admin){
            $user = $admin->username;
            $email = $admin->email;
            $phone = $admin->phone_number;
        }
        $data_array = array(
            'user'          => $user,
            'phone'         => $phone,
            'email'         => $email,
            'amount'        => price_formatted($data['amount'],'EUR'),
            'status'        => ($data['status'] == 0) ? trans('pending') : trans('completed') ,
            'currency'      => $data['currency'],
            'created_at'    => $data['created_at'],
            'payout_method' => $data['payout_method']
        );

        $this->load->model('order_model');

        $this->load->model('email_model');

        $template = $this->order_model->get_email_templates($this->selected_lang->id,'payout_requests','admin');

        if(!empty($template) && $email != ''){
            $send_mail            = [];
            $send_mail['to']      = $email;
            $send_mail['subject'] = $template->subject;
            $send_mail['message'] = email_template_replace($data_array,$template);
            $this->email_model->send_email_mail_template($send_mail);
        }
        return true;
    }

    public function send_payout_request_mail_to_seller($data){
        
        $user = '';
        $email = '';
        $phone = '';

        if($this->auth_user){
            $user = $this->auth_user->username;
            $email = $this->auth_user->email;
            $phone = $this->auth_user->phone_number;
        }

        $data_array = array(
            'user'          => $user,
            'phone'         => $phone,
            'email'         => $email,
            'amount'        => price_formatted($data['amount'],'EUR'),
            'status'        => ($data['status'] == 0) ? trans('pending') : trans('completed') ,
            'currency'      => $data['currency'],
            'created_at'    => $data['created_at'],
            'payout_method' => $data['payout_method']
        );

        $this->load->model('order_model');

        $this->load->model('email_model');

        $template = $this->order_model->get_email_templates($this->selected_lang->id,'payout_requests','seller');

        if(!empty($template)  && $email != ''){
            $send_mail            = [];
            $send_mail['to']      = $email;
            $send_mail['subject'] = $template->subject;
            $send_mail['message'] = email_template_replace($data_array,$template);
            $this->email_model->send_email_mail_template($send_mail);
        }
        return true;



    }










        

}
