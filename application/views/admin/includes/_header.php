<!DOCTYPE html>
<html lang="en" dir="ltr" class="bp-panel-active cookies filereader draganddrop no-touchevents mouseevents"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- <title>Administration panel</title> -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/css/favicon-32x32.png"/>
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/css/favicon-16x16.png"/>
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/css/apple-touch-icon.png"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/safari-pinned-tab.svg"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/standalone.fd04ce04fc815ef5d3c4f0400bd95b3d.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/standalone.4b537e4660831d3b44adf8fedc83cc74.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/custom.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/font-awesome/css/font-awesome.min.css">
<link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/icheck/square/purple.css">
<!-- Datatables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/datatables/jquery.dataTables_themeroller.css">
<!-- Tags Input -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/tagsinput/jquery.tagsinput.min.css">
<!-- Bootstrap Toggle -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap-toggle.min.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/pace/pace.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/magnific-popup/magnific-popup.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">
<!-- Theme style -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/<?php echo $this->general_settings->site_color; ?>.min.css"/>

<!-- jQuery 3 -->
<script data-no-defer="">
    window.jsErrors = [];
</script>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
</script>
<style>

    .index-td-product img {
        width: 60px;
        float: left;
        margin-right: 10px;
    }
    input:focus:invalid:focus{
        border-color:#ffffff;
    }
    .order-total .col-left {
        font-weight: 600;
        padding-right:100px;
    }
    .modal.fade.in {
        top: -3% !important;
    }
    .aaa{
        position: fixed;
        top: 90%; 
        left:1%;
    }
    .order-total .col-right {
        text-align: right;
    }
    .order-total {
        width: 400px;
        max-width: 100%;
        /* float: right; */
        padding: 20px;
    }
    .navbar {
        min-height: 0px !important;
        margin-bottom: 0px !important;
        border: none !important;
    }
    .font-weight-bold {
        font-weight: 700!important;
    }
    .mb-3, .my-3 {
        margin-bottom: 1
    rem
    !important;
    }
    .shadow{
        text-shadow: none !important;
    }
    .index-table {
        max-height: 300px;
        overflow-y: auto;
    }
    .pad{
        border: solid 1px #e1e8ef;
        border-radius: 4px;
        padding: 14px 27px 15px 22px;
    }
    .table-sm-meta {
        color: #999;
        font-size: 12px;
        margin-top: 2px;
        display: block;
    }
    .users-list > li img {
        border-radius: 50%;
        max-width: 100%;
        height: auto;
    }
    .users-list > li {
        float: left;
        text-align: center !important;
        width: 16.6% !important;
    }
    .list-unstyled, .chart-legend, .contacts-list, .users-list, .mailbox-attachments {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .users-list > li {
        width: 25%;
        float: left;
        padding: 10px;
        text-align: center;
    }
    .members{
        display:none;
    }
    .float-right {
        float: right!important;
    }
    .row{
        margin-left: 0px !important;
    }
    .users-list > li > a:hover, .users-list > li > a:hover .users-list-name {
        color: #999;
    }
    .a_set{
        display:flex !important;
    }
    .i_set{
        font-size:15px; 
        padding:3px;
    }
    .span_set{
        font-size:15px;
        /* padding:5px 5px 5px 0px; */
        margin-left:0px;
    }
    .nav.nav-pills .dropdown-menu {
        min-width:225px;
    }
    form {
        margin: 0 0 0px;
    }
    .hover-show.nav-pills li.dropdown:hover .dropdown-menu{
        color:white;
    }
    .caret {
        vertical-align:top;
    }
    .nav-pills > li > a{
        color:#0388cc;
    }
    .dropdown-menu > li > a:hover {
        color: #fff;
    }
    .dropdown-menu > li > a {
        color: #464343;
    }
    body{
        background:#eef1f3;    
    }
    .btn-info {
        background-color: #0388cc;
        border-color: #0388cc ;
    }
    .navbar-right .dropdown-menu {
        right: 0;
        left: 0 ;
    }
    .aaa{
        width:80px;
    }


    .dropdown-submenu > .dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
    .cm-noscript {display:none}
</style>
</head>

<body data-ca-scroll-to-elm-offset="120" class="screen--lg">
    <div id="ajax_overlay" class="ajax-overlay" style="display: none;"></div>
    <div id="ajax_loading_box" class="hidden ajax-loading-box" style="display: none;"></div>
        <div class="bp__container">
            <div class="cm-notification-container alert-wrap "></div>
                <div class="main-wrap bp-tygh-main-container" id="main_column">
                    <div class="admin-content">
                    

                    <div class="navbar-admin-top cm-sticky-scroll" data-ca-stick-on-screens="sm-large,md,md-large,lg,uhd" data-ca-top="-43" data-ca-padding="0" style="position: sticky; top: -43px;">
                        <!--Navbar-->
                        <div class="navbar mobile-hidden " id="header_navbar" >
                            <div class="navbar-inner" >
                                                    
                                <div class="nav-ult">     
                                    <li class="nav-company">
                                        <a href="<?php echo base_url(); ?>"style="padding-top: 7px;"><img src="https://interbazaar.net/uploads/logo/logo_5ececd146c44f.png" alt="logo" data-xblocker="passed" style="visibility: visible;width: 60%;"></a>
                                    </li>
                                </div>

                                <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////// -->
                                <ul id="mainrightnavbar" class="nav hover-show navbar-right" style="display:flex">

                                    <div style="display:flex">
                                        <div style="margin-right:10px">
                                            <select id="select" name="subcategory" class="form-control" onchange="get_third_categories(this.value);" style="border-radius: 3px;margin-top: 5px; height: 32px;">
                                                <option value="1" >Products</option>
                                                <option value="2" >Members</option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="products">
                                                <form action="<?php echo base_url(); ?>admin/products" method="GET" accept-charset="utf-8">
                                                    <?php
                                                    if (!empty($this->input->get('category', true))):
                                                        $subcategories = $this->category_model->get_subcategories_by_parent_id($this->input->get('category', true));
                                                        if (!empty($subcategories)) {
                                                            foreach ($subcategories as $item):?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                                                            <?php endforeach;
                                                        }
                                                    endif;
                                                    ?>
                                                    <div >
                                                        <div style="display:flex">
                                                            <input name="q" style=" margin-top: 5px;margin-bottom: 6px;" class="form-control" placeholder="Search for Products" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required autocomplete="off">
                                                            <button type="submit" class="btn btn-default btn-search" style="height: 32px;"><i class="icon-search"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="members">
                                                <form action="<?php echo base_url(); ?>admin/filter_members" method="GET" accept-charset="utf-8">
                                                    <?php
                                                    if (!empty($this->input->get('category', true))):
                                                        $subcategories = $this->category_model->get_subcategories_by_parent_id($this->input->get('category', true));
                                                        if (!empty($subcategories)) {
                                                            foreach ($subcategories as $item):?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                                                            <?php endforeach;
                                                        }
                                                    endif;
                                                    ?>
                                                    <div >
                                                        <div style="display:flex">
                                                            <input name="mem" style=" margin-top: 5px;margin-bottom: 6px;" class="form-control" placeholder="Search for Members" type="search" value="<?php echo html_escape($this->input->get('mem', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required autocomplete="off">
                                                            <button type="submit" class="btn btn-default btn-search" style="height: 32px;"><i class="icon-search"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                        <script>
                                            $('docment').ready(function(){
                                                var sel = $('select').val();
                                                if(sel == 2){
                                                    $('.products').hide();
                                                    $('.members').show();
                                                    
                                                }else{
                                                    $('.products').show();
                                                    $('.members').hide();
                                                }
                                            });
                                            function get_third_categories(num){
                                                console.log(num);
                                                if(num == 2){
                                                    $('.products').hide();
                                                    $('.members').show();
                                                }else{
                                                    $('.products').show();
                                                    $('.members').hide();
                                                }

                                            }
                                        </script>

                                        <li class="dropdown dropdown-top-menu-item navigate-items">
                                            <a id="elm_menu_design" class="dropdown-toggle design shadow">
                                                Design<b class="caret"></b>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>slider" class="a_set">
                                                        <i class="fa fa-sliders i_set"></i>
                                                        <span class="span_set"><?php echo trans("slider"); ?></span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>navigation" class="a_set">
                                                        <i class="fa fa-th i_set" ></i>
                                                        <span class="span_set"><?php echo trans("navigation"); ?></span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>preferences" style="display:flex">
                                                        <i class="fa fa-check-square-o i_set"></i>
                                                        <span class="span_set"><?php echo trans("preferences"); ?></span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>import-export" style="display:flex">
                                                        <i class="fa fa-database i_set"></i> <span class="span_set"><?php echo trans("import_export"); ?>Database I & E</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-submenu  ">
                                                    <div class="dropdown-submenu__link-overlay"></div>                                        
                                                    <a id="elm_menu_addons_manage_addons" class="dropdown-submenu__link ">
                                                        <i class="fa fa-paint-brush "></i>Visual 
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="<?php echo admin_url(); ?>visual-settings"> <?php echo trans("visual_settings"); ?></a></li>
                                                        <li><a href="<?php echo admin_url(); ?>font-settings"> <?php echo trans("font_settings"); ?></a></li>
                                                    </ul>
                                                </li>
                                                
                                            </ul>
                                        </li>

                                        <li class="dropdown dropdown-top-menu-item navigate-items">
                                                <a id="elm_menu_addons" class="dropdown-toggle addons shadow">
                                                    Settings<b class="caret"></b>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>email-settings" style="display:flex">
                                                            <i class="fa fa-envelope " style="padding-top: 3px;"></i> <span class="span_set">Email</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>cache-system" style="display:flex">
                                                            <i class="fa fa-database " style="padding-top: 3px;"></i>
                                                            <span class="span_set"><?php echo trans("cache_system"); ?></span>
                                                        </a>
                                                    </li>

                                                    <li class="dropdown-submenu  ">
                                                        <div class="dropdown-submenu__link-overlay"></div>                                        
                                                        <a id="elm_menu_addons_manage_addons" class="dropdown-submenu__link ">
                                                            <i class="fa fa-circle-o "></i>Form
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="<?php echo admin_url(); ?>form-settings"> <?php echo trans("form_settings"); ?></a></li>
                                                            <li><a href="<?php echo admin_url(); ?>form-settings/shipping-options"> <?php echo trans("shipping_options"); ?></a></li>
                                                            <li><a href="<?php echo admin_url(); ?>form-settings/product-conditions"> <?php echo trans("product_conditions"); ?></a></li>
                                                        </ul>
                                                    </li>

                                                    <li class="dropdown-submenu  ">
                                                        <div class="dropdown-submenu__link-overlay"></div>                                        
                                                        <a id="elm_menu_addons_manage_addons" class="dropdown-submenu__link ">
                                                            <i class="fa fa-cog "></i>General
                                                        <ul class="dropdown-menu">
                                                            <li><a href="<?php echo admin_url(); ?>settings"> <?php echo trans("general_settings"); ?></a></li>
                                                            <li><a href="<?php echo admin_url(); ?>languages"> <?php echo trans("language_settings"); ?></a></li>
                                                            <li><a href="<?php echo admin_url(); ?>email-templates/1"><?php echo trans('email_templates'); ?></a></li>
                                                            <li><a href="<?php echo admin_url(); ?>social-login"> <?php echo trans("social_login"); ?></a></li>
                                                        </ul>
                                                    </li>

                                                    

                                                    <li class="divider"></li>

                                                    <li class="dropdown-submenu  ">
                                                        <div class="dropdown-submenu__link-overlay"></div>                                        
                                                        <a id="elm_menu_addons_manage_addons" class="dropdown-submenu__link ">
                                                            <i class="fa fa-cogs"></i>System 
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="<?php echo admin_url(); ?>system-settings"> <?php echo trans("system_settings"); ?></a></li>
                                                            <li><a href="<?php echo admin_url(); ?>route-settings"> <?php echo trans("route_settings"); ?></a></li>
                                                        </ul>
                                                    </li>

                                                </ul>
                                            </li>
                                        <li class="divider-vertical"></li>

                                        <li class="dropdown dropdown-top-menu-item">

                                            <a class="dropdown-toggle cm-combination" data-toggle="dropdown" id="sw_select_EUR_wrap_">
                                                $ <b class="caret"></b>
                                            </a>
                                            <ul class="dropdown-menu cm-select-list pull-right">
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>payment-settings">
                                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i> 
                                                        <span>Payment</span>
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>currency-settings">
                                                        <i class="fa fa-money"></i> 
                                                        <span>Currency</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>                                                                                          
                                        <!--end curriencies-->

                                        <li class="divider-vertical"></li>

                                        <li class="dropdown dropdown-top-menu-item dropdown--open-enable">
                                            
                                            <a class="dropdown-toggle">
                                                <i class="icon-white icon-user"></i>
                                                <b class="caret"></b>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li class="disabled">
                                                    <span class="hidden-xs" style="padding: 5px 5px 5px 19px;"><strong>User :</strong> <?php echo $this->auth_user->username; ?></span>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>"><i class="fa fa-user"></i> <?php echo trans("profile"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo generate_url("settings"); ?>"><i class="fa fa-cog"></i> <?php echo trans("update_profile"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo generate_url("settings", "change_password"); ?>"><i class="fa fa-lock"></i> <?php echo trans("change_password"); ?></a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>logout" class="logout"><i class="fa fa-sign-out"></i> <?php echo trans("logout"); ?></a>
                                                </li>
                                            </ul>

                                        </li>



                                        <!--end user menu -->
                                </ul>   

                            </div>
                        </div>

                        <!--Subnav-->
                        <div class="subnav" id="header_subnav">
                        
                            <!-- end quick menu -->

                            <ul class="nav hover-show nav-pills">
                                <hr class="mobile-visible navbar-hr">
                                <ul class="nav hover-show nav-pills nav-child">
                                    <!-- order -->
                                    <li class="dropdown">
                                        <a href="" class="dropdown-toggle" style="border-top: 0px;">ORDERS<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex;">
                                                    <i class="fa fa-shopping-cart i_set"></i>
                                                    <span class="span_set">Orders</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>orders"> <?php echo trans("orders"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>transactions"> <?php echo trans("transactions"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>order-bank-transfers"> <?php echo trans("bank_transfer_notifications"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>invoices"> <?php echo trans("invoices"); ?></a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>digital-sales" style="display:flex">
                                                    <i class="fa fa-shopping-bag i_set"></i>
                                                    <span class="span_set"><?php echo trans("digital_sales"); ?></span>
                                                </a>
                                            </li>
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-money i_set"></i>
                                                    <span class="span_set">Earnings</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>earnings"> <?php echo trans("earnings"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>seller-balances"> <?php echo trans("seller_balances"); ?></a></li>
                                                </ul>
                                            </li>
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-credit-card i_set"></i>
                                                    <span class="span_set">Payouts</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>add-payout"> <?php echo trans("add_payout"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>payout-requests"> <?php echo trans("payout_requests"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>completed-payouts"> <?php echo trans("completed_payouts"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>payout-settings"> <?php echo trans("payout_settings"); ?></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- products -->
                                    <li class="dropdown  ">
                                        <a href="" class="dropdown-toggle" style="border-top: 0px;">PRODUCTS<b class="caret"></b></a>
                                        <ul class="dropdown-menu">

                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-shopping-basket angle-left i_set"></i>
                                                    <span class="span_set">Products</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>sell_now"> <?php echo trans("add_product"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>products"> <?php echo trans("products"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>pending-products"> <?php echo trans("pending_products"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>hidden-products"> <?php echo trans("hidden_products"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>drafts"> <?php echo trans("drafts"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>import-products"> Import Products</a></li>
                                                    <li><a href="<?php echo admin_url(); ?>deleted-products"> <?php echo trans("deleted_products"); ?></a></li>
                                                </ul>
                                            </li>

                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-dollar i_set"></i>
                                                    <span class="span_set">Featured Products</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>featured-products"> <?php echo trans("products"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>featured-products-pricing"> <?php echo trans("pricing"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>featured-products-transactions"> <?php echo trans("transactions"); ?></a></li>
                                                </ul>
                                            </li>

                                            <li>
                                                <a href="<?php echo admin_url(); ?>quote-requests" style="display:flex">
                                                    <i class="fa fa-tag"></i> <span class="span_set"><?php echo trans("quote_requests"); ?></span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?php echo admin_url(); ?>categories" style="display:flex">
                                                    <i class="fa fa-folder-open"></i> <span class="span_set"><?php echo trans("categories"); ?></span>
                                                </a>
                                            </li>

                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-plus-square-o i_set"></i>
                                                    <span class="span_set">Custom Fields</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>add-custom-field"> <?php echo trans("add_custom_field"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>custom-fields"> <?php echo trans("custom_fields"); ?></a></li>
                                                </ul>
                                            </li>
                                            
                                        </ul>
                                    </li>

                                    

                                    <!--  membership-->
                                    <li class="dropdown  ">
                                        <a href="" class="dropdown-toggle" style="border-top: 0px;">MEMBERSHIP<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>shop-opening-requests" style="display:flex">
                                                    <i class="fa fa-question-circle i_set"></i>
                                                    <span class="span_set">Shop Opening Requests</span>
                                                </a>
                                            </li>
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-user i_set"></i>
                                                    <span class="span_set">Users</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>vendors"> <?php echo trans("vendors"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>members"> <?php echo trans("members"); ?></a></li>
                                                </ul>
                                            </li>

                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-users "></i>
                                                    <span class="span_set">Administrator</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>add-administrator"> <?php echo trans("add_administrator"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>administrators"> <?php echo trans("administrators"); ?></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <!--management tools  -->
                                    <li class="dropdown  ">
                                        <a href="" class="dropdown-toggle" style="border-top: 0px;">MANAGEMENT TOOLS<b class="caret"></b></a>
                                        <ul class="dropdown-menu"> 
                                            <li>
                                                <a href="<?php echo admin_url(); ?>storage" style="display:flex">
                                                    <i class="fa fa-cloud-upload i_set"></i>
                                                    <span class="span_set"><?php echo trans("storage"); ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>seo-tools" style="display:flex">
                                                    <i class="fa fa-wrench i_set"></i> <span class="span_set"><?php echo trans("seo_tools"); ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>ad-spaces" style="display:flex">
                                                    <i class="fa fa-dollar i_set"></i> <span class="span_set"><?php echo trans("ad_spaces"); ?></span>
                                                </a>
                                            </li>
                                            <li >
                                                <a href="<?php echo admin_url(); ?>contact-messages" style="display:flex">
                                                <i class="fa fa-envelope-o i_set" aria-hidden="true"></i>
                                                    <span class="span_set"><?php echo trans("contact_messages"); ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>reviews" style="display:flex">
                                                    <i class="fa fa-star i_set"></i>
                                                    <span class="span_set"><?php echo trans("reviews"); ?></span>
                                                </a>
                                            </li>
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-comments i_set"></i>
                                                    <span class="span_set">Comments</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>product-comments"> <?php echo trans("product_comments"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>blog-comments"> <?php echo trans("blog_comments"); ?></a></li>
                                                </ul>
                                            </li>
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-envelope-o i_set"></i>
                                                    <span class="span_set">Newsletter</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>send-email-subscribers"><?php echo trans("send_email_subscribers"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>subscribers"><?php echo trans("subscribers"); ?></a>
                                                </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- content -->
                                    <li class="dropdown  ">
                                        <a href="" class="dropdown-toggle" style="border-top: 0px;">CONTENT<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-file i_set"></i>
                                                    <span class="span_set">Pages</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>add-page"> <?php echo trans("add_page"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>pages"> <?php echo trans("pages"); ?></a></li>
                                                </ul>
                                            </li>

                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-file-text i_set"></i>
                                                    <span class="span_set">Blog</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>blog-add-post"> <?php echo trans("add_post"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>blog-posts"> <?php echo trans("posts"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>blog-categories"> <?php echo trans("categories"); ?></a></li>
                                                </ul>
                                            </li>

                                            <li class="newsletters dropdown-submenu">
                                                <div class="dropdown-submenu__link-overlay"></div>                                
                                                <a class=" dropdown-submenu__link is-addon" style="display:flex">
                                                    <i class="fa fa-map-marker i_set"></i>
                                                    <span class="span_set">Location</span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo admin_url(); ?>countries"> <?php echo trans("countries"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>states"> <?php echo trans("states"); ?></a></li>
                                                    <li><a href="<?php echo admin_url(); ?>cities"> <?php echo trans("cities"); ?></a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                    
                        </div>

                        <div class="actions cm-sticky-scroll" data-ca-stick-on-screens="sm-large,md,md-large,lg,uhd" data-ca-top="88" data-ca-padding="45" id="actions_panel" >
                            <div class="actions__wrapper " style="display:flex;justify-content:space-between">
                                    <div style="display:flex">                                                   
                                    <a href="<?php echo admin_url(); ?>" class="btn cm-back-link cm-disabled" ><i class="icon-arrow-left " style=" padding-top: 7px;"></i></a>
                                    <h4 class="home" style=" margin-top: 11px;">HOME</h4>
                                </div>                                                   
                                <nav class="navbar navbar-static-top">
                                    <!--nav bar-->
                                    <div class="navbar-custom-menu">
                                        
                                        <ul class="nav navbar-nav" style="float:right">
                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>refunds?type=pending" data-toggle="tooltip" data-placement="bottom" title="Refund Requests">
                                                <i class="fa fa-money" aria-hidden="true"></i>
                                                <span class="label label-primary" id="refunds_pending"></span>
                                            </a>
                                            </li>

                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>refunds?type=completed" data-toggle="tooltip" data-placement="bottom" title="Refunds Completed">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                                        <span class="label label-success" id="refunds_completed"></span>
                                                        
                                                    </a>
                                            </li>

                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>refunds?type=cancelled" data-toggle="tooltip" data-placement="bottom" title="Refunds Cancelled">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                                        <span class="label label-danger" id="refunds_cancelled"></span>
                                                        
                                                    </a>
                                            </li>

                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>order-bank-transfers" data-toggle="tooltip" data-placement="bottom" title="Bank Transfer">
                                            <i class="fa fa-exchange" aria-hidden="true"></i>
                                                        <span class="label label-primary" id="bank_transfer_notification_badge"></span>
                                                        
                                                    </a>
                                            </li>



                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>orders"  data-toggle="tooltip" data-placement="bottom" title="Orders">
                                                        <i class="fa fa-shopping-cart"></i>
                                                        <span class="label label-success" id="order_notification_badge"></span>
                                                        
                                                    </a>
                                            </li>
                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>order-bank-transfers" data-toggle="tooltip" data-placement="bottom" title="Order Complate With Bank">
                                            <i class="fa fa-university" aria-hidden="true"></i>
                                                        <span class="label label-warning" id="order_complete_bank_notification_badge"></span>
                                                        
                                                    </a>
                                            </li>
                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>payout-requests" data-toggle="tooltip" data-placement="bottom" title=" Payout Request">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                                        <span class="label label-danger" id="payout_request_notification_badge"></span>
                                                        
                                                    </a>
                                            </li>
                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>contact-messages" data-toggle="tooltip" data-placement="bottom" title=" Contact Message">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                        <span class="label label-warning" id="incoming_contact_message_notification_badge"></span>
                                                        
                                                    </a>
                                            </li>
                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>shop-opening-requests" data-toggle="tooltip" data-placement="bottom" title=" Shop opening request">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        <span class="label label-warning" id=""> <?php echo get_shop_request(); ?>   </span>
                                                        
                                                    </a>
                                            </li>
                                            <li class="aaa">
                                            <a class="" href="<?php echo admin_url(); ?>pending-product-comments" data-toggle="tooltip" data-placement="bottom" title=" Pending product comments">
                                            <i class="fa fa-commenting-o" aria-hidden="flas"></i>
                                                    <span class="label label-warning" id=""><?php echo get_pending_comments(); ?></span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:15px; width : 100%"></div>

                    <div class="admin-content-wrap"> 
                    
