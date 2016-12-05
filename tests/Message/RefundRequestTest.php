<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    public function setUp() {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData() {
        $this->initializeRequest(array(
            'boltTransactionId' => 'ABCD1234',
            'currency' => 'USD',
            'amount' => '12.45',
        ));
        $data = $this->request->getData();

        $this->assertSame(3, sizeof($data));
        $this->assertSame('ABCD1234', $data['transaction_id']);
        $this->assertSame(1245, $data['Amount']);
        $this->assertSame('USD', $data['Currency']);
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The boltTransactionId parameter is required
     */
    public function testTransactionIdIsRequired() {
        $this->initializeRequest(array(
            'amount' => '12.45',
            'currency' => 'USD',
        ));
        $this->request->getData();
    }


    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The amount parameter is required
     */
    public function testAmountIsRequired() {
        $this->initializeRequest(array(
            'boltTransactionId' => 'ABCD1234',
            'currency' => 'USD',
        ));
        $this->request->getData();
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The currency parameter is required
     */
    public function testCurrencyCodeIsRequired() {
        $this->initializeRequest(array(
            'boltTransactionId' => 'ABCD1234',
            'amount' => '12.45',
        ));
        $this->request->getData();
    }

    private function initializeRequest($data) {
        $this->request->initialize($data);
    }
}
