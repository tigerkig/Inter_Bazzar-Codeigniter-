<?php defined('BASEPATH') or exit('No direct script access allowed');




//get parent categories
if (!function_exists('get_parent_categories')) {
    function get_parent_categories($categories)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) {
                return $item->parent_id == 0;
            });
        }
        return null;
    }
}

//get subcategories
if (!function_exists('get_subcategories')) {
    function get_subcategories($categories, $parent_id)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) use ($parent_id) {
                return $item->parent_id == $parent_id;
            });
        }
        return null;
    }
}

//get navigation categories
if (!function_exists('get_navigation_categories')) {
    function get_navigation_categories($categories)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) {
                return $item->show_image_on_navigation == 1;
            });
        }
        return null;
    }
}

//get category
if (!function_exists('get_category')) {
    function get_category($categories, $id)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) use ($id) {
                return $item->id == $id;
            });
        }
        return null;
    }
}

if (!function_exists('get_category_by_id')) {
    function get_category_by_id($id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_category($id);
    }
}

//get category
if (!function_exists('get_category_by_id')) {
    function get_category_by_id($id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_category($id);
    }
}

//get category name
if (!function_exists('category_name')) {
    function category_name($category)
    {
        if (!empty($category)) {
            if (!empty($category->name)) {
                return html_escape($category->name);
            } else {
                if (!empty($category->second_name)) {
                    return html_escape($category->second_name);
                }
            }
        }
        return "";
    }
}

//get category image url
if (!function_exists('get_category_image_url')) {
    function get_category_image_url($category)
    {
        if ($category->storage == "aws_s3") {
            $ci =& get_instance();
            return $ci->aws_base_url . $category->image;
        } else {
            return base_url() . $category->image;
        }
    }
}

//generate ids string
if (!function_exists('generate_ids_string')) {
    function generate_ids_string($array)
    {
        if (empty($array)) {
            return "0";
        } else {
            $array_new = array();
            foreach ($array as $item) {
                if (!empty(clean_number($item))) {
                    array_push($array_new, clean_number($item));
                }
            }
            return implode(',', $array_new);
        }
    }
}


//product form data
if (!function_exists('get_product_form_data')) {
    function get_product_form_data($product)
    {   
        // Author : 225
        // $dt = get_category_by_id($product->category_id);
            
        $no_purchase_btn_disabled = false;
        // if($dt->no_purchase == 1){
        //     $no_purchase_btn_disabled = true;
        // }else if($dt->parent_id != 0){
        //     $no_purchase_btn_disabled = check_parent($dt->parent_id);
        // }
        // Author : 225
        
        $ci =& get_instance();
        $data = new stdClass();
        $data->add_to_cart_url = "";
        $data->button = "";

        if (!empty($product)) {
            $disabled = "";
            if ($product->stock < 1 || $no_purchase_btn_disabled == true) {
                $disabled = " disabled";
            }
            if ($product->listing_type == 'sell_on_site') {
                if ($product->is_free_product != 1) {
                    $data->add_to_cart_url = base_url() . 'add-to-cart';
                    $data->button = '<button class="btn btn-md btn-block btn-product-cart"' . $disabled . '><i class="icon-cart-solid"></i>' . trans("add_to_cart") . '</button>';
                }
            } elseif ($product->listing_type == 'bidding') {
                $data->add_to_cart_url = base_url() . 'request-quote';
                $data->button = '<button class="btn btn-md btn-block btn-product-cart"' . $disabled . '>' . trans("request_a_quote") . '</button>';
                if (!$ci->auth_check && $product->listing_type == 'bidding') {
                    $data->button = '<button type="button" data-toggle="modal" data-target="#loginModal" class="btn btn-md btn-block btn-product-cart"' . $disabled . '>' . trans("request_a_quote") . '</button>';
                }
            } else {
                if (!empty($product->external_link)) {
                    $data->button = '<a href="' . $product->external_link . '" class="btn btn-md btn-block" target="_blank">' . trans("buy_now") . '</a>';
                }
            }
        }
        return $data;
    }
}

//get product item image
if (!function_exists('get_product_item_image')) {
    function get_product_item_image($product, $get_second = false)
    {
        $ci =& get_instance();
        if (!empty($product)) {
            $image = $product->image;
            if (!empty($product->image_second) && $get_second == true) {
                $image = $product->image_second;
            }
            if (!empty($image)) {
                $image_array = explode("::", $image);
                if (!empty($image_array[0]) && !empty($image_array[1])) {
                    if ($image_array[0] == "aws_s3") {
                        return $ci->aws_base_url . "uploads/images/" . $image_array[1];
                    } else {
                        return base_url() . "uploads/images/" . $image_array[1];
                    }
                }
            }
        }
        return base_url() . 'assets/img/no-image.jpg';
    }
}

//get latest products
if (!function_exists('get_latest_products')) {
    function get_latest_products($limit)
    {
        $ci =& get_instance();
        $key = "latest_products";
        if ($ci->default_location_id != 0) {
            $key = "latest_products_location_" . $ci->default_location_id;
        }
        $latest_products = get_cached_data($key);
        if (empty($latest_products)) {
            $latest_products = $ci->product_model->get_products_limited($limit);
            set_cache_data($key, $latest_products);
        }
        return $latest_products;
    }
}

//get promoted products
if (!function_exists('get_promoted_products')) {
    function get_promoted_products($offset, $per_page)
    {
        $ci =& get_instance();
        $key = "promoted_products_" . $offset . "_" . $per_page;
        if ($ci->default_location_id != 0) {
            $key = "promoted_products_location_" . $ci->default_location_id . "_" . $offset . "_" . $per_page;
        }
        $promoted_products = get_cached_data($key);
        if (empty($promoted_products)) {
            $promoted_products = $ci->product_model->get_promoted_products_limited($offset, $per_page);
            set_cache_data($key, $promoted_products);
        }
        return $promoted_products;
    }
}

//get promoted products count
if (!function_exists('get_promoted_products_count')) {
    function get_promoted_products_count()
    {
        $ci =& get_instance();
        $key = "promoted_products_count";
        if ($ci->default_location_id != 0) {
            $key = "promoted_products_count_location_" . $ci->default_location_id;
        }
        $count = get_cached_data($key);
        if (empty($count)) {
            $count = $ci->product_model->get_promoted_products_count();
            set_cache_data($key, $count);
        }
        return $count;
    }
}

//get route settings
if (!function_exists('get_route_settings')) {
    function get_route_settings()
    {
        if (@SITE_MDS_KEY != @sha1(gt_sys_suffx() . gt_dmn_cd())) {
            @mem_usg_sys();
        }
    }
}

//is product in wishlist
if (!function_exists('is_product_in_wishlist')) {
    function is_product_in_wishlist($product)
    {
        // echo $product;
        $ci =& get_instance();
        if ($ci->auth_check) {
            if (!empty($product->is_in_wishlist)) {
                return true;
            }
        } else {
            $wishlist = $ci->session->userdata('mds_guest_wishlist');
            if (!empty($wishlist)) {
                if (in_array($product->id, $wishlist)) {
                    return true;
                }
            }
        }
        return false;
    }
}

//get currency
if (!function_exists('get_currency')) {
    function get_currency($currency_key)
    {
        $ci =& get_instance();
        if (!empty($ci->currencies)) {
            if (isset($ci->currencies[$currency_key])) {
                return $ci->currencies[$currency_key]["hex"];
            }
        }
        return "";
    }
}

//calculate product price
if (!function_exists('calculate_product_price')) {
    function calculate_product_price($price, $discount_rate)
    {
        if (!empty($price)) {
            if (!empty($discount_rate)) {
                $price = $price - (($price * $discount_rate) / 100);
            }
            return $price;
        }
        return 0;
    }
}

//calculate vat
if (!function_exists('calculate_vat')) {
    function calculate_vat($price_calculated, $vat_rate)
    {
        return ($price_calculated * $vat_rate) / 100;
    }
}

//calculate product vat
if (!function_exists('calculate_product_vat')) {
    function calculate_product_vat($product)
    {
        if (!empty($product)) {
            if (!empty($product->vat_rate)) {
                $price = calculate_product_price($product->price, $product->discount_rate);
                return ($price * $product->vat_rate) / 100;
            }
        }
        return 0;
    }
}

//calculate earned amount
if (!function_exists('calculate_earned_amount')) {
    function calculate_earned_amount($product)
    {
        $ci =& get_instance();
        if (!empty($product)) {
            $price = calculate_product_price($product->price, $product->discount_rate) + calculate_product_vat($product);
            return $price - (($price * $ci->general_settings->commission_rate) / 100);
        }
        return 0;
    }
}

//price formatted
if (!function_exists('price_formatted')) {
    function price_formatted($price, $currency, $format = null)
    {
        $ci =& get_instance();
        $price = $price / 100;
        $dec_point = '.';
        $thousands_sep = ',';
        if ($ci->thousands_separator != '.') {
            $dec_point = ',';
            $thousands_sep = '.';
        }

        if (is_int($price)) {
            $price = number_format($price, 0, $dec_point, $thousands_sep);
        } else {
            $price = number_format($price, 2, $dec_point, $thousands_sep);
        }
        $price = price_currency_format($price, $currency);
        return $price;
    }
}

//price currency format
if (!function_exists('price_currency_format')) {
    function price_currency_format($price, $currency)
    {
        $ci =& get_instance();
        $currency = get_currency($currency);
        $space = "";
        if ($ci->payment_settings->space_between_money_currency == 1) {
            $space = " ";
        }
        if ($ci->payment_settings->currency_symbol_format == "left") {
            $price = "<span>" . $currency . "</span>" . $space . $price;
        } else {
            $price = $price . $space . "<span>" . $currency . "</span>";
        }
        return $price;
    }
}

//get price
if (!function_exists('get_price')) {
    function get_price($price, $format_type)
    {
        $ci =& get_instance();

        if ($format_type == "input") {
            $price = $price / 100;
            if (is_int($price)) {
                $price = number_format($price, 0, ".", "");
            } else {
                $price = number_format($price, 2, ".", "");
            }
            if ($ci->thousands_separator == ',') {
                $price = str_replace('.', ',', $price);
            }
            return $price;
        } elseif ($format_type == "decimal") {
            $price = $price / 100;
            return number_format($price, 2, ".", "");
        } elseif ($format_type == "database") {
            $price = str_replace(',', '.', $price);
            $price = floatval($price);
            $price = number_format($price, 2, '.', '') * 100;
            return $price;
        } elseif ($format_type == "separator_format") {
            $price = $price / 100;
            $dec_point = '.';
            $thousands_sep = ',';
            if ($ci->thousands_separator != '.') {
                $dec_point = ',';
                $thousands_sep = '.';
            }
            return number_format($price, 2, $dec_point, $thousands_sep);
        }
    }
}

//get variation label
if (!function_exists('get_variation_label')) {
    function get_variation_label($label_array, $lang_id)
    {
        $ci =& get_instance();
        $label = "";
        if (!empty($label_array)) {
            $label_array = unserialize($label_array);
            foreach ($label_array as $item) {
                if ($lang_id == $item['lang_id']) {
                    $label = $item['label'];
                    break;
                }
            }
            if (empty($label)) {
                foreach ($label_array as $item) {
                    if ($ci->general_settings->site_lang == $item['lang_id']) {
                        $label = $item['label'];
                        break;
                    }
                }
            }
        }
        return $label;
    }
}

//get variation option name
if (!function_exists('get_variation_option_name')) {
    function get_variation_option_name($names_array, $lang_id)
    {
        $ci =& get_instance();
        $name = "";
        if (!empty($names_array)) {
            $names_array = unserialize($names_array);
            foreach ($names_array as $item) {
                if ($lang_id == $item['lang_id']) {
                    $name = $item['option_name'];
                    break;
                }
            }
            if (empty($name)) {
                foreach ($names_array as $item) {
                    if ($ci->general_settings->site_lang == $item['lang_id']) {
                        $name = $item['option_name'];
                        break;
                    }
                }
            }
        }
        return $name;
    }
}

//get variation default option
if (!function_exists('get_variation_default_option')) {
    function get_variation_default_option($variation_id)
    {
        $ci =& get_instance();
        return $ci->variation_model->get_variation_default_option($variation_id);
    }
}

//get variation sub options
if (!function_exists('get_variation_sub_options')) {
    function get_variation_sub_options($parent_id)
    {
        $ci =& get_instance();
        return $ci->variation_model->get_variation_sub_options($parent_id);
    }
}

//is there variation uses different price
if (!function_exists('is_there_variation_uses_different_price')) {
    function is_there_variation_uses_different_price($product_id, $except_id = null)
    {
        $ci =& get_instance();
        return $ci->variation_model->is_there_variation_uses_different_price($product_id, $except_id);
    }
}

//discount rate format
if (!function_exists('discount_rate_format')) {
    function discount_rate_format($discount_rate)
    {
        return $discount_rate . "%";
    }
}

// Author : 225
// check parent category
if (!function_exists('check_parent')) {
    function check_parent($category_id)
    {
        $dt = get_category_by_id($category_id);
        if($dt->no_purchase == 1){
            return true;
        }else if($dt->parent_id != 0){
            return check_parent($dt->parent_id);
        }else{
            return false;
        }
    }
}

if (!function_exists('check_no_purchase_cat')) {
    function check_no_purchase_cat($category_id)
    {
        $dt = get_category_by_id($category_id);
        if($dt->no_purchase == 1){
            return true;
        }
        return false;
    }
}

if (!function_exists('currency_convert')) {
    function currency_convert($base_price,$base_currency){
        // Fetching JSON
        //$req_url = "https://prime.exchangerate-api.com/v5/f3c4c291d280fac1d8ca49b4/latest/$base_currency";
		$req_url = "https://api.exchangerate.host/latest?base=".$base_currency;
        $response_json = file_get_contents($req_url);
		

        // Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {

            // Decoding
            $response = json_decode($response_json);

            // Check for success
            if( $response->success) {
		
              // YOUR APPLICATION CODE HERE, e.g.
              $base_price = $base_price; // Your price in USD
		
              return $EUR_price = round(($base_price * $response->rates->EUR), 2);

            }

            }
            catch(Exception $e) {
                // Handle JSON parse error...
                return 0;
            }

        }
    }
}

if (!function_exists('currency_convert')) {
    function get_db_currency_rates($base_price,$base_currency,$admin_currency){
        $ci = &get_instance();
        $resp = $ci->currency_model->get_currency_rates(['code' => $base_currency]);
    }
}

if (!function_exists('paybyme')) {
    function paybyme($price){
        if(!empty($price)){

        }
    }
}

function make_request_bk($product_name,$product_price) {

    $ci =& get_instance();
    // echo "<pre>";
    // print_r($ci->payment_settings);
    // exit;

    $clientIp = $_SERVER['SERVER_ADDR'];
    $client_ip = is_null($clientIp) ? $_SERVER['REMOTE_ADDR'] : $clientIp;
    $postFields = '';
    $postFields .= "currencyCode=EUR";
    $postFields .= '&secretKey='.$ci->payment_settings->paybyme_secret_key.'&token='.$ci->payment_settings->paybyme_token;

    $postFields .= '&username=' . $ci->payment_settings->paybyme_username;
    // $postFields .= '&password=' . $ci->payment_settings->paybyme_password;
    $postFields .= '&syncId=' . time();
    // $postFields .= '&shortcode=' . $ci->payment_settings->paybyme_password;
    $postFields .= '&subCompany=' . $ci->general_settings->application_name;
    $postFields .= '&assetName=Interbazaar';
    $postFields .= '&assetPrice=' . $product_price;
    $postFields .= '&notifyPage=' . base_url('paybyme-payment-post');
    $postFields .= '&errorPage=' . base_url('paybyme-payment-post');
    $postFields .= '&redirectPage=' . base_url('paybyme-payment-post');
    $postFields .= '&clientIp=' .$client_ip;

    $postFields .= '&keywordId='.$ci->payment_settings->paybyme_keywordId;
    
    
    $postFields .= "&languageCode=".$ci->payment_settings->paybyme_languageCode;
    
    $postFields .= "&countryCode=" .$ci->payment_settings->paybyme_countryCode;

    // echo "<br>";
    // echo $postFields;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $ci->payment_settings->paybyme_request_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl) or die('Connection Error!');
    curl_close ($curl);

    return $result;
}

function make_request($product_name,$product_price) {

    $ci =& get_instance();

    $clientIp = $_SERVER['REMOTE_ADDR'];
    
    $client_ip = is_null($clientIp) ? $_SERVER['REMOTE_ADDR'] : $clientIp;
   
    $postFields = '';
    
    $postFields .= "currencyCode=EUR";
    
    $postFields .= '&secretKey='.$ci->payment_settings->paybyme_secret_key.'&token='.$ci->payment_settings->paybyme_token;

    $postFields .= '&username=' . $ci->payment_settings->paybyme_username;
    
    $postFields .= '&syncId=' . time();
    
    $postFields .= '&subCompany=' . $ci->general_settings->application_name;
    
    $postFields .= '&assetName=Interbazaar';
    
    $postFields .= '&assetPrice=' . $product_price;
    
    $postFields .= '&notifyPage=' . base_url().'notify.php';
    
    $postFields .= '&errorPage=' . base_url().'paybyme-failure';
    
    $postFields .= '&redirectPage=' . base_url().'paybyme-success';
    
    $postFields .= '&clientIp=' .$client_ip;

    $postFields .= '&keywordId='.$ci->payment_settings->paybyme_keywordId;
    
    
    $postFields .= "&languageCode=".$ci->payment_settings->paybyme_languageCode;
    
    $postFields .= "&countryCode=" .$ci->payment_settings->paybyme_countryCode;

    // $postFields .= "&whiteLabel=1&paymentType=vpos";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $ci->payment_settings->paybyme_request_url);

    curl_setopt($curl, CURLOPT_POST, true);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl) or die('Connection Error!');

    curl_close ($curl);

    return $result;
}

function get_hash_key($result)
{
    $params = parse_str($result);
    // if(!is_null($params) && !is_null($params['ErrorCode'] && $params['ErrorCode'] == '1000')) {
    //     exit('123');
    //     $hash = $ErrorDesc;
    // } else {
    //     if(!is_null($params) && !is_null($params['ErrorCode'])){
    //         $hash = false;
    //     }else{
    //         $hash = false;
    //     }
    // }

    if(!is_null($ErrorCode) && $ErrorCode == '1000') {
        return $ErrorDesc;
    } else {
        if(!is_null($ErrorCode)){
            return false;
        }else{
            return false;
        }
    }

    // echo $hash;
    // exit;
    // return $hash;
}

if (!function_exists('currency_convert')) {
    function currency_convert($base_price,$base_currency){
        // Fetching JSON
        //$req_url = "https://prime.exchangerate-api.com/v5/f3c4c291d280fac1d8ca49b4/latest/$base_currency";
		$req_url = "https://api.exchangerate.host/latest?base=".$base_currency;

        $response_json = file_get_contents($req_url);

        // Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {

            // Decoding
            $response = json_decode($response_json);

            // Check for success
            if('true' === $response->success) {

              // YOUR APPLICATION CODE HERE, e.g.
              $base_price = $base_price; // Your price in USD
              return $EUR_price = round(($base_price * $response->rates->EUR), 2);

            }

            }
            catch(Exception $e) {
                // Handle JSON parse error...
                return 0;
            }

        }
    }
}

if (!function_exists('currency_convert')) {
    function get_db_currency_rates($base_price,$base_currency,$admin_currency){
        $ci = &get_instance();
        $resp = $ci->currency_model->get_currency_rates(['code' => $base_currency]);
    }
}
if (!function_exists('user_phone_number')) {
    function user_phone_number($user_id=""){
        $number = "Number not available";
        $ci = &get_instance();
        $resp = $ci->db->select('phone_number')->where('id',$user_id)->get('users')->row();
        if($resp){
            $number = $resp->phone_number;
        }
        return $number;
    }
}
// Author : 225

// Author : 225
?>