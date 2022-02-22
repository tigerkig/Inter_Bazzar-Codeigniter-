<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($payment_option == "paybyme"): ?>
    <div class="row">
        <div class="col-12">
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>
    <?php

       /* $product_title = implode(',',array_column($this->session->userdata('mds_shopping_cart'),'product_title'));
        
        $product_price = get_price($cart_total->total,'decimal');
        
        $resp = make_request($product_title,$product_price);

        if($resp){
            $payment_id = $this->session->set_userdata('payment_id',$resp); 
            ?>
            <a href="<?php echo $this->payment_settings->paybyme_payment_url; ?>&hash=<?php echo $resp; ?>">Pay</a>
            <?php
        }else{
            echo 'Something went wrong with IP';
        }*/
        
    ?>

    <div id="nav-tab-card" class="tab-pane fade show active">
        <?php echo form_open('cart_controller/paybyme_payment_post', ['id' => 'form_validate', 'class' => 'form-checkout']); ?>
        <input type="hidden" name="mds_payment_type" value="<?php echo $mds_payment_type; ?>">
        <div class="row">
            <div class="col-12 text-center">
                <?php if ($this->session->flashdata('error_credit_card')): ?>
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error_credit_card'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <input type="hidden" name="total_amount" value="<?php echo round($total_amount); ?>" class="<?php echo get_price($total_amount,'input'); ?>">
        <input type="hidden" name="currency" value="<?php echo $currency; ?>">

        <div class="row hidden">
            <div class="form-group col-12">
                <input type="text" name="full_name" class="form-control form-input input-field-card" value="<?php echo old('full_name'); ?>" placeholder="<?php echo trans("name_on_the_card"); ?>" maxlength="200" >
            </div>
        </div>

        <div class="row hidden">
            <div class="form-group col-12">
                <div class="input-group">
                    <input type="text" name="cardNumber" class="form-control form-input input-field-card input-card-number" value="<?php echo old('cardNumber'); ?>" placeholder="<?php echo trans("card_number"); ?>" >
                    <div class="input-group-append">
                        <span class="input-group-text text-muted card-input-logos">
                            <img src="<?php echo base_url(); ?>assets/img/payment/image001.gif" alt="visa">
                            
                            <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                            <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                            <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row hidden">
            <div class="form-group col-sm-6 col-12">
                <input type="text" name="cardExpiry" class="form-control form-input input-field-card input-expiry-date" value="<?php echo old('cardExpiry'); ?>" placeholder="<?php echo trans("expiration_date"); ?>">
            </div>
            <div class="form-group col-sm-6 col-12">
                <input type="text" name="cardCVC" class="form-control form-input input-field-card input-cvv" value="<?php echo old('cardCVC'); ?>" placeholder="<?php echo trans("cvv"); ?>" >
                <div class="icon-cvv">
                    <i class="icon-question-circle"></i>
                </div>
                <div class="cvv-code-container">
                    <img src="<?php echo base_url(); ?>assets/img/payment/code.png" alt="code">
                </div>
            </div>
        </div>
        <div class="input-group-append">
            <button type="submit" name="creditCard" value="creditCard" class="btn btn-custom btn-block shadow-sm"><?php echo trans("confirm_payment"); ?></button> 
            <div class="input-group-append">
                <span class="input-group-text text-muted card-input-logos">
                    <img src="<?php echo base_url(); ?>assets/img/payment/image001.gif" alt="Payby.me">
                    <!-- <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa"> -->
                    <!-- <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard"> -->
                    <!-- <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex"> -->
                </span>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
    <!-- <input type="button" name="pay" id="pay" value="Pay" data-amount="<?php // echo $total_amount; ?>"> -->
<?php endif; ?>
<script src="<?php echo base_url(); ?>assets/js/cleave.min.js"></script>
<script>
    new Cleave('.input-card-number', {
        creditCard: true
    });

    new Cleave('.input-expiry-date', {
        date: true,
        datePattern: ['m', 'Y'],
        delimiter: '/'
    });

    new Cleave('.input-cvv', {
        numericOnly: true,
        blocks: [3]
    });

    $(".icon-cvv i").hover(function () {
        $(".cvv-code-container").show();
    }, function () {
        $(".cvv-code-container").hide();
    });
</script>
<script>
$(document).ready(function(){
    $("#devamEt").click(function(){     
        var data = {
            'kart_isim': $('#kart_isim').val(),
            'pan': $('#pan').val(),
            'cv2': $('#cv2').val(),
            'Ecom_Payment_Card_ExpDate_Month': $('#Ecom_Payment_Card_ExpDate_Month').val(),
            'Ecom_Payment_Card_ExpDate_Year': $('#Ecom_Payment_Card_ExpDate_Year').val()
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "cart_controller/moka_payment_post",
            data: data,
            success: function (response) {
                location.reload();
            }
        });
    });

    $(document).on('click','#pay',function(){
        var amount = $(this).data('amount');
        var cardNumber = $('').val();

        var data = {

            'total_amount': $(this).data('amount'),

            // 'full_name' : $('input[name=full_name]').val(),

            // 'cardNumber' : $('input[name=cardNumber]').val(),

            // 'cardExpiry' : $('input[name=cardExpiry]').val(),

            // 'cardCVC' : $('input[name=cardCVC]').val(),
            
            // 'currency' : $('input[name=currency]').val(),

        };

        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        
        $.ajax({
            url: base_url + "paybyme-payment-post",
            type: 'POST',
            dataType: 'json',
            data: data,
        })
        .done(function(resp) {
            console.log(resp,"success");
            if(resp.status == 1){
                var popup = window.open(resp.url,'_blank','width=500px,height=400px');
                window.onunload = refreshParent;
                function refreshParent() {
                    window.opener.location.reload();
                }
            }else{
                location.reload();
            }
        })
        .fail(function(error) {
            console.log(error,"error");
        })
        .always(function(resp) {
            console.log(resp,"complete");
        });
        

        // $.ajax({
        //     type: "POST",
        //     url: base_url + "paybyme-payment-post",
        //     data: data,
        //     // dataType : 'json',
        //     success: function (resp) {
        //         alert('sawan',resp);
        //         if(resp.status == 1){
        //             window.open(resp.url,'width=500px,height=400px');
        //         }else{
        //             location.reload();
        //         }

        //         // console.log(response);
                
        //         // location.reload();
        //     }
        // });
    });


});
</script>