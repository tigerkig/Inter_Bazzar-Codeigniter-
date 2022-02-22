<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => 'Email']); ?>
<table role="presentation" class="main">
    <!-- START MAIN CONTENT AREA -->
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                    	<?php echo $content; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php $this->load->view('email/_footer'); ?>