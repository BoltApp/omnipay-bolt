<?php

namespace Omnipay\Bolt;

use Omnipay\Bolt\Message\Address;
use Omnipay\Bolt\Message\Cart;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp() {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testVoid() {
        $request = $this->gateway->void(array('boltTransactionId' => 'ABCDE'));
        $this->assertInstanceOf('Omnipay\Bolt\Message\VoidRequest', $request);
        $this->assertNotNull($request->getData());
        $this->assertSame('ABCDE', $request->getData()['transaction_id']);
    }

    public function testRefund() {
        $request = $this->gateway->refund(array(
            'boltTransactionId' => 'ABCD1234',
            'currency' => 'USD',
            'amount' => '12.45',
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\RefundRequest', $request);
        $this->assertNotNull($request->getData());
        $this->assertSame('ABCD1234', $request->getData()['transaction_id']);
    }

    public function testFetchTransaction() {
        $request = $this->gateway->fetchTransaction(array(
            'transactionReference' => 'ABCD-1234-EFGH'
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\FetchTransactionRequest', $request);
    }

    public function testCapture() {
        $request = $this->gateway->capture(array(
            'boltTransactionId' => 'ABCD1234'
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\CaptureRequest', $request);
        $this->assertNotNull($request->getData());
        $this->assertSame('ABCD1234', $request->getData()['transaction_id']);
    }

    public function testCompleteAuthorize() {
        $cart = new Cart(array(
            'displayId' => 'ABCDE',
            'orderReference' => 'GGHHR',
            'currency' => 'USD',
            'totalAmount' => '12345'
        ));
        $billingAddress = new Address(array(
            'countryCode' => 'US',
            'state' => 'California',
            'postalCode' => '543210'
        ));
        $request = $this->gateway->completeAuthorize(array(
            'transactionReference' => 'ABCD-1234-EFGH',
            'cart' => $cart,
            'billingAddress' => $billingAddress
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\CompleteAuthorizeRequest', $request);
        $this->assertSame('ABCD-1234-EFGH', $request->getData()['reference']);
        $this->assertSame(false, $request->getData()['auto_capture']);
        $this->assertSame('ABCDE', $request->getData()['cart']['display_id']);
        $this->assertSame('GGHHR', $request->getData()['cart']['order_reference']);
        $this->assertSame('USD', $request->getData()['cart']['currency']);
        $this->assertSame(12345, $request->getData()['cart']['total_amount']);
        $this->assertSame('543210', $request->getData()['cart']['billing_address']['postal_code']);
        $this->assertSame('California', $request->getData()['cart']['billing_address']['region']);
        $this->assertSame('US', $request->getData()['cart']['billing_address']['country_code']);
    }

    public function testCompletePurchase() {
        $cart = new Cart(array(
            'displayId' => 'ABCDE',
            'orderReference' => 'GGHHR',
            'currency' => 'USD',
            'totalAmount' => '12345'
        ));
        $billingAddress = new Address(array(
            'countryCode' => 'US',
            'state' => 'California',
            'postalCode' => '543210'
        ));
        $request = $this->gateway->completePurchase(array(
            'transactionReference' => 'ABCD-1234-EFGH',
            'cart' => $cart,
            'billingAddress' => $billingAddress
        ));
        $this->assertInstanceOf('Omnipay\Bolt\Message\CompletePurchaseRequest', $request);
        $this->assertSame('ABCD-1234-EFGH', $request->getData()['reference']);
        $this->assertSame(true, $request->getData()['auto_capture']);
        $this->assertSame('ABCDE', $request->getData()['cart']['display_id']);
        $this->assertSame('GGHHR', $request->getData()['cart']['order_reference']);
        $this->assertSame('USD', $request->getData()['cart']['currency']);
        $this->assertSame(12345, $request->getData()['cart']['total_amount']);
        $this->assertSame('543210', $request->getData()['cart']['billing_address']['postal_code']);
        $this->assertSame('California', $request->getData()['cart']['billing_address']['region']);
        $this->assertSame('US', $request->getData()['cart']['billing_address']['country_code']);
    }
}
