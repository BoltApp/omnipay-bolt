<?php

namespace Omnipay\Bolt\Message;

class CompleteAuthorizeResponse extends Response {
    public function getIsValid() {
        if (array_key_exists('is_valid', $this->data)) {
            return $this->data['is_valid'];
        } else {
            return null;
        }
    }
}
