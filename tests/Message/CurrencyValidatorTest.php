<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Tests\TestCase;

class CurrencyValidatorTest extends TestCase
{
    public function testSupportedCurrencyCode() {
        $this->assertTrue(CurrencyValidator::isValidCurrencyCode("USD"));
    }

    public function testUnsupportedCurrencyCode() {
        $this->assertFalse(CurrencyValidator::isValidCurrencyCode("GBP"));
    }

    public function testInvalidCurrencyCode() {
        $this->assertFalse(CurrencyValidator::isValidCurrencyCode("Blah"));
    }
}
