<?php
require_once("./AcpayAPI.class.php");

$api_url = 'https://api.acpay.com/v1/';
$api_public_key = 'api_public_key';
$api_secret_key = 'api_secret_key';

$acpay = new AcpayAPI($api_public_key,$api_secret_key, $api_url);
if ($acpay->get_deposit_address($result,'eth')) {
	// Success
	echo json_encode($result);
}
else {
	// Error
	echo json_encode($result);
}
?>