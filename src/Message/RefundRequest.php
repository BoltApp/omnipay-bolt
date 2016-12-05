<?php

namespace Omnipay\Bolt\Message;

use \Omnipay\Common\Exception\InvalidRequestException;
use \Guzzle\Http\Message\RequestInterface;

class RefundRequest extends AbstractRequest {

    public function getApiKey() {
        return $this->getManagementKey();
    }

    public function getHttpMethod() {
        return RequestInterface::POST;
    }

    public function getEndpoint() {
        return '/merchant/transactions/credit';
    }

    public function getData() {
        $this->validate('boltTransactionId', 'amount', 'currency');
        $currencyCode = $this->getCurrency();
        $amount = floatval($this->getAmount()) * 100;

        if (!CurrencyValidator::isValidCurrencyCode($currencyCode)) {
            throw new InvalidRequestException("Currency ".$currencyCode." is either invalid or unsupported");
        }

        return array(
            'transaction_id' => $this->getBoltTransactionId(),
            'Amount' => intval($amount),
            'Currency' => $this->getCurrency(),
        );
    }
}