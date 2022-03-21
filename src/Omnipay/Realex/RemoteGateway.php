<?php

namespace Omnipay\Realex;

use Omnipay\Common\AbstractGateway;
use Omnipay\Realex\Message\AuthRequest;
use Omnipay\Realex\Message\AuthResponse;
use Omnipay\Realex\Message\RemoteAbstractResponse;
use Omnipay\Realex\Message\VerifySigRequest;
use Omnipay\Realex\Message\VerifySigResponse;
use Omnipay\Realex\Trais\GatewayParameters;

/**
 * Realex Remote Gateway
 */
class RemoteGateway extends AbstractGateway
{
    use GatewayParameters;
    
    public function purchase(array $parameters = array())
    {
        if (array_key_exists('mobileType', $parameters)) {
            return $this->createRequest('\Omnipay\Realex\Message\AuthMobileRequest', $parameters);
        } elseif (array_key_exists('cardReference', $parameters)) {
            return $this->createRequest('\Omnipay\Realex\Message\SavedAuthRequest', $parameters);
        } elseif ($this->get3dSecure()) {
            return $this->createRequest('\Omnipay\Realex\Message\EnrolmentRequest', $parameters);
        } else {
            return $this->createRequest('\Omnipay\Realex\Message\AuthRequest', $parameters);
        }
    }

    /**
     * This will always be called as the result of returning from 3D Secure.
     * Verify that the 3D Secure message we've received is legit
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\RefundRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\VoidRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\FetchTransactionRequest', $parameters);
    }

    /**
     * Create/update/delete card/customer details
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\CreateCardRequest', $parameters);
    }

    public function updateCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\UpdateCardRequest', $parameters);
    }

    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\DeleteCardRequest', $parameters);
    }

    public function createCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\CreateCustomerRequest', $parameters);
    }

    public function updateCustomer(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\UpdateCustomerRequest', $parameters);
    }

    public function generatePaymentToken(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\GenerateTokenRequest', $parameters);
    }
    
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Realex\Message\GenerateAuthorizeTokenRequest', $parameters);
    }
}
