<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
    var thousands_separator = '<?php echo $this->thousands_separator; ?>';
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables js -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/datatables/dataTables.bootstrap.min.js"></script>
<!-- Bootstrap Toggle Js -->
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-toggle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/js/adminlte.min.js"></script>
<!-- iCheck js -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/icheck/icheck.min.js"></script>
<!-- Pace -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/pace/pace.min.js"></script>
<!-- Ckeditor js -->
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/lang/<?php echo $this->selected_lang->ckeditor_lang; ?>.js"></script>
<!-- Tagsinput js -->
<script src="<?php echo base_url(); ?>assets/admin/vendor/tagsinput/jquery.tagsinput.min.js"></script>
<!-- Plugins JS-->
<script src="<?php echo base_url(); ?>assets/admin/js/plugins.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Custom js -->
<script src="<?php echo base_url(); ?>assets/admin/js/script-1.6.js"></script>
<!-- Ckeditor -->
<script>
    var ckEditor = document.getElementById('ckEditor');
    if (ckEditor != undefined && ckEditor != null) {
        CKEDITOR.replace('ckEditor', {
            language: '<?php echo $this->selected_lang->ckeditor_lang; ?>',
            removeButtons: 'Save',
            allowedContent: true,
            extraPlugins: 'videoembed,oembed'
        });
    }

    function selectFile(fileUrl) {
        window.opener.CKEDITOR.tools.callFunction(1, fileUrl);
    }

    CKEDITOR.on('dialogDefinition', function (ev) {
        var editor = ev.editor;
        var dialogDefinition = ev.data.definition;

        // This function will be called when the user will pick a file in file manager
        var cleanUpFuncRef = CKEDITOR.tools.addFunction(function (a) {
            $('#ckFileManagerModal').modal('hide');
            CKEDITOR.tools.callFunction(1, a, "");
        });
        var tabCount = dialogDefinition.contents.length;
        for (var i = 0; i < tabCount; i++) {
            var browseButton = dialogDefinition.contents[i].get('browse');
            if (browseButton !== null) {
                browseButton.onClick = function (dialog, i) {
                    editor._.filebrowserSe = this;
                    var iframe = $('#ckFileManagerModal').find('iframe').attr({
                        src: editor.config.filebrowserBrowseUrl + '&CKEditor=body&CKEditorFuncNum=' + cleanUpFuncRef + '&langCode=en'
                    });
                    $('#ckFileManagerModal').appendTo('body').modal('show');
                }
            }
        }
    });

    CKEDITOR.on('instanceReady', function (evt) {
        $(document).on('click', '.btn_ck_add_image', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('image');
            }
        });
        $(document).on('click', '.btn_ck_add_video', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('videoembed');
            }
        });
        $(document).on('click', '.btn_ck_add_iframe', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('iframe');
            }
        });
    });
</script>
<script>
    var ckEditor = document.getElementById('ckEditorBankAccounts');
    if (ckEditor != null) {
        CKEDITOR.replace('ckEditorBankAccounts', {
            language: '<?php echo $this->selected_lang->ckeditor_lang; ?>',
            toolbar: [
                ['Copy', 'Paste', 'PasteText'],
                {name: 'basicstyles', items: ['Bold', 'Italic']}, {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
            ]
        });
    }
</script>
<?php if (isset($lang_search_column)): ?>
    <script>
        var table = $('#cs_datatable_lang').DataTable({
            dom: 'l<"#table_dropdown">frtip',
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
        });
        //insert a label
        $('<label class="table-label"><label/>').text('Language').appendTo('#table_dropdown');

        //insert the select and some options
        $select = $('<select class="form-control input-sm"><select/>').appendTo('#table_dropdown');

        $('<option/>').val('').text('<?php echo trans("all"); ?>').appendTo($select);
        <?php foreach ($this->languages as $lang): ?>
        $('<option/>').val('<?php echo $lang->name; ?>').text('<?php echo $lang->name; ?>').appendTo($select);
        <?php endforeach; ?>

        table.column(<?php echo $lang_search_column; ?>).search('').draw();

        $("#table_dropdown select").change(function () {
            table.column(<?php echo $lang_search_column; ?>).search($(this).val()).draw();
        });
    </script>
<?php endif; ?>
<script>
    $('#location_1').on('ifChecked', function () {
        $("#location_countries").hide();
    });
    $('#location_2').on('ifChecked', function () {
        $("#location_countries").show();
    });
    var sweetalert_ok = '<?php echo trans("ok"); ?>';
    var sweetalert_cancel = '<?php echo trans("cancel"); ?>';

     //Order Notification
    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: base_url + "order-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#order_notification_badge').text(response.content);
                    $('#order_notification_badge').show();
                }else{
                    $('#order_notification_badge').html('0');
                }
            }
        });






        /*Refunds*/
        $.ajax({
            type: "GET",
            url: base_url + "refunds-p-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#refunds_pending').text(response.content);
                    $('#refunds_pending').show();
                }else{
                    $('#refunds_pending').html('0');
                }
            }
        });

        /*Refunds*/
        $.ajax({
            type: "GET",
            url: base_url + "refunds-c-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#refunds_completed').text(response.content);
                    $('#refunds_completed').show();
                }else{
                    $('#refunds_completed').html('0');
                }
            }
        });


        /*Refunds*/
        $.ajax({
            type: "GET",
            url: base_url + "refunds-can-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#refunds_cancelled').text(response.content);
                    $('#refunds_cancelled').show();
                }else{
                    $('#refunds_cancelled').html('0');
                }
            }
        });

        /*Bank Transfer*/
        $.ajax({
            type: "GET",
            url: base_url + "bank-transfer-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#bank_transfer_notification_badge').text(response.content);
                    $('#bank_transfer_notification_badge').show();
                }else{
                    $('#bank_transfer_notification_badge').html('0');
                }
            }
        });

        /*Order Complete With Bank Notification*/
        $.ajax({
            type: "GET",
            url: base_url + "order-complete-bank-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#order_complete_bank_notification_badge').text(response.content);
                    $('#order_complete_bank_notification_badge').show();
                }else{
                    $('#order_complete_bank_notification_badge').html('0');
                }
            }
        });

         /*Payout Request Notification*/
        $.ajax({
            type: "GET",
            url: base_url + "payout-request-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#payout_request_notification_badge').text(response.content);
                    $('#payout_request_notification_badge').show();
                }else{
                    $('#payout_request_notification_badge').html('0');
                }
            }
        });

        /*Payout Request Notification*/
        $.ajax({
            type: "GET",
            url: base_url + "incoming-contact-message-notification",
            data: "data",
            dataType: "json",
            success: function (response) {
               // console.log(response.content+'test11');
                if(response.content > 0){
                    $('#incoming_contact_message_notification_badge').text(response.content);
                    $('#incoming_contact_message_notification_badge').show();
                }else{
                    $('#incoming_contact_message_notification_badge').html('0');
                }
            }
        });

    });

    $(document).on('click','.delete_payout',function(){
        var id = $(this).data('id');
        if(confirm("<?php echo trans('delete_comfirm_msg')?>")){
            $.ajax({
                url: "<?php echo base_url('delete-payout-settings'); ?>",
                type: 'GET',
                dataType: 'json',
                data: {id : id},
                success:function(resp){
                    if(resp.status == true){
                        location.reload();
                    }else{
                        alert("<?php echo trans('msg_error') ?>");
                    }
                }
            });
        }
    });

    

</script>
<script type="text/javascript">
<?php if(isset($email_templates_message)): ?>
    <?php foreach($email_templates_message as $language): ?>
        var myeditor = "ckEditor_<?php echo $language->id; ?>";
        var ckEditor = document.getElementById(myeditor);
        console.log('ckEditor',myeditor,ckEditor);
        if (ckEditor != undefined && ckEditor != null) {
            CKEDITOR.replace(myeditor, {
                language: '<?php echo $this->selected_lang->ckeditor_lang; ?>',
                removeButtons: 'Save',
                allowedContent: true,
                extraPlugins: 'videoembed,oembed'
            });
        }
    <?php endforeach; ?>
<?php endif; ?>
    
$(document).on('click','#save_changes',function(){
    $('#save_templates').submit();
});

</script>
</body>
</html>
