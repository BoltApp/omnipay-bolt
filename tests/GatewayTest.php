<?php

namespace Omnipay\Bolt;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testVoid()
    {
        $request = $this->gateway->void(array('boltTransactionId' => 'ABCDE'));
        $this->assertInstanceOf('Omnipay\Bolt\Message\VoidRequest', $request);
        $this->assertNotNull($request->getData());
        $this->assertSame('ABCDE', $request->getData()['transaction_id']);
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array(
            'boltTransactionId' => 'ABCD1234',
            'currency' => 'USD',
            'amount' => '12.45',
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\RefundRequest', $request);
        $this->assertNotNull($request->getData());
        $this->assertSame('ABCD1234', $request->getData()['transaction_id']);
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(array(
            'transactionReference' => 'ABCD-1234-EFGH'
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\FetchTransactionRequest', $request);
    }

    public function testCapture()
    {
        $request = $this->gateway->capture(array(
            'boltTransactionId' => 'ABCD1234'
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\CaptureRequest', $request);
    }
}
