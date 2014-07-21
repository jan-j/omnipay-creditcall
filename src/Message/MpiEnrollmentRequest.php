<?php

namespace Omnipay\Creditcall\Message;

use Omnipay\Common\CreditCard;

/**
 * Creditcall 3D Secure Enrollment Request
 */
class MpiEnrollmentRequest extends AbstractMpiRequest
{

    protected function createResponse($data)
    {
        return $this->response = new MpiEnrollmentResponse($this, $data);
    }

    public function getAcquirerBin()
    {
        return $this->getParameter('acquirerBin');
    }

    public function setAcquirerBin($value)
    {
        return $this->setParameter('acquirerBin', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getMd()
    {
        return $this->getParameter('md');
    }

    public function setMd($value)
    {
        return $this->setParameter('md', $value);
    }

    public function getXid()
    {
        return substr(md5(microtime(true) . $this->getPassword() . rand()), 0, 20);
    }

    public function getData()
    {
        $data = $this->getBaseData();

        /** @var CreditCard $card */
        $card = $this->getCard();

        $enrollment = $data->addChild('Enrollment');

        $enrollment->addChild('AcquirerBIN', $this->getAcquirerBin());
        $enrollment->addChild('Amount', $this->getAmount());
        $enrollment->addChild('CurrencyCode', $this->getCurrencyNumeric());

        $enrollment->addChild('ExpiryDateMonth', $card->getExpiryDate('m'));
        $enrollment->addChild('ExpiryDateYear', $card->getExpiryDate('Y'));
        $enrollment->addChild('PAN', $card->getNumber());

        $enrollment->addChild('MerchantID', $this->getMerchantId());
        $enrollment->addChild('Password', $this->getPassword());
        $enrollment->addChild('TransactionNarrative', $this->getDescription());
        $enrollment->addChild('XID', $this->getXid());

        return $data;
    }
}
