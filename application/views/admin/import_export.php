<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="col-md-12" style="padding:0px; position: absolute">
        <div class="box box-primary import">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('import_export'); ?> Import Export</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
           
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
				            <?php echo form_open_multipart('admin_controller/exportDB'); ?>

				<form method="POST" enctype="multipart/form-data" action="<?php echo admin_url(); ?>exportDB" >
				<div class="row">
					<div class="col-md-12">
						<div class="box box-primary">
							<div class="box-header" style="display: flex; justify-content: around;">
								<div style="width: 50%">
								<button type="button" class="btn btn-block btn-warning"  data-toggle="collapse" data-target="#table">
								SELECT TABLES
								</button>
								</div>
								<div  style="width: 50%; margin-left: 10px;">
								<input type="submit" value="Export" class="btn btn-block btn-success">
								</div>
							</div>
							<div class="box-body collapse" id="table">
								<table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Table Name</th>
                                        <th scope="col">Select</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($tables as $key => $val) {
                                            echo '<tr>
                                            <th scope="row">'.$key.'</th>
                                            <td>'.$val.'</td>
                                            <td><input type="checkbox" name="table['.$val.']"></td>
                                            </tr>
                                        </tbody>';
                                            }
                                        ?>
                                        </tbody>
                                </table>
							</div>
						</div>
					</div>
				</div>
			<?php echo form_close(); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                             <a href="<?php echo admin_url(); ?>exportCSV_db" name="import_csv" id="import_csv" class="btn btn-success"> <i class="fa fa-upload" aria-hidden="true"></i> Import</a>
                            <!-- <a href="<?php echo admin_url(); ?>exportCSV" name="import_csv" id="import_csv" class="btn btn-primary"><i class="fa fa-download"></i>Create Backup</a> -->
                             <!-- <form action="<?=admin_url() ?>rollbackBackup_upload" method="post" enctype="multipart/form-data">
                                Upload file : 
                                <input type="file" name="uploadFile" value="" /><br><br>
                                <input type="submit" name="submit" value="Upload" />
                            </form> -->
                           
                            <?php echo form_open_multipart('database_controller/do_upload');?> 

                            <!-- <form method="POST" enctype="multipart/form-data" action="<?php echo admin_url(); ?>do_upload" > -->
                                <input type="file" name="fileForUpload">
                                <input type="submit" value="Upload">
                            <!-- </form>     -->
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <?php // echo  $config['upload_path'] = './uploads/temp/';?>
                <!-- /.box-body -->
                
                <!-- /.box-footer -->
                <!-- form end -->
            </div>
			<!-- /.box -->
        <!-- Table-->

        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive bbb">
                        <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                                <th width="20">ID</th>
                                <th>File Name</th>
                                <th>Back Date</th>
                                <th>Download</th>
                                <th>Delete</th>
                                <th>Import DB</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $this->db->order_by("id","desc"); $query = $this->db->get('db_backup');

                            foreach ($query->result() as $row)
                            {      
                             ?>
                                <tr>
                                    <td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $row->id; ?>"></td>
                                    <td><?php echo $row->id; ?></td>
                                    <td><?php echo $row->file_name; ?></td>
                                    <td><?php echo $row->backup_date; ?></td>

                                    <td><a href="<?=base_url ()?>backups/database/<?php echo $row->file_name; ?>" name="download_csv" id="<?php echo $row->id; ?>" class="btn btn-primary"><i class="fa fa-download"></i>Download</a></td>

                                    <td><a href="<?=admin_url ()?>delete-db-backup/<?php echo $row->id;?>" name="download_csv" id="<?php echo $row->id; ?>" class="btn btn-primary"><i class="fa fa-download"></i>Delete</a></td>

                                    <td><a href="<?=admin_url ()?>rollback-db-backup/<?php echo $row->id;?>" name="download_csv" id="<?php echo $row->id; ?>" class="btn btn-primary"><i class="fa fa-download"></i>RoleBack</a></td>
                                    
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12">
                        <div class="row">
                            <!-- <div class="pull-left">
                                <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_comments('<?php //echo trans("confirm_comments"); ?>');"><?php //echo trans('delete'); ?></button>
                                <?php //if ($show_approve_button == true): ?>
                                    <button class="btn btn-sm btn-success btn-table-delete" onclick="approve_selected_comments();"><?php //echo trans('approve'); ?></button>
                                <?php //endif; ?>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
        <!--End table-->    
        </div>
    </div>
</div>
