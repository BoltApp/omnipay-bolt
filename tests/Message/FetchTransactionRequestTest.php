<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{
    public function setUp() {
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testFetchTransactionRequest() {
        $this->initializeRequest(array(
            'transactionReference' => 'ABCD-1234-EFGH',
        ));
        $this->assertEquals(array(), $this->request->getData());
        $this->assertEquals('/merchant/transactions/ABCD-1234-EFGH', $this->request->getEndpoint());
        $this->assertEquals('GET', $this->request->getHttpMethod());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The transactionReference parameter is required
     */
    public function testTransactionReferenceIsRequired() {
        $this->initializeRequest(array());
        $this->request->getData();
    }

    private function initializeRequest($data) {
        $this->request->initialize($data);
    }
}
