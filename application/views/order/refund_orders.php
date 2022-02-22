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
					<?php $this->load->view("order/_order_tabs"); ?>
				</div>
			</div>

			<div class="col-sm-12 col-md-9">
				<div class="row-custom">
					<div class="profile-tab-content">
						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th scope="col"><?php echo trans("order"); ?></th>
									<th scope="col"><?php echo trans("price"); ?></th>
									<th scope="col"><?php echo trans("refund_track_cd"); ?></th>
									<th scope="col"><?php echo trans("status"); ?></th>
									<th scope="col"><?php echo trans("date"); ?></th>
									<th scope="col"><?php echo trans("options"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($orders)): ?>
									<?php foreach ($orders as $order): ?>
										<tr>
											<td>#<?php echo $order->refund_id; ?></td>
											<td><?php echo price_formatted($order->product_total_price, $order->price_currency); ?></td>
											
											<td><?php echo $order->refund_track_code; ?></td>
											<td>
												<strong class="font-600">
													<?php echo trans($order->order_status); ?>
												</strong>
											</td>
											<td><?php echo formatted_date($order->created_at); ?></td>
											<td>
												<a href="<?php echo generate_url("order_details") . "/" . $order->order_number; ?>" class="btn btn-sm btn-table-info"><?php echo trans("details"); ?></a>
												<?php if($order->order_status == 'refund_pending') : ?>
													<button type="button" class="btn btn-sm btn-table-info mt-2" onclick="refund_order_product(<?php echo $order->refund_id; ?>, '<?php echo $order->refund_track_code; ?>')"><?php echo trans("edit"); ?></button>

													<script>
	
		function refund_order_product(order_product_id, track_code) {
			$('#refund_id').val(order_product_id);
			$('input[name="refund_track_code"]').val(track_code);
			$('#refundProduct').modal();
		}
	
</script>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>


						<?php if (empty($orders)): ?>
							<p class="text-center">
								<?php echo trans("no_records_found"); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
				<div class="row-custom m-t-15">
					<div class="float-right">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Wrapper End-->

<div class="modal fade" id="refundProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <!-- form start -->
            <?php echo form_open('refund-request-update'); ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo trans("refund_order_request"); ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        
                        <div class="form-group">
							<input class="form-control" name="refund_track_code" placeholder="<?php echo trans('refund_track_code'); ?>"></input>
							<input type="hidden" name="refund_id" id="refund_id" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><?php echo trans("close"); ?></button>
                <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
            </div>
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>

