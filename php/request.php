<?php
include_once("./AcpayAPI.php");

$api_public_key = 'api_public_key';
$api_secret_key = 'api_secret_key';

$acpay = new AcpayAPI($api_public_key, $api_secret_key);

/******

call: create_withdrawal

******/

$currency = 'ttc';

if ($acpay->get_deposit_address($result, $currency, [
    'callback'=>true,
    'callback_url'=>'https://mydomain.com/payment/callback.php',
    'custom_field'=>'U201928'
])) {
    if ($data->valid==true) {
        die($data->result->address);
    }
}

/******

call: create_withdrawal

******/

$currency = 'ttc';
$amount = 100;
$to_address = '0xe43041621fd27109d965c58993339f09ca4d69d7';

if ($acpay->create_withdrawal($data, $currency, $amount, $to_address,[
    'callback'=>true,
    'callback_url'=>'https://mydomain.com/payment/callback.php',
    'custom_field'=>'U201928'
])) {
    if ($data->valid==true) {
        die($data->result->ref_id);
    }
}
?>