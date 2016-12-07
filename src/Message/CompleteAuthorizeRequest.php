<?php

namespace Omnipay\Bolt\Message;

use \Guzzle\Http\Message\RequestInterface;

class CompleteAuthorizeRequest extends AbstractRequest {

    public function getApiKey() {
        return $this->getManagementKey();
    }

    public function getHttpMethod() {
        return RequestInterface::POST;
    }

    public function getEndpoint() {
        return '/merchant/transactions/complete_authorize';
    }

    /**
     * Get Cart.
     *
     * @return Cart.
     */
    public function getCart() {
        return $this->getParameter('cart');
    }

    /**
     * Get Billing Address.
     *
     * @return Address.
     */
    public function getBillingAddress() {
        return $this->getParameter('billingAddress');
    }

    /**
     * Set Cart
     *
     * @param Cart $cart
     * @return AbstractRequest Provides a fluent interface
     */
    public function setCart($cart) {
        return $this->setParameter('cart', $cart);
    }

    /**
     * Set Billing Address
     *
     * @param Address $billingAddress
     * @return AbstractRequest Provides a fluent interface
     */
    public function setBillingAddress($billingAddress) {
        return $this->setParameter('billingAddress', $billingAddress);
    }

    public function getData() {
        $this->validate('transactionReference', 'cart', 'billingAddress');

        $data = array(
            'reference' => $this->getTransactionReference(),
            'cart' => array(
                'order_reference' => $this->getCart()->getOrderReference(),
                'display_id' => $this->getCart()->getDisplayId(),
                'currency' => $this->getCart()->getCurrency(),
                'total_amount' => $this->getCart()->getTotalAmount(),
                'billing_address' => array(
                    'region' => $this->getBillingAddress()->getState(),
                    'postal_code' => $this->getBillingAddress()->getPostalCode(),
                    'country_code' => $this->getBillingAddress()->getCountryCode()
                )
            )
        );

        return $data;
    }
}