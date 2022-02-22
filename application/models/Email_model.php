<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "third_party/swiftmailer/vendor/autoload.php";
require APPPATH . "third_party/phpmailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email_model extends CI_Model
{
    //send email activation
    public function send_email_activation($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'subject' => trans("confirm_your_account"),
                'to' => $user->email,
                'template_path' => "email/email_activation",
                'token' => $token
            );

            $this->send_email($data);
        }
    }

    //send email reset password
    public function send_email_reset_password($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $this->load->model('order_model');
            $template = $this->order_model->get_email_templates($this->selected_lang->id,'reset_password');

            $data_array = array(
                'user' => $user->first_name,
                'reset_link' => generate_url("reset_password").'?token='.$token,
            );

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $user->email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }

            // $data = array(
            //     'subject' => trans("reset_password"),
            //     'to' => $user->email,
            //     'template_path' => "email/email_reset_password",
            //     'token' => $token
            // );

            // $this->send_email($data);
        }
    }

    //send email newsletter
    public function send_email_newsletter($subscriber, $subject, $message)
    {
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $this->newsletter_model->update_subscriber_token($subscriber->email);
                $subscriber = $this->newsletter_model->get_subscriber($subscriber->email);
            }

            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $subscriber->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => $subscriber,
            );
            return $this->send_email($data);
        }
    }

    //send email
    public function send_email($data)
    {
        if ($this->general_settings->mail_library == "swift") {
            try {
                // Create the Transport
                $transport = (new Swift_SmtpTransport($this->general_settings->mail_host, $this->general_settings->mail_port, 'ssl'))
                    ->setUsername($this->general_settings->mail_username)
                    ->setPassword($this->general_settings->mail_password);

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message($this->general_settings->application_name))
                    ->setFrom(array($this->general_settings->mail_username => $this->general_settings->application_name))
                    ->setTo([$data['to'] => ''])
                    ->setSubject($data['subject'])
                    ->setBody($this->load->view($data['template_path'], $data, TRUE), 'text/html');

                //Send the message
                $result = $mailer->send($message);
                if ($result) {
                    return true;
                }
            } catch (\Swift_TransportException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            } catch (\Swift_RfcComplianceException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            }
        } elseif ($this->general_settings->mail_library == "php") {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = $this->general_settings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->general_settings->mail_username;
                $mail->Password = $this->general_settings->mail_password;
                $mail->SMTPSecure = 'ssl';
                $mail->CharSet = 'UTF-8';
                $mail->Port = $this->general_settings->mail_port;
                //Recipients
                $mail->setFrom($this->general_settings->mail_username, $this->general_settings->application_name);
                $mail->addAddress($data['to']);
                //Content
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                // $mail->Body = $data['message'];
                $mail->Body = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
                $mail->send();
                return true;
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $mail->ErrorInfo);
                return false;
            }
        } else {
            $this->load->library('email');

            $settings = $this->settings_model->get_general_settings();
            if ($settings->mail_protocol == "mail") {
                $config = Array(
                    'protocol' => 'mail',
                    'smtp_host' => $settings->mail_host,
                    'smtp_port' => $settings->mail_port,
                    'smtp_user' => $settings->mail_username,
                    'smtp_pass' => $settings->mail_password,
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            } else {
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => $settings->mail_host,
                    'smtp_port' => $settings->mail_port,
                    'smtp_user' => $settings->mail_username,
                    'smtp_pass' => $settings->mail_password,
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            }


            //initialize
            $this->email->initialize($config);

            //send email
            $message = $this->load->view($data['template_path'], $data, TRUE);
            $this->email->from($settings->mail_username, $settings->application_name);
            $this->email->to($data['to']);
            $this->email->subject($data['subject']);
            $this->email->message($message);

            $this->email->set_newline("\r\n");

            if ($this->email->send()) {
                return true;
            } else {
                $this->session->set_flashdata('error', $this->email->print_debugger(array('headers')));
                return false;
            }
        }
    }

    public function send_email_mail_template($data,$Cc='')
    {
        if ($this->general_settings->mail_library == "swift") {
            try {
                // Create the Transport
                // $this->general_settings->mail_port
                $transport = (new Swift_SmtpTransport($this->general_settings->mail_host, $this->general_settings->mail_port , 'ssl'))
                    ->setUsername($this->general_settings->mail_username)
                    ->setPassword($this->general_settings->mail_password);

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $resp['content'] = $data['message'];
                $message = (new Swift_Message($this->general_settings->application_name))
                    ->setFrom(array($this->general_settings->mail_username => $this->general_settings->application_name))
                    ->setTo([$data['to'] => ''])
                    ->setSubject($data['subject'])
                    ->setBody($this->load->view('email/email_template', $resp, TRUE), 'text/html');
                    
                if($Cc!=''){
                    $message->addCc($Cc);
                }
                    // ->setBody($data['message'], 'text/html');
                //Send the message
                $result = $mailer->send($message);
                if ($result) {
                    // $this->session->set_flashdata('success', trans('success'));
                    return true;
                }
            } catch (\Swift_TransportException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            } catch (\Swift_RfcComplianceException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            }
        } elseif ($this->general_settings->mail_library == "php") {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = $this->general_settings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->general_settings->mail_username;
                $mail->Password = $this->general_settings->mail_password;
                $mail->SMTPSecure = 'ssl';
                $mail->CharSet = 'UTF-8';
                $mail->Port = $this->general_settings->mail_port;
                //Recipients
                $mail->setFrom($this->general_settings->mail_username, $this->general_settings->application_name);
                $mail->addAddress($data['to']);
                //Content
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                // $mail->Body = $data['message'];
                $resp['content'] = $data['message'];
                $mail->Body = $this->load->view('email/email_template', $resp, TRUE);
                // $mail->Body = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
                $mail->send();
                return true;
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $mail->ErrorInfo);
                return false;
            }
        } else {
            $this->load->library('email');

            $settings = $this->settings_model->get_general_settings();
            if ($settings->mail_protocol == "mail") {
                $config = Array(
                    'protocol' => 'mail',
                    'smtp_host' => $settings->mail_host,
                    'smtp_port' => $settings->mail_port,
                    'smtp_user' => $settings->mail_username,
                    'smtp_pass' => $settings->mail_password,
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            } else {
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => $settings->mail_host,
                    'smtp_port' => $settings->mail_port,
                    'smtp_user' => $settings->mail_username,
                    'smtp_pass' => $settings->mail_password,
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            }


            //initialize
            $this->email->initialize($config);

            //send email
            $resp['content'] = $data['message'];
            $message = $this->load->view('email/email_template', $resp, TRUE);
            // $message = $this->load->view($data['template_path'], $data, TRUE);
            $this->email->from($settings->mail_username, $settings->application_name);
            $this->email->to($data['to']);
            $this->email->subject($data['subject']);
            $this->email->message($message);

            $this->email->set_newline("\r\n");

            if ($this->email->send()) {
                return true;
            } else {
                $this->session->set_flashdata('error', $this->email->print_debugger(array('headers')));
                return false;
            }
        }
    }

    public function get_email_templates($user=""){
        $this->db->select('*');
        $this->db->where('status',1);
        if($user){
            $this->db->where('user_type',$user);
        }
        return $this->db->get('email_templates')->result();
    }

    public function get_email_templates_message($email_template_id=""){
        $this->db->select('*');
        if($email_template_id!=''){
            $this->db->where('email_templates_id',$email_template_id);
        }
        return $this->db->get('email_templates_messages')->result();
    }

    public function update_templates($post_data){
        if(!empty($post_data)){
            foreach ($post_data as $key => $value) {
                $this->db->where('id',$value['id']);
                $this->db->update('email_templates_messages',['subject' => $value['subject'], 'message' => $value['message']]);
            }
            return true;
        }
        return false;
    }

    public function send_request_quote_email($post_data){

        $this->load->model('order_model');
        $template = $this->order_model->get_email_templates($this->selected_lang->id,'quote_request','seller');

        $data_array = array(
            'request_number' => $post_data['request_number'],
            'quote_url'      => '<a href="'.$post_data['email_link'].'">View Details</a>',
        );

        if(!empty($template)){
            $send_mail            = [];
            $send_mail['to']      = $post_data['to'];
            $send_mail['subject'] = $template->subject;
            $send_mail['message'] = email_template_replace($data_array,$template);
            $this->send_email_mail_template($send_mail);
        }

    }

}
