<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box" style="position:absolute;">
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
				<div class="table-responsive">
					<table class="table table-bordered table-striped" role="grid">
						<?php $this->load->view('admin/order/_filter_orders'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('order'); ?></th>
							<th><?php echo trans('buyer'); ?></th>
							<th><?php echo trans('total'); ?></th>
							<th><?php echo trans('currency'); ?></th>
							<th><?php echo trans('status'); ?></th>
							<th><?php echo trans('payment_status'); ?></th>
							<th><?php echo trans('updated'); ?></th>
							<th><?php echo trans('date'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($orders as $item): ?>
							<tr>
								<td class="order-number-table">
									<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="table-link">
										#<?php echo html_escape($item->order_number); ?>
									</a>
								</td>
								<td>
									<?php if ($item->buyer_id == 0): ?>
										<div class="table-orders-user">
											<img src="<?php echo get_user_avatar(null); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
											<?php $shipping = get_order_shipping($item->id);
											if (!empty($shipping)): ?>
												<span><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?></span>
											<?php endif; ?>
											<label class="label bg-olive" style="position: absolute;top: 0; left: 0;"><?php echo trans("guest"); ?></label>
										</div>
									<?php else:
										$buyer = get_user($item->buyer_id);
										if (!empty($buyer)):?>
											<div class="table-orders-user">
												<a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
													<img src="<?php echo get_user_avatar($buyer); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
													<?php echo html_escape($buyer->username); ?>
												</a>
											</div>
										<?php endif;
									endif;
									?>
								</td>
								<td><strong><?php echo price_formatted($item->price_total, $item->price_currency); ?></strong></td>
								<td><?php echo $item->price_currency; ?></td>
								<td>
									<?php if ($item->status == 1): ?>
										<label class="label label-success"><?php echo trans("completed"); ?></label>
									<?php else: ?>
										<label class="label label-default"><?php echo trans("order_processing"); ?></label>
									<?php endif; ?>
								</td>
								<td>
									<?php echo trans($item->payment_status); ?>
								</td>
								<td><?php echo time_ago($item->updated_at); ?></td>
								<td> <?php echo formatted_date($item->created_at); ?></td>
								
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($orders)): ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-12 table-ft">
						<div class="row">
							<div class="pull-right">
								<?php echo $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
</div>
