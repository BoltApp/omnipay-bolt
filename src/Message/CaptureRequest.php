<?php

namespace Omnipay\Bolt\Message;

use \Guzzle\Http\Message\RequestInterface;
use \Omnipay\Common\Exception\InvalidRequestException;

class CaptureRequest extends AbstractRequest {

    public function getApiKey() {
        return $this->getManagementKey();
    }

    public function getHttpMethod() {
        return RequestInterface::POST;
    }

    public function getEndpoint() {
        return '/merchant/transactions/capture';
    }

    public function getData() {
        $this->validate('boltTransactionId');
        $currencyCode = $this->getCurrency();
        $amount = null;

        if ($this->getParameter('amount') != null) {
            $amount = floatval($this->getAmount()) * 100;
        }

        if ($currencyCode != null && !CurrencyValidator::isValidCurrencyCode($currencyCode)) {
            throw new InvalidRequestException("Currency ".$currencyCode." is either invalid or unsupported");
        }

        $data = array(
            'transaction_id' => $this->getBoltTransactionId(),
        );

        if ($amount != null) {
            $data['amount'] = intval($amount);
        }

        if ($this->getCurrency()  != null) {
            $data['currency'] = $this->getCurrency();
        }

        return $data;
    }
}