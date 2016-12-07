<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse {
    public function isSuccessful() {
        return !array_key_exists('errors', $this->data) || sizeof($this->data['errors']) == 0;
    }

    // No action to Bolt requires a redirect
    // Hence its set to false
    public function isRedirect() {
        return false;
    }

    public function getBoltTransactionId() {
        if (array_key_exists('id', $this->data)) {
            return $this->data['id'];
        } else {
            return null;
        }
    }

    public function getTransactionStatus() {
        if (array_key_exists('status', $this->data)) {
            return $this->data['status'];
        } else {
            return null;
        }
    }

    public function getErrors() {
        if (array_key_exists('errors', $this->data)) {
            return $this->data['errors'];
        } else {
            return null;
        }
    }

    /**
     * The following are the transaction statuses
     * 1. authorized: Transaction has been authorized
     * 2. completed:  Transaction has been captured
     * 3. cancelled:  Transaction has been Voided
     * 4. pending:    Pending review by Bolt
     * 5. failed:     Transaction declined automatically or after review
     */
    public function getTransactionReference() {
        if (array_key_exists('reference', $this->data)) {
            return $this->data['reference'];
        } else {
            return null;
        }
    }

    /**
     * The following are the transaction statuses
     * 1. cc_payment:       Payment by customer (Customer to Merchant)
     * 2. cc_credit:        Refund (Merchant to Customer)
     * 3. funding_transfer: Bank transfer (Bolt to Merchant)
     */
    public function getTransactionType() {
        if (array_key_exists('type', $this->data)) {
            return $this->data['type'];
        } else {
            return null;
        }
    }

    public function getAuthorizedAmount() {
        if ($this->getTransactionType() == 'cc_payment') {
            return $this->getAmountValue($this->data);
        } else {
            return null;
        }
    }

    public function getAuthorizedCurrency() {
        if ($this->getTransactionType() == 'cc_payment') {
            return $this->getAmountCurrency($this->data);
        } else {
            return null;
        }
    }

    public function getRefundedAmount() {
        if ($this->getTransactionType() == 'cc_credit') {
            return $this->getAmountValue($this->data);
        } else {
            return null;
        }
    }

    public function getRefundedCurrency() {
        if ($this->getTransactionType() == 'cc_credit') {
            return $this->getAmountCurrency($this->data);
        } else {
            return null;
        }
    }

    public function getCapturedAmount() {
        if (array_key_exists('capture', $this->data)) {
            $capturedBlock = $this->data['capture'];
            if ($capturedBlock['status'] == 'succeeded') {
                return $this->getAmountValue($capturedBlock);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getCapturedCurrency() {
        if (array_key_exists('capture', $this->data)) {
            $capturedBlock = $this->data['capture'];
            if ($capturedBlock['status'] == 'succeeded') {
                return $this->getAmountCurrency($capturedBlock);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getRefundTransactionReferences() {
        if (array_key_exists('refund_transaction_ids', $this->data)) {
            return $this->data['refund_transaction_ids'];
        } else {
            return null;
        }
    }

    private function getAmountValue($data) {
        if (array_key_exists('amount', $data)) {
            $amount = $data['amount'];
            if (array_key_exists('amount', $amount)) {
                return $amount['amount']/100.0;
            }
        } else {
            return null;
        }
    }

    private function getAmountCurrency($data) {
        if (array_key_exists('amount', $data)) {
            $amount = $this->data['amount'];
            if (array_key_exists('currency', $amount)) {
                return $amount['currency'];
            }
        } else {
            return null;
        }
    }
}
