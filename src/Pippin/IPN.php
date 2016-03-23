<?php

namespace Pippin;

final class IPN {

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
		return $this->getDataValueOrNull('payer_email');
	}

	public function getReceiverEmail() {
		return $this->getDataValueOrNull('receiver_email');
	}

	public function getTransactionId() {
		return $this->getDataValueOrNull('txn_id');
	}

}
