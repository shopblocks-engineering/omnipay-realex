<?php

namespace Omnipay\Realex\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class GenerateTokenResponse extends AbstractResponse implements ResponseInterface
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
        return true;
    }

    public function getRedirectMethod()
    {
        return 'INSTANCE';
    }

    public function isSuccessful()
    {
        return !isset($this->data['error']);
    }
    
    public function getRequest() {}

    public function isCancelled() {}

    public function getMessage() {}

    public function getCode() {}

    public function getTransactionReference() {}
}
