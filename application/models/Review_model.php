<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model
{
    //add review
    public function add_review($rating, $product_id, $review_text)
    {
        $data = array(
            'product_id' => $product_id,
            'user_id' => $this->auth_user->id,
            'rating' => $rating,
            'review' => $review_text,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }

        if (!empty($data['product_id']) && !empty($data['user_id']) && !empty($data['rating'])) {
            $this->db->insert('reviews', $data);
            
            //update product rating
            $this->update_product_rating($product_id);

            // review to admin
            $this->send_product_review_to_admin($data);
            
            // review to seller
            $this->send_product_review_to_seller($data);

        }
    }

    //update review
    public function update_review($review_id, $rating, $product_id, $review_text)
    {
        $data = array(
            'rating' => $rating,
            'review' => $review_text,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['rating']) && !empty($data['review'])) {
            $this->db->where('product_id', $product_id);
            $this->db->where('user_id', $this->auth_user->id);
            $this->db->update('reviews', $data);
            //update product rating
            $this->update_product_rating($product_id);

            $data = array(
                'product_id' => $product_id,
                'user_id' => $this->auth_user->id,
                'rating' => $rating,
                'review' => $review_text,
                'created_at' => date("Y-m-d H:i:s")
            );

            // review to admin
            $this->send_product_review_to_admin($data);
            
            // review to seller
            $this->send_product_review_to_seller($data);

        }
    }

    //get review count
    public function get_review_count($product_id)
    {
        $product_id = clean_number($product_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->where('reviews.product_id', $product_id);
        $query = $this->db->get('reviews');
        return $query->num_rows();
    }

    //get reviews
    public function get_reviews($product_id)
    {
        $product_id = clean_number($product_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get all reviews
    public function get_all_reviews()
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username');
        $this->db->order_by('reviews.created_at', 'DESC');
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get latest reviews
    public function get_latest_reviews($limit)
    {
        $limit = clean_number($limit);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username');
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get limited reviews
    public function get_limited_reviews($product_id, $limit)
    {
        $product_id = clean_number($product_id);
        $limit = clean_number($limit);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get review
    public function get_review($product_id, $user_id)
    {
        $product_id = clean_number($product_id);
        $user_id = clean_number($user_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->where('users.id', $user_id);
        $query = $this->db->get('reviews');
        return $query->row();
    }

    //update product rating
    public function update_product_rating($product_id)
    {
        $product_id = clean_number($product_id);
        $reviews = $this->get_reviews($product_id);
        $data = array();
        if (!empty($reviews)) {
            $count = count($reviews);
            $total = 0;
            foreach ($reviews as $review) {
                $total += $review->rating;
            }
            $data['rating'] = round($total / $count);
        } else {
            $data['rating'] = 0;
        }
        $this->db->where('id', $product_id);
        $this->db->update('products', $data);
    }

    //get user reviews count
    public function get_user_reviews_count($user_id)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.user_id', clean_number($user_id));
        $query = $this->db->get('reviews');
        return $query->num_rows();
    }

    //get paginated user reviews
    public function get_user_reviews_orders($user_id, $offset, $per_page)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.user_id', clean_number($user_id));
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //calculate user rating
    public function calculate_user_rating($user_id)
    {
        $std = new stdClass();
        $std->count = 0;
        $std->rating = 0;

        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('COUNT(reviews.id) AS count, SUM(reviews.rating) AS total');
        $this->db->where('products.user_id', clean_number($user_id));
        $query = $this->db->get('reviews');
        if (!empty($query->row())) {
            $total = $query->row()->total;
            $count = $query->row()->count;
            if (!empty($total) and !empty($count)) {
                $avg = round($total / $count);
                $std->count = $count;
                $std->rating = $avg;
            }
        }
        return $std;
    }

    //delete review
    public function delete_review($id, $product_id = null)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('reviews');
        $row = $query->row();
        if (empty($row)) {
            return false;
        }
        $product = get_product($row->product_id);
        if (empty($product)) {
            return false;
        }

        $this->db->where('id', $id);
        if ($this->db->delete('reviews')) {
            //update product rating
            $this->update_product_rating($product->id);
            return true;
        }
        return false;
    }

    //delete multi reviews
    public function delete_multi_reviews($review_ids)
    {
        if (!empty($review_ids)) {
            foreach ($review_ids as $id) {
                $this->delete_review($id);
            }
        }
    }

    public function send_product_review_to_admin($data){
        $comment_by_name = '';
        if($data['user_id'] != 0){
            $comment_by = get_user($data['user_id']);
            $comment_by_name =  $comment_by->first_name.' '.$comment_by->last_name;
        }

        $admin = get_user(1);
        $product = get_available_product($data['product_id']);
        $data_array = array(
           'user' => $admin->username,
            'email' => $admin->email,
            'product_title' => $product->title,
            'product_description' => $product->description,
            'review' => $data['review'],
            'rating' => $data['rating'],
            'created_at' => $data['created_at'],
            'review_by' => $comment_by_name
        );

        $this->load->model('order_model');
        $this->load->model('email_model');

        $template = $this->order_model->get_email_templates($this->selected_lang->id,'review_notification','admin');

        if(!empty($template)){
            $send_mail            = [];
            $send_mail['to']      = $admin->email;
            $send_mail['subject'] = $template->subject;
            $send_mail['message'] = email_template_replace($data_array,$template);
            $this->email_model->send_email_mail_template($send_mail);
        }
    }
    
    public function send_product_review_to_seller($data){
        $comment_by_name = '';
        if($data['user_id'] != 0){
            $comment_by = get_user($data['user_id']);
            $comment_by_name =  $comment_by->first_name.' '.$comment_by->last_name;
        }

        $product = get_available_product($data['product_id']);
        if($product->user_id != 0){

            $admin = get_user($product->user_id);

            $data_array = array(
                'user' => $admin->username,
                'email' => $admin->email,
                'product_title' => $product->title,
                'product_description' => $product->description,
                'review' => $data['review'],
                'rating' => $data['rating'],
                'created_at' => $data['created_at'],
                'review_by' => $comment_by_name
            );

            $this->load->model('order_model');
            $this->load->model('email_model');

            $template = $this->order_model->get_email_templates($this->selected_lang->id,'review_notification','seller');

            if(!empty($template)){
                $send_mail            = [];
                $send_mail['to']      = $admin->email;
                $send_mail['subject'] = $template->subject;
                $send_mail['message'] = email_template_replace($data_array,$template);
                $this->email_model->send_email_mail_template($send_mail);
            }

        }
    }

}
