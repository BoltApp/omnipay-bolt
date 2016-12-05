<?php

namespace Omnipay\Bolt;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway {
    public function getName()
    {
        return 'Bolt';
    }

    /**
     * Get the gateway parameters.
     * 
     * Note: Everytime a new parameter is added, make sure to add the getters and setters
     * for the parameter in this Gateway class and in the AbstractRequest class
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'managementKey' => '',
            'processingKey' => '',
            'testMode' => false,
        );
    }

    public function supportsFetchTransaction() {
        return method_exists($this, 'fetchTransaction');
    }

    public function setManagementKey($value) {
        return $this->setParameter('managementKey', $value);
    }

    public function setProcessingKey($value) {
        return $this->setParameter('processingKey', $value);
    }

    public function getManagementKey() {
        return $this->getParameter('managementKey');
    }

    public function getProcessingKey() {
        return $this->getParameter('processingKey');
    }

    public function void(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Bolt\Message\VoidRequest', $parameters);
    }

    public function refund(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Bolt\Message\RefundRequest', $parameters);
    }

    public function capture(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Bolt\Message\CaptureRequest', $parameters);
    }

    public function acceptNotification() {
        return $this->createRequest('\Omnipay\Bolt\Message\ServerNotification', null);
    }

    public function fetchTransaction(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Bolt\Message\FetchTransactionRequest', $parameters);
    }
}