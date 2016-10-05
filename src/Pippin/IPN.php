<?php

namespace Pippin;

use ArrayAccess;
use RuntimeException;

final class IPN implements ArrayAccess {

	private $data = [];

	public function __construct($data) {
		$this->data = $data;
	}

	private function getDataValueOrNull($key) {
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}

		return null;
	}

	public function getData() {
		return $this->data;
	}

	public function getPayerEmail() {
		return $this['payer_email'];
	}

	public function getReceiverEmails() {
		if (isset($this['receiver_email'])) {
			return [$this['receiver_email']];
		}
		
		$emails = []
		for($i = 0; isset($this["transaction[{$i}].receiver"]); $i++) {
			$emails[] = $this["transaction[{$i}].receiver"];
		}
		return $emails;
	}

	public function getTransactionIds() {
		if (isset($this['txn_id'])) {
			return [$this['txn_id']];
		}
		
		$IDs = [];
		for($i = 0; isset($this["transaction[{$i}].id"]); $i++) {
			$IDs[] = $this["transaction[{$i}].id"];
		}
		return $IDs;
	}

	public function getTransactionType() {
		return $this['txn_type'] ?: $this['transaction_type'];
	}

	public function getCurrencies() {
		if (isset($this['mc_currency'])) {
			$currency = $this['mc_currency'];
			return (is_string($currency)) ? [strtoupper($currency)] : null;
		}
		
		$currencies = [];
		for($i = 0; isset($this["transaction[{$i}].amount"]); $i++) {
			// For Adapative Payments IPNs, the amount has the form "<CURRENCY> <AMOUNT>"
			// For example, "USD 5.00". Split the string by spaces, and return the first component.
			$currencies[] = explode(" ", $this["transaction[{$i}].amount"])[0];
		}
		return $currencies;
	}
	
	public function getAmounts() {
		if (isset($this['mc_gross'])) {
			return [$this['mc_gross']];
		}
		
		$amounts = [];
		for($i = 0; isset($this["transaction[{$i}].amount"]); $i++) {
			// For Adapative Payments IPNs, the amount has the form "<CURRENCY> <AMOUNT>"
			// For example, "USD 5.00". Split the string by spaces, and return the last component.
			$amounts[] = explode(" ", $this["transaction[{$i}].amount"])[1];
		}
		return $amounts;
	}

	public function getPaymentStatus() {
		$status = $this['payment_status'] ?: $this['status'];
		return strtoupper($status);
	}

	public function getCustom() {
		return $this['custom'];
	}

	public function getTrackingID() {
		return $this['tracking_id'];
	}

	// ---

	public function offsetSet($key, $value) {
		throw new RuntimeException('offsetSet is unavailable for IPN, as it represents an immutable data type.');
	}

	public function offsetExists($key) {
		return isset($this->data[$key]);
	}

	public function offsetUnset($key) {
		throw new RuntimeException('offsetUnset is unavailable for IPN, as it represents an immutable data type.');
	}

	public function offsetGet($key) {
		return $this->getDataValueOrNull($key);
	}

}
