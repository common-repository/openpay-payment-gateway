<?php

/**
 * Get Order Feature
 *
 * @author ideatarmac.com
 */

namespace BusinessLayer\Openpay\Features;

class GetOrder extends Feature
{
    /**
     * create a Feature object with values from config files/$configParams and the 
     * PaymentManager object. This means the Request header and body, Apiinstance and 
     * debug files will created with section GetOrder in config file and Attributes 
     * from object PaymentManager
     *
     * @param \BusinessLayer\Openpay\PaymentManager $paymentManager 
     * @param array|null $configParams
     */
    public function __construct($paymentManager, $configParams = null)
    {
        parent::__construct('GetOrder', $configParams, $paymentManager);
    }
}
