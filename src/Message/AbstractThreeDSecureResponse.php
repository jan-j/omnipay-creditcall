<?php

namespace Omnipay\Creditcall\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * Creditcall 3D Secure Response
 */
abstract class AbstractThreeDSecureResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getCode()
    {
        return isset($this->data->Response->Error->Code) ? (string)$this->data->Response->Error->Code : null;
    }

    public function getMessage()
    {
        return isset($this->data->Response->Error->Message) ? (string)$this->data->Response->Error->Message : null;
    }

    public function getDetailMessage()
    {
        return isset($this->data->Response->Error->Detail) ? (string)$this->data->Response->Error->Detail : null;
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return null;
        }
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        if ($this->isRedirect()) {
            return array();
        }
    }
}
