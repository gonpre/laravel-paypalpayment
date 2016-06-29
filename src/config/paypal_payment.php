<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Account credentials from developer portal
    |--------------------------------------------------------------------------
    |
    | This data is provided by the developer console
    | at developer.paypal.com
    |
    */
	'Account' => [
		'ClientId'     => env('PAYPAL_CLIENT_ID'),
		'ClientSecret' => env('PAYPAL_CLIENT_SECRET'),
	],

    /*
    |--------------------------------------------------------------------------
    | Connection Information
    |--------------------------------------------------------------------------
    */
	'Http' => [
		'ConnectionTimeOut' => env('PAYPAL_HTTP_TIMEOUT', 30),
		'Retry'             => env('PAYPAL_HTTP_RETRY', 1),
		// 'Proxy'             => env('PAYPAL_HTTP_PROXY', 'http://[username:password]@hostname[:port][/path]'),
	],

    /*
    |--------------------------------------------------------------------------
    | Service Configuration
    |--------------------------------------------------------------------------
    |
    | For integrating with the live endpoint,
	| change the URL to https://api.paypal.com!
    |
    */
	'Service' => [
		'EndPoint' => env('PAYPAL_SERVICE_ENDPOINT', 'https://api.sandbox.paypal.com'),
	],


    /*
    |--------------------------------------------------------------------------
    | Logging Information
    |--------------------------------------------------------------------------
    |
    | Filename:
    | When using a relative path, the log file is created
	| relative to the .php file that is the entry point
	| for this request. You can also provide an absolute
	| path here
	|
	| LogLevel:
	| Logging level can be one of FINE, INFO, WARN or ERROR
	| Logging is most verbose in the 'FINE' level and
	| decreases as you proceed towards ERROR
    |
    */
	'Log' => [
		'LogEnabled' => env('PAYPAL_LOG_ENABLED', false),
		'FileName'   => env('PAYPAL_LOG_FILE_NAME', '../PayPal.log'),
		'LogLevel'   => env('PAYPAL_LOG_LEVEL', 'FINE'),
	],
];