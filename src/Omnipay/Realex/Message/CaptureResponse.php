<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class CaptureResponse extends AbstractRequest implements ResponseInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
    
    public function sendData($data)
    {

    }


    public function isRedirect()
    {
        return false;
    
    }
    public function isSuccessful()
    {
        return $this->data->responseCode == '00';
    }
    
    public function getRequest() {}

    public function isCancelled() {}

    public function getMessage() {}

    public function getCode() {}

    public function getTransactionReference() {}
}
