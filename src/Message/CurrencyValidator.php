<?php

namespace Omnipay\Bolt\Message;

class CurrencyValidator {

    private static $supportedCurrencies = array('USD');

    public static function isValidCurrencyCode($currencyCode) {
        return in_array($currencyCode, CurrencyValidator::$supportedCurrencies);
    }
}