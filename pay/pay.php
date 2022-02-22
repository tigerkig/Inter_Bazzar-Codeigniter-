<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
/* Pay.php */
/* Here all payment details to submit card details */

$notifypage   = 'https://interbazaar.net/pay/notify.php';

$redirectPage = 'https://interbazaar.net/pay/redirect.php';

$errorPage 	  = 'https://interbazaar.net/pay/errorpage.php';

$request_url  = 'https://pos.payby.me/webpayment/request.aspx';

// $request_url  = 'https://TESTpos.payby.me/webpayment/request.aspx';

$payment_url  = 'https://pos.payby.me/webpayment/PayWhiteLabel.aspx';

// $payment_url  = 'https://TESTpos.payby.me/webpayment/Pay.aspx';

$serverip 	  = $_SERVER['SERVER_ADDR'];

$amount 	    = $_REQUEST['amount'];

$card_number  = $_REQUEST['card_number'];

$month		    = $_REQUEST['month'];

$year 		    = $_REQUEST['year'];

$cvv		      = $_REQUEST['cvv'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $request_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  // CURLOPT_POSTFIELDS => "subCompany=Interbazaar&secretKey=secretkey001&username=username001&token=token001&keywordId=1&clientIp=".$serverip."&syncId=".time()."&countryCode=TR&currencyCode=EUR&languageCode=tr&notifyPage=".$notifypage."&redirectPage=".$redirectPage."&errorPage=".$errorPage."&assetName=interbazaar&assetPrice=".$amount.'&paymentType=vpos',
  CURLOPT_POSTFIELDS => "subCompany=Interbazaar&secretKey=996DFFEA582DC028CA49DDF697453C89&username=B742D6AB84B327290523&token=996DFFEA582DC028CA49DDF697453C89&keywordId=342&clientIp=".$serverip."&syncId=".time()."&countryCode=TR&currencyCode=EUR&languageCode=tr&notifyPage=".$notifypage."&redirectPage=".$redirectPage."&errorPage=".$errorPage."&assetName=interbazaar&assetPrice=".$amount,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded"
  ),
));
$response = curl_exec($curl) or die ('Connection Error');

curl_close($curl);

if(strrpos($response, 'Status')){

  $hash_data    = get_hash($response);

  $encrypted_key  = encrypted_card_detail($card_number,$month,$year,$cvv);

  user_redirect($hash_data,$encrypted_key);

}else{

  echo $response;
  
  exit;

}

function get_hash($result){

  if($result != ''){
    $params = parse_str($result);
    $data = [];
    $data['status'] = $Status;
    $data['error_code'] = $ErrorCode;
    $data['error_desc'] = $ErrorDesc;
    return $data;
  }else{
    exit('An Error Occured In Hash key by Payby.me');
  }
 	return $data;
}
	
function encrypted_card_detail($card_number,$month,$year,$cvv){
	define('AES_256_ECB', 'aes-256-ecb');
	$encryption_key = base64_decode("00MOKIkftkzR5uDY1Mz6XqQtd90ttijoSldSwz3uq1Y=");

	// Create some data to encrypt
	$data = $card_number.'|'.$month.'|'.$year.'|'.$cvv;
	// $data = "4242424242424242|12|2020|123";
	// echo "Data: $data"."<br/>";

	return $encrypted = openssl_encrypt($data, AES_256_ECB, $encryption_key);
	// echo "Encrypted: $encrypted"."<br/>";

	// $decrypted = openssl_decrypt($encrypted, AES_256_ECB, $encryption_key);
	// echo "Decrypted: $decrypted"."<br/>";
}

function user_redirect($hash_data,$card_encrypted){
	global $payment_url;
	if($hash_data['status'] == 1 && $hash_data['error_code'] == '1000'){
    	$hash = $hash_data['error_desc'];
    	$url = $payment_url."?hash=".$hash."&encrypted=".$card_encrypted;
    	// header("location:$url");
    	echo json_encode(['url' => $url]);
    	exit;
	}else{
		echo $hash_data['error_desc'];
		exit;
	}
}

?>