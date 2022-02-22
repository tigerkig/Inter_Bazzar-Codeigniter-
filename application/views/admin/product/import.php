<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
				<?php echo form_open_multipart('product_admin_controller/import_post'); ?>
				<!-- /.box-body -->
            <input type="file" id="upload" name="file" accept=".csv">
                <button type="submit" class="btn btn-primary pull-right">Import Products</button>
           
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
