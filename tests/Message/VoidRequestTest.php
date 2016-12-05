<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    public function setUp() {
        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData() {
        $this->initializeRequest(array(
            'boltTransactionId' => 'ABCD1234'
        ));
        $data = $this->request->getData();

        $this->assertSame(1, sizeof($data));
        $this->assertSame('ABCD1234', $data['transaction_id']);
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The boltTransactionId parameter is required
     */
    public function testTransactionIdIsRequired() {
        $this->initializeRequest(array());
        $this->request->getData();
    }

    private function initializeRequest($data) {
        $this->request->initialize($data);
    }
}
