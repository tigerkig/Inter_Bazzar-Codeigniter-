<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemplates_admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
        $this->load->model('email_model');
    }

    /**
     * Earnings
     */
    public function index($id="")
    {
        $data['title'] = trans('email_templates');
        $data['form_action'] = admin_url() . "add-email-templates";

        $data['email_templates']   = $this->email_model->get_email_templates('user');
        
        $data['admin_email_templates']  = $this->email_model->get_email_templates('admin');
        
        $data['seller_email_templates']  = $this->email_model->get_email_templates('seller');

        $data['email_templates_message'] = $this->email_model->get_email_templates_message($id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/email_templates/index', $data);
        $this->load->view('admin/includes/_footer',$data);
    }

    public function save_templates_post(){

        $post_data = $this->input->post();
        $submit_data = [];
        foreach($post_data['template_id'] as $key => $template){
            $submit_data[$key]['id'] = $template;
            $submit_data[$key]['subject'] = $post_data['subject'][$key];
            $submit_data[$key]['message'] = $post_data['page_content'][$key];
        }
            
        $resp = $this->email_model->update_templates($submit_data);
        if($resp){
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function edit(){
        
    }

}
