<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-md-12" style="padding:0px">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="left">
                <h3 class="box-title"><?php echo trans("add_city"); ?></h3>
            </div>
            <div class="right">
                <a href="<?php echo admin_url(); ?>cities" class="btn btn-success btn-add-new">
                    <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?php echo trans('cities'); ?>
                </a>
            </div>
        </div>

        <!-- /.box-header -->

        <!-- form start -->
        <?php echo form_open('admin_controller/add_city_post'); ?>

        <div class="box-body">
            <!-- include message block -->
            <?php $this->load->view('admin/includes/_messages'); ?>
            <div class="form-group">
                <label><?php echo trans('country'); ?></label>
                <select name="country_id" class="form-control" onchange="get_states_by_country($(this).val());" required>
                    <option value=""><?php echo trans("select"); ?></option>
                    <?php
                    foreach ($countries as $item): ?>
                        <option value="<?php echo $item->id; ?>">
                            <?php echo html_escape($item->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo trans('state'); ?></label>
                <select name="state_id" id="select_states" class="form-control" required>
                    <option value=""><?php echo trans("select"); ?></option>
                    <?php foreach ($states as $item): ?>
                        <option value="<?php echo $item->id; ?>">
                            <?php echo html_escape($item->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo trans("name"); ?></label>
                <input type="text" class="form-control" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="200" required>
            </div>

        </div>

        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_city'); ?></button>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?><!-- form end -->
    </div>
    <!-- /.box -->
</div>
