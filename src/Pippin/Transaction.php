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
     * @param string $status
     * @param string $receiver
     * @param string $currency
     * @param double $amount
     */
    public function __construct(string $id, string $status, string $receiver, string $currency, float $amount) {
        $this->id = $id;
        $this->status = $status;
        $this->receiver = $receiver;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getID(): string {
        return $this->id;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getReceiver(): string {
        return $this->receiver;
    }

    public function getCurrency(): string {
        return $this->currency;
    }

    public function getAmount(): float {
        return $this->amount;
    }

}
