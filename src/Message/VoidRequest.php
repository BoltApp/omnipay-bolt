<?php

namespace Omnipay\Bolt\Message;

use \Guzzle\Http\Message\RequestInterface;

class VoidRequest extends AbstractRequest {

    public function getApiKey() {
        return $this->getManagementKey();
    }

    public function getHttpMethod() {
        return RequestInterface::POST;
    }

    public function getEndpoint() {
        return '/merchant/transactions/void';
    }

    public function getData() {
        $this->validate('boltTransactionId');
        return array(
            'transaction_id' => $this->getBoltTransactionId(),
        );
    }
}