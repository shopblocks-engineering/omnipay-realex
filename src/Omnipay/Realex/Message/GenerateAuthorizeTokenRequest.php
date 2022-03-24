<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractRequest;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpEcomConfig;
use GlobalPayments\Api\HostedPaymentConfig;
use GlobalPayments\Api\Entities\Enums\HppVersion;
use GlobalPayments\Api\Entities\Enums\AddressType;
use GlobalPayments\Api\Entities\Enums\RecurringSequence;
use GlobalPayments\Api\Entities\Enums\RecurringType;
use GlobalPayments\Api\Services\HostedService;
use GlobalPayments\Api\Entities\HostedPaymentData;
use GlobalPayments\Api\Entities\Address;
use Omnipay\Realex\Traits\GatewayParameters;

class GenerateAuthorizeTokenRequest extends AbstractRequest
{
    use GatewayParameters;

    protected $prodEndpoint = "https://pay.realexpayments.com/pay";
    protected $testEndpoint = "https://pay.sandbox.realexpayments.com/pay";

    private $data;

    public function getData()
    {
        $config = new GpEcomConfig();
        $config->merchantId = $this->getMerchantId();
        $config->accountId = $this->getAccount();
        $config->sharedSecret = $this->getSecret();
        if ($this->getTestMode()) {
            $config->serviceUrl = $this->testEndpoint;
        } else {
            $config->serviceUrl = $this->prodEndpoint;
        }
        
        $config->hostedPaymentConfig = new HostedPaymentConfig();
        $config->hostedPaymentConfig->version = HppVersion::VERSION_2;
        $config->hostedPaymentConfig->cardStorageEnabled = "1";

        $hostedPaymentData = new HostedPaymentData();
        
        //here we need to check whether the customer is already stored, if so we can do something with their data
        if (!empty($this->getCustomerReference())) {
            $hostedPaymentData->customerKey = $this->getCustomerReference(); 
            $hostedPaymentData->customerExists = 1;
        } else {
            $hostedPaymentData->customerExists = 0;            
        }

        $hostedPaymentData->customerEmail = $this->getCustomerEmail();
        $hostedPaymentData->customerPhoneMobile = $this->getCustomerPhoneMobile();
        $hostedPaymentData->addressesMatch = false;

        $billingAddress = new Address();
        $billingAddress->streetAddress1 = $this->getBillingAddressStreet1();
        $billingAddress->streetAddress2 = $this->getBillingAddressStreet2();
        $billingAddress->streetAddress3 = "";
        $billingAddress->city = $this->getBillingAddressCity();
        $billingAddress->postalCode = $this->getBillingAddressPostalCode();
        $billingAddress->country = 826; //$this->getBillingAddressCountry();

        $shippingAddress = new Address();
        $shippingAddress->streetAddress1 = $this->getShippingAddressStreet1();
        $shippingAddress->streetAddress2 = $this->getShippingAddressStreet2();
        $shippingAddress->streetAddress3 = "";
        $shippingAddress->city = $this->getShippingAddressCity();
        $shippingAddress->postalCode = $this->getShippingAddressPostalCode();
        $shippingAddress->country = 826; //$this->getShippingAddressCountry();

        $data['config'] = $config;
        $data['hosted_payment_data'] = $hostedPaymentData;
        $data['billing_address'] = $billingAddress;
        $data['shipping_address'] = $shippingAddress;
        $data['order_id'] = $this->getOrderId();
        $data['amount'] = $this->getAmount();

        return $data;
    }

    public function sendData($data)
    {        
        try {
            $service = new HostedService($data['config']);
            $hppJson = $service->authorize($data['amount'])
                ->withCurrency("GBP")
                ->withAddress($data['billing_address'], AddressType::BILLING)
                ->withAddress($data['shipping_address'], AddressType::SHIPPING)
                ->withOrderId($data['order_id'])
                ->withHostedPaymentData($data['hosted_payment_data'])
                ->withRecurringInfo(RecurringType::VARIABLE, RecurringSequence::FIRST)
                ->serialize();
            $this->data = $hppJson;
        } catch (ApiException $ex) {
            dd($ex->getMessage());
        }

        return $this->createResponse($this->data);
    }

    public function createResponse($data)
    {
        return $this->response = new GenerateAuthorizeTokenResponse($data);
    }
}
