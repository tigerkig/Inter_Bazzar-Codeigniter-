<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-md-12" style="padding:0px">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo trans("import_language"); ?></h3>
        </div>
        <!-- /.box-header -->

        <!-- form start -->
        <?php echo form_open_multipart('language_controller/import_language_post'); ?>

        <input type="hidden" name="id" value="<?php echo html_escape($language->id); ?>">

        <div class="box-body">
            <!-- include message block -->
            <?php $this->load->view('admin/includes/_messages'); ?>

        
            <div class="form-group">
                <label class="control-label"><?php echo trans('language_file'); ?></label>
                <div class="display-block">
                    <a class='btn btn-success btn-sm btn-file-upload'>
                        <?php echo trans('select'); ?>
                        <input type="file" id="upload" name="file" accept=".csv">
                    </a>
                </div>
            </div>

        </div>

        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><?php echo trans('import_language'); ?></button>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?><!-- form end -->
    </div>
    <!-- /.box -->
</div>
