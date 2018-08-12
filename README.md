# ACPAY API GUIDE <small>(for api v1)</small>
<h2>Introduction</h2> The ACPAY API will provide access to our payment services and information to our sellers. API calls are implemented as HTTP POST calls to https://api.acpay.com
<h3>API Setup</h3>
<p>The only setup needed is to go to the API Keys page and generate an API key. You will be given a secret and public key used to authenticate your API calls. Make sure you don't share your secret key with any 3rd parties!</p>
<h3>Authentication & Security</h3>
<p>Every API call has a SHA-512 HMAC signature generated with your secret key. Our server generates it's own HMAC signature and compares it with the API caller's. If they don't match the API call is discarded. The HMAC signature is sent as a HTTP header called 'HMAC'.</p>

<p>The HMAC signature is created from the full raw POST data of your request. For example if your API secret key was "api_secret_key" and public key was "api_public_key" and you were using the get_payment_address function the raw request might look like:</p>

`currency=btc&key=api_public_key&request=get_payment_address&version=1`

<p>and the HMAC would be:</p>

`b31081d9c758fa9c66325ecf8cfa3580f3553f1a644bf4c96516eab99a62a8654ab7ceeac2870d8eb2c984e473f87274921d2a3daafb2e1a575cafde75dc7d2d`
	
<h3>API Response</h3>
<p>The API will return an array with 1 or 2 elements: 'error' and 'result'. The result will always have an 'error' field. If its value is 'ok' (case-sensitive) the API call was a success, otherwise it will contain an error message. If there is data to return to you, it will be stored as an array in the 'result' element.</p>
<h3>API POST Fields</h3>
<p>API calls are made as basic HTTP POST requests using the following variables: (note: The POST data is regular application/x-www-form-urlencoded style data, not JSON or XML)</p>

<h3>Multiple Currencies</h3> Once registered, you can manage the currencies you want to integrate in the Membership area / Currencies. Please enable the currencies there before using this API.

<h2>API Calls</h2>

<p>All POST requests must be send to the url below, including the HMAC authentication code.</p>

`https://api.acpay.com`

<h3>Get Currencies</h3>
<h4>Parameters:</h4>
<p>API POST Fields (in addition to the Main Fields described in the <a href="#introduction">Introduction</a>)</p>
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
			<td>Yes</td>
		</tr>
	</tbody>
</table>
<h4>Example request:</h4>

`POST: key=api_public_key&version=1&request=currencies`

<h3>Get Rates</h3>
<h4>Parameters:</h4>
<p>API POST Fields (in addition to the Main Fields described in the <a href="#introduction">Introduction</a>)</p>
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
			<td>Yes</td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Fiat currency to accept (usd, eur)</td>
			<td>No</td>
		</tr>
	</tbody>
</table>

<h4>Example request:</h4>

`POST: key=api_public_key&version=1&request=rates&currency=usd`

<h3>Get Deposit Address</h3>
<h4>Parameters:</h4>
<p>API POST Fields (in addition to the Main Fields described in the <a href="#introduction">Introduction</a>)</p>
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
			<td>get_deposit_address</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency to accept (btc, eth, usdt, bdc, alc, etc)</td>
			<td>Yes</td>
		</tr>
	</tbody>
</table>

<h4>Example request:</h4>

`POST: key=api_public_key&version=1&request=get_deposit_address&currency=btc`

<h3>Get Payment Address</h3>
<h4>Parameters:</h4>
<p>API POST Fields (in addition to the Main Fields described in the <a href="#introduction">Introduction</a>)</p>
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
			<td>Yes</td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency to accept (btc, eth, ltc, usdt, bch, bdc, alc, etc)</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>callback_url</td>
			<td>..</td>
			<td>No</td>
		</tr>
	</tbody>
</table>

<h4>Example request:</h4>

`POST: key=api_public_key&version=1&request=get_payment_address&currency=btc&callback_url=https://www.test.com/payment/callback.php`

<h3>Create Payment</h3>
<h4>Parameters:</h4>
<p>API POST Fields (in addition to the Main Fields described in the <a href="#introduction">Introduction</a>)</p>
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
			<td>create_payment</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>mode</td>
			<td>1</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency to accept (btc, eth, ltc, usdt, bch, bdc, alc, etc).</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>success_url</td>
			<td>Success Url to be redirect after a payment successful.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>failure_url</td>
			<td>Failure Url to be redirected after a payment failure.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>cancel_url</td>
			<td>Cancel Url to be redirected after a payment cancel.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>callback_url</td>
			<td>URL for your IPN callbacks. If not set it will use the IPN URL in your Edit Settings page if you have one set.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>callback_fiat_currencies</td>
			<td>Converted fiat currency from callback url.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>new</td>
			<td>Force to create a new address.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field1</td>
			<td>Custom Field 1 (Max length: 100).</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field2</td>
			<td>Custom Field 2 (Max length: 100).</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field3</td>
			<td>Custom Field 3 (Maximum length: 100).</td>
			<td>No</td>
		</tr>
	</tbody>
</table>

<h4>Example request:</h4>

`POST: key=api_public_key&version=1&request=create_payment&mode=1&currency=btc&callback_url=https://www.test.com/payment/callback.php`

<h4>Response:</h4>
<p>The API always responds with a JSON string. [data] collection contains the important values:<br>
<strong>[address]</strong> is the payment address to show to the customer.<br>
<strong>[payment_id]</strong> is the unique identifier of the payment channel.</p>

<h4>Response example:</h4>

```json
{
    "success": true,
    "data": {
        "address": "0x2073eb3be1a41908e0353427da7f16412a01ae71",
        "payment_id": "d024d82c22e451d4642b1ae91ec43dfe7b42f7f8ce0"
    }
}
```

<h4>Get Payment Channel UI:</h4>
<p><strong>Use: http://pay.acpay.com/{payment_id}</strong></p>

`Example: http://pay.acpay.com/d024d82c22e451d4642b1ae91ec43dfe7b42f7f8ce0`

<h3>Create Withdrawal</h3>
<h4>Parameters:</h4>
<p>API POST Fields (in addition to the Main Fields described in the <a href="#introduction">Introduction</a>)</p>
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
			<td>Yes</td>
		</tr>
		<tr>
			<td>amount</td>
			<td>The amount of the withdrawal in the currency below.</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>currency</td>
			<td>Crypto currency to accept (btc, eth, ltc, usdt, bch, bdc, alc, etc)</td>
			<td>Yes</td>
		</tr>
		<tr>
			<td>callback_url</td>
			<td>URL for your IPN callbacks. If not set it will use the IPN URL in your Edit Settings page if you have one set.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>callback_fiat_currencies</td>
			<td>Converted fiat currency from callback url.</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field1</td>
			<td>Custom Field 1 (Max length: 100).</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field2</td>
			<td>Custom Field 2 (Max length: 100).</td>
			<td>No</td>
		</tr>
		<tr>
			<td>custom_field3</td>
			<td>Custom Field 3 (Maximum length: 100).</td>
			<td>No</td>
		</tr>
	</tbody>
</table>
<h4>Example request:</h4>

`POST: key=api_public_key&version=1&request=create_withdrawal&amount=1.2&currency=btc&callback_url=https://www.test.com/payment/callback.php`

<h3>Callback</h3>
<p>A callback is sent every time a new block is mined. To stop further callbacks, reply with the invoice ID. See code sample below.</p>
<h4>Fields:</h4>
<table>
	<thead>
		<tr>
			<th>Field</th>
			<th>Description</th>
			<th>Show field with Callback Type</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>id</td>
			<td></td>
			<td>All callback</td>
		</tr>
		<tr>
			<td>callback_mode</td>
			<td>hmac</td>
			<td>All callback</td>
		</tr>
		<tr>
			<td>callback_type</td>
			<td>payment, withdrawal</td>
			<td>All callback</td>
		</tr>
		<tr>
			<td>amount</td>
			<td>This amount of the currency below. </td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>currency</td>
			<td>crypto currency type</td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>address</td>
			<td>This address of crypto currency</td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>tx_id</td>
			<td>Transaction id of crypto currency</td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>confirmations</td>
			<td>Confirmation count of transaction</td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>status</td>
			<td>Output the status</td>
			<td>All callback</td>
		</tr>
		<tr>
			<td>fiat_conv</td>
			<td>Requested fiat currency conversion list</td>
			<td>payment</td>
		</tr>
		<tr>
			<td>custom_field1</td>
			<td>Custom Field 1</td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>custom_field2</td>
			<td>Custom Field 2</td>
			<td>payment, withdrawal</td>
		</tr>
		<tr>
			<td>custom_field3</td>
			<td>Custom Field 3</td>
			<td>payment, withdrawal</td>
		</tr>
	</tbody>
</table>

<h4>Callback example:</h4>

```json
{
	"id": "ddjqowekzzj23oqkafkq1jggqewekz",
	"callback_mode": "hmac",
	"callback_type": "payment",
	"amount": 1.2,
	"currency": "btc",
	"address": "1KBKM4ZBJsmAC2brNwyKq2LKFivRYtj8L5",
	"tx_id": "a321022f8ba56e6fbb3195123d266905757219ae0f625eb29fec48dc018269df",
	"confirmations": 5,
	"status": {
		"code": 100,
		"text": "done"
	},
	"fiat_conv": {
		"usd": {
			"amount": 7620.276,
			"rate": 6350.23
		},
		"eur": {
			"amount": 7010.652,
			"rate": 5842.21
		}
	},
	"custom_field1": "N3392812",
	"custom_field2": "",
	"custom_field3": ""
}
```

<h3>Request Limit</h3>
The system is designed to process thousands of transactions per second, so we do not limit the number of payments you can process. However, for DDoS protection reasons, the API calls are limited to 1000 per minute from one IP.
<h3>What to use as a payout address?</h3>
You will need payout addresses for all crypto currencies you want to accept. Only you will have access to your payout wallets. You can use any online wallet, service or exchange of your choice. If you don't have one, consider reading our Wallet Guide

