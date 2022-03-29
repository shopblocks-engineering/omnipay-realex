<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseResponse extends AbstractResponse implements ResponseInterface
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
    
    public function isSuccessful()
    {
        return $this->data->responseCode == "00";
    }

    public function getMessage()
    {
        return $this->data->responseMessage;
    }
    
    public function isRedirect()
    {
        return false;
    }
    
    public function getRequest() {}

    public function isCancelled() {}

    public function getCode() {}

    public function getTransactionReference() {}
}
