<?php
/*
 * Class AcpayAPI
 */
class AcpayAPI {
    private $api_public_key;
    private $api_secret_key;
    private $api_url = 'https://api.acpay.com/v1/';
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
            if ($call['valid']===true) {
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
            if ($call['valid']===true) {
                return true;
            }
        }
        return false;
    }

    public function get_deposit_address(&$result, $currency, $etc=array()) {
        $result = null;
        $params = array();
        $params['currency'] = $currency;
        if (is_array($etc) && count($etc)>0) {
            foreach($etc as $key=>$value) {
                $params[$key] = $value;
            }
        }
        $call = $this->call('get_deposit_address',$params);
        if ($call && is_array($call)) {
            $result = $call;
            if ($call['valid']===true) {
                return true;
            }
        }
        return false;
    }

    public function create_withdrawal(&$result, $amount, $currency, $address, $etc=array()) {
        $result = null;
        $params = array();
        $params['amount'] = $amount;
        $params['currency'] = $currency;
        $params['address'] = $address;
        if (is_array($etc) && count($etc)>0) {
            foreach($etc as $key=>$value) {
                $params[$key] = $value;
            }
         }
        $call = $this->call('create_withdrawal',$params);
        if ($call && is_array($call)) {
            $result = $call;
            if ($call['valid']===true) {
                return true;
            }
        }
        return false;
    }

    public function call($request, $params = array()) {
        $params['key'] = $this->api_public_key;
        $params['request'] = $request;
        
        $query_data = http_build_query($params, '', '&');
        $hmac_string = hash_hmac('sha512', trim($query_data), trim($this->api_secret_key));
        
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
                return json_decode($data,true);
            }
        }
        catch(Exception $e) {
            return false;
        }

        return false;
    }
}
?>