<?php 

function redirect_ssl() {

  $CI =& get_instance();
  
  $class = $CI->router->fetch_class();

  $exclude =  [];  // add more controller name to exclude ssl.
    
  // echo "<pre>";
  // echo 'enable_admin_secure_connection : '.$CI->general_settings->enable_admin_secure_connection.' / ';
  // echo admin_url().','.current_url();
  if(($CI->general_settings->enable_admin_secure_connection == 1) && (strpos(current_url(), 'admin') == true)) {
    
    // redirecting to ssl.
    $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);

    if ($_SERVER['SERVER_PORT'] != 443) redirect($CI->uri->uri_string());

  } else if(($CI->general_settings->enable_user_secure_connection == 1) && (strpos(current_url(), 'admin') == false)){
    
    // redirecting to ssl.
    $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);

    if ($_SERVER['SERVER_PORT'] != 443) redirect($CI->uri->uri_string());

  }else{
    
    // redirecting with no ssl.
    $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
    
    if ($_SERVER['SERVER_PORT'] == 443) redirect($CI->uri->uri_string());
  
  }
}