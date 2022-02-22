<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="col-md-12" style="margin-bottom: 5px; background-color:white">
        <h3 style="font-size: 18px; font-weight: 600; margin-top: 10px;"><?php echo trans('social_login'); ?></h3>
    </div>
    <div class="col-md-12" style="display:flex;padding:0px">
        <div class="col-md-4" style="padding-left:0px">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('facebook_login'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open('admin_controller/facebook_login_post'); ?>

                <div class="box-body">
                    <!-- include message block -->
                    <?php if (!empty($this->session->flashdata('mes_social_facebook'))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <label class="label-sitemap"><?php echo trans('app_id'); ?></label>
                        <input type="text" class="form-control" name="facebook_app_id"
                            placeholder="<?php echo trans('app_id'); ?>"
                            value="<?php echo $this->general_settings->facebook_app_id; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label class="label-sitemap"><?php echo trans('app_secret'); ?></label>
                        <input type="text" class="form-control" name="facebook_app_secret"
                            placeholder="<?php echo trans('app_secret'); ?>"
                            value="<?php echo $this->general_settings->facebook_app_secret; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('google_login'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open('admin_controller/google_login_post'); ?>
                <div class="box-body">
                    <!-- include message block -->
                    <?php if (!empty($this->session->flashdata('mes_social_google'))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <label class="label-sitemap"><?php echo trans('client_id'); ?></label>
                        <input type="text" class="form-control" name="google_client_id"
                            placeholder="<?php echo trans('client_id'); ?>"
                            value="<?php echo $this->general_settings->google_client_id; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="label-sitemap"><?php echo trans('client_secret'); ?></label>
                        <input type="text" class="form-control" name="google_client_secret"
                            placeholder="<?php echo trans('client_secret'); ?>"
                            value="<?php echo $this->general_settings->google_client_secret; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
        </div>
        <div class="col-md-4" style="padding-right:0px">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('vk_login'); ?></h3>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <?php echo form_open('admin_controller/social_login_vk_post'); ?>
                <div class="box-body">
                    <!-- include message block -->
                    <?php if (!empty($this->session->flashdata('mes_social_vk'))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>

                    <div class="form-group">
                        <label class="label-sitemap"><?php echo trans('app_id'); ?></label>
                        <input type="text" class="form-control" name="vk_app_id" placeholder="<?php echo trans('app_id'); ?>"
                            value="<?php echo $this->general_settings->vk_app_id; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label class="label-sitemap"><?php echo trans('secure_key'); ?></label>
                        <input type="text" class="form-control" name="vk_secure_key" placeholder="<?php echo trans('secure_key'); ?>"
                            value="<?php echo $this->general_settings->vk_secure_key; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->

                    <?php echo form_close(); ?><!-- form end -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    <div>
