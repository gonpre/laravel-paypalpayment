<?php namespace Gonpre\PayPalPayment;

use Gonpre\PayPalPayment\Plan;
use Gonpre\PayPalPayment\Agreement;

use PayPal\Api\Address;
use PayPal\Api\AgreementDetails;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Currency;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Links;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PaymentExecution;
use PayPal\Api\PaymentHistory;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\RelatedResources;
use PayPal\Api\Sale;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Api\Transactions;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Core\PayPalConfigManager;
use PayPal\Rest\ApiContext;

class PayPalPayment
{
    const PAYMENT_DEFINITION_TYPE_REGULAR = 'REGULAR';
    const PAYMENT_DEFINITION_TYPE_TRIAL   = 'TRIAL';
    const PLAN_TYPE_FIXED                 = 'FIXED';
    const PLAN_TYPE_INFINITE              = 'INFINITE';

    use Plan, Agreement;

    /**
     * @return \PayPal\Api\MerchantPreferences
     */
    public function merchantPreferences($data = null)
    {
        return new MerchantPreferences($data);
    }

    /**
     * @return \PayPal\Api\PaymentDefinition
     */
    public function paymentDefinition($data = null)
    {
        return new PaymentDefinition($data);
    }

    /**
     * @return \PayPal\Api\Currency
     */
    public function currency($data = null)
    {
        return new Currency($data);
    }

    /**
     * @return \PayPal\Api\Address
     */
    public function address($data = null)
    {
        return new Address($data);
    }

    /**
     * @return \PayPal\Api\Amount
     */
    public function amount($data = null)
    {
        return new Amount($data);
    }

    /**
     * @return \PayPal\Api\Details
     */
    public  function details($data = null)
    {
        return new Details($data);
    }

    /**
     * @return \PayPal\Api\Authorization
     */
    public  function authorization($data = null)
    {
        return new Authorization($data);
    }

    /**
     * @return \PayPal\Api\Capture
     */
    public  function capture($data = null)
    {
        return new Capture($data);
    }

    /**
     * @return \PayPal\Api\CreditCard
     */
    public  function creditCard($data = null)
    {
        return new CreditCard($data);
    }

    /**
     * @return \PayPal\Api\CreditCardToken
     */
    public  function creditCardToken($data = null)
    {
        return new CreditCardToken($data);
    }

    /**
     * @return \PayPal\Api\FundingInstrument
     */
    public  function fundingInstrument($data = null)
    {
        return new FundingInstrument($data);
    }

    /**
     * @return \PayPal\Api\Item
     */
    public  function item($data = null)
    {
        return new Item($data);
    }

    /**
     * @return \PayPal\Api\ItemList
     */
    public  function itemList($data = null)
    {
        return new ItemList($data);
    }

    /**
     * @return \PayPal\Api\Links
     */
    public  function links($data = null)
    {
        return new Links($data);
    }

    /**
     * @return \PayPal\Api\Payee
     */
    public  function payee($data = null)
    {
        return new Payee($data);
    }

    /**
     * @return \PayPal\Api\Payer
     */
    public  function payer($data = null)
    {
        return new Payer($data);
    }

    /**
     * @return \PayPal\Api\PayerInfo
     */
    public  function payerInfo($data = null)
    {
        return new PayerInfo($data);
    }

    /**
     * @return \PayPal\Api\Payment
     */
    public  function payment($data = null)
    {
        return new Payment($data);
    }

    /**
     * Get a payment details using the paymentId
     *
     * @param $paymentId
     * @param \PayPal\Rest\ApiContext $apiContext
     *
     * @return \PayPal\Api\Payment
     */
    public static function getPayment($paymentId, ApiContext $apiContext = null)
    {
        return Payment::get($paymentId, $apiContext);
    }

    /**
     * @return \PayPal\Api\PaymentExecution
     */
    public  function paymentExecution($data = null)
    {
        return new PaymentExecution($data);
    }

    /**
     * @return \PayPal\Api\PaymentHistory
     */
    public  function paymentHistory($data = null)
    {
        return new PaymentHistory($data);
    }

    /**
     * @return \PayPal\Api\RedirectUrls
     */
    public  function redirectUrls($data = null)
    {
        return new RedirectUrls($data);
    }

    /**
     * @return \PayPal\Api\Refund
     */
    public  function refund($data = null)
    {
        return new Refund($data);
    }

    /**
     * @return \PayPal\Api\RelatedResources
     */
    public  function relatedResources($data = null)
    {
        return new RelatedResources($data);
    }

    /**
     * @return \PayPal\Api\Sale
     */
    public  function sale($data = null)
    {
        return new Sale($data);
    }

    /**
     * @return \PayPal\Api\ShippingAddress
     */
    public  function shippingAddress($data = null)
    {
        return new ShippingAddress($data);
    }

    /**
     * @return \PayPal\Api\Transactions
     */
    public  function transactions($data = null)
    {
        return new Transactions($data);
    }

    /**
     * @return \PayPal\Api\Transaction
     */
    public function transaction($data = null)
    {
        return new Transaction($data);
    }

    /**
     * @param null $clientId
     * @param null $clientSecret
     * @param null $requestId
     * @return \PayPal\Rest\ApiContext
     */
    public function apiContext($clientId = null, $clientSecret = null, $requestId = null)
    {
        if (empty($clientId) || empty($clientSecret)) {
            $clientId     = config('paypal_payment.acct1.ClientId', null);
            $clientSecret = config('paypal_payment.acct1.ClientSecret', null);
        }

        $credentials = self::OAuthTokenCredential($clientId, $clientSecret);
        $apiContext  = new ApiContext($credentials, $requestId);

        if (!config('paypal_payment.config.ini')) {
            $config = config('paypal_payment');
            unset($config['config']['ini']);

            $flatConfig  = array_dot($config);
            $apiContext->setConfig($flatConfig);
        }

        return $apiContext;
    }

    /**
     * @param null $ClientId
     * @param null $ClientSecret
     * @return PayPal/Auth/OAuthTokenCredential
     */
    public  static function OAuthTokenCredential($clientId = null, $clientSecret=null)
    {
        if(!empty($clientId) && !empty($clientSecret)) {
          return new OAuthTokenCredential($clientId, $clientSecret);
        }

        $configManager  = PayPalConfigManager::getInstance();
        // $cred is used by samples that include this bootstrap file
        // This piece of code simply demonstrates how you can
        // dynamically pass in a client id/secret instead of using
        // the config file. If you do not need a way to pass
        // in credentials dynamically, you can skip the
        // <Resource>::setCredential($cred) calls that
        // you see in the samples.

        $cred = new OAuthTokenCredential(
            $configManager->get('acct1.ClientId'),
            $configManager->get('acct1.ClientSecret'));

        return $cred;
    }

    /**
     * grape all payment details
     * @param $param
     * @param null $apiContext
     * @return \PayPal\Api\Payment
     */
    public static function getAll($param, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::all($param, $apiContext);
        }

        return Payment::all($param);
    }

}
