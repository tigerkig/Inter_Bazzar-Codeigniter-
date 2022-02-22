<?php

$payment_url = "";

$serverip = $_SERVER['SERVER_ADDR'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://pos.payby.me/webpayment/request.aspx",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "secretKey=996DFFEA582DC028CA49DDF697453C89&username=B742D6AB84B327290523&token=996DFFEA582DC028CA49DDF697453C89&keywordId=342&ClientIp=".$serverip."&syncId=".time()."&countryCode=TR&currencyCode=EUR&languageCode=tr&notifyPage=http%3A//interbazaar.net/notify.php&redirectPage=http%3A//interbazaar.net/notify.php&errorPage=http%3A//interbazaar.net/notify.php&AssetName=interbazaar&AssetPrice=1&whiteLabel=1&paymentType=vpos",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
// echo get_hash($response);
echo "OK";


function get_hash($result)
{
 	$params = parse_str($result);

 	if(!is_null($params) && !is_null($params['ErrorCode'] && $params['ErrorCode'] == '1000')) {
    	$hash = $params['ErrorDesc'];
 	} else {
    	(!is_null($params) && !is_null($params['ErrorCode']) ? die($params['ErrorCode']) : die('An Error Occoured!'));
 	}
 	return $hash;
}

function user_redirect($hash)
{
     header("Location: https://pos.payby.me/webpayment/Pay.aspx");
}


?>