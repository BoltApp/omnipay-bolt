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

    public function getResponseClass() {
        return '\Omnipay\Bolt\Message\CompleteAuthorizeResponse';
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
        $this->validate('transactionReference', 'cart');

        $data = array(
            'reference' => $this->getTransactionReference()
        );

        if ($this->getCart() != null) {
            $data['cart'] = array();

            if ($this->getCart()->getOrderReference() != null) {
                $data['cart']['order_reference'] = $this->getCart()->getOrderReference();
            }

            if ($this->getCart()->getDisplayId() != null) {
                $data['cart']['display_id'] = $this->getCart()->getDisplayId();
            }

            $data['cart']['currency'] = $this->getCart()->getCurrency();
            $data['cart']['total_amount'] = intval($this->getCart()->getTotalAmount());

            if ($this->getCart() != null) {
                $data['cart']['order_reference'] = $this->getCart()->getOrderReference();
            }

            if ($this->getBillingAddress() != null) {
                $data['cart']['billing_address'] = array(
                    'postal_code' => $this->getBillingAddress()->getPostalCode(),
                    'region' => $this->getBillingAddress()->getState(),
                    'country_code' => $this->getBillingAddress()->getCountryCode()
                );
            }
        }

        return $data;
    }
}