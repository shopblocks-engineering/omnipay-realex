<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class CaptureResponse extends AbstractResponse implements ResponseInterface
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

    public function isRedirect()
    {
        return false;
    
    }
    
    public function isSuccessful()
    {
        return $this->data->responseCode == '00';
    }
    
    public function getCode() {
        return $this->data->responseCode;
    }
    
    public function getRequest() {}

    public function isCancelled() {}

    public function getMessage() {}


    public function getTransactionReference() {}
}
