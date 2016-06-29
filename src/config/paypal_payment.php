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

    'acct1' => [

        'ClientId'     => env('PAYPAL_CLIENT_ID'),
        'ClientSecret' => env('PAYPAL_CLIENT_SECRET'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Connection Information
    |--------------------------------------------------------------------------
    */

    'http' => [

        'CURLOPT_CONNECTTIMEOUT' => env('PAYPAL_HTTP_TIMEOUT', 30),
        // 'Proxy'                  => env('PAYPAL_HTTP_PROXY', 'http://[username:password]@hostname[:port][/path]'),
        'headers'                => [
            'PayPal-Partner-Attribution-Id' => env('PAYPAL_HTTP_HEADERS_PARTNER_ID', '123123123'),
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Service Configuration
    |--------------------------------------------------------------------------
    |
    | can be set to sandbox / live
    |
    */

    'mode' => env('PAYPAL_MODE', 'sandbox'),

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

    'log' => [

        'LogEnabled' => env('PAYPAL_LOG_ENABLED', false),
        'FileName'   => env('PAYPAL_LOG_FILE_NAME', '../PayPal.log'),
        'LogLevel'   => env('PAYPAL_LOG_LEVEL', 'FINE'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Configuration
    |--------------------------------------------------------------------------
    | If validation is set to strict, the PayPalModel would make sure that
    | there are proper accessors (Getters and Setters) for each model
    | objects. Accepted value is
    | 'log'     : logs the error message to logger only (default)
    | 'strict'  : throws a php notice message
    | 'disable' : disable the validation
    |
    */

    'validation' => [

        'level' => env('PAYPAL_VALIDATION_LEVEL', 'disable'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Caching Configuration
    |--------------------------------------------------------------------------
    | If Cache is enabled, it stores the access token retrieved from ClientId and Secret from the
    | server into a file provided by the cache.FileName option or by using
    | the constant $CACHE_PATH value in PayPal/Cache/AuthorizationCache if the option is omitted/empty.
    | If the value is set to 'true', it would try to create a file and store the information.
    | For any other value, it would disable it
    | Please note, this is a very good performance improvement, and we would encourage you to
    | set this up properly to reduce the number of calls, to almost 50% on normal use cases
    | PLEASE NOTE: You may need to provide proper write permissions to /var directory under PayPal-PHP-SDK on
    | your hosting server or whichever custom directory you choose
    |
    | When using a relative path, the cache file is created
    | relative to the .php file that is the entry point
    | for this request. You can also provide an absolute
    | path here
    |
    */

    'cache' => [

        'enabled'  => env('PAYPAL_CACHE_ENABLED', true),
        'FileName' => env('PAYPAL_CACHE_FILENAME', '../auth.cache'),

    ],
];