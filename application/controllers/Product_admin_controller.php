<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    /**
     * Products
     */
    public function products()
    {
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "products";
        $data['list_type'] = "products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'products', $this->product_admin_model->get_paginated_products_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_products($pagination['per_page'], $pagination['offset'], 'products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }





    // Members
    public function filter_members()
    {
        $search = $this->input->get('mem', true);

        $data['users'] = $this->auth_model->filter_mem($search);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/members',$data);
        $this->load->view('admin/includes/_footer');
    }





	public function import()
	{
		
		$data['title'] = "Import Products From CSV";
        $data['form_action'] = admin_url() . "products";
        $data['list_type'] = "products";
        //get paginated products

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/import', $data);
        $this->load->view('admin/includes/_footer');
	}
	
	private function generateEmailAddress($maxLenLocal=64, $maxLenDomain=255){
            $numeric        =  '0123456789';
            $alphabetic     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $extras         = '.-_';
            $all            = $numeric . $alphabetic . $extras;
            $alphaNumeric   = $alphabetic . $numeric;
            $alphaNumericP  = $alphabetic . $numeric . "-";
            $randomString   = '';

            // GENERATE 1ST 4 CHARACTERS OF THE LOCAL-PART
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $alphabetic[rand(0, strlen($alphabetic) - 1)];
            }
            // GENERATE A NUMBER BETWEEN 20 & 60
            $rndNum         = rand(20, $maxLenLocal-4);

            for ($i = 0; $i < $rndNum; $i++) {
                $randomString .= $all[rand(0, strlen($all) - 1)];
            }

            // ADD AN @ SYMBOL...
            $randomString .= "@";

            // GENERATE DOMAIN NAME - INITIAL 3 CHARS:
            for ($i = 0; $i < 3; $i++) {
                $randomString .= $alphabetic[rand(0, strlen($alphabetic) - 1)];
            }

            // GENERATE A NUMBER BETWEEN 15 & $maxLenDomain-7
            $rndNum2        = rand(15, $maxLenDomain-7);
            for ($i = 0; $i < $rndNum2; $i++) {
                $randomString .= $all[rand(0, strlen($all) - 1)];
            }
            // ADD AN DOT . SYMBOL...
            $randomString .= ".";

            // GENERATE TLD: 4
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $alphaNumeric[rand(0, strlen($alphaNumeric) - 1)];
            }

            return $randomString;

        }
	
	
	private function convertText($text)
{
	$text = str_replace('-', ' ', $text);
	$cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
        ];
    $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        ];
   return str_replace($cyr, $lat, $text);
}

	
	public function import_post()
	{
		$maxEX = ini_get('max_execution_time');
		
		ini_set('max_execution_time', 0); 
		
		$csv = $_FILES['file']['tmp_name'];
		$id = $this->input->post('id', true);

		$handle = fopen($csv,"r");
		$flag = true;
		while (($row = fgetcsv($handle, 10000, ",")) != FALSE) //get row vales
		{
			if($flag) { $flag = false; continue; }
			/*
			$data_translation = array(
                        'lang_id' => $id,
                        'label' => $row[0],
                        'translation' => $row[1]
                    );
					$this->db->insert('language_translations', $data_translation);
					*/
			$username = $row[1];
			
			if ($this->auth_model->get_user_by_username($username) == null) {
				$data = array(
                    'email' => $this->generateEmailAddress(10,5),
                    'email_status' => 1,
                    'role' => "vendor",
                    'username' => $username,
                    'slug' => $this->auth_model->generate_uniqe_slug($username),
                    'user_type' => "registered",
                    'created_at' => date('Y-m-d H:i:s')
                );
				$this->db->insert('users', $data);
			}
			
			preg_match('/(\d+)/', $row[7], $output); 
			$price = $output[0];
			
			if(strpos($row[3], "лв") !== -1) {
				$curr = "BGN";
			} else {
				$curr = "EUR";
			}
			
			$cat = explode('-',$row[13]);
			
			$cat = end($cat);

            $sql = "SELECT * FROM categories WHERE description = ?";
            $query = $this->db->query($sql, $cat);
			
			preg_match('/(.*), гр/', $row[4], $address);
			
			$data = array(
            'title' => $row[6],
            'product_type' => "physical",
            'listing_type' => "ordinary_listing",
            'sku' => "",
            'price' => $price,
            'currency' => $curr,
            'discount_rate' => 0,
            'vat_rate' => 0,
            'description' => $row[8]."<br>".$row[9],
            'product_condition' => "",
            'country_id' => 34,
            'state_id' => 0,
            'city_id' => 0,
            'address' => $this->convertText($address[1]),
            'zip_code' => "",
            'user_id' => $this->auth_model->get_user_by_username($username)->id,
            'status' => 1,
            'is_promoted' => 0,
            'promote_start_date' => date('Y-m-d H:i:s'),
            'promote_end_date' => date('Y-m-d H:i:s'),
            'promote_plan' => "none",
            'promote_day' => 0,
            'visibility' => 1,
            'rating' => 0,
            'hit' => $row[11],
            'demo_url' => "",
            'external_link' => "",
            'files_included' => "",
            'stock' => 1,
            'shipping_time' => "",
            'shipping_cost_type' => "",
            'shipping_cost' => 0,
            'shipping_cost_additional' => 0,
            'is_deleted' => 0,
            'is_draft' => 0,
            'is_free_product' => 0,
            'created_at' => date('Y-m-d H:i:s'),
			'category_id' => $query->row()->id,
			'slug' => str_slug($row[6])
        );

			$this->db->insert('products', $data);
			
			$productID = $this->db->insert_id();
			
			$images = explode(';',$row[5]);

            if(count($images) > 0) {
                foreach($images as $im) {
                $new_name = 'img_x500_' . generate_unique_id() . '.jpg';
                $new_path = 'uploads/images/' . $new_name;
                
                file_put_contents($new_path, file_get_contents($im));
                
                $data = [];
                $data = array(
                    'product_id' => $productID,
                    'image_default' => $new_name,
                    'image_big' => $new_name,
                    'image_small' => $new_name,
                    'is_main' => 0,
                    'storage' => "local"
                );
                
            $this->db->insert('images', $data);

            }
			
			
			}
		}
		

		ini_set('max_execution_time', $maxEX);
		$this->session->set_flashdata('success', "Products Imported");
		redirect($this->agent->referrer());
	}


    /**
     * Pending Products
     */
    public function pending_products()
    {
        $data['title'] = trans("pending_products");
        $data['form_action'] = admin_url() . "pending-products";
        $data['list_type'] = "pending_products";
        //get paginated pending products
        $pagination = $this->paginate(admin_url() . 'pending-products', $this->product_admin_model->get_paginated_pending_products_count('pending_products'));
        $data['products'] = $this->product_admin_model->get_paginated_pending_products($pagination['per_page'], $pagination['offset'], 'pending_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/pending_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Hidden Products
     */
    public function hidden_products()
    {
        $data['title'] = trans("hidden_products");
        $data['form_action'] = admin_url() . "hidden-products";
        $data['list_type'] = "hidden_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'hidden-products', $this->product_admin_model->get_paginated_hidden_products_count('hidden_products'));
        $data['products'] = $this->product_admin_model->get_paginated_hidden_products($pagination['per_page'], $pagination['offset'], 'hidden_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Draft
     */
    public function drafts()
    {
        $data['title'] = trans("drafts");
        $data['form_action'] = admin_url() . "drafts";
        $data['list_type'] = "drafts";
        //get paginated drafts
        $pagination = $this->paginate(admin_url() . 'drafts', $this->product_admin_model->get_paginated_drafts_count('drafts'));
        $data['products'] = $this->product_admin_model->get_paginated_drafts($pagination['per_page'], $pagination['offset'], 'drafts');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/drafts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Deleted Products
     */
    public function deleted_products()
    {
        $data['title'] = trans("deleted_products");
        $data['form_action'] = admin_url() . "deleted-products";
        $data['list_type'] = "deleted_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'deleted-products', $this->product_admin_model->get_paginated_deleted_products_count('deleted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_deleted_products($pagination['per_page'], $pagination['offset'], 'deleted_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/deleted_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products
     */
    public function featured_products()
    {
        $data['title'] = trans("featured_products");
        $data['form_action'] = admin_url() . "featured-products";
        $data['list_type'] = "featured_products";
        //get paginated featured products
        $pagination = $this->paginate(admin_url() . 'featured-products', $this->product_admin_model->get_paginated_promoted_products_count('promoted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_promoted_products($pagination['per_page'], $pagination['offset'], 'promoted_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/featured_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products Pricing
     */
    public function featured_products_pricing()
    {
        $data['title'] = trans("pricing");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/pricing', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Featured Products Pricing Post
     */
    public function featured_products_pricing_post()
    {
        if ($this->settings_model->update_pricing_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Featured Products Transactions
     */
    public function featured_products_transactions()
    {
        $data['title'] = trans("featured_products_transactions");
        $data['form_action'] = admin_url() . "featured-products-transactions";

        $pagination = $this->paginate(admin_url() . 'featured-products-transactions', $this->transaction_model->get_promoted_transactions_count());
        $data['transactions'] = $this->transaction_model->get_paginated_promoted_transactions($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/transactions', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Featured Transaction Post
     */
    public function delete_featured_transaction_post()
    {
        $id = $this->input->post('id', true);
        if ($this->transaction_model->delete_promoted_transaction($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Product Details
     */
    public function product_details($id)
    {
        $data['title'] = trans("product_details");
        $data['product'] = $this->product_admin_model->get_product($id);
        if (empty($data['product'])) {
            redirect($this->agent->referrer());
        }
        $data['panel_settings'] = $this->settings_model->get_panel_settings();
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/product_details', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Approve Product
     */
    public function approve_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->approve_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        $redirect_url = $this->input->post('redirect_url', true);
        if (!empty($redirect_url)) {
            redirect($redirect_url);
        }
    }

    /**
     * Restore Product
     */
    public function restore_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->restore_product($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Product
     */
    public function delete_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Product Permanently
     */
    public function delete_product_permanently()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product_permanently($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Products
     */
    public function delete_selected_products()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products($product_ids);

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Products Permanently
     */
    public function delete_selected_products_permanently()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products_permanently($product_ids);

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Add Remove Featured Products
     */
    public function add_remove_featured_products()
    {
        $product_id = $this->input->post('product_id', true);
        $day_count = $this->input->post('day_count', true);
        $is_ajax = $this->input->post('is_ajax', true);
        if ($this->product_admin_model->add_remove_promoted_products($product_id, $day_count)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        if ($is_ajax == 0) {
            redirect($this->agent->referrer());
        }
    }


    /**
     * Comments
     */
    public function comments()
    {
        $data['title'] = trans("approved_comments");
        $data['comments'] = $this->comment_model->get_approved_comments();
        $data['top_button_text'] = trans("pending_comments");
        $data['top_button_url'] = admin_url() . "pending-product-comments";
        $data['show_approve_button'] = false;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pending_comments()
    {
        $data['title'] = trans("pending_comments");
        $data['comments'] = $this->comment_model->get_pending_comments();
        $data['top_button_text'] = trans("approved_comments");
        $data['top_button_url'] = admin_url() . "product-comments";
        $data['show_approve_button'] = true;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approve_comment_post()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->approve_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Approve Selected Comments
     */
    public function approve_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->approve_multi_comments($comment_ids);
    }


    /**
     * Delete Comment
     */
    public function delete_comment()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->delete_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->delete_multi_comments($comment_ids);
    }

    /**
     * Reviews
     */
    public function reviews()
    {
        $data['title'] = trans("reviews");
        $data['reviews'] = $this->review_model->get_all_reviews();
        $data['panel_settings'] = $this->settings_model->get_panel_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/review/reviews', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Review
     */
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        if ($this->review_model->delete_review($id)) {
            $this->session->set_flashdata('success', trans("msg_review_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Reviews
     */
    public function delete_selected_reviews()
    {
        $review_ids = $this->input->post('review_ids', true);
        $this->review_model->delete_multi_reviews($review_ids);
    }

}
