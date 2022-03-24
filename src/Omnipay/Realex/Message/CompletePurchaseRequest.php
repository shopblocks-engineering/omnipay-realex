<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractRequest;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpEcomConfig;
use GlobalPayments\Api\Services\HostedService;
use GlobalPayments\Api\HostedPaymentConfig;
use Omnipay\Realex\Traits\GatewayParameters;

class CompletePurchaseRequest extends AbstractRequest
{
    use GatewayParameters;
    
    protected $prodEndpoint = "https://pay.realexpayments.com/pay";
    protected $testEndpoint = "https://pay.sandbox.realexpayments.com/pay";

    public function getData()
    {
        $config = new GpEcomConfig();
        $config->merchantId = $this->getMerchantId();
        $config->accountId = $this->getAccount();
        $config->sharedSecret = $this->getSecret();
        $config->orderId = $this->getOrderId();
        if ($this->getTestMode()) {
            $config->serviceUrl = $this->testEndpoint;
        } else {
            $config->serviceUrl = $this->prodEndpoint;
        }

        $data['config'] = $config;
        $data['response_json'] = $this->getResponseJson();
        
        return $data;
    }

    public function sendData($data)
    {
        try {
            $service = new HostedService($data['config']);

            $parsedResponse = $service->parseResponse($data['response_json'], true);
        } catch (ApiException $ex) {
            dd($ex->getMessage());
        }

        return $this->createResponse($parsedResponse ?? null);
    }

    public function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($data);
    }
}
