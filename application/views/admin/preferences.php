<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- <div class="row" style="margin-bottom: 15px;"> -->
    <div class="col-md-12" style="margin-bottom: 5px; background-color:white">
        <h3 style="font-size: 18px; font-weight: 600;margin-top: 10px;"><?php echo trans('preferences'); ?></h3>
    </div>
<!-- </div> -->

<div class="row" style="position:absolute">
    <div class="col-sm-12" style="padding-left:0px">
        <div class="row">
            <div class="col-sm-12" style="padding-left:0px">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans('general'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/preferences_post'); ?>
                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_general"))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('multilingual_system'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="multilingual_system" value="1" id="multilingual_system_1"
                                           class="square-purple" <?php echo ($this->general_settings->multilingual_system == 1) ? 'checked' : ''; ?>>
                                    <label for="multilingual_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="multilingual_system" value="0" id="multilingual_system_2"
                                           class="square-purple" <?php echo ($this->general_settings->multilingual_system != 1) ? 'checked' : ''; ?>>
                                    <label for="multilingual_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('rss_system'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="rss_system" value="1" id="rss_system_1"
                                           class="square-purple" <?php echo ($this->general_settings->rss_system == 1) ? 'checked' : ''; ?>>
                                    <label for="rss_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="rss_system" value="0" id="rss_system_2"
                                           class="square-purple" <?php echo ($this->general_settings->rss_system != 1) ? 'checked' : ''; ?>>
                                    <label for="rss_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('vendor_verification_system'); ?></label>
                                    <small><?php echo "(" . trans('vendor_verification_system_exp') . ")"; ?></small>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="vendor_verification_system" value="1" id="vendor_verification_system_1"
                                           class="square-purple" <?php echo ($this->general_settings->vendor_verification_system == 1) ? 'checked' : ''; ?>>
                                    <label for="vendor_verification_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="vendor_verification_system" value="0" id="vendor_verification_system_2"
                                           class="square-purple" <?php echo ($this->general_settings->vendor_verification_system != 1) ? 'checked' : ''; ?>>
                                    <label for="vendor_verification_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('hide_vendor_contact_information'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="hide_vendor_contact_information" value="1" id="hide_vendor_contact_information_1"
                                           class="square-purple" <?php echo ($this->general_settings->hide_vendor_contact_information == 1) ? 'checked' : ''; ?>>
                                    <label for="hide_vendor_contact_information_1" class="option-label"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="hide_vendor_contact_information" value="0" id="hide_vendor_contact_information_2"
                                           class="square-purple" <?php echo ($this->general_settings->hide_vendor_contact_information != 1) ? 'checked' : ''; ?>>
                                    <label for="hide_vendor_contact_information_2" class="option-label"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('guest_checkout'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="guest_checkout" value="1" id="guest_checkout_1"
                                           class="square-purple" <?php echo ($this->general_settings->guest_checkout == 1) ? 'checked' : ''; ?>>
                                    <label for="guest_checkout_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="guest_checkout" value="0" id="guest_checkout_2"
                                           class="square-purple" <?php echo ($this->general_settings->guest_checkout != 1) ? 'checked' : ''; ?>>
                                    <label for="guest_checkout_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="submit" value="general" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <!-- /.box -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>

            <div class="col-sm-12" style="padding-left:0px">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans('products'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/preferences_post'); ?>
                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_products"))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('approve_before_publishing'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="approve_before_publishing" value="1" id="approve_before_publishing_1"
                                           class="square-purple" <?php echo ($this->general_settings->approve_before_publishing == 1) ? 'checked' : ''; ?>>
                                    <label for="approve_before_publishing_1" class="option-label"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="approve_before_publishing" value="0" id="approve_before_publishing_2"
                                           class="square-purple" <?php echo ($this->general_settings->approve_before_publishing != 1) ? 'checked' : ''; ?>>
                                    <label for="approve_before_publishing_2" class="option-label"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('featured_products'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="promoted_products" value="1" id="promoted_products_1"
                                           class="square-purple" <?php echo ($this->general_settings->promoted_products == 1) ? 'checked' : ''; ?>>
                                    <label for="promoted_products_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="promoted_products" value="0" id="promoted_products_2"
                                           class="square-purple" <?php echo ($this->general_settings->promoted_products != 1) ? 'checked' : ''; ?>>
                                    <label for="promoted_products_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('product_link_structure'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="product_link_structure" value="slug-id" id="product_link_structure_1"
                                           class="square-purple" <?php echo ($this->general_settings->product_link_structure == "slug-id") ? 'checked' : ''; ?>>
                                    <label for="product_link_structure_1" class="option-label">domain.com/slug-id</label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="product_link_structure" value="id-slug" id="product_link_structure_2"
                                           class="square-purple" <?php echo ($this->general_settings->product_link_structure == "id-slug") ? 'checked' : ''; ?>>
                                    <label for="product_link_structure_2" class="option-label">domain.com/id-slug</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="submit" value="products" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <!-- /.box -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-12" style="padding-left:0px">
        <div class="row">
            <div class="col-sm-12" style="padding-left:0px">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans('homepage'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/preferences_post'); ?>
                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_homepage"))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('index_categories'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_categories" value="1" id="index_categories_1"
                                            class="square-purple" <?php echo ($this->general_settings->index_categories == 1) ? 'checked' : ''; ?>>
                                    <label for="index_categories_1" class="option-label"><?php echo trans('show'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_categories" value="0" id="index_categories_2"
                                            class="square-purple" <?php echo ($this->general_settings->index_categories != 1) ? 'checked' : ''; ?>>
                                    <label for="index_categories_2" class="option-label"><?php echo trans('hide'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('index_featured_products'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_promoted_products" value="1" id="index_promoted_products_1"
                                            class="square-purple" <?php echo ($this->general_settings->index_promoted_products == 1) ? 'checked' : ''; ?>>
                                    <label for="index_promoted_products_1" class="option-label"><?php echo trans('show'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_promoted_products" value="0" id="index_promoted_products_2"
                                            class="square-purple" <?php echo ($this->general_settings->index_promoted_products != 1) ? 'checked' : ''; ?>>
                                    <label for="index_promoted_products_2" class="option-label"><?php echo trans('hide'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('index_latest_products'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_latest_products" value="1" id="index_latest_products_1"
                                            class="square-purple" <?php echo ($this->general_settings->index_latest_products == 1) ? 'checked' : ''; ?>>
                                    <label for="index_latest_products_1" class="option-label"><?php echo trans('show'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_latest_products" value="0" id="index_latest_products_2"
                                            class="square-purple" <?php echo ($this->general_settings->index_latest_products != 1) ? 'checked' : ''; ?>>
                                    <label for="index_latest_products_2" class="option-label"><?php echo trans('hide'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('index_blog_slider'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_blog_slider" value="1" id="index_blog_slider_1"
                                            class="square-purple" <?php echo ($this->general_settings->index_blog_slider == 1) ? 'checked' : ''; ?>>
                                    <label for="index_blog_slider_1" class="option-label"><?php echo trans('show'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="index_blog_slider" value="0" id="index_blog_slider_2"
                                            class="square-purple" <?php echo ($this->general_settings->index_blog_slider != 1) ? 'checked' : ''; ?>>
                                    <label for="index_blog_slider_2" class="option-label"><?php echo trans('hide'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label class="control-label"><?php echo trans('index_featured_products_count'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="number" class="form-control" name="index_promoted_products_count" value="<?php echo html_escape($this->general_settings->index_promoted_products_count); ?>" min="0" required style="max-width: 600px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label class="control-label"><?php echo trans('index_latest_products_count'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="number" class="form-control" name="index_latest_products_count" value="<?php echo html_escape($this->general_settings->index_latest_products_count); ?>" min="0" required style="max-width: 600px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="submit" value="homepage" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <!-- /.box -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12" style="padding-left:0px">
        <div class="row">

            <div class="col-sm-12" style="padding-left:0px">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">POS Transactions</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/preferences_post'); ?>
                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_homepage"))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label>Select categories</label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="pos_all_categories" value="1" id="pos_all_categories1"
                                           class="square-purple" <?php echo ($this->general_settings->pos_all_categories== 1) ? 'checked' : ''; ?>>
                                    <label for="pos_all_categories1" class="option-label">From All Categories</label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="pos_all_categories" value="0" id="pos_all_categories2"
                                           class="square-purple" <?php echo ($this->general_settings->pos_all_categories != 1) ? 'checked' : ''; ?>>
                                    <label for="pos_all_categories2" class="option-label">Spesific Categories</label>
                                </div>
								<div class="col-md-12 col-xs-12" style="margin-top: 10px">
									<?php 
										$selected_cat = json_decode($this->general_settings->pos_categories_list, true);
									
									?>
									<select name="pos_categories_list[]" class="form-control" multiple>
										<?php
										foreach($categories as $cat):
										?>
										<option value="<?php echo $cat->id; ?>" <?php echo (in_array($cat->id, $selected_cat) ?  "selected":  ""); ?>><?php echo $cat->slug;?></option>
										<?php
										endforeach;
										?>
									</select>
                                </div>
								
								<div class="col-sm-12 col-xs-12" style="margin-top: 20px">
									<label>POS Accept Urls</label> <button type="button" onclick="$('#ip_list').append(`<input type='text' name='pos_accept_url[]' value='' class='form-control' style='margin-bottom: 2px;'>`)" class="btn btn-success btn-xs">+</button>
                                </div>
								<div class="col-md-12 col-xs-12" id="ip_list">
									<?php foreach(json_decode($this->general_settings->pos_accept_url,true) as $ip): ?>
                                    <input type="text" name="pos_accept_url[]" value="<?php echo $ip; ?>" class="form-control" style='margin-bottom: 2px;'>
									<?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="submit" value="pos" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <!-- /.box -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
            <div class="col-sm-12" style="padding-left:0px">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans('reviews') . " & " . trans('comments'); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/preferences_post'); ?>
                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_reviews_comments"))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('reviews'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="reviews" value="1" id="reviews_1"
                                           class="square-purple" <?php echo ($this->general_settings->reviews == 1) ? 'checked' : ''; ?>>
                                    <label for="reviews_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="reviews" value="0" id="reviews_2"
                                           class="square-purple" <?php echo ($this->general_settings->reviews != 1) ? 'checked' : ''; ?>>
                                    <label for="reviews_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('product_comments'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="product_comments" value="1" id="product_comments_1"
                                           class="square-purple" <?php echo ($this->general_settings->product_comments == 1) ? 'checked' : ''; ?>>
                                    <label for="product_comments_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="product_comments" value="0" id="product_comments_2"
                                           class="square-purple" <?php echo ($this->general_settings->product_comments != 1) ? 'checked' : ''; ?>>
                                    <label for="product_comments_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('blog_comments'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="blog_comments" value="1" id="blog_comments_1"
                                           class="square-purple" <?php echo ($this->general_settings->blog_comments == 1) ? 'checked' : ''; ?>>
                                    <label for="blog_comments_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="blog_comments" value="0" id="blog_comments_2"
                                           class="square-purple" <?php echo ($this->general_settings->blog_comments != 1) ? 'checked' : ''; ?>>
                                    <label for="blog_comments_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?php echo trans('comment_approval_system'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="comment_approval_system" value="1" id="comment_approval_system_1"
                                           class="square-purple" <?php echo ($this->general_settings->comment_approval_system == 1) ? 'checked' : ''; ?>>
                                    <label for="comment_approval_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                                </div>
                                <div class="col-md-6 col-xs-12 col-option">
                                    <input type="radio" name="comment_approval_system" value="0" id="comment_approval_system_2"
                                           class="square-purple" <?php echo ($this->general_settings->comment_approval_system != 1) ? 'checked' : ''; ?>>
                                    <label for="comment_approval_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="submit" value="reviews_comments" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <!-- /.box -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
        </div>
    </div>
</div>

