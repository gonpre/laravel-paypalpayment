<?php namespace Gonpre\PayPalPayment;

use PayPal\Api\Agreement as PPApiAgreement;
use PayPal\Api\AgreementDetails;
use PayPal\Api\AgreementStateDescriptor;

trait Agreement
{

    /**
     * @return \PayPal\Api\Agreement
     */
    public function agreement($data = null)
    {
        return new PPApiAgreement($data);
    }

    /**
     * Get the agreement using the paypal id
     *
     * @param  string                           $agreementId
     * @param  \PayPal\Rest\ApiContext|null     $apiContext
     * @param  \PayPal\Transport\PayPalRestCall $restCall
     * @return \PayPal\Api\Agreement
     */
    public function getAgreement($agreementId, $apiContext = null, $restCall = null)
    {
        return PPApiAgreement::get($agreementId, $apiContext, $restCall);
    }

    /**
     * @return \PayPal\Api\AgreementDetails
     */
    public function agreementDetails($data = null)
    {
        return new AgreementDetails($data);
    }

    /**
     * @return \PayPal\Api\AgreementStateDescriptor
     */
    public function agreementStateDescriptor($data = null)
    {
        return new AgreementStateDescriptor($data);
    }
}