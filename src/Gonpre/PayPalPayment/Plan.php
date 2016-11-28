<?php namespace Gonpre\PayPalPayment;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Plan as PPApiPlan;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Transport\PayPalRestCall;

trait Plan
{
    /**
     * Return a new plan
     *
     * @param  array|null $data
     * @return \PayPal\Api\Plan
     */
    public function plan($data = null)
    {
        return new PPApiPlan($data);
    }

    /**
     * Get the plan using the paypal id
     *
     * @param  string                           $planId
     * @param  \PayPal\Rest\ApiContext|null     $apiContext
     * @param  \PayPal\Transport\PayPalRestCall $restCall
     * @return \PayPal\Api\Plan
     */
    public function getPlan($planId, ApiContext $apiContext = null, PayPalRestCall $restCall = null)
    {
        return PPApiPlan::get($planId, $apiContext, $restCall);
    }

    /**
     * Activate a current plan
     *
     * @param  sintrg                  $planId
     * @param  \PayPal\Rest\ApiContext $apiContext
     * @return \PayPal\Api\Plan
     */
    public function activatePlan($planId, ApiContext $apiContext)
    {
        $plan  = $this->getPlan($planId, $apiContext);
        $patch = new Patch();
        $value = new PayPalModel(['state' => 'ACTIVE']);

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);

        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);

        $plan->update($patchRequest, $apiContext);

        return $plan;
    }

    /**
     * Update a current plan
     *
     * @param  sintrg                  $planId
     * @param  array                   $data This should be an array with the indexes 'payment_definitions' or 'merchant_preferences'
     * @param  \PayPal\Rest\ApiContext $apiContext
     * @return \PayPal\Api\Plan
     */
    public function updatePlan($id, array $data, ApiContext $apiContext)
    {
        $plan  = $this->getPlan($planId, $apiContext);

        if (!empty($data['payment_definitions'])) {
            $paymentDefinitions = $plan->getPaymentDefinitions();
            $paymentDefinitionId = $paymentDefinitions[0]->getId();

            $patch = new Patch();
            $patch->setOp('replace')
                ->setPath('/payment-definitions/' . $paymentDefinitionId)
                ->setValue($data['payment_definitions']);

            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $plan->update($patchRequest, $apiContext);
        }

        if (!empty($data['merchant_preferences'])) {
            $merchantPreferences = $plan->getMerchantPreferences();
            $merchantPreferencesId = $merchantPreferences[0]->getId();

            $patch = new Patch();
            $patch->setOp('replace')
                ->setPath('/merchant-preferences/' . $merchantPreferencesId)
                ->setValue($data['merchant_preferences']);

            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $plan->update($patchRequest, $apiContext);
        }

        $plan  = $this->getPlan($planId, $apiContext);

        return $plan;
    }

    /**
     * Delete a plan by id
     *
     * @param  string                  $id
     * @param  \PayPal\Rest\ApiContext $apiContext
     * @return \PayPal\Api\Plan
     */
    public function deletePlan($id, ApiContext $apiContext)
    {
        $plan = $this->getPlan($id, $apiContext);

        return $plan->delete($spiContext);
    }
}