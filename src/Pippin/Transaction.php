<?php

namespace Pippin;

class Transaction {

    private $amount;
    private $currency;
    private $id;
    private $receiver;
    private $status;

    /**
     * @param string $id
     * @param string $type
     * @param string $status
     * @param array  $receiver
     * @param string $currency
     * @param double $amount
     */
    public function __construct($id, $status, $receiver, $currency, $amount) {
        $this->id = $id;
        $this->status = $status;
        $this->receiver = $receiver;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getID() {
        return $this->id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getReceiver() {
        return $this->receiver;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function getAmount() {
        return $this->amount;
    }

}
