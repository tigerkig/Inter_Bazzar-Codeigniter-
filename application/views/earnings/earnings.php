<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper" >
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo $title; ?></h1>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("earnings/_earnings_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="earnings-boxes">
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-6 m-b-sm-15">
                                <div class="earnings-box">
                                    <p class="title"><?php echo trans("sales"); ?></p>
                                    <p class="price"><?php echo $user->number_of_sales; ?></p>
                                    <p class="description"><?php echo trans("number_of_total_sales"); ?></p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="earnings-box">
                                    <p class="title"><?php echo trans("balance"); ?></p>
                                    <p class="price"><?php echo price_formatted($user->balance, $this->payment_settings->default_product_currency); ?></p>
                                    <p class="description"><?php echo trans("balance_exp"); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-custom table-earnings-container">
                    <div class="table-responsive">
                        <table class="table table-orders table-striped">
                            <thead>
                            <tr>
                                <th scope="col"><?php echo trans("order"); ?></th>
                                <th scope="col"><?php echo trans("price"); ?></th>
                                <th scope="col"><?php echo trans("commission_rate"); ?></th>
                                <th scope="col"><?php echo trans("shipping_cost"); ?></th>
                                <th scope="col"><?php echo trans("earned_amount"); ?></th>
                                <th scope="col"><?php echo trans("date"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($earnings as $earning): ?>
                                <tr>
                                    <td>#<?php echo $earning->order_number; ?></td>
                                    <td>
                                        <?php // echo price_formatted($earning->price, $earning->currency); ?>
                                        <?php echo price_formatted(currency_convert($earning->price,$earning->currency,'EUR'), 'EUR'); ?>
                                    </td>
                                    <td><?php echo $earning->commission_rate; ?>%</td>
                                    <td>
                                        <?php // echo price_formatted($earning->shipping_cost, $earning->currency); ?>
                                        <?php echo price_formatted(currency_convert($earning->shipping_cost,$earning->currency,'EUR'), 'EUR'); ?>
                                    </td>
                                    <td>
                                        <?php // echo price_formatted($earning->earned_amount, $earning->currency); ?>
                                        <?php echo price_formatted(currency_convert($earning->earned_amount,$earning->currency,'EUR'), 'EUR'); ?>
                                        <?php
                                        $order = get_order_by_order_number($earning->order_number);
                                        if (!empty($order) && $order->payment_method == "Cash On Delivery"):?>
                                            <span class="text-danger">(-<?php echo price_formatted($earning->earned_amount, $earning->currency); ?>)</span><br><small class="text-danger"><?php echo trans("cash_on_delivery"); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo formatted_date($earning->created_at); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (empty($earnings)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="row-custom m-t-15">
                    <div class="float-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Wrapper End-->

