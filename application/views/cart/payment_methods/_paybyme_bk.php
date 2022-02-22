<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($payment_option == "paybyme"): ?>
    <div class="row">
        <div class="col-12">
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>
    <!--<img src="<?php echo base_url(); ?>assets/img/payment/paybyme.png" alt="paypal" class="img-payment-logo">--!>
    <?php

        $product_title = implode(',',array_column($this->session->userdata('mds_shopping_cart'),'product_title'));
        
        $product_price = (int)$cart_total->total;

        // $resp = make_request($product_title,$product_price);

        // if($resp){
            //$payment_id = $this->session->set_userdata('payment_id',$resp); 
            ?>
            
                
            <?php echo form_open('cart_controller/redirect_to_paybyme_post'); ?>

            <input type="hidden" name="amount" value="<?php echo $product_price; ?>" >

            <!-- <textarea class="hidden" name="redirect_url"><?php // echo $this->payment_settings->paybyme_payment_url; ?>?hash=<?php //  echo $resp; ?></textarea> -->
            <button type="submit" class="btn btn-primary pull-right" style="color:#fff">Pay</button>
            <?php echo form_close(); ?><!-- form end -->
            
            <?php
        // }else{
        //     echo 'Something went wrong with IP';
        // }
        
    ?>
<?php endif; ?>