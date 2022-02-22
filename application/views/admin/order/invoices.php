<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box" style="position:absolute;">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->
    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><br>   

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <?php echo form_open($form_action, ['method' => 'GET']); ?>

                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?php echo trans("show"); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>

                                <div class="item-table-filter">
                                    <label><?php echo trans("search"); ?></label>
                                    <input name="order_number" class="form-control" placeholder="<?php echo trans("order_number"); ?>" type="search" value="<?php echo html_escape($this->input->get('order_number', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>

                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary"><?php echo trans("filter"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('order_number'); ?></th>
                            <th><?php echo trans('buyer'); ?></th>
                            <th><?php echo trans('first_name'); ?></th>
                            <th><?php echo trans('last_name'); ?></th>
                            <th><?php echo trans('address'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($invoices as $item): ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->order_number; ?></td>
                                <td><?php echo $item->client_username; ?></td>
                                <td><?php echo $item->client_first_name; ?></td>
                                <td><?php echo $item->client_last_name; ?></td>
                                <td><?php echo $item->client_address; ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-primary" onclick="view(<?php echo $item->order_number; ?>)" data-toggle="modal" data-target="#exampleModal"> 
                                    <i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_invoice"); ?></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($invoices)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<script>
    function view(id){
        var requestUrl =  '<?= base_url(); ?>ajax_requestPost/';
        var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        $.ajax({
           url: requestUrl,
           headers: {'X-Requested-With': 'XMLHttpRequest'},
           type: 'POST',
           data: {
               id,
               _taken:$('input[name="_taken"]').val(),
               [csrfName]: csrfHash
               },
           error: function() {
                alert('Something is wrong');
           },
           success: function(data) {
               var data = JSON.parse(data); 
                $('.txt_csrfname').val(data.token);
                document.getElementById("order_number").innerHTML = data.invoice.order_number;
                document.getElementById("created_at").innerHTML = data.order.created_at;
                document.getElementById("client_username").innerHTML = data.invoice.client_username;
                document.getElementById("client_first_name").innerHTML = data.invoice.client_first_name;
                document.getElementById("client_last_name").innerHTML = data.invoice.client_last_name;
                document.getElementById("client_address").innerHTML = data.invoice.client_address;
                document.getElementById("payment_method").innerHTML = data.order.payment_method;
                document.getElementById("price_currency").innerHTML = data.order.price_currency;

                document.getElementById("seller").innerHTML = data.invoice_items[0].seller;
                document.getElementById("product_id").innerHTML = data.order_products[0].product_id;
                document.getElementById("product_title").innerHTML = data.order_products[0].product_title;
                document.getElementById("product_quantity").innerHTML = data.order_products[0].product_quantity;
                document.getElementById("product_unit_price").innerHTML = data.order_products[0].product_unit_price;
                // if(!empty(data.order_products[0].price_vat))
                    document.getElementById("price_vat").innerHTML = data.order_products[0].price_vat;
                // }
                document.getElementById("product_shipping_cost").innerHTML = data.order_products[0].product_shipping_cost;
                document.getElementById("product_total_price").innerHTML = data.order_products[0].product_total_price;
                document.getElementById("price_subtotal").innerHTML = data.order.price_subtotal;
                document.getElementById("price_shipping").innerHTML = data.order.price_shipping;
                document.getElementById("price_total").innerHTML = data.order.price_total;
                document.getElementById("price_vat").innerHTML = data.order.price_vat;
                
           }
        });
        
    }

</script>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="left: 150px; width: 63%;">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Invoice: #<span style="display: inline-block;width: 100px;" id="order_number"> </span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <div class="row" style="padding: 30px;">
                    <div class="col-md-6">
                        <div class="logo">
                            <img src="<?php echo get_logo($this->general_settings); ?>" alt="logo">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="float-right">
                            <!-- <p class="font-weight-bold mb-1" > Invoice: #<span style="display: inline-block;width: 100px;" id="order_number"> </span></p> -->
                            <p class="font-weight-bold">Date: <span style="pddding-right:3px;width: 100px;" id="created_at"></span></p>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding: 45px 30px;">
                    <div class="col-md-6">
                        <h4 class="font-weight-bold mb-3">Client Information</h4>
                            <p class="mb-1" id="client_username"></p>
                            <p class="mb-1"> <span id="client_first_name"></span>&nbsp;<span id="client_last_name"></span></p>
                            <p class="mb-1" id="client_address"></p>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            <h4 class="font-weight-bold mb-3"> Payment Details </h4>
                            <p class="mb-1">Payment Method: <span style="display: inline-block;min-width: 158px;" id="payment_method"> </p>
                            <p class="mb-1">Currency: <span style="display: inline-block;min-width: 158px;" id="price_currency"> </p>
                        </div>
                    </div>
                </div>

                <div class="row p-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-0 font-weight-bold">seller</th>
                                        <th class="border-0 font-weight-bold">Product Id</th>
                                        <th class="border-0 font-weight-bold">Description</th>
                                        <th class="border-0 font-weight-bold">Quantity</th>
                                        <th class="border-0 font-weight-bold">Unit_price</th>
                                        <th class="border-0 font-weight-bold">Vat</th>
                                        <th class="border-0 font-weight-bold">Shipping</th>
                                        <th class="border-0 font-weight-bold">Yotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr style="font-size: 15px;">
                                        <td id="seller"> </td>
                                        <td id="product_id">  </td>
                                        <td id="product_title"> </td>
                                        <td id="product_quantity"> </td>
                                        <td id="product_unit_price"></td>
                                        <td id="price_vat"> </td>
                                        <td id="product_shipping_cost"></td>
                                        <td id="product_total_price"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="order-total float-right">
                            <div class="row mb-2" style="display:flex">
                                <div class="col-6 col-left"> SubTotal </div>
                                <div class="col-6 col-right">
                                    <strong class="font-600" id="price_subtotal"></strong>
                                </div>
                            </div>
                            <div class="row mb-2" style="display:flex">
                                <div class="col-6 col-left">
                                    Vat
                                </div>
                                <div class="col-6 col-right">
                                    <strong class="font-600" id="price_vat" style=" padding-left: 27px;"> </strong>
                                </div>
                            </div>
                            <div class="row mb-2" style="display:flex">
                                <div class="col-6 col-left">
                                    Shipping 
                                </div>
                                <div class="col-6 col-right">
                                    <strong class="font-600" id="price_shipping"> </strong>
                                </div>
                            </div>
                            <div class="row mb-2" style="display:flex"~>
                                <div class="col-6 col-left">
                                    Total
                                </div>
                                <div class="col-6 col-right">
                                    <strong class="font-600" id="price_total" style=" padding-left: 27px;"> </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-12 text-center mt-3">
                            <button id="btn_print" class="btn btn-primary btn-md hidden-print">
                                <svg id="i-print" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-top: -4px;">
                                    <path d="M7 25 L2 25 2 9 30 9 30 25 25 25 M7 19 L7 30 25 30 25 19 Z M25 9 L25 2 7 2 7 9 M22 14 L25 14"/>
                                </svg>
                                &nbsp;&nbsp; print </button>
                        </div>
                    </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<style>
    body {
        font-size: 16px !important;
    }

    .container-invoice {
        max-width: 900px;
        margin: 0 auto;
    }

    table {
        border-bottom: 1px solid #dee2e6;
    }

    table th {
        font-size: 14px;
        white-space: nowrap;
    }

    .order-total {
        width: 400px;
        max-width: 100%;
        float: right;
        padding: 20px;
    }

    .order-total .col-left {
        font-weight: 600;
    }

    .order-total .col-right {
        text-align: right;
    }

    #btn_print {
        min-width: 180px;
    }

    @media print {
        .hidden-print {
            display: none !important;
        }
    }
</style>
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script> -->
<script>
    $(document).on('click', '#btn_print', function () {
        window.print();
    });
</script>