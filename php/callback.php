<?php
$api_secret_key = 'api_secret_key';

function error($msg) {
    die('Error: '.$msg);
}
function done() {
    die('[OK]');
}
function required_params_check(&$param) {
    if (empty($param['id'])) return FALSE;
    if (empty($param['version'])) return FALSE;
    if (empty($param['auth'])) return FALSE;
    if (empty($param['type'])) return FALSE;
    if (empty($param['status'])) return FALSE;
    if (empty($param['currency'])) return FALSE;
    return TRUE;
}

if (empty($api_secret_key)) {
    error('No API Secret Key');
}

$raw_input = file_get_contents('php://input');
if (empty($raw_input)) {
    error('No POST Data');
}

if (required_params_check($_POST)===FALSE) {
    error('Required Params Error');
}

if ($_POST['auth'] !== 'hmac') {
    error('No API HMAC');
}

if (empty($_SERVER['HTTP_HMAC'])) {
    error('No HMAC Signature');
}

$hmac_string = hash_hmac("sha512", trim($raw_input), trim($api_secret_key));
if (function_exists('hash_equals')) {
    if (!hash_equals($hmac_string, $_SERVER['HTTP_HMAC'])) {
        error('HMAC Signature Error');
    }
}
else {
    if ($hmac_string!=$_SERVER['HTTP_HMAC']) {
        error('HMAC Signature Error');
    }
}

$type = $_POST['type'];
$status = intval($_POST['status']);

if ($type=='deposit') {
    $ref_id = !empty($_POST['ref_id'])?$_POST['ref_id']:'';
    $transaction_hash = !empty($_POST['transaction_hash'])?$_POST['transaction_hash']:'';
    $transaction_amount = !empty($_POST['transaction_amount'])?floatval($_POST['transaction_amount']):0;
    $transaction_to = !empty($_POST['transaction_to'])?$_POST['transaction_to']:'';
    $confirmations = !empty($_POST['confirmations'])?intval($_POST['confirmations']):0;
    $custom_field = !empty($_POST['custom_field'])?$_POST['custom_field']:'';
    if ($status == 200 || $status == 201) {
        if ($confirmations>=3) {
            // Deposit example
            $deposit_id = 'N291102';
            $deposit_amount = 2.5;
            if ($custom_field==$deposit_id && $transaction_amount==$deposit_amount && $_POST['currency']=='btc') {
                // done
                done();
            }
        }
    }
}
else if ($type=='withdrawal') {
    $ref_id = !empty($_POST['ref_id'])?$_POST['ref_id']:'';
    $transaction_hash = !empty($_POST['transaction_hash'])?$_POST['transaction_hash']:'';
    $transaction_amount = !empty($_POST['transaction_amount'])?floatval($_POST['transaction_amount']):0;
    $transaction_to = !empty($_POST['transaction_to'])?$_POST['transaction_to']:'';
    $custom_field = !empty($_POST['custom_field'])?$_POST['custom_field']:'';
    if ($status == 200) {
        // Withdrawal example
        $withdraw_id = 'bqw2c5d9e43f355c0a';
        if ($custom_field==$withdraw_id) {
            // done
            done();
        }
    }
}
else {
    done();
}
?>