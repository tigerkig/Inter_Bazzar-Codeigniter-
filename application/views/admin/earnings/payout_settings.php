<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<div class="col-md-12" style="position:absolute;margin-bottom: 5px;padding:0px">
<div class="row col-md-12" style="margin-bottom: 5px;padding:0px">
    <div class="col-md-12" style="display:flex;justify-content:space-between;background-color: white;padding-top: 10px;padding-bottom:10px">
        <div><h3 style="font-size: 25px;font-weight: 600;margin-top: 0px;margin-bottom: 0px;padding-top: 6px;"><?php echo trans('payout_settings'); ?></h3></div>
        <div class=" text-center">
        <?php if (!empty($this->session->flashdata("msg_success"))):
            $this->load->view('admin/includes/_messages');
        endif; ?>
    </div>
        <div><button type="button" class="btn btn-primary pull-right myModal" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;<?php echo trans('add_payout'); ?></button></div>
    </div>
</div>
<div class="row hidden">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('paypal'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('earnings_admin_controller/payout_paypal_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_paypal"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="payout_paypal_enabled" value="1" id="paypal_enabled_1"
                                   class="square-purple" <?php echo ($this->payment_settings->payout_paypal_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="paypal_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="payout_paypal_enabled" value="0" id="paypal_enabled_2"
                                   class="square-purple" <?php echo ($this->payment_settings->payout_paypal_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="paypal_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('min_poyout_amount'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                    <input type="text" name="min_payout_paypal" class="form-control form-input price-input" value="<?php echo get_price($this->payment_settings->min_payout_paypal, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                </div>

                <div class="form-group">
                       
                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <input type="checkbox" name="is_commission_active_payout_paypal" class="form-control square-purple" value="1" <?php echo ($this->payment_settings->is_commission_active_payout_paypal == 1) ? 'checked' : ''; ?>>
                        <label class="control-label"><?php echo trans('is_commission_active_payout'); ?></label>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                        <input type="input" name="payout_commission_paypal" class="form-control form-input price-input" value="<?php echo ($this->payment_settings->commission_type_payout_paypal == 2) ? $this->payment_settings->payout_commission_paypal : get_price($this->payment_settings->payout_commission_paypal,'input'); ?>">
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                        <select class="form-control form-select" name="commission_type_payout_paypal">
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo ($this->payment_settings->commission_type_payout_paypal == 1) ? 'selected' : '';?>>Amount</option>
                            <option value="2" <?php echo ($this->payment_settings->commission_type_payout_paypal == 2) ? 'selected' : '';?>>%</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('iban'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('earnings_admin_controller/payout_iban_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_iban"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="payout_iban_enabled" value="1" id="iban_enabled_1"
                                   class="square-purple" <?php echo ($this->payment_settings->payout_iban_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="iban_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="payout_iban_enabled" value="0" id="iban_enabled_2"
                                   class="square-purple" <?php echo ($this->payment_settings->payout_iban_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="iban_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('min_poyout_amount'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                    <input type="text" name="min_payout_iban" class="form-control form-input price-input" value="<?php echo get_price($this->payment_settings->min_payout_iban, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                </div>

                <div class="form-group">
                       
                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <input type="checkbox" name="is_commission_active_payout_iban" value="1" class="form-control square-purple" <?php echo ($this->payment_settings->is_commission_active_payout_iban == 1) ? 'checked' : ''; ?>>
                        <label class="control-label"><?php echo trans('is_commission_active_payout'); ?></label>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                        <input type="input" name="payout_commission_iban" class="form-control form-input price-input" value="<?php echo ($this->payment_settings->commission_type_payout_iban == 2) ? $this->payment_settings->payout_commission_iban : get_price($this->payment_settings->payout_commission_iban,'input'); ?>">
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                        <select class="form-control form-select" name="commission_type_payout_iban">
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo ($this->payment_settings->commission_type_payout_iban == 1) ? 'selected' : '';?>>Amount</option>
                            <option value="2" <?php echo ($this->payment_settings->commission_type_payout_iban == 2) ? 'selected' : '';?>>%</option>
                        </select>
                    </div>

                </div>

            </div>


            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>

<div class="row hidden">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('swift'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('earnings_admin_controller/payout_swift_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_swift"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="payout_swift_enabled" value="1" id="swift_enabled_1"
                                   class="square-purple" <?php echo ($this->payment_settings->payout_swift_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="swift_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="payout_swift_enabled" value="0" id="swift_enabled_2"
                                   class="square-purple" <?php echo ($this->payment_settings->payout_swift_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="swift_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('min_poyout_amount'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                    <input type="text" name="min_payout_swift" class="form-control form-input price-input" value="<?php echo get_price($this->payment_settings->min_payout_swift, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                </div>

                <div class="form-group">
                       
                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <input type="checkbox" name="is_commission_active_payout_swift" value="1" class="form-control square-purple" <?php echo ($this->payment_settings->is_commission_active_payout_swift == 1) ? 'checked' : ''; ?>>
                        <label class="control-label"><?php echo trans('is_commission_active_payout'); ?></label>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                        <input type="input" name="payout_commission_swift" class="form-control form-input price-input" value="<?php echo ($this->payment_settings->commission_type_payout_swift == 2) ? $this->payment_settings->payout_commission_swift : get_price($this->payment_settings->payout_commission_swift,'input'); ?>">
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                        <select class="form-control form-select"  name="commission_type_payout_swift">
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo ($this->payment_settings->commission_type_payout_swift == 1) ? 'selected' : '';?>>Amount</option>
                            <option value="2" <?php echo ($this->payment_settings->commission_type_payout_swift == 2) ? 'selected' : '';?>>%</option>
                        </select>
                    </div>

                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->




<div class="row">
    <?php if(!empty($this->payout_settings)): ?>
        <?php $counter = 0;?>
        <?php $counter_id = 0;?>
        <?php $counter_id_remove = 0;?>
        <?php foreach($this->payout_settings as $str => $setting): ?>
            
            <div class="col-md-12" style="padding-left:0px;">
                <div class="box box-primary container" style="padding: 10px 60px 60px 60px ;">
                    <div class="box-header with-border">
                        <h2 ><?php echo $setting->name; ?></h2>
                    </div>
                    <?php echo form_open('earnings_admin_controller/update_payout_setting_post'); ?>
                    <input type="hidden" name="id" value="<?php echo $setting->id; ?>">
                    <div class="box-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label class="resize">Status</label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="payout_status_enabled" value="1" id="payout_status_enabled_1_<?php echo strtolower($setting->id) ?>"
                                        class="square-purple" <?php echo ($setting->status == 1) ? 'checked' : ''; ?>>
                                    <label for="payout_status_enabled_1_<?php echo strtolower($setting->id) ?>" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="payout_status_enabled" value="0" id="payout_status_enabled_2_<?php echo strtolower($setting->id) ?>"
                                        class="square-purple" <?php echo ($setting->status == 0) ? 'checked' : ''; ?>>
                                    <label for="payout_status_enabled_2_<?php echo strtolower($setting->id) ?>" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group" style="display: grid;">    
                            <div class="col-md-12">

                                <div class="table-responsive-wrapper" >
                                    <table class="table hidden-inputs table-middle table--relative table-responsive" id="main_table_<?php echo $counter?>"> 
                                        <thead id="main_thead">
                                            <tr>
                                                <!-- <th width="3%">&nbsp;</th> -->
                                                <th width="3%">&nbsp;</th>
                                                <th style="color:#333" width="4%">Pos.</th>
                                                <th style="color:#333" width="25%">Name</th>
                                                <th style="color:#333" width="25%">Type</th>
                                                <th style="color:#333" width="12%">Required</th>
                                                <th width="15%">&nbsp;</th>
                                                <!-- <th width="6%" class="right">Status</th> -->
                                            </tr>
                                        </thead>

                                        <?php foreach(json_decode($setting->input_data) as $key => $aaa): 
                                            $number_pos = preg_replace('/[^0-9]/', '', $key); ?>
                                            <?php if($key == 'pos_'.$number_pos): ?>
                                                <?php foreach(json_decode($setting->input_data) as $key1 => $aaa1):?>
                                                    <?php if($key1 == 'table_name_'.$number_pos): ?>
                                                        <?php if($aaa != ''): ?>
                                                            <tbody class="cm-row-item cm-row-status-a" id="main_box_add_elements_<?php echo $counter?>_<?php echo $counter_id?>">
                                                                <tr class="border" >
                                                                    <td data-th="&nbsp;" style="padding-left: 80px;">
                                                                        <div id="0<?php echo $counter?>_<?php echo $key?>" onclick="hide_show(this.id)" class="hand btn cm-combination-options-60" style=""><span class="icon-caret-right"></span></div>
                                                                        <div id="1<?php echo $counter?>_<?php echo $key?>" onclick="hide_show(this.id)" class="hand btn cm-combination-options-60" style="display:none"><span class="icon-caret-down"></span> </div>
                                                                    </td>
                                                                    <td class="right" data-th="Pos.">
                                                                        <input class="input-micro" size="3" type="text" name="pos_<?php echo $counter_id?>" id="elements_0" value="<?php echo $aaa?>">
                                                                    </td>

                                                                    <td data-th="Name">
                                                                        <input id="main_descr_elm_add_variants_<?php echo $counter?>_<?php echo $counter_id?>" class="<?php echo $key.'_'.$counter;?>" type="text" name="table_name_<?php echo $counter_id?>" value="<?php echo $aaa1?>">
                                                                        <hr id="<?php echo $key.'_'.$counter;?>" class="main_hr_<?php echo $counter?>_<?php echo $counter_id?>" style="display:none; margin-right:46px;">
                                                                    </td>

                                                                    <td data-th="Type">
                                                                        <select id="main_elm_add_variants_<?php echo $counter?>_<?php echo $counter_id?>" name="select_<?php echo $counter_id?>" class="<?php echo $key.$counter?>" onchange="main_fn_check_element_type(this.id, this.value);">
                                                                            <optgroup label="Base">
                                                                            <option value="S">Select box</option>
                                                                            <option value="R">Radio group</option>
                                                                            <option value="N">Multiple checkboxes</option>
                                                                            <option value="M">Multiple selectbox</option>
                                                                            <option value="C">Check box</option>
                                                                            <option value="I">Input field</option>
                                                                            <option value="T">Text area</option>
                                                                            <option value="H">Header</option>
                                                                            <option value="D">Separator</option>
                                                                            </optgroup>
                                                                            <optgroup label="Special">
                                                                            
                                                                            <option value="V">Date</option>
                                                                            <option value="Y">E-mail</option>
                                                                            <option value="Z">Number</option>
                                                                            <option value="P">Phone</option>
                                                                            <option value="X">Countries list</option>
                                                                            <option value="W">States list</option>
                                                                            <option value="F">File</option>
                                                                            <!-- <option value="A">Referer</option> -->
                                                                            <!-- <option value="B">IP address</option> -->

                                                                            </optgroup>
                                                                        </select>       
                                                                    </td>

                                                                    <td class="center" data-th="Required">
                                                                        <input type="hidden" name="" value="N">
                                                                        <input id="main_req_elm_add_variants_<?php echo $counter?>_<?php echo $counter_id;?>" type="checkbox" name="" checked="checked" value='Y'>
                                                                    </td>

                                                                    <td class="left" data-th="&nbsp;">
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn " onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" style="border: 1px solid #ccc;">
                                                                                <i class="icon-trash"></i>
                                                                            </button>
                                                                        </div>        
                                                                    </td>

                                                                    <!-- <td class="right" data-th="Status">
                                                                        <input type="hidden" name="" id="" value="A">

                                                                        <div class="cm-popup-box btn-group dropleft">
                                                                            <a id="" class="dropdown-toggle btn-text" data-toggle="dropdown">Active <span class="caret"></span> </a>
                                                                            <ul class="dropdown-menu cm-select">
                                                                                <li class="disabled"><a class="status-link-a active" onclick="return fn_check_object_status(this, 'a', '');" data-ca-result-id="">Active</a></li>
                                                                                <li><a class="status-link-d " onclick="return fn_check_object_status(this, 'd', '');" data-ca-result-id="">Disabled</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </td> -->
                                                                </tr>

                                                                <tr id="main_box_element_variants_add_variants_<?php echo $counter_id?>" class="row-more row-gray hide_show <?php echo $counter?>_<?php echo $key?>">
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="5">
                                                                        <div class="table-responsive-wrapper">
                                                                            <table class="table table-middle table--relative table-responsive" id="main_table_child_<?php echo $counter?>_<?php echo $counter_id?>">
                                                                                <thead>
                                                                                    <tr class="cm-first-sibling">
                                                                                        <th width="5%" class="left">Pos.</th>
                                                                                        <th width="67%" >Description</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>

                                                                                    <?php
                                                                                    foreach(json_decode($setting->input_data) as $key2 => $aaa2): 
                                                                                        $headers = explode('_', $key2);
                                                                                        $cnt = count($headers); 
                                                                                        if($cnt >= 2): $ppp = $headers[$cnt-2];
                                                                                            if($number_pos == $ppp): $letter = preg_replace("/[^a-zA-Z_]+/", "", $key2);?>
                                                                                            <?php if($letter == 'pos__' && $aaa2 != ''): ?>

                                                                                                <tr id="box_main_elm_variants_add_variants_<?php echo $counter?>_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" class="cm-row-item cm-elm-variants">

                                                                                                    <td data-th="Pos.">
                                                                                                        <input class="input-micro" size="3" type="text" name="<?php echo $key2?>" id="main_variants_0_0" value="<?php echo $aaa2?>">
                                                                                                        <!-- <input class="input-micro" size="3" type="text" name="pos_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" id="main_variants_0_0" value="<?php echo $aaa2?>"> -->
                                                                                                    </td>

                                                                                                    <?php foreach(json_decode($setting->input_data) as $key3 => $aaa3): 
                                                                                                        $n = preg_replace('/[^0-9_]/', '', $key2);?>
                                                                                                        <?php if($key3 == 'pos_text'.$n): ?>

                                                                                                            <td data-th="Description">
                                                                                                                <input class="span7" type="text" name="<?php echo $key3?>" id="description_0_0" value="<?php echo $aaa3?>">
                                                                                                                <!-- <input class="span7" type="text" name="pos_text_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" id="description_0_0" value="<?php echo $aaa3?>"> -->
                                                                                                            </td>

                                                                                                            <td data-th="&nbsp;">
                                                                                                                <div class="btn-group">
                                                                                                                    <!-- <a class="btn btn-add" name="add" id="elm_variants_add_variants" onclick='child_insert(0)' style='border: 1px solid #ccc;' value="0">Add</a>&nbsp; -->
                                                                                                                    <!-- <a class="btn btn-clone" name="clone" id="elm_variants_add_variants" onclick="Tygh.$('#box_' + this.id).cloneNode(5, true);" style='border: 1px solid #ccc;'>Clone</a>&nbsp;     -->
                                                                                                                    <button type="button" class="btn " name="remove" id="" title="Remove" onclick='this.parentElement.parentElement.parentElement.remove()' style='border: 1px solid #ccc;'>
                                                                                                                        <i class="icon-trash"></i>
                                                                                                                    </button>
                                                                                                                </div>                    
                                                                                                            </td>

                                                                                                            <?php $counter_id_remove++; ?>
                                                                                                        <?php endif;?>
                                                                                                    <?php endforeach; ?>

                                                                                                </tr>
                                                                                            <?php endif;?>
                                                                                        <?php endif;endif;?>
                                                                                    <?php endforeach; ?>

                                                                                    <tr id="box_main_elm_variants_add_variants_<?php echo $counter?>_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" class="cm-row-item cm-elm-variants">
                                                                                        <td data-th="Pos.">
                                                                                            <input class="input-micro" size="3" type="text" name="pos_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" id="main_variants_0_0" value="">
                                                                                        </td>
                                                                                        <td data-th="Description">
                                                                                            <input class="span7" type="text" name="pos_text_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" id="main_description_0_0" value="">
                                                                                        </td>
                                                                                        <td data-th="&nbsp;">
                                                                                            <div class="btn-group">
                                                                                                <a class="btn btn-add" name="add" id="main_elm_variants_add_variants_<?php echo $counter?>_<?php echo $counter_id?>_<?php echo $counter_id_remove?>" onclick='main_child_insert(this.id)' style='border: 1px solid #ccc;' value="0">Add</a>&nbsp;
                                                                                                <button type="button" class="btn " onclick='this.parentElement.parentElement.parentElement.remove()' style='border: 1px solid #ccc;' disabled>
                                                                                                    <i class="icon-trash"></i>
                                                                                                </button>
                                                                                            </div>                    
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php $counter_id_remove = 0 ; ?>
                                                                                </tbody>

                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        <?php endif;?>   
                                                    <?php endif;?>   

                                                    <?php if($key1 == 'select_'.$number_pos):?>
                                                        <script>
                                                            $(document).ready(function(){
                                                                var $variable  = '<?php echo $aaa1?>';
                                                                var $variable1 = '.'+'<?php echo $key.$counter?>';
                                                                var $hr_id = '#'+'<?php echo $key.'_'.$counter;?>';
                                                                var $hr_class = '.'+'<?php echo $key.'_'.$counter;?>';
                                                                var inter2 = '#main_req_elm_add_variants_' + '<?php echo $counter_id;?>';
                                                                $(' '+$variable1+' ').val($variable).change();
                                                                if($variable == 'D') {
                                                                    $(''+$hr_id+'').show();
                                                                    $(''+$hr_class+'').hide();
                                                                    $(''+inter2+'').attr("disabled", true);
                                                                }
                                                                if($variable == 'H') {
                                                                    $(''+inter2+'').attr("disabled", true);
                                                                }
                                                            })
                                                        </script>
                                                    <?php endif;?> 
                                                    
                                                <?php endforeach; ?><?php $counter_id++; ?>
                                            <?php endif;?>    
                                        <?php endforeach; ?>

                                        <tbody class="cm-row-item cm-row-status-a" id="main_box_add_elements_<?php echo $counter?>_<?php echo $counter_id?>">
                                            <tr class="border" >
                                                <td data-th="&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td  class="right" data-th="Pos.">
                                                    <input class="input-micro" size="3" type="text" name="pos_<?php echo $counter_id?>" id="" value="">
                                                </td>

                                                <td data-th="Name">
                                                    <input id="main_descr_elm_add_variants_<?php echo $counter?>_<?php echo $counter_id?>" type="text" name="table_name_<?php echo $counter_id?>" value="" >
                                                    <hr class="main_hr_<?php echo $counter?>_<?php echo $counter_id?>" style="display:none; margin-right:46px;">
                                                            
                                                </td>

                                                <td data-th="Type">
                                                    <select id="main_elm_add_variants_<?php echo $counter?>_<?php echo $counter_id?>" name="select_<?php echo $counter_id?>" onchange="main_fn_check_element_type(this.id, this.value);">
                                                        <optgroup label="Base">
                                                        <option value="S">Select box</option>
                                                        <option value="R">Radio group</option>
                                                        <option value="N">Multiple checkboxes</option>
                                                        <option value="M">Multiple selectbox</option>
                                                        <option value="C">Check box</option>
                                                        <option value="I">Input field</option>
                                                        <option value="T">Text area</option>
                                                        <option value="H">Header</option>
                                                        <option value="D">Separator</option>
                                                        </optgroup>
                                                        <optgroup label="Special">
                                                        
                                                        <option value="V">Date</option>
                                                        <option value="Y">E-mail</option>
                                                        <option value="Z">Number</option>
                                                        <option value="P">Phone</option>
                                                        <option value="X">Countries list</option>
                                                        <option value="W">States list</option>
                                                        <option value="F">File</option>

                                                        </optgroup>
                                                    </select>       
                                                </td>

                                                <td class="center" data-th="Required">
                                                    <input id="main_req_elm_add_variants_<?php echo $counter?>_<?php echo $counter_id;?>" type="checkbox" name="" checked="checked" value='Y'>
                                                </td>

                                                <td class="left" data-th="&nbsp;">
                                                    <div class="btn-group">
                                                        <a class="btn btn-add" name="add" id="main_add_elements_<?php echo $counter?>_<?php echo $counter_id?>" onclick="main_add_elements(this.id)" style="border: 1px solid #ccc;">Add</a>&nbsp;
                                                        <button type="button" class="btn " onclick="" title="Remove" style="border: 1px solid #ccc;" disabled>
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                    </div>        
                                                </td>

                                                <!-- <td class="right" data-th="Status">
                                                    <input type="hidden" name="" id="" value="A">
                                                    <div class="cm-popup-box btn-group dropleft">
                                                        <a id="" class="dropdown-toggle btn-text" data-toggle="dropdown">Active
                                                        <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu cm-select">
                                                            <li class="disabled"><a class="status-link-a active" onclick="return fn_check_object_status(this, 'a', '');" data-ca-result-id="">Active</a></li>
                                                            <li><a class="status-link-d " onclick="$('.border').children().attr('disabled', 'disabled');" data-ca-result-id="">Disabled</a></li>
                                                        </ul>
                                                    </div>
                                                </td> -->
                                            </tr>
                                            
                                            <tr id="box_element_variants_add_variants_0_" class="row-more row-gray">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td colspan="5">
                                                    <div class="table-responsive-wrapper">
                                                        <table class="table table-middle table--relative table-responsive" id="main_table_child_<?php echo $counter?>_<?php echo $counter_id?>">
                                                            <thead>
                                                                <tr class="cm-first-sibling">
                                                                    <th width="5%" class="left">Pos.</th>
                                                                    <th width="67%">Description</th>
                                                                    <th>&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr id="box_main_elm_variants_add_variants_<?php echo $counter?>_<?php echo $counter_id?>_0" class="cm-row-item cm-elm-variants">
                                                                    <td data-th="Pos.">
                                                                        <input class="input-micro" size="3" type="text" name="pos_<?php echo $counter_id?>_0" id="variants_0_0">
                                                                    </td>
                                                                    <td data-th="Description">
                                                                        <input class="span7" type="text" name="pos_text_<?php echo $counter_id?>_0" id="description_0_0" >
                                                                    </td>
                                                                    <td >
                                                                        <div class="btn-group">
                                                                            <a class="btn btn-add" name="add" id="main_elm_variants_add_variants_<?php echo $counter?>_<?php echo $counter_id?>_0" onclick='main_child_insert(this.id)' style='border: 1px solid #ccc;' value="0">Add</a>&nbsp;
                                                                            <button type="button" class="btn " name="remove" id="elm_variants_remove_variants_0" title="Remove" onclick='child_remove(this.id)' style='border: 1px solid #ccc;' disabled>
                                                                                <i class="icon-trash"></i>
                                                                            </button>
                                                                        </div>                    
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>


                                        </tbody>
                                        <?php $counter_id = 0; ?>

                                    </table>
                                </div>

                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label"><?php echo trans('min_poyout_amount'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                                <input type="text" name="minimum_amount" class="form-control form-input price-input" value="<?php echo get_price($setting->minimum_amount, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <div class="col-md-4 col-sm-4 col-xs-12 col-option" style=" margin-top: 29px;">
                                <input type="checkbox" name="commission_active" value="1" class="form-control square-purple" <?php echo ($setting->commission_active == 1) ? 'checked' : ''; ?> id="checkbox_<?php echo $setting->id ?>">
                                <label class="control-label resize" for="checkbox_<?php echo $setting->id ?>"><?php echo trans('is_commission_active_payout'); ?></label>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <label class="control-label resize"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                                <input type="input" name="payout_amount" class="form-control form-input price-input" value="<?php echo ($setting->payout_type == 2) ? $setting->payout_amount : get_price($setting->payout_amount,'input'); ?>">
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <label class="control-label resize"><?php echo trans('commission_type_payout'); ?></label>
                                <select class="form-control form-select"  name="payout_type">
                                    <option value="">-- Select --</option>
                                    <option value="1" <?php echo ($setting->payout_type == 1) ? 'selected' : '';?>>Amount</option>
                                    <option value="2" <?php echo ($setting->payout_type == 2) ? 'selected' : '';?>>%</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-md-12">
                            <button type="button" data-id="<?php echo $setting->id; ?>" class="btn btn-danger delete_payout"><?php echo trans('delete'); ?></button>
                            <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                    <!-- /.box -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>  
            <?php $counter++;?>

        <?php endforeach; ?>
    <?php endif; ?>
</div>




<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->






<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 53%;right: -9%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title"><?php echo trans('add_payout'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo form_open('add-payout-settings'); ?>
                        <div class="box-body">
                            <div class="form-group">
                                 <label class="control-label"><?php echo trans('name'); ?></label>
                                <input type="text" name="name" class="form-control form-input" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <label><?php echo trans("status"); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                        <input type="radio" name="status" value="1" id="status_1"
                                               class="square-purple" required>
                                        <label for="status_1" class="option-label"><?php echo trans('enable'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                        <input type="radio" name="status" value="0" id="status_2"
                                               class="square-purple" >
                                        <label for="status_2" class="option-label"><?php echo trans('disable'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="table-responsive-wrapper" >
                                <table class="table hidden-inputs table-middle table--relative table-responsive" id="table"> 
                                    <thead id="thead">
                                        <tr>
                                            <th width="3%">&nbsp;</th>
                                            <th width="4%">Pos.</th>
                                            <th width="25%">Name</th>
                                            <th width="25%">Type</th>
                                            <th width="12%">Required</th>
                                            <th width="17%">&nbsp;</th>
                                            <!-- <th width="6%" class="right">Status</th> -->
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="cm-row-item cm-row-status-a" id="box_add_elements_0">
                                        <tr class="border" >
                                            <td data-th="&nbsp;">&nbsp;</td>
                                            <td class="right" data-th="Pos.">
                                                <input class="input-micro" size="3" type="text" name="pos_0" id="elements_0" value="">
                                            </td>
                                            <td data-th="Name">
                                                <input id="descr_elm_add_variants_0" type="text" name="table_name_0" value="" >
                                                <hr id="hr_elm_add_variants_0">
                                            </td>
                                            <td data-th="Type">
                                                <select id="elm_add_variants_0" name="select_0" onchange="fn_check_element_type(this.id, this.value);">
                                                    <optgroup label="Base">
                                                    <option value="S">Select box</option>
                                                    <option value="R">Radio group</option>
                                                    <option value="N">Multiple checkboxes</option>
                                                    <option value="M">Multiple selectbox</option>
                                                    <option value="C">Check box</option>
                                                    <option value="I">Input field</option>
                                                    <option value="T">Text area</option>
                                                    <option value="H">Header</option>
                                                    <option value="D">Separator</option>
                                                    </optgroup>
                                                    <optgroup label="Special">
                                                    
                                                    <option value="V">Date</option>
                                                    <option value="Y">E-mail</option>
                                                    <option value="Z">Number</option>
                                                    <option value="P">Phone</option>
                                                    <option value="X">Countries list</option>
                                                    <option value="W">States list</option>
                                                    <option value="F">File</option>
                                                    <!-- <option value="A">Referer</option> -->
                                                    <!-- <option value="B">IP address</option> -->

                                                    </optgroup>
                                                </select>       
                                            </td>
                                            <td class="center" data-th="Required">
                                                <input type="hidden" name="" value="N">
                                                <input id="req_elm_add_variants_0" type="checkbox" name="" checked="checked" value='Y'>
                                            </td>
                                            <td class="left" data-th="&nbsp;">
                                                <div class="btn-group">
                                                    <a class="btn btn-add" name="add" id="add_elements" onclick="" style="border: 1px solid #ccc;">Add</a>&nbsp;
                                                    <!-- <a class="btn btn-clone" name="clone" id="add_elements_0 " onclick="parent_clone(this.id)" style="border: 1px solid #ccc;">Clone</a>&nbsp;     -->
                                                    <button type="button" class="btn " name="remove" id="remove_elements_0" onclick="remove_item(this.id)" title="Remove" style="border: 1px solid #ccc;" disabled>
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </div>        
                                            </td>
                                            <!-- <td class="right" data-th="Status">
                                                <input type="hidden" name="" id="" value="A">
                                                <div class="cm-popup-box btn-group dropleft">
                                                    <a id="" class="dropdown-toggle btn-text" data-toggle="dropdown">Active
                                                    <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu cm-select">
                                                        <li class="disabled"><a class="status-link-a active" onclick="return fn_check_object_status(this, 'a', '');" data-ca-result-id="">Active</a></li>
                                                        <li><a class="status-link-d " onclick="return fn_check_object_status(this, 'd', '');" data-ca-result-id="">Disabled</a></li>
                                                    </ul>
                                                </div>
                                            </td> -->
                                        </tr>
                                        
                                        <tr id="box_element_variants_add_variants_0" class="row-more row-gray">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td colspan="5">
                                                <div class="table-responsive-wrapper">
                                                    <table class="table table-middle table--relative table-responsive" id="table_child">
                                                        <thead>
                                                            <tr class="cm-first-sibling">
                                                                <th width="5%" class="left">Pos.</th>
                                                                <th>Description</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="box_elm_variants_add_variants_0" class="cm-row-item cm-elm-variants">
                                                                <td data-th="Pos.">
                                                                    <input class="input-micro" size="3" type="text" name="pos_0_0" id="variants_0_0">
                                                                </td>
                                                                <td data-th="Description">
                                                                    <input class="span7" type="text" name="pos_text_0_0" id="description_0_0" >
                                                                </td>
                                                                <td data-th="&nbsp;">
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-add" name="add" id="elm_variants_add_variants" onclick='child_insert(0)' style='border: 1px solid #ccc;' value="0">Add</a>&nbsp;
                                                                        <!-- <a class="btn btn-clone" name="clone" id="elm_variants_add_variants" onclick="Tygh.$('#box_' + this.id).cloneNode(5, true);" style='border: 1px solid #ccc;'>Clone</a>&nbsp;     -->
                                                                        <button type="button" class="btn " name="remove" id="elm_variants_remove_variants_0" title="Remove" onclick='child_remove(this.id)' style='border: 1px solid #ccc;' disabled>
                                                                            <i class="icon-trash"></i>
                                                                        </button>
                                                                    </div>                    
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <br>
                            <br>


                            <div class="form-group">
                                <label class="control-label"><?php echo trans('min_poyout_amount'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                                <input type="text" name="minimum_amount" class="form-control form-input price-input" onpaste="return false;" maxlength="32" required>
                            </div>

                            <div class="form-group">
                                   
                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                    <input type="checkbox" name="commission_active" value="1" class="form-control square-purple" id="checkbox_23">
                                    <label class="control-label" for="checkbox_23"><?php echo trans('is_commission_active_payout'); ?></label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                    <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                                    <input type="input" name="payout_amount" class="form-control form-input price-input" value="">
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                    <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                                    <select class="form-control form-select"  name="payout_type">
                                        <option value="">-- Select --</option>
                                        <option value="1">Amount</option>
                                        <option value="2">%</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-primary">Close</button>
                            <button type="submit" class="btn btn-success pull-right">Save Changes</button>
                        </div>
                        <?php echo form_close(); ?>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    .hide_show{
        display: none;
    }
    .hand{
        color: #0388cc;
        background-color: #fff;
        line-height: 22px;
        background-image: none;
        text-shadow: none;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        border: 1px solid #d3dbe2;
        cursor:pointer;
        padding:4px 12px !important;
    }
    .lay{
        display:inline;
        margin-right: 58px;
    }
    .box-title{
        font-size: 22px !important;
    }
    .resize{
        font-size:16px;
    }
    .btn-group > .btn-add, .btn-group > .btn-clone {
        padding-left: 8px;
        padding-right: 8px;
    }
    .btn-group > .btn + .btn {
        margin-left: -1px;
    }
    .row-more>td {
        border-top: 1px dashed #ddd !important;
    }
    .row-gray {
        background-color: #fcfcfc;
        border-bottom: 1px solid #ede8e8;
    }
    .table>tbody+tbody {
        border-top: 1px solid #ddd !important;
    }
    hr {
        margin: 15px 0;
        border: 0;
        border-top: 1px solid #c3c3c3;
        border-bottom: 1px solid #fff;
    }
    .headerTitle {
        font-size: 25px;
    }
</style>


<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->




<script>
    function phoneMask() { 
        var num = $(this).val().replace(/\D/g,''); 
        $(this).val('+'+num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
    }
    $('[type="tel"]').keyup(phoneMask);

    $('#hr_elm_add_variants_0').hide();
    var str, $count = 1, $count_a = 1, fix, count_b=1, count_c=1;
    var myCounter = 0;
    function fn_check_element_type(id, value){
        if(id.length == 18){
            count_id = id.slice(-1);
        }else{
            count_id = id.slice(-2);
        }
        var str = '#box_add_elements_'+count_id;
        var str1 = '#box_element_variants_add_variants_'+count_id;
        var str2 = '#hr_elm_add_variants_'+count_id;
        var str3 = '#descr_elm_add_variants_'+count_id;
        var str4 = '#req_elm_add_variants_'+count_id;

        if(value == 'S' || value == 'R' || value == 'N' || value == 'M')
        {
            $(''+str2+'').hide();
            $(''+str3+'').show();
            $(''+str4+'').attr("disabled", false);
            $('#table '+str+' '+str1+' ').remove();
                $('#table '+str+' ').append([
                    "<tr id='box_element_variants_add_variants_" + count_id + "' class='row-more row-gray'>",
                        "<td>&nbsp;</td><td>&nbsp;</td>",
                        "<td colspan='5'>",
                            "<div class='table-responsive-wrapper'>",
                                "<table class='table table-middle table--relative table-responsive' id='table_child'>",
                                    "<thead>",
                                        "<tr class='cm-first-sibling'>",
                                            "<th width='5%' class='left'>Pos.</th>",
                                            "<th>Description</th>",
                                            "<th>&nbsp;</th>",
                                        "</tr>",
                                    "</thead>",
                                    "<tbody>",
                                        "<tr id='box_elm_variants_add_variants_" + count_id + "' class='cm-row-item cm-elm-variants'>",
                                            "<td data-th='Pos.'>",
                                                "<input class='input-micro' size='3' type='text' name='pos_" +  count_id + "_" + "0" +"' id='variants_" +  count_id +  "_" + "0" + "'>",
                                                // "<input class='input-micro' size='3' type='text' name='' id='variants_" +  count_id +  "_" + "0" + "'>",
                                            "</td>",
                                            "<td data-th='Description'>",
                                                "<input class='span7' type='text' name='pos_text_" +  count_id + "_" + "0" + "' id='description_" +  count_id + "_" + "0" + "' >",
                                            "</td>",
                                            "<td data-th='&nbsp;'>",
                                                "<div class='btn-group'>",
                                                    "<a class='btn btn-add' name='add' id='elm_variants_add_variants' onclick='child_insert("+count_id+")' style='border: 1px solid #ccc;' >Add</a>&nbsp;",
                                                    // "<a class='btn btn-clone' name='clone' id='elm_variants_add_variants' onclick='' style='border: 1px solid #ccc;'>Clone</a>&nbsp;",
                                                    "<button type='button' class='btn ' name='remove' id='elm_variants_remove_variants' onclick='child_remove(this.id)' title='Remove' style='border: 1px solid #ccc;' disabled>",
                                                        "<i class='icon-trash'></i>",
                                                    "</button>",
                                                "</div>",             
                                            "</td>",
                                        "</tr>",
                                    "</tbody>",
                                "</table>",
                            "</div>",
                        "</td>",
                    "</tr>",
                ].join(''));
        }
        else
        {
            $(''+str2+'').hide();
            $(''+str3+'').show();
            $(''+str4+'').attr("disabled", false);
            $('#table '+str+' '+str1+' ').remove();
        }
        if(value == "D")
        {
            $(''+str3+'').hide();
            $(''+str2+'').show();
            $(''+str4+'').attr("disabled", true);
        }
        if(value == "H")
        {
            $(''+str4+'').attr("disabled", true);
        }
    }
    $(document).ready(function(){
        $('.setHeaderLabel').prev('.resize').addClass('headerTitle');
    })
    $(document).on('click',"#add_elements",function(){
        $('#table').append([
            "<tbody class='cm-row-item cm-row-status-a' id='box_add_elements_" +  $count + "'>",
                "<tr class='border'>",
                    "<td data-th='&nbsp;'>&nbsp;</td>",
                    "<td class='right' data-th='Pos.'>",
                        "<input class='input-micro' size='3' type='text' name='pos_" +  $count + "' value='' id='elements_" +  $count + "'>",
                        // "<input class='input-micro' size='3' type='text' name='' value='' id='elements_" +  $count + "'>",
                    "</td>",
                    "<td data-th='Name'>",
                        "<input id='descr_elm_add_variants_" +  $count + "' type='text' name=' table_name_" +  $count + "' >",
                        "<hr id='hr_elm_add_variants_" +  $count + "'>",
                    "</td>",
                    "<td data-th='Type'>",
                        "<select id='elm_add_variants_" +  $count + "' name='select_" +  $count + "' onchange='fn_check_element_type(this.id, this.value)'>",
                            "<optgroup label='Base'>",
                                "<option value='S'>Select box</option>",
                                "<option value='R'>Radio group</option>",
                                "<option value='N'>Multiple checkboxes</option>",
                                "<option value='M'>Multiple selectbox</option>",
                                "<option value='C'>Check box</option>",
                                "<option value='I'>Input field</option>",
                                "<option value='T'>Text area</option>",
                                "<option value='H'>Header</option>",
                                "<option value='D'>Separator</option>",
                            "</optgroup>",
                            "<optgroup label='Special'>",
                                "<option value='V'>Date</option>",
                                "<option value='Y'>E-mail</option>",
                                "<option value='Z'>Number</option>",
                                "<option value='P'>Phone</option>",
                                "<option value='X'>Countries list</option>",
                                "<option value='W'>States list</option>",
                                "<option value='F'>File</option>",
                                // "<option value='A'>Referer</option>",
                                // "<option value='B'>IP address</option>",
                            "</optgroup>",
                        "</select>",
                    "</td>",
                    "<td class='center' data-th='Required'>",
                        "<input type='hidden' name='' >",
                        // "<input id='req_elm_add_variants_" +  $count + "' type='checkbox' name='Required_" +  $count + "' checked='checked' value='Y'>",
                        "<input id='req_elm_add_variants_" +  $count + "' type='checkbox' name='' checked='checked' value='Y'>",
                    "</td>",
                    "<td class='left' data-th='&nbsp;'>",
                        "<div class='btn-group'>",
                            "<a class='btn btn-add' name='add' id='add_elements' onclick='' style='border: 1px solid #ccc;'>Add</a>&nbsp;",
                            // "<a class='btn btn-clone' name='clone' id='add_elements_" +  $count + "' onclick='parent_clone(this.id)' style='border: 1px solid #ccc;'>Clone</a>&nbsp; ",
                            "<button type='button' class='btn ' name='remove' id='remove_elements_" +  $count + "' title='Remove' onclick='remove_item(this.id)' style='border: 1px solid #ccc;'>",
                                "<i class='icon-trash'></i>",
                            "</button>",
                        "</div>",        
                    "</td>",
                    // "<td class='right' data-th='Status'>",
                    //     "<input type='hidden' name='' id='' value='A'>",
                    //     "<div class='cm-popup-box btn-group dropleft'>",
                    //         "<a id='sw_' class='dropdown-toggle btn-text' data-toggle='dropdown'>Active",
                    //             "<span class='caret'></span>",
                    //         "</a>",
                    //         "<ul class='dropdown-menu cm-select'>",
                    //             "<li class='disabled'><a class='status-link-a active' onclick='return fn_check_object_status(this, 'a', '');' data-ca-result-id=''>Active</a></li>",
                    //             "<li><a class='status-link-d ' onclick='return fn_check_object_status(this, 'd', '');' data-ca-result-id=''>Disabled</a></li>",
                    //         "</ul>",
                    //     "</div>",
                    // "</td>",
                "</tr>",


                "<tr id='box_element_variants_add_variants_" + $count + "' class='row-more row-gray'>",
                    "<td>&nbsp;</td><td>&nbsp;</td>",
                    "<td colspan='5'>",
                        "<div class='table-responsive-wrapper'>",
                            "<table class='table table-middle table--relative table-responsive' id='table_child'>",
                                "<thead>",
                                    "<tr class='cm-first-sibling'>",
                                        "<th width='5%' class='left'>Pos.</th>",
                                        "<th>Description</th>",
                                        "<th>&nbsp;</th>",
                                    "</tr>",
                                "</thead>",
                                "<tbody>",
                                    "<tr id='box_elm_variants_add_variants_" + $count + "' class='cm-row-item cm-elm-variants'>",
                                        "<td data-th='Pos.'>",
                                            "<input class='input-micro' size='3' type='text' name='pos_" +  $count + "_" + "0" + "'  id='variants_" +  $count + "_" + "0" + "'>",
                                            // "<input class='input-micro' size='3' type='text' name=''  id='variants_" +  $count + "_" + "0" + "'>",
                                        "</td>",
                                        "<td data-th='Description'>",                                                  
                                            "<input class='span7' type='text' name='pos_text_" +  $count + "_" + "0" + "'  id='description_" +  $count + "_" + "0" +"' >",
                                        "</td>",
                                        "<td data-th='&nbsp;'>",
                                            "<div class='btn-group'>",
                                                "<a class='btn btn-add' name='add' id='elm_variants_add_variants' onclick=' child_insert("+$count+")' style='border: 1px solid #ccc;' value='"+ $count +"'>Add</a>&nbsp;",
                                                // "<a class='btn btn-clone' name='clone' id='elm_variants_add_variants' onclick='' style='border: 1px solid #ccc;'>Clone</a>&nbsp;",
                                                "<button type='button' class='btn ' name='remove' id='elm_variants_remove_variants' onclick='child_remove(this.id)' title='Remove' style='border: 1px solid #ccc;' disabled>",
                                                    "<i class='icon-trash'></i>",
                                                "</button>",
                                            "</div>",             
                                        "</td>",
                                    "</tr>",
                                "</tbody>",
                            "</table>",
                        "</div>",
                    "</td>",
                "</tr>",
            "</tbody>",
        ].join(''));
        var str_hide = '#hr_elm_add_variants_'+$count;
        $(''+str_hide+'').hide();
        $count++;
        
    })

    function child_insert(id){
        var find = '#box_element_variants_add_variants_' + id;

        $(' '+find+' #table_child tbody').append([
            "<tr id='box_elm_variants_add_variants_" + id + "_" + $count_a + "' class='cm-row-item cm-elm-variants'>",
                "<td data-th='Pos.'>",
                    "<input class='input-micro' size='3' type='text' name='pos_" + id + "_" + $count_a + "' id='variants_" + id + "_" + $count_a + "'>",
                    // "<input class='input-micro' size='3' type='text' name='' id='variants_" + id + "_" + $count_a + "'>",
                    "</td>",
                "<td data-th='Description'>",
                    "<input class='span7' type='text' name='pos_text_" + id + "_" + $count_a + "' id='description_" + id + "_" + $count_a + "' >",
                "</td>",
                "<td data-th='&nbsp;'>",
                    "<div class='btn-group'>",
                        "<a class='btn btn-add' name='add' id='elm_variants_add_variants' onclick='child_insert("+id+")' style='border: 1px solid #ccc;'>Add</a>&nbsp;",
                        // "<a class='btn btn-clone' name='clone' id='elm_variants_add_variants' onclick='' style='border: 1px solid #ccc;'>Clone</a>&nbsp;",
                        "<button type='button' class='btn ' name='remove' id='elm_variants_remove_variants_" + id + "_" + $count_a + "' onclick='child_remove(this.id)' title='Remove' style='border: 1px solid #ccc;'>",
                            "<i class='icon-trash'></i>",
                        "</button>",
                    "</div>",             
                "</td>",
            "</tr>"

        ].join(''));
        $count_a++;
    }

    function child_remove(id) {
        var cut = id.replace( /[^\d\_]*/g, '').slice(4);
        var inter1 = '#box_elm_variants_add_variants_'+cut;
        $('#table_child '+inter1+' ').remove();

    }

    function remove_item(id){
        if(id.length == 18){
            remove_id = id.slice(-2);
        }else{
            remove_id = id.slice(-1);
        }
        inter = '#box_add_elements_'+remove_id;
        $('#table '+inter+' ').remove();
    }

    function hide_show(id){
        var old_id = id.substr(1);
        if(id.charAt(0) == '0'){
            $('.'+ old_id +'').show();
            $('#0'+ old_id + '').css("display", "none");
            $('#1'+ old_id + '').css("display", "block");
        }else{
            $('#1'+ old_id + '').css("display", "none");
            $('#0'+ old_id + '').css("display", "block");
            $('.'+ old_id +' ').hide();
        }
    }

    function main_remove_item(id) {
        var cut = id.replace( /[^\d\^]*/g, '');
        var inter1 = '#main_box_add_elements_'+cut;
        $('#main_table '+inter1+' ').remove();
    }
    

    
    function main_child_insert(id){
        var myArray = id.split("_");
        myCounter++;
        var myVariable = (myArray[myArray.length-1])*1 + myCounter;
        var inter1 = '#main_box_element_variants_add_variants_' + myArray[myArray.length-2];
        var inter2 = 'box_main_elm_variants_add_variants_' + myArray[myArray.length-2] + '_' + myVariable;
        var inter3 = 'elm_variants_add_variants_' + myArray[myArray.length-2] + '_' + myVariable;
        
        $(' '+inter1+' #main_table_child tbody').append([
            "<tr id='"+inter2+" ' class='cm-row-item cm-elm-variants'>",
                "<td data-th='Pos.'>",
                    "<input class='input-micro' size='3' type='text' name='pos_" + myArray[myArray.length-2] + "_" + myVariable + "' id=''>",
                    "</td>",
                "<td data-th='Description'>",
                    "<input class='span7' type='text' name='pos_text_" + myArray[myArray.length-2] + "_" + myVariable + "' id='' >",
                "</td>",
                "<td data-th='&nbsp;'>",
                    "<div class='btn-group'>",
                        // "<a class='btn btn-add' name='add' id='"+inter3+"' onclick='main_child_insert(this.id)' style='border: 1px solid #ccc;'>Add</a>&nbsp;",
                        "<button type='button' class='btn' name='remove' id='main_elm_variants_remove_variants_" + myArray[myArray.length-2] + "_" + myVariable + "' onclick='this.parentElement.parentElement.parentElement.remove()' title='Remove' style='border: 1px solid #ccc;margin-left:40px;'>",
                            "<i class='icon-trash'></i>",
                        "</button>",
                    "</div>",             
                "</td>",
            "</tr>"

        ].join(''));

    }
    
    function main_fn_check_element_type(id, value){
        var m = id.split('_');
        var sum = '#main_descr_elm_add_variants_' + m[4] + '_' + m[5] ;
        var sum1 = '#main_req_elm_add_variants_' + m[4] + '_'  + m[5] ;
        var tt = '.main_hr_' + m[4] + '_'  + m[5];
        if(value == 'D'){
            $(''+sum+'').hide();
            $(''+tt+'').show();
        }else{
            $(''+sum+'').show();
            $(''+tt+'').hide();
        }
        if(value == 'H' || value == 'D'){
            $(''+sum1+'').attr("disabled", true);
        }else{
            $(''+sum1+'').attr("disabled", false);
        }
    }

    function main_add_elements(id){
        var myArray = id.split("_");
        var main_table_id = "#main_table_" + myArray[3];
        var main_table_id1 = (myArray[4])*1 + count_b;
        $(''+main_table_id+'').append([
            "<tbody class='cm-row-item cm-row-status-a' id='main_box_add_elements_" + myArray[3] + "_" +  main_table_id1 +"'>",
                "<tr class='border'>",
                    "<td data-th='&nbsp;'>&nbsp;</td>",
                    "<td class='right' data-th='Pos.'>",
                        "<input class='input-micro' size='3' type='text' name='pos_" +  main_table_id1 + "' value='' id='elements_" +  $count + "'>",
                        // "<input class='input-micro' size='3' type='text' name='' value='' id='elements_" +  $count + "'>",
                    "</td>",
                    "<td data-th='Name'>",
                        "<input id='main_descr_elm_add_variants_" + myArray[3] + "_" +  main_table_id1 + "' type='text' name=' table_name_" +  main_table_id1 + "' >",
                        "<hr id='' class='main_hr_" + myArray[3] + "_" +  main_table_id1 + "' style='display:none; margin-right:46px;'>",
                    "</td>",


                    "<td data-th='Type'>",
                        "<select id='main_elm_add_variants_" + myArray[3] + "_" +  main_table_id1 + "' name='select_" +  main_table_id1 + "' onchange='main_fn_check_element_type(this.id, this.value)'>",
                            "<optgroup label='Base'>",
                                "<option value='S'>Select box</option>",
                                "<option value='R'>Radio group</option>",
                                "<option value='N'>Multiple checkboxes</option>",
                                "<option value='M'>Multiple selectbox</option>",
                                "<option value='C'>Check box</option>",
                                "<option value='I'>Input field</option>",
                                "<option value='T'>Text area</option>",
                                "<option value='H'>Header</option>",
                                "<option value='D'>Separator</option>",
                            "</optgroup>",
                            "<optgroup label='Special'>",
                                "<option value='V'>Date</option>",
                                "<option value='Y'>E-mail</option>",
                                "<option value='Z'>Number</option>",
                                "<option value='P'>Phone</option>",
                                "<option value='X'>Countries list</option>",
                                "<option value='W'>States list</option>",
                                "<option value='F'>File</option>",
                            "</optgroup>",
                        "</select>",
                    "</td>",
                    "<td class='center' data-th='Required'>",
                        "<input type='hidden' name='' >",
                        "<input id='main_req_elm_add_variants_" + myArray[3] + "_" +  main_table_id1 + "' type='checkbox' name='' checked='checked' value='Y'>",
                    "</td>",
                    "<td class='left' data-th='&nbsp;'>",
                        "<div class='btn-group'>",
                            // "<a class='btn btn-add' name='add' id='add_elements' onclick='' style='border: 1px solid #ccc;'>Add</a>&nbsp;",
                            // "<a class='btn btn-clone' name='clone' id='add_elements_" +  $count + "' onclick='parent_clone(this.id)' style='border: 1px solid #ccc;'>Clone</a>&nbsp; ",
                            "<button type='button' class='btn ' onclick='this.parentElement.parentElement.parentElement.parentElement.remove()' style='border: 1px solid #ccc;margin-left: 41px;'>",
                                "<i class='icon-trash'></i>",
                            "</button>",
                        "</div>",        
                    "</td>",
                    // "<td class='right' data-th='Status'>",
                    //     "<input type='hidden' name='' id='' value='A'>",
                    //     "<div class='cm-popup-box btn-group dropleft'>",
                    //         "<a id='sw_' class='dropdown-toggle btn-text' data-toggle='dropdown'>Active",
                    //             "<span class='caret'></span>",
                    //         "</a>",
                    //         "<ul class='dropdown-menu cm-select'>",
                    //             "<li class='disabled'><a class='status-link-a active' onclick='return fn_check_object_status(this, 'a', '');' data-ca-result-id=''>Active</a></li>",
                    //             "<li><a class='status-link-d ' onclick='return fn_check_object_status(this, 'd', '');' data-ca-result-id=''>Disabled</a></li>",
                    //         "</ul>",
                    //     "</div>",
                    // "</td>",
                "</tr>",


                "<tr id='box_element_variants_add_variants_" + $count + "' class='row-more row-gray'>",
                    "<td>&nbsp;</td><td>&nbsp;</td>",
                    "<td colspan='5'>",
                        "<div class='table-responsive-wrapper'>",
                            "<table class='table table-middle table--relative table-responsive' id='main_table_child_" + myArray[3] + "_" + main_table_id1 + "'>",
                                "<thead>",
                                    "<tr class='cm-first-sibling'>",
                                        "<th width='5%' class='left'>Pos.</th>",
                                        "<th width='67%'>Description</th>",
                                        "<th>&nbsp;</th>",
                                    "</tr>",
                                "</thead>",
                                "<tbody>",
                                    "<tr id='box_main_elm_variants_add_variants_" + myArray[3] + "_" + main_table_id1 + "_0" + "' class='cm-row-item cm-elm-variants'>",
                                        "<td data-th='Pos.'>",
                                            "<input class='input-micro' size='3' type='text' name='pos_" +  main_table_id1 + "_" + "0" + "'  id='variants_" +  $count + "_" + "0" + "'>",
                                        "</td>",
                                        "<td data-th='Description'>",                                                  
                                            "<input class='span7' type='text' name='pos_text_" +  main_table_id1 + "_" + "0" + "'  id='description_" +  $count + "_" + "0" +"' >",
                                        "</td>",
                                        "<td data-th='&nbsp;'>",
                                            "<div class='btn-group'>",
                                                "<a class='btn btn-add' name='add' id='main_elm_variants_add_variants_" + myArray[3] + "_" + main_table_id1 + "_" + "0" +"' onclick='main_child_insert(this.id)' style='border: 1px solid #ccc;' value='"+ $count +"'>Add</a>&nbsp;",
                                                "<button type='button' class='btn ' onclick='this.parentElement.parentElement.parentElement.remove()'style='border: 1px solid #ccc;' disabled>",
                                                    "<i class='icon-trash'></i>",
                                                "</button>",
                                            "</div>",             
                                        "</td>",
                                    "</tr>",
                                "</tbody>",
                            "</table>",
                        "</div>",
                    "</td>",
                "</tr>",
            "</tbody>",
        ].join(''));
        count_b++;
    }


    function main_child_insert(id){
        console.log(id);
        var myArray = id.split("_");
        var main_table_id = "#main_table_child_" + myArray[5] + '_' + myArray[6];
        var main_table_id1 = (myArray[7])*1 + count_c;

        $(''+main_table_id+' tbody').append([
            "<tr id='box_main_elm_variants_add_variants_" + myArray[5] + "_" + myArray[6] + "_" + main_table_id1 + "' class='cm-row-item cm-elm-variants'>",
                "<td data-th='Pos.'>",
                    "<input class='input-micro' size='3' type='text' name='pos_" + myArray[6] + "_" + main_table_id1 + "' id='variants_" + id + "_" + $count_a + "'>",
                    // "<input class='input-micro' size='3' type='text' name='' id='variants_" + id + "_" + $count_a + "'>",
                    "</td>",
                "<td data-th='Description'>",
                    "<input class='span7' type='text' name='pos_text_" + myArray[6] + "_" + main_table_id1 + "' id='description_" + id + "_" + $count_a + "' >",
                "</td>",
                "<td data-th='&nbsp;'>",
                    "<div class='btn-group'>",
                        // "<a class='btn btn-add' name='add' id='elm_variants_add_variants' onclick='child_insert("+id+")' style='border: 1px solid #ccc;'>Add</a>&nbsp;",
                        // "<a class='btn btn-clone' name='clone' id='elm_variants_add_variants' onclick='' style='border: 1px solid #ccc;'>Clone</a>&nbsp;",
                        "<button type='button' class='btn ' onclick='this.parentElement.parentElement.parentElement.remove()' style='border: 1px solid #ccc;margin-left:40px'>",
                            "<i class='icon-trash'></i>",
                        "</button>",
                    "</div>",             
                "</td>",
            "</tr>"

        ].join(''));
        count_c++;
    }

</script>