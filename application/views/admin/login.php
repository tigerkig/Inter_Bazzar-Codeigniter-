<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo html_escape($title); ?> - <?php echo html_escape($this->general_settings->application_name); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>"/>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">

    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">

	<div style="padding-top:10%">
        <!-- <center><img src="https://interbazaar.net/uploads/logo/logo_5ececd146c44f.png" alt="Sanal Pos 365 | Online ödeme alın, bayi olun alt bayilik verin." /></center> -->

        <div class="container">
            
            <section id="content">

                <?php echo form_open('common_controller/admin_login_post'); ?>
                    <h1>Giriş Formu</h1>
                    <input type="text" placeholder="Kullanıcı Adı" required="" id="username" type="email" name="email"
                        placeholder="<?php echo trans("email"); ?>"
                        value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required/>


                    <input type="password" name="password" id="password"
                        placeholder="<?php echo trans("password"); ?>"
                        value="<?php echo old('password'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>

                    <div class="col-sm-4 col-xs-12">
                        <input type="submit" value="<?php echo trans("login"); ?>" />
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <a href="<?php echo generate_url("forgot_password"); ?>">Forgot your password?</a>
                        <!-- <a href="<?php echo admin_url()."forgot_password"; ?>">Forgot your password?</a> -->
                    </div>

                <?php echo form_close(); ?><!-- form end -->
                
            </section>

        </div>
    </div>
    


</body>
</html>
