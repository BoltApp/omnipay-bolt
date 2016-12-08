<?php

namespace Omnipay\Bolt\Message;

class CompletePurchaseRequest extends CompleteAuthorizeRequest  {

    public function getAutoCapture() {
        return true;
    }
}