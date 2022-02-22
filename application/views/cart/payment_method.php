<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $check_option = true; ?>
<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="shopping-cart shopping-cart-shipping">
					<div class="row">
						<div class="col-sm-12 col-lg-7">
							<div class="left">
								<h1 class="cart-section-title"><?php echo trans("checkout"); ?></h1>
								<?php if (!$this->auth_check): ?>
									<div class="row m-b-15">
										<div class="col-12 col-md-6">
											<p><?php echo trans("checking_out_as_guest"); ?></p>
										</div>
										<div class="col-12 col-md-6">
											<p class="text-right"><?php echo trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link-underlined" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>
										</div>
									</div>
								<?php endif; ?>

								<?php if (!empty($cart_has_physical_product) && $this->form_settings->shipping == 1 && $mds_payment_type != 'promote'): ?>
									<div class="tab-checkout tab-checkout-closed">
										<a href="<?php echo generate_url("cart","shipping"); ?>"><h2 class="title">1.&nbsp;&nbsp;<?php echo trans("shipping_information"); ?></h2></a>
										<a href="<?php echo generate_url("cart","shipping"); ?>" class="link-underlined edit-link"><?php echo trans("edit"); ?></a>
									</div>
								<?php endif; ?>

								<div class="tab-checkout tab-checkout-open">
									<h2 class="title">
										<?php if (!empty($cart_has_physical_product) && $this->form_settings->shipping == 1 && $mds_payment_type != 'promote') {
											echo '2.';
										} else {
											echo '1.';
										} ?>
										&nbsp;<?php echo trans("payment_method"); ?></h2>
									<?php echo form_open('payment-method-post', ['id' => 'form_validate', 'class' => 'validate_terms']); ?>
									<input type="hidden" name="mds_payment_type" value="<?php echo $mds_payment_type ?>">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
											<?php $country = get_country($this->session->userdata('m_payment_country')); ?>
												<ul class="payment-options-list">
												<?php
													$__countries = json_decode($this->payment_settings->paypal_countries, true);
												?>
													<?php if ($this->payment_settings->paypal_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_paypal" name="payment_option" value="paypal" checked required>
																		<label class="custom-control-label label-payment-option" for="option_paypal"><?php echo trans("paypal"); ?></label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_paypal">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
																		<img src="<?php echo base_url(); ?>assets/img/payment/discover.svg" alt="discover">
																		<img src="<?php echo base_url(); ?>assets/img/payment/paypal.svg" alt="paypal">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													
													<?php
													$__countries = json_decode($this->payment_settings->stripe_countries, true);
												?>
													<?php if ($this->payment_settings->stripe_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_stripe" name="payment_option" value="stripe" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																		<label class="custom-control-label label-payment-option" for="option_stripe"><?php echo trans("stripe"); ?></label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_stripe">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
																		<img src="<?php echo base_url(); ?>assets/img/payment/stripe.svg" alt="stripe">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->paystack_countries, true);
												?>
													<?php if ($this->payment_settings->paystack_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_paystack" name="payment_option" value="paystack" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																		<label class="custom-control-label label-payment-option" for="option_paystack"><?php echo trans("paystack"); ?></label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_paystack">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/verve.svg" alt="verve">
																		<img src="<?php echo base_url(); ?>assets/img/payment/paystack.png" alt="paystack">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->razorpay_countries, true);
												?>
													<?php if ($this->payment_settings->razorpay_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_razorpay" name="payment_option" value="razorpay" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																		<label class="custom-control-label label-payment-option" for="option_razorpay">Razorpay</label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_razorpay">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
																		<img src="<?php echo base_url(); ?>assets/img/payment/maestro.svg" alt="maestro">
																		<img src="<?php echo base_url(); ?>assets/img/payment/diners.svg" alt="diners">
																		<img src="<?php echo base_url(); ?>assets/img/payment/rupay.svg" alt="rupay" style="padding: 1px 0;">
																		<img src="<?php echo base_url(); ?>assets/img/payment/razorpay.svg" alt="razorpay">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->iyzico_countries, true); 
												?>
													<?php if ($this->payment_settings->iyzico_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_iyzico" name="payment_option" value="iyzico" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																		<label class="custom-control-label label-payment-option" for="option_iyzico"><?php echo trans("iyzico"); ?></label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_iyzico">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
																		<img src="<?php echo base_url(); ?>assets/img/payment/troy.png" alt="troy">
																		<img src="<?php echo base_url(); ?>assets/img/payment/iyzico.svg" alt="iyzico">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->moka_countries, true); 
												?>
													<?php if ($this->payment_settings->moka_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_moka" name="payment_option" value="moka" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																		<label class="custom-control-label label-payment-option" for="option_moka"><?php echo trans("moka"); ?></label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_pagseguro">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
																		<img src="<?php echo base_url(); ?>assets/img/payment/elo.svg" alt="elo">
																		<img src="<?php echo base_url(); ?>assets/img/payment/diners.svg" alt="diners">
																		<img src="<?php echo base_url(); ?>assets/img/payment/hipercard.svg" alt="hipercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/moka.png" alt="moka">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->pagseguro_countries, true);
												?>
													<?php if ($this->payment_settings->pagseguro_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="list-left">
																	<div class="custom-control custom-radio">
																		<input type="radio" class="custom-control-input" id="option_pagseguro" name="payment_option" value="pagseguro" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																		<label class="custom-control-label label-payment-option" for="option_pagseguro"><?php echo trans("pagseguro"); ?></label>
																	</div>
																</div>
																<div class="list-right">
																	<label for="option_pagseguro">
																		<img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
																		<img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
																		<img src="<?php echo base_url(); ?>assets/img/payment/elo.svg" alt="elo">
																		<img src="<?php echo base_url(); ?>assets/img/payment/diners.svg" alt="diners">
																		<img src="<?php echo base_url(); ?>assets/img/payment/hipercard.svg" alt="hipercard">
																		<img src="<?php echo base_url(); ?>assets/img/payment/pagseguro.png" alt="pagseguro">
																	</label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->bank_transfer_countries, true);
												?>
													<?php if ($this->payment_settings->bank_transfer_enabled ): ?>
														<li>
															<div class="option-payment">
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" id="option_bank" name="payment_option" value="bank_transfer" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																	<label class="custom-control-label label-payment-option" for="option_bank"><?php echo trans("bank_transfer"); ?><br><small><?php echo trans("bank_transfer_exp"); ?></small></label>
																</div>
															</div>
														</li>
														<?php $check_option = false;
													endif; ?>
													<?php
													$__countries = json_decode($this->payment_settings->cash_on_delivery_countries, true);
												?>
													<?php if ($this->auth_check == 1 && $this->payment_settings->cash_on_delivery_enabled && empty($cart_has_digital_product) && $mds_payment_type != 'promote' ): ?>
														<li>
															<div class="option-payment">
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" id="option_cash_on_delivery" name="payment_option" value="cash_on_delivery" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																	<label class="custom-control-label label-payment-option" for="option_cash_on_delivery"><?php echo trans("cash_on_delivery"); ?><br><small><?php echo trans("cash_on_delivery_exp"); ?></small></label>
																</div>
															</div>
														</li>
													<?php endif; ?>

													<?php
														$__countries = json_decode($this->payment_settings->paybyme_countries, true);
													?>
													<?php if ($this->payment_settings->paybyme_status ): ?>
													<li>
														<div class="option-payment">
															<div class="custom-control custom-radio">
																<input type="radio" class="custom-control-input" id="option_paybyme" name="payment_option" value="paybyme" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
																<label class="custom-control-label label-payment-option" for="option_paybyme">PaybyMe<?php echo trans("paybyme"); ?><br>
																	<small>PaybyMe<?php echo trans("paybyme"); ?></small></label>
															</div>
														</div>
													</li>
													<?php $check_option = false;
													endif; ?>

												</ul>
											</div>
											<div class="form-group">
												<div class="custom-control custom-checkbox custom-control-validate-input">
													<input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
													<?php $page_terms_condition = get_page_by_default_name("terms_conditions", $this->selected_lang->id); ?>
													<label for="checkbox_terms" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;<a href="<?php echo lang_base_url() . $page_terms_condition->slug; ?>" class="link-terms" target="_blank"><strong><?php echo html_escape($page_terms_condition->title); ?></strong></a></label>
												</div>
											</div>
											
											<?php if ($is_norefund): ?>
												<div class="form-group">
													<div class="custom-control custom-checkbox custom-control-validate-input">
														<input type="checkbox" class="custom-control-input" name="terms_refund" id="checkbox_terms_refund" required>

														<label for="checkbox_terms_refund" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;<?php echo trans('refund_agree_checkbox'); ?></label>
													</div>
												</div>
											<?php endif; ?>

											<div class="form-group m-t-15">
												<?php if ($mds_payment_type != 'promote'): ?>
													<a href="<?php echo generate_url("cart"); ?>" class="link-underlined link-return-cart"><&nbsp;<?php echo trans("return_to_cart"); ?></a>
												<?php endif; ?>
												<button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-continue-payment float-right"><?php echo trans("continue_to_payment") ?></button>
											</div>
										</div>
									</div>
									<?php echo form_close(); ?>
								</div>

								<div class="tab-checkout tab-checkout-closed-bordered">
									<h2 class="title">
										<?php if (!empty($cart_has_physical_product) && $this->form_settings->shipping == 1 && $mds_payment_type != 'promote') {
											echo '3.';
										} else {
											echo '2.';
										} ?>
										&nbsp;<?php echo trans("payment"); ?>
									</h2>
								</div>
							</div>
						</div>

						<?php if ($mds_payment_type == 'promote') {
							$this->load->view("cart/_order_summary_promote");
						} else {
							$this->load->view("cart/_order_summary");
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="agreementModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php  echo trans('order_agreement') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <textarea class="form-control" readonly style="overflow-y: scroll; height: 400px; resize: none; background-color: white;"><?php echo trans('sales_terms'); ?></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-custom btn-continue-payment float-right"  id="dismissBt" data-dismiss="modal"><?php echo trans('disagree') ?></button>
		<button type="button" class="btn-md btn-primary btn-continue-payment float-right"  id="acceptBt"><?php echo trans('agree'); ?></button>
      </div>
    </div>
  </div>
</div>

	<?php if ($is_norefund): ?>
	<div class="modal" tabindex="-1" role="dialog" id="agreementModalRefund">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php  echo trans('refund_agreement') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <textarea class="form-control" readonly style="overflow-y: scroll; height: 400px; resize: none; background-color: white;"><?php echo trans('sales_terms_refund'); ?></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-custom btn-continue-payment float-right"   id="dismissBt-r" data-dismiss="modal"><?php echo trans('disagree') ?></button>
		<button type="button" class="btn btn-lg btm-primary btn-continue-payment float-right"   id="acceptBt-r"><?php echo trans('agree'); ?></button>
      </div>
    </div>
  </div>
</div>
	<?php endif; ?>

<script>
	$(function() {
		$('#checkbox_terms').click(function() {
			$('#agreementModal').modal();
			event.preventDefault();
			return false;
		});
		$('#dismissBt').click(function(){
			$.get('<?php echo site_url("clear-cart"); ?>',function(data) {
				location.href = "<?php echo site_url(); ?>";
			});
		});
		$('#acceptBt').click(function(){
			$('#agreementModal').modal('hide');
			$('#checkbox_terms').prop('checked', true);
		});
		
		<?php if($is_norefund): ?>
		$('#checkbox_terms_refund').click(function() {
			$('#agreementModalRefund').modal();
			event.preventDefault();
			return false;
		});
		$('#dismissBt-r').click(function(){
			$.get('<?php echo site_url("clear-cart"); ?>',function(data) {
				location.href = "<?php echo site_url(); ?>";
			});
		});
		$('#acceptBt-r').click(function(){
			$('#agreementModalRefund').modal('hide');
			$('#checkbox_terms_refund').prop('checked', true);
		});
		<?php endif; ?>
		
		
	});
</script>
<!-- Wrapper End-->
