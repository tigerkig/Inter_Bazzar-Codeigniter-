<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-md-12" style="padding:0px; position:absolute">
    <div class="col-md-6" style="padding-left:0px">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('system_settings'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/system_settings_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("system_setting"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('physical_products'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="physical_products_system" value="1" id="physical_products_1" class="square-purple" <?php echo ($this->general_settings->physical_products_system == 1) ? 'checked' : ''; ?>>
                            <label for="physical_products_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="physical_products_system" value="0" id="physical_products_2" class="square-purple" <?php echo ($this->general_settings->physical_products_system != 1) ? 'checked' : ''; ?>>
                            <label for="physical_products_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('digital_products'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="digital_products_system" value="1" id="digital_products_1" class="square-purple" <?php echo ($this->general_settings->digital_products_system == 1) ? 'checked' : ''; ?>>
                            <label for="digital_products_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="digital_products_system" value="0" id="digital_products_2" class="square-purple" <?php echo ($this->general_settings->digital_products_system != 1) ? 'checked' : ''; ?>>
                            <label for="digital_products_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('marketplace_selling_product_on_the_site'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="marketplace_system" value="1" id="marketplace_system_1" class="square-purple" <?php echo ($this->general_settings->marketplace_system == 1) ? 'checked' : ''; ?>>
                            <label for="marketplace_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="marketplace_system" value="0" id="marketplace_system_2" class="square-purple" <?php echo ($this->general_settings->marketplace_system != 1) ? 'checked' : ''; ?>>
                            <label for="marketplace_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('classified_ads_adding_product_as_listing'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="classified_ads_system" value="1" id="classified_ads_system_1" class="square-purple" <?php echo ($this->general_settings->classified_ads_system == 1) ? 'checked' : ''; ?>>
                            <label for="classified_ads_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="classified_ads_system" value="0" id="classified_ads_system_2" class="square-purple" <?php echo ($this->general_settings->classified_ads_system != 1) ? 'checked' : ''; ?>>
                            <label for="classified_ads_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('bidding_system_request_quote'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="bidding_system" value="1" id="bidding_system_1" class="square-purple" <?php echo ($this->general_settings->bidding_system == 1) ? 'checked' : ''; ?>>
                            <label for="bidding_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="bidding_system" value="0" id="bidding_system_2" class="square-purple" <?php echo ($this->general_settings->bidding_system != 1) ? 'checked' : ''; ?>>
                            <label for="bidding_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><?php echo trans('multi_vendor_system'); ?></label>
                            <small style="font-size: 13px;">(<?php echo trans("multi_vendor_system_exp"); ?>)</small>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="multi_vendor_system" value="1" id="multi_vendor_system_1" class="square-purple" <?php echo ($this->general_settings->multi_vendor_system == 1) ? 'checked' : ''; ?>>
                            <label for="multi_vendor_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="multi_vendor_system" value="0" id="multi_vendor_system_2" class="square-purple" <?php echo ($this->general_settings->multi_vendor_system != 1) ? 'checked' : ''; ?>>
                            <label for="multi_vendor_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><?php echo trans('vat'); ?></label>
                            <small style="font-size: 13px;">(<?php echo trans("vat_exp"); ?>)</small>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="vat_status" value="1" id="vat_status_1" class="square-purple" <?php echo ($this->general_settings->vat_status == 1) ? 'checked' : ''; ?>>
                            <label for="vat_status_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="vat_status" value="0" id="vat_status_2" class="square-purple" <?php echo ($this->general_settings->vat_status != 1) ? 'checked' : ''; ?>>
                            <label for="vat_status_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php echo trans('commission_rate'); ?></label>
                    <input type="number" name="commission_rate" class="form-control" min="0" max="100" value="<?php echo $this->general_settings->commission_rate; ?>">
                </div>

                <div class="form-group">
                    <label><?php echo trans('commission_withdrawn_days'); ?></label>
                    <input type="number" name="commission_withdrawn_days" class="form-control" min="0" max="100" value="<?php echo $this->general_settings->commission_withdrawn_days; ?>">
                </div>

                <div class="form-group">
                    <label>Refund Day period</label>
                    <input type="number" name="refund_period" class="form-control" min="0" max="100" value="<?php echo $this->general_settings->refund_period; ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('timezone'); ?></label>
                    <select name="timezone" class="form-control">
                        <?php $timezones = timezone_identifiers_list();
                        if (!empty($timezones)):
                            foreach ($timezones as $timezone):?>
                                <option value="<?php echo $timezone; ?>" <?php echo ($timezone == $this->general_settings->timezone) ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
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

    <div class="col-md-6" style="padding-right:0px">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('security_setting'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/security_settings_post'); ?>

            <div class="box-body">
                <?php if (!empty($this->session->flashdata("security_setting"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <!-- include message block -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('enable_store_front'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="enable_user_secure_connection" value="1" id="enable_user_secure_connection1" class="square-purple" <?php echo ($this->general_settings->enable_user_secure_connection == 1) ? 'checked' : ''; ?>>
                            <label for="enable_user_secure_connection1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="enable_user_secure_connection" value="0" id="enable_user_secure_connection2" class="square-purple" <?php echo ($this->general_settings->enable_user_secure_connection == 0) ? 'checked' : ''; ?>>
                            <label for="enable_user_secure_connection2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-10">
                            <label><strong><?php echo trans('enable_for_admin'); ?></strong></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="enable_admin_secure_connection" value="1" id="enable_admin_secure_connection1" class="square-purple" <?php echo ($this->general_settings->enable_admin_secure_connection == 1) ? 'checked' : ''; ?>>
                            <label for="enable_admin_secure_connection1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="enable_admin_secure_connection" value="0" id="enable_admin_secure_connection2" class="square-purple" <?php echo ($this->general_settings->enable_admin_secure_connection == 0) ? 'checked' : ''; ?>>
                            <label for="enable_admin_secure_connection2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

</div>


