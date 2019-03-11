<?php

namespace Omnipay\Bolt\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {

    /**
     * Live Endpoint URL.
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://api.bolt.com/v1';

    /**
     * Test Endpoint URL.
     *
     * @var string URL
     */
    protected $testEndpoint = 'https://api-sandbox.bolt.com/v1';

    public function getRootEndpoint() {
        if ($this->getTestMode()) {
            return $this->testEndpoint;
        }

        return $this->liveEndpoint;
    }

    abstract public function getEndpoint();

    abstract public function getApiKey();

    abstract public function getHttpMethod();

    public function getResponseClass() {
        return '\Omnipay\Bolt\Message\Response';
    }

    public function getManagementKey() {
        return $this->getParameter('managementKey');
    }

    public function getProcessingKey() {
        return $this->getParameter('processingKey');
    }

    public function getBoltTransactionId() {
        return $this->getParameter('boltTransactionId');
    }

    public function setManagementKey($key) {
        return $this->setParameter('managementKey', $key);
    }

    public function setProcessingKey($key) {
        return $this->setParameter('processingKey', $key);
    }

    public function setBoltTransactionId($id) {
        return $this->setParameter('boltTransactionId', $id);
    }

    public function sendData($data) {
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function (\Guzzle\Common\Event $event) {
                $event->stopPropagation();
            }
        );
        $uri = $this->getRootEndpoint().$this->getEndpoint();
        $key = $this->getApiKey();
        $encoded_data = json_encode($data);
        $header = array(
            'Content-Type' => 'application/json',
            'X-Nonce' => strval(rand(100000000, 99999999)),
            'Content-Length' => strlen($encoded_data),
            'X-Merchant-Key' => $key,
        );

        $responseClass = $this->getResponseClass();
        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $uri,
            $header,
            $encoded_data
        );
        $httpResponse = $httpRequest->send();
        $this->response = new $responseClass($this, $httpResponse->json());

        return $this->response;
    }
}