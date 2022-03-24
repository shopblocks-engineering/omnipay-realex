<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Realex\Traits\GatewayParameters;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpEcomConfig;
use GlobalPayments\Api\Entities\Exceptions\ApiException;
use GlobalPayments\Api\Entities\Transaction;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\Services\HostedService;
use GlobalPayments\Api\Entities\Enums\TransactionType;
use GlobalPayments\Api\Entities\Enums\GatewayProvider;

class CaptureRequest extends AbstractRequest
{
    use GatewayParameters;

    protected $prodEndpoint = "https://api.realexpayments.com/epage-remote.cgi";
    protected $testEndpoint = "https://api.sandbox.realexpayments.com/epage-remote.cgi";

    private $data;

    public function getData()
    {
        $config = new GpEcomConfig();
        $config->merchantId = $this->getMerchantId();
        $config->accountId = $this->getAccount();
        $config->sharedSecret = $this->getSecret();
        $config->gatewayProvider = GatewayProvider::GP_ECOM;
        if ($this->getTestMode()) {
            $config->serviceUrl = $this->testEndpoint;
        } else {
            $config->serviceUrl = $this->prodEndpoint;
        }

        $data['config'] = $config;
        $data['order_id'] = $this->getOrderId();
        $data['amount'] = $this->getAmount();
        $data['payment_reference'] = $this->getPaymentReference();

        return $data;
    }

    public function sendData($data)
    {
        try {
            ServicesContainer::configureService($data['config']);
            // a settle request requires the original order id
            $orderId = $data['order_id'];
            // and the payments reference (pasref) from the authorization response
            $paymentsReference = $data['payment_reference'];
            // create the settle transaction object
            $settle = Transaction::fromId($paymentsReference);
            // send the settle request, we must specify the amount and currency
            $response = Transaction::fromId($paymentsReference, $orderId, 1)
                ->capture($data['amount'])
                ->execute();
    
            $this->data = $response;
        } catch (ApiException $ex) {
            dd($ex->getMessage());
        }
            
        return $this->createResponse($this->data);
    }
    
    public function createResponse($data)
    {
        return $this->response = new CaptureResponse($data);
    }
}
