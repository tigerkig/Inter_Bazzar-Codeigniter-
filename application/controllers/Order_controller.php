<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!is_sale_active()) {
            redirect(lang_base_url());
        }
        $this->order_per_page = 15;
        $this->earnings_per_page = 15;
        $this->user_id = $this->auth_user->id;
    }

    /**
     * Orders
     */
    public function orders()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "active_orders";

        $pagination = $this->paginate(generate_url("orders"), $this->order_model->get_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_orders($this->user_id, $pagination['per_page'], $pagination['offset']);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Completed Orders
     */
    public function completed_orders()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "completed_orders";

        $pagination = $this->paginate(generate_url("orders", "completed_orders"), $this->order_model->get_completed_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_completed_orders($this->user_id, $pagination['per_page'], $pagination['offset']);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders', $data);
        $this->load->view('partials/_footer');
    }

    public function refund_orders()
    {
        $data['title'] = trans("refund_orders");
        $data['description'] = trans("refund_orders") . " - " . $this->app_name;
        $data['keywords'] = trans("refund_orders") . "," . $this->app_name;
        $data["active_tab"] = "refund_orders";

        $pagination = $this->paginate(generate_url("orders", "refund_orders"), $this->order_model->get_completed_refund_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_refunds($this->user_id, $pagination['per_page'], $pagination['offset']);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('order/refund_orders', $data);
        $this->load->view('partials/_footer');
    }


    public function edit_refund_order()
    {
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
    
        
        
        $code = $this->input->post('refund_track_code', true);
        $id = $this->input->post('refund_id', true);
        $data = [
            'refund_track_code' => $code,
        ];
        
        $this->db->join('order_products','refunds.refund_order_product_id = order_products.id');
        $row = $this->db->get_where('refunds', ['refunds.id' => intval($id)])->result()[0]; 
        

        if (is_null($row)) {
            redirect($this->agent->referrer());
        }
        
        $this->db->where('id', intval($id));
        $this->db->update('refunds', $data);

        $this->session->set_flashdata('success', trans("msg_updated"));


        redirect($this->agent->referrer());
       
        
    }


    /**
     * Order
     */
    public function order($order_number)
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "";

        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if ($data["order"]->buyer_id != $this->user_id) {
            redirect(lang_base_url());
        }
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data["last_bank_transfer"] = $this->order_admin_model->get_bank_transfer_by_order_number($data["order"]->order_number);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('order/order', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Bank Transfer Payment Report Post
     */
    public function bank_transfer_payment_report_post()
    {
        $this->order_model->add_bank_transfer_payment_report();
        redirect($this->agent->referrer());
    }

    /**
     * Sales
     */
    public function sales()
    {
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("sales");
        $data['description'] = trans("sales") . " - " . $this->app_name;
        $data['keywords'] = trans("sales") . "," . $this->app_name;
        $data["active_tab"] = "active_sales";
        $pagination = $this->paginate(generate_url("sales"), $this->order_model->get_sales_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_sales($this->user_id, $pagination['per_page'], $pagination['offset']);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('sale/sales', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Completed Sales
     */
    public function completed_sales()
    {
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("sales");
        $data['description'] = trans("sales") . " - " . $this->app_name;
        $data['keywords'] = trans("sales") . "," . $this->app_name;
        $data["active_tab"] = "completed_sales";
        $pagination = $this->paginate(generate_url("sales", "completed_sales"), $this->order_model->get_completed_sales_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_completed_sales($this->user_id, $pagination['per_page'], $pagination['offset']);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('sale/sales', $data);
        $this->load->view('partials/_footer');
    }

    public function refunded_sales()
    {
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("refunded_sales");
        $data['description'] = trans("refunded_sales") . " - " . $this->app_name;
        $data['keywords'] = trans("refunded_sales") . "," . $this->app_name;
        $data["active_tab"] = "refunded_sales";
        $pagination = $this->paginate(generate_url("sales", "refunded_sales"), $this->order_model->get_refunded_sales_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_refunded_sales($this->user_id, $pagination['per_page'], $pagination['offset']);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('sale/refunded_sales', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Sale
     */
    public function sale($order_number)
    {
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("sales");
        $data['description'] = trans("sales") . " - " . $this->app_name;
        $data['keywords'] = trans("sales") . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if (!$this->order_model->check_order_seller($data["order"]->id)) {
            redirect(lang_base_url());
        }
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('sale/sale', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Invoice
     */
    public function ajaxRequestPost()
    {
        $order_number =  $this->input->post('id');
        
        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        $data["invoice"] = $this->order_model->get_invoice_by_order_number($order_number);
        if (empty($data["invoice"])) {
            $this->order_model->add_invoice($data["order"]->id);
        }
        if (empty($data["invoice"])) {
            redirect(lang_base_url());
        }
        $data["invoice_items"] = unserialize($data["invoice"]->invoice_items);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        //check permission
        if ($this->auth_user->role != "admin") {
            $is_seller = false;
            if (!empty($data["order_products"])) {
                foreach ($data["order_products"] as $item) {
                    if ($item->seller_id == $this->auth_user->id) {
                        $is_seller = true;
                    }
                }
            }
            if ($this->auth_user->id != $data["order"]->buyer_id && $is_seller == false) {
                redirect(lang_base_url());
                exit();
            }
        }
        $data['token'] = $this->security->get_csrf_hash();

        echo json_encode($data);
    }


    public function invoice($order_number)
    {   

        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        $data["invoice"] = $this->order_model->get_invoice_by_order_number($order_number);
        if (empty($data["invoice"])) {
            $this->order_model->add_invoice($data["order"]->id);
        }
        if (empty($data["invoice"])) {
            redirect(lang_base_url());
        }
        $data["invoice_items"] = unserialize($data["invoice"]->invoice_items);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data['index_settings'] = $this->settings_model->get_index_settings();

        //check permission
        if ($this->auth_user->role != "admin") {
            $is_seller = false;
            if (!empty($data["order_products"])) {
                foreach ($data["order_products"] as $item) {
                    if ($item->seller_id == $this->auth_user->id) {
                        $is_seller = true;
                    }
                }
            }
            if ($this->auth_user->id != $data["order"]->buyer_id && $is_seller == false) {
                redirect(lang_base_url());
                exit();
            }
        }
        // $this->load->view('admin/includes/_header');
        // echo $data["description"];
        // $this->load->view('admin/order/invoice' , $data);
        $this->load->view('order/invoice', $data);
        // $this->load->view('admin/order/invoices', $data);
        // $this->load->view('admin/includes/_footer');
        // return json_encode($data);
    }


    /**
     * Update Order Product Status Post
     */
    public function update_order_product_status_post()
    {
        $id = $this->input->post('id', true);
        $order_product = $this->order_model->get_order_product($id);
        if (!empty($order_product)) {
            if ($this->order_model->update_order_product_status($id)) {

                //add digital sale if payment received
                $order_status = $this->input->post('order_status', true);
                if ($order_status == 'completed' || $order_status == 'payment_received') {
                    $this->order_model->add_digital_sale($order_product->product_id, $order_product->order_id);
                }
                $this->order_admin_model->update_payment_status_if_all_received($order_product->order_id);
                $this->order_admin_model->update_order_status_if_completed($order_product->order_id);

            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Add Shipping Tracking Number Post
     */
    public function add_shipping_tracking_number_post()
    {
        $id = $this->input->post('id', true);
        $order_product = $this->order_model->get_order_product($id);
        if (!empty($order_product)) {
            $this->order_model->add_shipping_tracking_number($id);
        }
        redirect($this->agent->referrer());
    }

    /**
     * Approve Order Product
     */
    public function approve_order_product_post()
    {
        $order_id = $this->input->post('order_product_id', true);
        $order_product_id = $this->input->post('order_product_id', true);
        if ($this->order_model->approve_order_product($order_product_id)) {
            //order product
            $order_product = $this->order_model->get_order_product($order_product_id);
            //add seller earnings
            $this->earnings_model->add_seller_earnings($order_product);
            //update order status
            $this->order_admin_model->update_order_status_if_completed($order_product->order_id);
        }
    }
public function approve_refund()
    {
        $order_product_id = $this->input->post('order_product_id', true);
        
        $this->db->where('order_products.id', $order_product_id);
        $query = $this->db->get('order_products');

        $row = $query->result()[0];

        if ($row->seller_id != $this->auth_user->id  || $row->order_status != 'refund_pending') {
            redirect($this->agent->referrer());
        }

        $this->db->where('order_products.id', $order_product_id);
        $this->db->update('order_products', ['order_status ' => 'refund_completed']);

        $user = $this->db->get_where('users', ['id' => $row->buyer_id])->result()[0];

        $data_array = array(
                'user' => $user->username,
                'phone' => $user->phone_number,
                'email' => $user->email,
                'seller' => $this->db->get_where('users', ['id' => $row->seller_id])[0]->result()->username, 
                'order_id' => $row->order_id,
            );
            $template = $this->get_email_templates($this->selected_lang->id,'product_refund_completed');
            $this->load->model('email_model');

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $user->email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }

            $template = $this->get_email_templates($this->selected_lang->id,'product_refund_completed_a');

            $admin = $this->db->get_where('users', ['id' => 1])->result()[0];  

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $admin->email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }


        $this->session->set_flashdata('success', trans("sale_updated"));
        redirect($this->agent->referrer());
    }


    public function cancel_refund()
    {
        $order_product_id = $this->input->post('order_product_id', true);
        
        $this->db->where('order_products.id', $order_product_id);
        $query = $this->db->get('order_products');

        $row = $query->result()[0];

        if ($row->seller_id != $this->auth_user->id || $row->order_status != 'refund_pending') {
            redirect($this->agent->referrer());
        }

        $this->db->where('order_products.id', $order_product_id);
        $this->db->update('order_products', ['order_status ' => 'refund_cancelled']);

        $this->db->reset_query();

        $this->db->where('id', $this->auth_user->id);
        $this->db->update('users', ['balance ' => $this->auth_user->balance + $row->product_total_price]);


        $this->db->reset_query();
        $user = $this->db->get_where('users', ['id' => $row->buyer_id])->result()[0];


        $data_array = array(
                'user' => $user->username,
                'phone' => $user->phone_number,
                'email' => $user->email,
                'seller' => $this->db->get_where('users', ['id' => $row->seller_id])->result()[0]->username, 
                'order_id' => $row->order_id,
            );
            $template = $this->get_email_templates($this->selected_lang->id,'product_refund_cancelled');
            $this->load->model('email_model');

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $user->email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }

            $template = $this->get_email_templates($this->selected_lang->id,'product_refund_cancelled_a');

            $admin = $this->db->get_where('users', ['id' => 1])->result()[0];  

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $admin->email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }


        $this->session->set_flashdata('success', trans("sale_updated"));
        redirect($this->agent->referrer());
    }

    public function get_email_templates($lang_id="",$template_name="",$user_type="user"){
        $this->db->select('*');
        $this->db->where('email_templates.name',$template_name);
        $this->db->where('email_templates.user_type',$user_type);
        $this->db->where('email_templates_messages.language_id',$lang_id);
        $this->db->join('email_templates_messages','email_templates_messages.email_templates_id = email_templates.id','LEFT JOIN');
        return $this->db->get('email_templates')->row();
    }
}
