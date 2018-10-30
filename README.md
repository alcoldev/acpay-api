# ACPAY API
The ACPAY API will provide access to our payment services and information to our sellers.<br>
API calls are implemented as HTTP POST calls to https://api.acpay.com/v1/<br>

__API Version: v1.0__

## API Setup
The only setup needed is to go to the API Keys page and generate an API key. You will be given a secret and public key used to authenticate your API calls. Make sure you don't share your secret key with any 3rd parties!

## API Request
API calls are made as basic HTTP POST requests using the following variables: (note: The POST data is regular application/x-www-form-urlencoded style data, not JSON or XML)

__Authentication:__

Every API call has a SHA-512 HMAC signature generated with your secret key. Our server generates it's own HMAC signature and compares it with the API caller's. If they don't match the API call is discarded. The HMAC signature is sent as a HTTP header called 'HMAC'.

The HMAC signature is created from the full raw POST data of your request. For example if your API secret key was "api_secret_key" and public key was "api_public_key" and you were using the get_payment_address function the raw request might look like:

`currency=btc&key=api_public_key&request=get_deposit_address`

and the HMAC would be:

`8bee1a1a2bd1d24d70ddbcc5ce30e9fb3220e051f72aed285f77ff60bdb12aa8268fb9739944207f1d1219149f3210f6cdac7d463fb34e8f7a4d4619b5ea099a`

## API Response
The API will return an array with 1 or 2 elements: 'valid' and 'result'. The result will always have an 'valid' field. If its value is 'true' (boolean) the API call was a success, otherwise it will contain an error message. If there is data to return to you, it will be stored as an array in the 'result' element.

__Success example:__

```json
{
    "valid":true,
    "result": {
        "address": "0x..."
    }
}
```

__Failed example:__

```json
{
    "valid":false,
    "errors": [{
        "message": "Missing required param",
        "fields":["currency"]
    }]
}
```

## Multiple Currencies
Once registered, you can manage the currencies you want to integrate in the Membership area / Currencies. Please enable the currencies there before using this API.

__Support crypto currencies:__

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Symbol</th>
			<th>Name</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>eth</td>
			<td>ETH</td>
			<td>Ethereum</td>
			<td><strong>Available</strong></td>
		</tr>
		<tr>
			<td>bdc</td>
			<td>BDC</td>
			<td>Bdcoin</td>
			<td><strong>Available</strong></td>
		</tr>
		<tr>
			<td>ttc</td>
			<td>TTC</td>
			<td>Test Token</td>
			<td><strong>Available</strong></td>
		</tr>
		<tr>
			<td>btc</td>
			<td>BTC</td>
			<td>Bitcoin</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>ltc</td>
			<td>LTC</td>
			<td>Litecoin</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>bch</td>
			<td>BCH</td>
			<td>Bitcoin Cash</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>usdt</td>
			<td>USDT</td>
			<td>Tether</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>dash</td>
			<td>DASH</td>
			<td>Dash</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>zec</td>
			<td>ZEC</td>
			<td>Zcash</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>qtum</td>
			<td>QTUM</td>
			<td>Qtum</td>
			<td>Maintenance</td>
		</tr>
		<tr>
			<td>alc</td>
			<td>ALC</td>
			<td>Alcash</td>
			<td>Maintenance</td>
		</tr>
	</tbody>
</table>

__Support fiat currencies:__

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Symbol</th>
			<th>Name</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>usd</td>
			<td>USD</td>
			<td>US Dollar</td>
			<td><strong>Available</strong></td>
		</tr>
	</tbody>
</table>

## API Call
All POST requests must be send to the url below, including the HMAC authentication code. https://api.acpay.com/v1/<br>

__PHP Example:__

https://github.com/alcoldev/acpay-api/blob/master/php/AcpayAPI.class.php

## Get Currencies

__Parameters:__

API POST Fields (in addition to the Main Fields described in the <a href="#api-request">API Request</a>)
<table>
	<thead>
		<tr>
			<th>Field</th>
			<th>Description</th>
			<th>Required</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>request</td>
			<td>currencies</td>
			<td><strong>Yes</strong></td>
		</tr>
	</tbody>
</table>
	
__Example request:__

`POST: key=api_public_key&request=currencies`

__Response:__

The API always responds with a JSON string. [data] collection contains the important values:

__Response example:__

```json
{
    "valid": true,
    "result": {
        "btc": {
            "name": "Bitcoin",
            "symbol": "BTC",
            "enable": true
        }
    }
}
```

## Get Rates

__Parameters:__

API POST Fields (in addition to the Main Fields described in the <a href="#api-request">API Request</a>)
<table>
	<thead>
		<tr>
			<th>Field</th>
			<th>Description</th>
			<th>Required</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>request</td>
			<td>rates</td>
			<td><strong>Yes</strong></td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Fiat currency to accept (usd)</td>
			<td>No</td>
		</tr>
	</tbody>
</table>

__Example request:__

`POST: key=api_public_key&request=rates&currency=usd`

__Response:__

The API always responds with a JSON string. [data] collection contains the important values:

__Response example:__

```json
{
    "valid": true,
    "result": {
        "usd": {
            "btc": {
                "rate": 6702.33928172,
                "last_update": 1539288831
            },
            "eth": {
                "rate": 305.22915962,
                "last_update": 1539288831
            }
        }
    }
}
```

## Get Deposit Address

__Parameters:__

API POST Fields (in addition to the Main Fields described in the <a href="#api-request">API Request</a>)
<table>
	<thead>
		<tr>
			<th>Field</th>
			<th>Description</th>
			<th>Required</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>request</td>
			<td>get_payment_address</td>
			<td><strong>Yes</strong></td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency id</td>
			<td><strong>Yes</strong></td>
		</tr>
        <tr>
			<td>callback</td>
			<td>Callback true or false (Default: false)</td>
			<td>No</td>
		</tr>
		<tr>
			<td>callback_url</td>
			<td>URL for your callbacks. If not set it will use the callback url in your Edit Settings page if you have one set.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field</td>
			<td>Custom Field (Maximum length: 50).</td>
			<td>No</td>
		</tr>
	</tbody>
</table>

__Example request:__

`POST: key=api_public_key&request=get_deposit_address&currency=btc&callback=true`

__Response:__

The API always responds with a JSON string. [data] collection contains the important values:
* __[address]__ is the deposit address to show to the customer.

__Response example:__

```json
{
    "valid": true,
    "result": {
        "address": "0x2073eb3be1a41908e0353427da7f16412a01ae71"
    }
}
```

__Get Deposit UI:__

* Use: https://pay.acpay.com/{deposit_address}
* Example: https://pay.acpay.com/0x2073eb3be1a41908e0353427da7f16412a01ae71

## Create Withdrawal

__Parameters:__

API POST Fields (in addition to the Main Fields described in the <a href="#api-request">API Request</a>)
<table>
	<thead>
		<tr>
			<th>Field</th>
			<th>Description</th>
			<th>Required</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>request</td>
			<td>create_withdrawal</td>
			<td><strong>Yes</strong></td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency id</td>
			<td><strong>Yes</strong></td>
		</tr>
        <tr>
			<td>amount</td>
			<td>The amount of the withdrawal in the currency below.</td>
			<td><strong>Yes</strong></td>
		</tr>
        <tr>
			<td>address</td>
			<td>Receiving crypto-currency address</td>
			<td><strong>Yes</strong></td>
		</tr>
        <tr>
			<td>callback</td>
			<td>Callback true or false (Default: false)</td>
			<td>No</td>
		</tr>
		<tr>
			<td>callback_url</td>
			<td>URL for your callbacks. If not set it will use the callback url in your Edit Settings page if you have one set.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field</td>
			<td>Custom Field (Maximum length: 50).</td>
			<td>No</td>
		</tr>
	</tbody>
</table>

__Example request:__

`POST: key=api_public_key&request=create_withdrawal&currency=btc&amount=1.2&address=0x...&callback=true&callback_url=https://www.test.com/payment/callback.php&custom_field=U929281`

__Response:__

The API always responds with a JSON string. [data] collection contains the important values:
* __[ref_id]__ is the Withdrawal Unique Reference Number of acpay backoffice.

__Response example:__

```json
{
    "valid": true,
    "result": {
        "ref_id": "793d6f37dbd811e88ace0af998f8ac2c"
    }
}
```

## Callback

A callback is sent every time a new block is mined. To stop further callbacks, reply with the "[OK]" Text. See code sample below.

<table>
	<thead>
		<tr>
			<th>Field</th>
			<th>Description</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>id</td>
			<td>Callback identifier</td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>version</td>
			<td>API version</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>auth</td>
			<td>Callback authentication</td>
			<td>hmac</td>
		</tr>
		<tr>
			<td>type</td>
			<td>Callback type</td>
			<td>deposit, withdrawal</td>
		</tr>
		<tr>
			<td>status</td>
            <td>Callback / Transaction Status</td>
			<td><a href="#callback-status-code">(see table below for details)</a></td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency id</td>
			<td>btc, eth, ltc, usdt, bch, bdc, alc, ttc ...</td>
		</tr>
        <tr>
			<td>ref_id</td>
			<td>Identifier of acpay console transaction</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>transaction_hash</td>
			<td>Blockchain Transaction hash</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>transaction_amount</td>
			<td>Blockchain Transaction amount</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>transaction_to</td>
			<td>To address</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>confirmations</td>
			<td>Confirmation count of transaction</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>custom_field</td>
			<td>Custom Field</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>

__Callback example:__

```json
{
    "id": "a514e32fcae48631f66c472d999aa0dd",
    "version": "1",
    "auth": "hmac",
    "type": "deposit",
    "status": "200",
    "currency": "btc",
    "ref_id": "9f1a7ec862ba0d44413e71fc5aa936c3",
    "transaction_hash": "a321022f8ba56e6fbb3195123d266905757219ae0f625eb29fec48dc018269df",
    "transaction_amount": "1.2",
    "transaction_to": "3A364JM2HEjuWrhBKC6phyDMFSFcWzHzKQ",
    "confirmations": "3",
    "custom_field": ""
}
```

__PHP Example:__

https://github.com/alcoldev/acpay-api/blob/master/php/callback.php

## Callback Status Code

<table>
	<thead>
		<tr>
			<th>Code</th>
			<th>Text</th>
            <th>Description</th>
		</tr>
	</thead>
	<tbody>
        <tr>
            <td>100</td>
            <td>Pending</td>
            <td>Transaction not included in the blockchain</td>
        </tr>
        <tr>
            <td>101</td>
            <td>Waiting</td>
            <td>Wait for user or merchant confirmation</td>
        </tr>
        <tr>
            <td>102</td>
            <td>In progress</td>
            <td>Transaction included in block</td>
        </tr>
        <tr>
            <td>103</td>
            <td>Cancel</td>
            <td>Transaction Canceled</td>
        </tr>
        <tr>
            <td>200</td>
            <td>Completed</td>
            <td>Secure confirmation / Transaction complete</td>
        </tr>
        <tr>
            <td>201</td>
            <td>Confirmed</td>
            <td>Minimal secure confirmation</td>
        </tr>
    </tbody>
</table>

## Rules / Fees

<table>
	<thead>
		<tr>
			<th>Currency</th>
			<th>Minimum Deposit</th>
			<th>Minimum Withdrawal</th>
			<th>Deposit Fee</th>
			<th>Withdrawal Fee</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>eth</td>
			<td>0.01 ETH</td>
			<td>0.05 ETH</td>
			<td>No deposit fee</td>
			<td>0.005 ETH</td>
		</tr>
		<tr>
			<td>bdc</td>
			<td>20 BDC</td>
			<td>100 BDC</td>
			<td>No deposit fee</td>
			<td>10 BDC</td>
		</tr>
        <tr>
			<td>ttc</td>
			<td>2 TTC</td>
			<td>10 TTC</td>
			<td>No deposit fee</td>
			<td>1 TTC</td>
		</tr>
	</tbody>
</table>

## Request Limit

The system is designed to process thousands of transactions per second, so we do not limit the number of payments you can process. However, for DDoS protection reasons, the API calls are limited to 1000 per minute from one IP.

## What to use as a payout address?

You will need payout addresses for all crypto currencies you want to accept. Only you will have access to your payout wallets. You can use any online wallet, service or exchange of your choice. If you don't have one, consider reading our Wallet Guide