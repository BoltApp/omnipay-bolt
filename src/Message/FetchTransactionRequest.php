<?php

namespace Omnipay\Bolt\Message;

use \Guzzle\Http\Message\RequestInterface;

class FetchTransactionRequest extends AbstractRequest {

    public function getApiKey() {
        return $this->getManagementKey();
    }

    public function getHttpMethod() {
        return RequestInterface::GET;
    }

    public function getEndpoint() {
        $reference = $this->getTransactionReference();
        return '/merchant/transactions/'.$reference;
    }

    public function getData() {
        $this->validate('transactionReference');
        return array();
    }
}