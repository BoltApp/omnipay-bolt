<?php

namespace Omnipay\Bolt\Message;

use Omnipay\Common\Message\NotificationInterface;

class ServerNotification implements NotificationInterface {

    private $data;

    public function getCartId() {
        if (array_key_exists('cartId', $this->data)) {
            return $this->data['cartId'];
        }

        return null;
    }

    public function getOrderId() {
        if (array_key_exists('orderId', $this->data)) {
            return $this->data['orderId'];
        }

        return null;
    }

    public function getBoltTransactionId() {
        if (array_key_exists('boltTransactionId', $this->data)) {
            return $this->data['boltTransactionId'];
        }

        return null;
    }

    public function getTransactionReference() {
        if (array_key_exists('transactionReference', $this->data)) {
            return $this->data['transactionReference'];
        }

        return null;
    }

    public function getMessage() {
        return null;
    }

    public function getTransactionStatus() {
        if (array_key_exists('transactionStatus', $this->data)) {
            return $this->data['transactionStatus'];
        }

        return null;
    }

    public function getNotificationType() {
        if (array_key_exists('notificationType', $this->data)) {
            return $this->data['notificationType'];
        }

        return null;
    }

    public function getData() {
        if (!isset($this->data)) {
            $this->constructData();
        }

        return $this->data;
    }

    private function constructData() {
        $this->data = array();

        if (array_key_exists('order_id', $_POST)) {
            $this->data['orderId'] = $_POST['order_id'];
        }

        if (array_key_exists('transaction_id', $_POST)) {
            $this->data['boltTransactionId'] = $_POST['transaction_id'];
        }

        if (array_key_exists('reference', $_POST)) {
            $this->data['transactionReference'] = $_POST['reference'];
        }

        if (array_key_exists('status', $_POST)) {
            $this->data['transactionStatus'] = $_POST['status'];
        }

        if (array_key_exists('notification_type', $_POST)) {
            $this->data['notificationType'] = $_POST['notification_type'];
        }

        if (array_key_exists('cart_id', $_POST)) {
            $this->data['cartId'] = $_POST['cart_id'];
        }
    }
}