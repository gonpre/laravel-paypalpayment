<?php namespace Gonpre\Paypalpayment;

use Illuminate\Support\ServiceProvider;

class PaypalpaymentServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['paypalpayment'] = $this->app->share(function($app) {
            return new PaypalPayment();
        });

        $this->publishes([
            __DIR__.'/../../config/paypal_payment.php' => config_path('paypal_payment.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['paypalpayment'];
    }

}
