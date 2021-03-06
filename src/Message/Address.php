<?php

namespace Omnipay\Bolt\Message;

use Symfony\Component\HttpFoundation\ParameterBag;
use Omnipay\Common\Helper;

class Address {

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

    public function getPostalCode() {
        return $this->parameters->get('postalCode');
    }

    public function setPostalCode($code) {
        return $this->parameters->set('postalCode', $code);
    }

    public function getState() {
        return $this->parameters->get('state');
    }

    public function setState($state) {
        return $this->parameters->set('state', $state);
    }

    public function getCountryCode() {
        return $this->parameters->get('countryCode');
    }

    public function setCountryCode($code) {
        return $this->parameters->set('countryCode', $code);
    }
}