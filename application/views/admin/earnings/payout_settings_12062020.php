<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?php echo trans('payout_settings'); ?></h3>
    </div>
</div>
<div class="row">
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
                        <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                        <select class="form-control form-select" name="commission_type_payout_paypal">
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo ($this->payment_settings->commission_type_payout_paypal == 1) ? 'selected' : '';?>>Amount</option>
                            <option value="2" <?php echo ($this->payment_settings->commission_type_payout_paypal == 2) ? 'selected' : '';?>>%</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                        <input type="input" name="payout_commission_paypal" class="form-control form-input price-input" value="<?php echo ($this->payment_settings->commission_type_payout_paypal == 2) ? $this->payment_settings->payout_commission_paypal : get_price($this->payment_settings->payout_commission_paypal,'input'); ?>">
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
                        <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                        <select class="form-control form-select" name="commission_type_payout_iban">
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo ($this->payment_settings->commission_type_payout_iban == 1) ? 'selected' : '';?>>Amount</option>
                            <option value="2" <?php echo ($this->payment_settings->commission_type_payout_iban == 2) ? 'selected' : '';?>>%</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                        <input type="input" name="payout_commission_iban" class="form-control form-input price-input" value="<?php echo ($this->payment_settings->commission_type_payout_iban == 2) ? $this->payment_settings->payout_commission_iban : get_price($this->payment_settings->payout_commission_iban,'input'); ?>">
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

<div class="row">
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
                        <label class="control-label"><?php echo trans('commission_type_payout'); ?></label>
                        <select class="form-control form-select"  name="commission_type_payout_swift">
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo ($this->payment_settings->commission_type_payout_swift == 1) ? 'selected' : '';?>>Amount</option>
                            <option value="2" <?php echo ($this->payment_settings->commission_type_payout_swift == 2) ? 'selected' : '';?>>%</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                        <label class="control-label"><?php echo trans('payout_commission'); ?> (<?php echo get_currency($this->payment_settings->default_product_currency); ?>)</label>
                        <input type="input" name="payout_commission_swift" class="form-control form-input price-input" value="<?php echo ($this->payment_settings->commission_type_payout_swift == 2) ? $this->payment_settings->payout_commission_swift : get_price($this->payment_settings->payout_commission_swift,'input'); ?>">
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
