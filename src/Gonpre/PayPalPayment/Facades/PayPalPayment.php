<?php namespace Gonpre\PayPalPayment\Facades;

use Illuminate\Support\Facades\Facade;

class PayPalPayment extends Facade
{

    const PAYMENT_DEFINITION_TYPE_REGULAR = \Gonpre\PayPalPayment\PayPalPayment::PAYMENT_DEFINITION_TYPE_REGULAR;
    const PAYMENT_DEFINITION_TYPE_TRIAL   = \Gonpre\PayPalPayment\PayPalPayment::PAYMENT_DEFINITION_TYPE_TRIAL;
    const PLAN_TYPE_FIXED                 = \Gonpre\PayPalPayment\PayPalPayment::PLAN_TYPE_FIXED;
    const PLAN_TYPE_INFINITE              = \Gonpre\PayPalPayment\PayPalPayment::PLAN_TYPE_INFINITE;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'paypalpayment';
    }
}