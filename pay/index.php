<?php 
/* index.php */
/* Form to fill card Information */
?>
<!DOCTYPE html>
<html>
<head>
	<title>Payby.me : Payment Gateway</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="content">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6" id="replaceall">
				<form action="pay.php" method="post" id="paybyme">
					<div class="form-group text-center">
						<strong>Payby.Me</strong>
					</div>
					<div class="form-group">
						<label>Amount</label>
						<input type="text" name="amount" class="form-control" placeholder="amount">
					</div>
					<div class="form-group">
						<label>Card. No.</label>
						<input type="text" name="card_number" class="form-control" placeholder="Card No." maxlength="16">
					</div>
					<div class="form-group">
						<label>Expiry Date</label>
						<input type="number" name="month" class="form-control" placeholder="month (Ex. 01)" maxlength="2">
						<input type="number" name="year" class="form-control" placeholder="year (Ex. 2020)">
					</div>
					<div class="form-group">
						<label>CVV</label>
						<input type="password" name="cvv" class="form-control" placeholder="cvv">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Pay</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	
	<!-- <script src="//code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<script type="text/javascript">
		 // $(document).on('submit','#paybyme',function(e){
		 // 	e.preventDefault(); // avoid to execute the actual submit of the form.
		 // 	var form = $(this);
   //   		var url = form.attr('action');
   //   		$.ajax({
	  //           type: "POST",
	  //           url: url,
	  //           data: form.serialize(), // serializes the form's elements.
	  //           dataType:'json',
	  //           success: function(data){
	  //           	var url = data.url;
	  //           	$('#replaceall').html('<iframe src="'+url+'" id="iframe" width="500px" height="300px"></iframe>');
	  //           	// $.get(url, function(resp) {
	  //           	// 	/*optional stuff to do after success */
	  //           	// 	console.log(resp);
	  //           	// 	$('#frame').html(resp);
	  //           	// });

	  //               // console.log(data); //  show response from the php script.
	  //           }
	  //        });
		 // });
	</script>

</body>
</html>