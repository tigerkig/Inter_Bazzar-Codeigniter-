
<div class="col-md-12" style="position:absolute; padding:0px">
    <div class="box" style="margin-bottom:5px">
        <div class="box-header with-border" style="padding: 15px;">
        
            <div class="left">
                <h3 class="box-title" style="padding-top: 5px;"><?php echo trans('email_templates') ?></h3>
            </div>
            
            <div class="pull-right">
                <button class="btn btn-primary btn-sm" id="save_changes"><?php echo trans('save_changes'); ?></button>
            </div>

            <div class="text-center">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div><!-- /.box-header -->
    </div>
    <div class="row">
        <div class="col-sm-4" style="padding:0px">
            <div class="box">
                <div class="box-header">
                    <h4><?php echo trans('email_templates'); ?></h4>
                </div>
                <div class="box-body">
                    <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($email_templates as $key => $value): ?>
                        <li><a href="<?php echo admin_url().'email-templates/'.$value->id; ?>"><?php echo trans($value->name) ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h4><?php echo trans('admin_email_templates'); ?></h4>
                </div>
                <div class="box-body">
                    <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($admin_email_templates as $key => $value): ?>
                        <li><a href="<?php echo admin_url().'email-templates/'.$value->id; ?>"><?php echo trans($value->name) ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <h4><?php echo trans('vendor_email_templates'); ?></h4>
                </div>
                <div class="box-body">
                    <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($seller_email_templates as $key => $value): ?>
                        <li><a href="<?php echo admin_url().'email-templates/'.$value->id; ?>"><?php echo trans($value->name) ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-sm-8">
            <?php echo form_open('emailtemplates_admin_controller/save_templates_post', ['id'=>'save_templates']); ?>
            <?php foreach ($email_templates_message as $key => $templates) : ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3><?php echo get_language($templates->language_id)->name; ?></h3>
                    </div>
                    <div class="box-body">
                        <input type="hidden" name="template_id[]" value="<?php echo $templates->id;  ?>">
                        <div class="form-group">
                            <label><?php echo trans('subject'); ?></label>
                            <input type="text" name="subject[]" class="form-control" value="<?php echo $templates->subject ?>">
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label><?php echo trans('message'); ?></label>
                            <textarea id="ckEditor_<?php echo $templates->id ?>" class="form-control" name="page_content[]" placeholder="Content"><?php echo old('page_content'); ?><?php echo $templates->message ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>