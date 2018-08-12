<?php
/*
 * Class AcpayAPI
 */
class AcpayAPI {
	private $api_public_key;
	private $api_secret_key;
	private $api_url = 'https://api.acpay.com';
	private $curl = null;
	
	public function __construct($api_public_key, $api_secret_key, $api_url=null) {
		$this->api_public_key = $api_public_key;
		$this->api_secret_key = $api_secret_key;
		if ($api_url!==null) {
			$this->api_url = $api_url;
		}
	}
	
	public function currencies(&$result) {
		$result = null;
		$params = array();
		$call = $this->call('currencies',$params);
		if ($call && is_array($call)) {
			$result = $call;
			if ($call['success']=="true") {
				return true;
			}
		}
		return false;
	}
	
	public function rates(&$result, $currency=null) {
		$result = null;
		$params = array();
		if ($currency!==null) {
			$params['currency'] = $currency;
		}
		$call = $this->call('rates',$params);
		if ($call && is_array($call)) {
			$result = $call;
			if ($call['success']=="true") {
				return true;
			}
		}
		return false;
	}
	
	public function get_deposit_address(&$result, $currency) {
		$result = null;
		$params = array();
		$params['currency'] = $currency;
		$call = $this->call('get_deposit_address',$params);
		if ($call && is_array($call)) {
			$result = $call;
			if ($call['success']=="true") {
				return true;
			}
		}
		return false;
	}
	
	public function get_payment_address(&$result, $currency, $callback_url=null) {
		$result = null;
		$params = array();
		$params['currency'] = $currency;
		if ($currency!==null) {
			$params['callback_url'] = $callback_url;
		}
		$call = $this->call('get_payment_address',$params);
		if ($call && is_array($call)) {
			$result = $call;
			if ($call['success']=="true") {
				return true;
			}
		}
		return false;
	}
	
	public function create_payment(&$result, $mode, $currency, $etc=array()) {
		$result = null;
		$params = array();
		$params['mode'] = $mode;
		$params['currency'] = $currency;
		if (is_array($etc) && count($etc)>0) {
			foreach($etc as $key=>$value) {
				$params[$key] = $value;
			}
		}
		$call = $this->call('create_payment',$params);
		if ($call && is_array($call)) {
			$result = $call;
			if ($call['success']=="true") {
				return true;
			}
		}
		return false;
	}
	
	public function create_withdrawal(&$result, $amount, $currency, $etc=array()) {
		$result = null;
		$params = array();
		$params['amount'] = $amount;
		$params['currency'] = $currency;
		if (is_array($etc) && count($etc)>0) {
			foreach($etc as $key=>$value) {
				$params[$key] = $value;
			}
		}
		$call = $this->call('create_withdrawal',$params);
		if ($call && is_array($call)) {
			$result = $call;
			if ($call['success']=="true") {
				return true;
			}
		}
		return false;
	}
	
	public function call($request, $params = array()) {
		
    $params['version'] = 1;
		$params['key'] = $this->api_public_key;
		$params['request'] = $request;
		
		ksort($params);
		$query_data = http_build_query($params, '', '&');
		$hmac_string = hash_hmac('sha512', trim($query_data), $this->api_secret_key);
		
		if ($this->curl === null) {
			$this->curl = curl_init($this->api_url);
			curl_setopt($this->curl, CURLOPT_HEADER, false);
			curl_setopt($this->curl, CURLOPT_FAILONERROR, true);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		}
		
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac_string));
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $query_data);
		$data = curl_exec($this->curl);
		
		try {
			if ($data) {
				$result = json_decode($data,true);
				return $result;
			}
		}
		catch(Exception $e) {
			return false;
		}
		
		return false;
	}
};
?>