<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo $title; ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("earnings/_earnings_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                
                    <!-- Nav pills -->
                    <ul class="nav nav-pills nav-payout-accounts justify-content-center">
                        <?php if(!empty($this->payout_settings)): ?>
                            <?php foreach($this->payout_settings as $key => $setting): ?>
                                
                                <?php if($setting->status): $show_all_tabs = true;  

                                    // $tab_name = 'others';
                                    // if(strtolower($setting->name) == 'paypal' || strtolower($setting->name) == 'swift' || strtolower($setting->name) == 'iban'){
                                        $tab_name = str_replace(' ','_',strtolower($setting->name));
                                    // }
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-paypal <?php echo ($active_tab == $tab_name) ? 'active' : ''; ?>" data-toggle="pill" href="#tab_<?php echo $tab_name; ?>"><?php echo $setting->name; ?></a>
                                    </li>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>
                <!-- Tab panes -->
                <?php if ($show_all_tabs): ?>
                    <div class="tab-content">
                        
                        <?php foreach($this->payout_settings as $key => $setting):?>

                            <?php $tab_name_content = str_replace(' ','_',strtolower($setting->name)); ?>

                        
                            <div class="tab-pane container <?php echo ($active_tab == $tab_name_content) ? 'active' : 'fade'; ?>" id="tab_<?php echo $tab_name_content; ?>">

                                <?php if ($active_tab == 'other'):
                                    $this->load->view('partials/_messages');
                                endif; ?>
                                <?php $number_id = 0;?>
                                <div class="row">
                                    <?php if(!empty($this->payout_settings)): ?>
                                        <?php foreach($this->payout_settings as $str => $setting):?>
                                            <?php $tab_name_underline = str_replace(' ','_',strtolower($setting->name)); ?>
                                            <?php if($tab_name_underline == $tab_name_content):?>
                                                <div class="col-md-12" style="padding-left:0px;">
                                                    <div class="box box-primary container" style="padding-top: 20px;">
                                                        <div class="box-header with-border">
                                                            <h2><?php echo $setting->name; ?></h2>
                                                        </div>

                                                    <?php echo form_open('earnings_admin_controller/add_payout_account'); ?>
                                                        <input type="hidden" name="id" value="<?php echo $setting->id; ?>">
                                                        <div class="box-body">

                                                            <div class="form-group" style="display: grid;">    
                                                                <div class="col-md-12">
                                                                    <?php foreach(json_decode($setting->input_data) as $key => $aaa): ?>
                                                                        
                                                                        <?php $result = preg_replace("/[^a-zA-Z_]+/", "", $key); 
                                                                        if($result == 'table_name_'): ?>
                                                                                <label class="resize" id="<?php echo $key?>" style="font-weight:bold !important; width:100%; margin-block: 17px;"><?php echo $aaa; ?></label>
                                                                        <?php endif ?> 

                                                                        <?php if($result == 'select_'):?>
                                                                            <?php switch ($aaa) {
                                                                                    case 'S':?>
                                                                                        <select id="<?php echo $setting->id?>_<?php echo $key ?>"  class="col-md-12 form-control valid" name="<?php echo $key?>">
                                                                                            <option label="" value="">- Select -</option>
                                                                                            <?php foreach(json_decode($setting->input_data) as $num => $bbb): ?>
                                                                                                <?php 
                                                                                                    $char = preg_replace("/[^a-zA-Z_]+/", "", $num); 
                                                                                                    $number = preg_replace('/[^0-9_]/', '', $num);
                                                                                                    $s = substr($number, 2);
                                                                                                    $start = strtok( $s, '_' );
                                                                                                    $a = strtok( $key, '_' );
                                                                                                    $end = strtok( '' );
                                                                                                    if($char == 'pos_text__'): 
                                                                                                        if($bbb != '' ): 
                                                                                                        if($start == $end):?>
                                                                                                            <option value="<?php echo $bbb ?>"><?php echo $bbb ?></option>
                                                                                                        <?php endif ?> 
                                                                                                        <?php endif ?> 
                                                                                                    <?php endif ?> 
                                                                                                
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                            <?php   break;
                                                                                    case 'R':?>
                                                                                            <?php foreach(json_decode($setting->input_data) as $num => $bbb): ?>
                                                                                                <?php 
                                                                                                    $char = preg_replace("/[^a-zA-Z_]+/", "", $num); 
                                                                                                    $number = preg_replace('/[^0-9_]/', '', $num);
                                                                                                    $s = substr($number, 2);
                                                                                                    $start = strtok( $s, '_' );
                                                                                                    $a = strtok( $key, '_' );
                                                                                                    $end = strtok( '' ); 
                                                                                                    if($char == 'pos_text__' ): 
                                                                                                        if($bbb != '' ): 
                                                                                                            if($start == $end):  $str_char =  str_replace(' ','_',strtolower($bbb));?>
                                                                                                            
                                                                                                                <div class="lay" >
                                                                                                                    <input type="radio" class="form_control" name="<?php echo $key; ?>" value="<?php echo $bbb; ?>" id="<?php echo $setting->id?>_<?php echo $str_char ?>">
                                                                                                                    <label for="<?php echo $key; ?>" style="padding: 1px 10px 0px 10px;"><?php echo $bbb; ?></label>
                                                                                                                </div>
                                                                                                            <?php endif ?> 
                                                                                                        <?php endif ?> 
                                                                                                    <?php endif ?> 
                                                                                            <?php endforeach; ?>
                                                                                            
                                                                            <?php    break;
                                                                                    case 'N':?>
                                                                                            <?php foreach(json_decode($setting->input_data) as $num => $bbb): ?>
                                                                                                <?php 
                                                                                                    $char = preg_replace("/[^a-zA-Z_]+/", "", $num); 
                                                                                                    $number = preg_replace('/[^0-9_]/', '', $num);
                                                                                                    $s = substr($number, 2);
                                                                                                    $start = strtok( $s, '_' );
                                                                                                    $a = strtok( $key, '_' );
                                                                                                    $end = strtok( '' ); 
                                                                                                    if($char == 'pos_text__'): 
                                                                                                        if($bbb != '' ): 
                                                                                                        if($start == $end): $str_char =  str_replace(' ','_',strtolower($bbb));?>
                                                                                                            <div class="lay" >
                                                                                                                <input type="checkbox" class="form_control" name="<?php echo $key; ?>" value="<?php echo $bbb; ?>" id="<?php echo $setting->id?>_<?php echo $str_char ?>">

                                                                                                                <!-- <input type="checkbox" class="form_control" name="<?php echo $key; ?>" value="<?php echo $bbb; ?>" id="<?php echo $setting->id?>_<?php echo $bbb ?>"> -->
                                                                                                                <label for="<?php echo $key; ?>" style="padding: 1px 10px 0px 10px;"><?php echo $bbb; ?></label>
                                                                                                            </div>
                                                                                                        <?php endif ?> 
                                                                                                    <?php endif ?> 
                                                                                                    <?php endif ?> 
                                                                                            <?php endforeach; ?>
                                                                            <?php   break;
                                                                                    case 'M':?>
                                                                                    <select id="<?php echo $setting->id?>_<?php echo $key ?>" class="col-md-12" name="<?php echo $key?>" multiple="multiple">
                                                                                        <?php foreach(json_decode($setting->input_data) as $num => $bbb): ?>
                                                                                            <?php 
                                                                                                $char = preg_replace("/[^a-zA-Z_]+/", "", $num); 
                                                                                                $number = preg_replace('/[^0-9_]/', '', $num);
                                                                                                $s = substr($number, 2);
                                                                                                $start = strtok( $s, '_' );
                                                                                                $a = strtok( $key, '_' );
                                                                                                $end = strtok( '' );
                                                                                                if($char == 'pos_text__'): 
                                                                                                    if($bbb != '' ): 

                                                                                                    if($start == $end):?>
                                                                                                        <option value="<?php echo $bbb ?>"><?php echo $bbb ?></option>
                                                                                                    <?php endif ?> 
                                                                                                    <?php endif ?> 
                                                                                                <?php endif ?> 
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                            <?php   break;
                                                                                    case 'C':?>
                                                                                    <input type="checkbox" class="form_control" name="<?php echo $key; ?>" id="<?php echo $setting->id?>_<?php echo $key ?>">
                                                                            <?php   break;
                                                                                    case 'I':?>
                                                                                    <input type="text" name="<?php echo $key?>" placeholder="Enter the text" id="<?php echo $setting->id?>_<?php echo $key ?>" class="form-control form-input " required>
                                                                            <?php   break;
                                                                                    case 'T':?>
                                                                                    <textarea id="<?php echo $setting->id?>_<?php echo $key ?> " name="<?php echo $key?>" class="md-textarea form-control" rows="3" required></textarea>
                                                                            <?php   break;
                                                                                    case 'H':?>
                                                                                        <div class="setHeaderLabel" style="display: none"></div>
                                                                            <?php   break;
                                                                                    case 'D':?>
                                                                                    <hr class="ty-form-builder__separator">
                                                                            <?php   break;
                                                                                    case 'V':?>
                                                                                    <input type="date" name="<?php echo $key?>" placeholder="Please select date" id="<?php echo $setting->id?>_<?php echo $key ?>" class="form-control form-input price-input" required>
                                                                            <?php   break;
                                                                                    case 'Y':?>
                                                                                    <input type="email" name="<?php echo $key?>" placeholder="Enter the Email" id="<?php echo $setting->id?>_<?php echo $key ?>" class="form-control form-input " required>
                                                                                <?php  break;
                                                                                    case 'Z':?>
                                                                                    <input type="number" name="<?php echo $key?>" placeholder="Enter the number" id="<?php echo $setting->id?>_<?php echo $key ?>" class="form-control form-input price-input" required>
                                                                            <?php   break;
                                                                                    case 'P':?>
                                                                                    <input id="<?php echo $setting->id?>_<?php echo $key ?>" type="tel" name="<?php echo $key?>" placeholder="+_(___)___-____" class="form-control form-input price-input" required>
                                                                            <?php   break;
                                                                                    case 'X':?>
                                                                                        <select id="<?php echo $setting->id?>_<?php echo $key ?>" name="<?php echo $key?>" class="form-control" required>
                                                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                                                            <?php foreach ($countries as $item): ?>
                                                                                                <option value="<?php echo $item->name; ?>" ><?php echo $item->name; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                            <?php   break;
                                                                                    case 'W':?>
                                                                                        <select id="<?php echo $setting->id?>_<?php echo $key ?>" name="<?php echo $key?>" class="form-control" required>
                                                                                            <option value="" selected><?php echo 'Select State'; ?></option>
                                                                                            <?php foreach ($states as $item): ?>
                                                                                                <option value="<?php echo $item->name; ?>" ><?php echo $item->name; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                            <?php   break;
                                                                                    case 'F':?>
                                                                                    <input type="file"  name="<?php echo $key?>" placeholder="" id="<?php echo $setting->id?>_<?php echo $key ?>" style="width:100%" required>

                                                                            <?php   break;
                                                                                    case 'A':?>
                                                                                    <!-- <input type="tel" name="" placeholder="referer" id="<?php echo $key ?>" class="form-control form-input price-input" required> -->

                                                                            <?php   break;
                                                                                    case 'B':?>
                                                                                    <!-- <input type="tel" name="" placeholder="ip message" id="<?php echo $key ?>" class="form-control form-input price-input" required> -->

                                                                            <?php   break;?><br><?php
                                                                                }?>
                                                                        <?php endif ?>   
                                                                        
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <?php $set_data = $setting->id?>
                                                        <?php if(!empty($setting->set_input_data)):?>
                                                            <?php foreach(json_decode($setting->set_input_data) as $key_val => $data_val): ?>
                                                                <script>
                                                                    $(document).ready(function () {                        
                                                                        var id_val = '<?php echo $key_val ?>';
                                                                        var id_val1 = '<?php echo $data_val ?>';
                                                                        var id_val2 = '<?php echo str_replace(' ','_',strtolower($data_val)) ?>';
                                                                        var id = '<?php echo $set_data?>';
                                                                        var sum_id = id + '_' + id_val;
                                                                        var sum_id1 = id + '_' + id_val2;
                                                                        if(id_val != 'id'){ 
                                                                            console.log(id_val1+'____________'+id_val2);
                                                                            $('#'+sum_id+'').val(id_val1);
                                                                            $('#'+sum_id1+'').attr('checked', true);
                                                                        }
                                                                    });
                                                                </script>

                                                            <?php endforeach; ?> 
                                                        <?php endif;?>            
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-md btn-custom"><?php echo trans("save_changes"); ?></button>
                                                            </div>
                                                        </div>
                                                        <!-- /.box-footer -->
                                                        <!-- /.box -->
                                                    <?php echo form_close(); ?><!-- form end -->
                                                    </div>
                                                </div>  
                                            <?php endif?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>
                <?php endif; ?>
            </div>
            
        </div>

    </div>
</div>
<!-- Wrapper End-->

<style>
    .form_control {
        width: 3%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 0.2rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;        
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .nav-payout-accounts .nav-link {
        padding: .6rem 2rem;
    }
    .lay{
        display:inline;
        margin-right: 58px;
    }
    .box-title{
        font-size: 22px !important;
    }
    .resize{
        font-size:16px;
    }
    .btn-group > .btn-add, .btn-group > .btn-clone {
        padding-left: 8px;
        padding-right: 8px;
    }
    .btn-group > .btn + .btn {
        margin-left: -1px;
    }
     {
        opacity: 0.4;
    }
    .row-more>td {
        border-top: 1px dashed #ddd !important;
    }
    .row-gray {
        background-color: #fcfcfc;
        border-bottom: 1px solid #ccc;
    }
    .table>tbody+tbody {
        border-top: 1px solid #ddd !important;
    }
    hr {
        margin: 20px 0;
        border: 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #fff;
    }
    .headerTitle {
        font-size: 30px;
    }
</style>
<script>
    $(document).ready(function(){
        $('.setHeaderLabel').prev('.resize').addClass('headerTitle');
    })
    function phoneMask() { 
        var num = $(this).val().replace(/\D/g,''); 
        $(this).val('+'+num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
    }
    $('[type="tel"]').keyup(phoneMask);
</script>