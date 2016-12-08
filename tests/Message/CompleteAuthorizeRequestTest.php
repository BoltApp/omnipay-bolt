<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Tests\TestCase;

class CompleteAuthorizeReqeustTest extends TestCase
{
    public function setUp() {
        $this->request = new CompleteAuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCompleteAuthorizeRequest() {
        $cart = new Cart(array(
            'displayId' => 'ABCDE',
            'orderReference' => 'GGHHR',
            'currency' => 'USD',
            'totalAmount' => '12345'
        ));
        $billingAddress = new Address(array(
            'state' => 'California',
            'countryCode' => 'US',
            'postalCode' => '543210'
        ));
        $this->initializeRequest(array(
            'transactionReference' => 'ABCD-1234-EFGH',
            'cart' => $cart,
            'billingAddress' => $billingAddress
        ));
        $data = $this->request->getData();

        $this->assertSame('POST', $this->request->getHttpMethod());
        $this->assertSame('/merchant/transactions/complete_authorize', $this->request->getEndpoint());
        $this->assertSame('ABCD-1234-EFGH', $data['reference']);
        $this->assertSame('ABCDE', $data['cart']['display_id']);
        $this->assertSame('GGHHR', $data['cart']['order_reference']);
        $this->assertSame('USD', $data['cart']['currency']);
        $this->assertSame(12345, $data['cart']['total_amount']);
        $this->assertSame('543210', $data['cart']['billing_address']['postal_code']);
        $this->assertSame('California', $data['cart']['billing_address']['region']);
        $this->assertSame('US', $data['cart']['billing_address']['country_code']);
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The transactionReference parameter is required
     */
    public function testTransactionReferenceIsRequired() {
        $cart = new Cart(array(
            'displayId' => 'ABCDE',
            'orderReference' => 'GGHHR',
            'currency' => 'USD',
            'totalAmount' => '12345'
        ));
        $billingAddress = new Address(array(
            'state' => 'California',
            'countryCode' => 'US',
            'postalCode' => '543210'
        ));
        $this->initializeRequest(array(
            'cart' => $cart,
            'billingAddress' => $billingAddress
        ));
        $this->request->getData();
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     * @expectedExceptionMessage The cart parameter is required
     */
    public function testCartIsRequired() {
        $billingAddress = new Address(array(
            'state' => 'California',
            'countryCode' => 'US',
            'postalCode' => '543210'
        ));
        $this->initializeRequest(array(
            'transactionReference' => 'ABCD-1234-EFGH',
            'billingAddress' => $billingAddress
        ));
        $this->request->getData();
    }

    private function initializeRequest($data) {
        $this->request->initialize($data);
    }
}
