<?php namespace Gonpre\PayPalPayment\Facades;

use Illuminate\Support\Facades\Facade;

class PayPalPayment extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'paypalpayment';
    }
}