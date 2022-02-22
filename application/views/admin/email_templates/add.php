<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
			<div class="box-header with-border">
				<div class="left">
					<h3 class="box-title">Add Email Templates</h3>
				</div>
				<div class="right">
					<a href="<?php echo admin_url(); ?>email-templates" class="btn btn-success btn-add-new">
						<i class="fa fa-list-ul"></i>&nbsp;&nbsp;Email Templates
					</a>
				</div>
			</div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('page_controller/add_page_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>"
                           value="<?php echo old('slug'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <?php foreach($this->languages as $language): ?>
                    <div class="form-group" style="margin-top: 30px;">
                        <label><?php echo $language->name ?> <?php echo trans('content'); ?></label>
                        <textarea id="ckEditor_<?php echo $language->short_form ?>" class="form-control" name="page_content_<?php echo $language->short_form ?>" placeholder="Content"><?php echo old('page_content'.$language->short_form); ?></textarea>
                    </div>

                <?php endforeach; ?>
            
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_page'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
    
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Email Templates</h3>
            </div>
        </div>
    </div>

    </div>
    <div class="col-sm-8">
        
    </div>
</div>
