<?php

namespace Pippin;

use ArrayAccess;
use RuntimeException;

final class IPN implements ArrayAccess {

	private $data = [];
	private $transactions = [];

	public function __construct($transactions, $data) {
		$this->transactions = $transactions;
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

	public function getTransactions() {
		return $this->transactions;
	}

	public function getPayerEmail() {
		return $this['payer_email'];
	}

	public function getTransactionType() {
		return $this['txn_type'] ?: $this['transaction_type'];
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
