<?php

namespace Omnipay\Bolt\Message;

use Symfony\Component\HttpFoundation\ParameterBag;
use Omnipay\Common\Helper;

class Cart {

    /**
     * Internal storage of all of the card parameters.
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    private $parameters;

    public function __construct($parameters = null) {
        $this->initialize($parameters);
    }

    public function initialize($parameters = null) {
        $this->parameters = new ParameterBag;
        Helper::initialize($this, $parameters);
        return $this;
    }

    public function getOrderReference() {
        return $this->parameters->get('orderReference');
    }

    public function getDisplayId() {
        return $this->parameters->get('displayId');
    }

    public function getCurrency() {
        return $this->parameters->get('currency');
    }

    public function getTotalAmount() {
        return $this->parameters->get('totalAmount');
    }

    public function setOrderReference($ref) {
        return $this->parameters->set('orderReference', $ref);
    }

    public function setDisplayId($id) {
        return $this->parameters->set('displayId', $id);
    }

    public function setCurrency($currency) {
        return $this->parameters->set('currency', $currency);
    }

    public function setTotalAmount($total) {
        return $this->parameters->set('totalAmount', $total);
    }
}