<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{
    public function setUp() {
        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCaptureRequest() {
        $this->initializeRequest(array(
            'boltTransactionId' => 'ABCD1234'
        ));
        $data = $this->request->getData();

        $this->assertSame(1, sizeof($data));
        $this->assertSame('ABCD1234', $data['transaction_id']);
    }

    public function testCaptureRequestForPartialCapture() {
        $this->initializeRequest(array(
            'boltTransactionId' => 'ABCD1234',
            'amount' => '12.34',
            'currency' => 'USD'
        ));
        $data = $this->request->getData();

        $this->assertSame(3, sizeof($data));
        $this->assertSame('ABCD1234', $data['transaction_id']);
        $this->assertSame(1234, $data['amount']);
        $this->assertSame('USD', $data['currency']);
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The boltTransactionId parameter is required
     */
    public function testBoltTransactionIdIsRequired() {
        $this->initializeRequest(array());
        $this->request->getData();
    }

    private function initializeRequest($data) {
        $this->request->initialize($data);
    }
}
