<?php

namespace Omnipay\Realex\Traits;

trait GatewayParameters
{
    public function getName()
    {
        return 'Realex Remote';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'account'    => '',
            'secret'     => '',
            '3dSecure'   => 0
        );
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getRefundPassword()
    {
        return $this->getParameter('refundPassword');
    }

    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }

    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    /**
     * Although Omnipay terminology deals with 'refunds', you need
     * to actually supply the 'rebate' password that Realex gives you
     * in order for this to work.
     *
     * @param string $value The 'rebate' password supplied by Realex
     *
     * @return $this
     */
    public function setRefundPassword($value)
    {
        return $this->setParameter('refundPassword', $value);
    }

    public function get3dSecure()
    {
        return $this->getParameter('3dSecure');
    }

    public function set3dSecure($value)
    {
        return $this->setParameter('3dSecure', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getCustomerPhoneMobile()
    {
        return $this->getParameter('customerPhoneMobile');
    }

    public function setCustomerPhoneMobile($value)
    {
        return $this->setParameter('customerPhoneMobile', $value);
    }

    public function setBillingAddressStreet1($value)
    {
        $this->setParameter('billingAddressStreet1', $value);
    }

    public function getBillingAddressStreet1()
    {
        return $this->getParameter('billingAddressStreet1');
    }

    public function setBillingAddressStreet2($value)
    {
        $this->setParameter('billingAddressStreet2', $value);
    }

    public function getBillingAddressStreet2()
    {
        return $this->getParameter('billingAddressStreet2');
    }

    public function setBillingAddressCity($value)
    {
        $this->setParameter('billingAddressCity', $value);
    }

    public function getBillingAddressCity()
    {
        return $this->getParameter('billingAddressCity');
    }

    public function setBillingAddressPostalCode($value)
    {
        $this->setParameter('billingAddressPostalCode', $value);
    }

    public function getBillingAddressPostalCode()
    {
        return $this->getParameter('billingAddressPostalCode');
    }

    public function setBillingAddressCountry($value)
    {
        $this->setParameter('billingAddressCountry', $value);
    }

    public function getBillingAddressCountry()
    {
        return $this->getParameter('billingAddressCountry');
    }

    public function setShippingAddressStreet1($value)
    {
        $this->setParameter('shippingAddressStreet1', $value);
    }

    public function getShippingAddressStreet1()
    {
        return $this->getParameter('shippingAddressStreet1');
    }

    public function setShippingAddressStreet2($value)
    {
        $this->setParameter('shippingAddressStreet2', $value);
    }

    public function getShippingAddressStreet2()
    {
        return $this->getParameter('shippingAddressStreet2');
    }

    public function setShippingAddressCity($value)
    {
        $this->setParameter('shippingAddressCity', $value);
    }

    public function getShippingAddressCity()
    {
        return $this->getParameter('shippingAddressCity');
    }

    public function setShippingAddressPostalCode($value)
    {
        $this->setParameter('shippingAddressPostalCode', $value);
    }

    public function getShippingAddressPostalCode()
    {
        return $this->getParameter('shippingAddressPostalCode');
    }

    public function setShippingAddressCountry($value)
    {
        $this->setParameter('shippingAddressCountry', $value);
    }

    public function getShippingAddressCountry()
    {
        return $this->getParameter('shippingAddressCountry');
    }

    public function setResponseJson($value)
    {
        $this->setParameter('response_json', $value);
    }

    public function getResponseJson()
    {
        return $this->getParameter('response_json');
    }

    public function setTestMode($value)
    {
        $this->setParameter('test_mode', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('test_mode');
    }    
}