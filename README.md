## Forked from:
[anouar/paypalpayment](https://github.com/anouarabdsslm/laravel-paypalpayment)

## Note :
If you're going to use this package with Laravel 4, make sure to include the Laravel 4 version:
```js
"require": {
    "gonpre/paypalpayment": "1.0"
}
```
laravel-paypalpayment
=====================
[![Build Status](https://travis-ci.org/gonpre/laravel-paypalpayment.svg?branch=master)](https://travis-ci.org/gonpre/laravel-paypalpayment)

laravel-paypalpayment is a simple package that helps you to process direct credit card payments, stored credit card payments and PayPal account payments with your Laravel 4/5 projects using PayPal REST API SDK.

## Donation :
If you want to support us: <a href='https://pledgie.com/campaigns/32161'><img alt='Click here to lend your support to: Laravel paypal payment package and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/32161.png?skin_name=chrome' border='0' ></a>

## <a href='https://youtu.be/q5Xb5r4MUB8'>Watch a Quick Demo</a>

Installation
=============
Install this package through Composer. To your `composer.json` file, add:

```js
"require": {
    "gonpre/paypalpayment": "dev-master"
}
```

Next, run `composer update` to download it.

Add the service provider to `config/app.php` (`app/config/app.php` in Laravel 4), within the `providers` array.

```php
'providers' => [
    // ...

    Gonpre\PayPalPayment\PayPalPaymentServiceProvider::class,
]
```

Then add an alias to `config/app.php` (`app/config/app.php`), within the `aliases` array.

```php
'aliases' => [
    // ...

    'PayPalPayment'   => Gonpre\PayPalPayment\Facades\PayPalPayment::class,
]
```
Finaly Pulish the package configuration by running this CMD ```php artisan vendor:publish```

## Configuration
By default, this package load the configuration from the `paypal_payment.php` file in the laravel config path, but if you want to use the ini config file change to true the config.ini setting

```php
    'config' => [
        'ini' => true,
    ],
```

Then go to `vendor\gonpre\paypalpayment\src\Gonpre\PayPalPayment\sdk_config.ini`.

Set your SDK configuration `acct1.ClientId` and `acct1.ClientSecret` , set the `service.mode` to the mode that you want , by default it set to testing mode which is `service.mode="sandbox"`. If you were going live, change it to live mode `service.mode="live"`.

```
;## This is an example configuration file for the SDK.
;## The sample scripts configure the SDK dynamically
;## but you can choose to go for file based configuration
;## in simpler apps (See bootstrap.php for more).
[Account]
acct1.ClientId = AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS
acct1.ClientSecret = EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL

;Connection Information
[Http]
; Add Curl Constants to be configured
; The settings provided in configurations would override defaults
; if provided in configurations
http.CURLOPT_CONNECTTIMEOUT = 30

; Adding HTTP Headers to each request sent to PayPal APIs
;http.headers.PayPal-Partner-Attribution-Id = 123123123

;http.Proxy=http://[username:password]@hostname[:port]

;Service Configuration
[Service]
; can be set to sandbox / live
mode = sandbox

;Logging Information
[Log]
log.LogEnabled=true

; When using a relative path, the log file is created
; relative to the .php file that is the entry point
; for this request. You can also provide an absolute
; path here
log.FileName=../PayPal.log

; Logging level can be one of
; Sandbox Environments: DEBUG, INFO, WARN, ERROR
; Live Environments: INFO, WARN, ERROR
; Logging is most verbose in the 'DEBUG' level and
; decreases as you proceed towards ERROR
; DEBUG level is disabled for live, to not log sensitive information.
; If the level is set to DEBUG, it will be reduced to FINE automatically,
; with a warning message
log.LogLevel=INFO

;Validation Configuration
[validation]
; If validation is set to strict, the PayPalModel would make sure that
; there are proper accessors (Getters and Setters) for each model
; objects. Accepted value is
; 'log'     : logs the error message to logger only (default)
; 'strict'  : throws a php notice message
; 'disable' : disable the validation
validation.level=disable

;Caching Configuration
[cache]
; If Cache is enabled, it stores the access token retrieved from ClientId and Secret from the
; server into a file provided by the cache.FileName option or by using 
; the constant $CACHE_PATH value in PayPal/Cache/AuthorizationCache if the option is omitted/empty.
; If the value is set to 'true', it would try to create a file and store the information.
; For any other value, it would disable it
; Please note, this is a very good performance improvement, and we would encourage you to
; set this up properly to reduce the number of calls, to almost 50% on normal use cases
; PLEASE NOTE: You may need to provide proper write permissions to /var directory under PayPal-PHP-SDK on
; your hosting server or whichever custom directory you choose
cache.enabled=true
; When using a relative path, the cache file is created
; relative to the .php file that is the entry point
; for this request. You can also provide an absolute
; path here
cache.FileName=../auth.cache
```

https://gist.github.com/jaypatel512/0af613871ea499985022

Example Code
============

### 1.- Initiate The Configuration
Create new controller `PayPalPaymentController` and initiate the configuration :

```php
class PayPalPaymentController extends BaseController {

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= PayPalPayment::OAuthTokenCredential();
    */
    public function __construct()
    {
        $this->_apiContext = PayPalPayment::ApiContext();
    }

}
```

If you want to use the Laravel config file: The first step is to publish the config with `artisan vendor:publish`. This will create the config file `storage/paypal_payment.php` (`app/config/paypal_payment.php` in Laravel 4). Configurate it, then replace the `setConfig()` method call (see above) with:

```php
$config = config('paypal_payment'); // Get all config items as multi dimensional array
$flatConfig = array_dot($config); // Flatten the array with dots

$this->_apiContext->setConfig($flatConfig);
```

### 2.- Create Payment
Add the `create()` function to the `PayPalPaymentController` Controller

```php

    /*
    * Display form to process payment using credit card
    */
    public function create()
    {
        return View::make('payment.order');
    }

    /*
    * Process payment using credit card
    */
    public function store()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= PayPalPayment::address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostalCode("14305");
        $addr->setCountryCode("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        $card = PayPalPayment::creditCard();
        $card->setType("visa")
            ->setNumber("4758411877817150")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("456")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = PayPalPayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = PayPalPayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments([$fi]);

        $item1 = PayPalPayment::item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);

        $item2 = PayPalPayment::item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);


        $itemList = PayPalPayment::itemList();
        $itemList->setItems([$item1, $item2]);


        $details = PayPalPayment::details();
        $details->setShipping("1.2")
                ->setTax("1.3")
                //total of items prices
                ->setSubtotal("17.5");

        //Payment Amount
        $amount = PayPalPayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("20")
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = PayPalPayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = PayPalPayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions([$transaction]);

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PayPalConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);
    }
```
### 3.- List Payment
Add the `index()` function to the `PayPalPaymentController` Controller
```php
    /**
     * Use this call to get a list of payments.
     * url:payment/
     */
    public function index()
    {
        echo "<pre>";

        $payments = PayPalPayment::getAll(['count' => 1, 'start_index' => 0], $this->_apiContext);

        dd($payments);
    }
```

### 4.- Get Payment details
Add the `show()` function to the `PayPalPaymentController` Controller
```php
    /**
     * Use this call to get details about payments that have not completed,
     * such as payments that are created and approved, or if a payment has failed.
     * url:payment/PAY-3B7201824D767003LKHZSVOA
     */

    public function show($payment_id)
    {
       $payment = PayPalPayment::getById($payment_id, $this->_apiContext);

       dd($payment);
    }
```

### 5.- Execute Payment
Only for Payment with `payment_method` as `"paypal"`
```php
    // Get the payment Object by passing paymentId
    // payment id and payer ID was previously stored in database in
    // create() fuction , this function create payment using "paypal" method
    $paymentId = '';grape it from DB;
    $PayerID = '';grape it from DB;
    $payment = PayPalPayment::getById($paymentId, $this->_apiContext);

    // PaymentExecution object includes information necessary
    // to execute a PayPal account payment.
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = PayPalPayment::PaymentExecution();
    $execution->setPayerId($PayerID);

    //Execute the payment
    $payment->execute($execution,$this->_apiContext);
```
Go to your `routes.php` file  and register a resourceful route to the controller: `Route::resource('payment', 'PayPalPaymentController');`

These examples pick the SDK configuration dynamically. If you want to pick your configuration from the `sdk_config.ini` file make sure to set thus configuration there.

Conclusion
==========
I hope this package help someone around -_*
