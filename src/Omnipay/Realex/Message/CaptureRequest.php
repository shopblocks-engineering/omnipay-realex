<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractRequest;
use GlobalPayments\Api\ServicesConfig;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\Entities\Transaction;
use GlobalPayments\Api\Entities\Exceptions\ApiException;
use Omnipay\Realex\Traits\GatewayParameters;

class CaptureRequest extends AbstractRequest
{
    use GatewayParameters;

    protected $prodEndpoint = "https://pay.realexpayments.com/pay";
    protected $testEndpoint = "https://pay.sandbox.realexpayments.com/pay";

    private $data;

    public function getData()
    {
        $config = new ServicesConfig();
        $config->merchantId = $this->getMerchantId();
        $config->accountId = $this->getAccount();
        $config->sharedSecret = $this->getSecret();
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
        \Log::info('data');
        \Log::info(print_r($data,1));

        try {
            ServicesContainer::configure($data['config']);
            // a settle request requires the original order id
            $orderId = $data['order_id'];
            // and the payments reference (pasref) from the authorization response
            $paymentsReference = $data['payment_reference'];
            // create the settle transaction object
            $settle = Transaction::fromId($paymentsReference, $orderId);
            

            // send the settle request, we must specify the amount and currency
            $response = $settle->capture($data['amount'])
                ->withCurrency("GBP")
                ->execute();
            
            $this->data = $response;
        } catch (ApiException $ex) {
            throw new \Exception($ex, $ex->getCode());
            
            dd($ex->getMessage());
        }
        \Log::info('response');
        \Log::info(print_r($this->data,1));
        return $this->createResponse($this->data);
    }

    public function createResponse($data)
    {
        return $this->response = new CaptureResponse($data);
    }
}
