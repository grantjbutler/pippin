<?php

namespace Pippin;

use ArrayAccess;
use RuntimeException;

use Carbon\Carbon;

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

	public function getBusiness() {
		return $this['business'];
	}

	public function getPayerEmail() {
		return $this['payer_email'] ?: $this['sender_email'];
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

	public function getPaymentDate() {
		if (isset($this['payment_date'])) {
			$paymentDate = $this['payment_date'];
			try {
				// payment_date format is "20:12:59 Jan 13, 2009 PST", as documented https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNIntro/
				return Carbon::createFromFormat('H:i:s M d, Y T', $paymentDate);
			}
			catch (Exception $e) {
				try {
					// payment_date format is "Mon May 30 2016 13:50:59 GMT-0400 (EDT)", as filled in in the IPN simulator.
					$paymentDate = preg_replace('/ \([A-Z]{3}\)/', '', $paymentDate);
					return Carbon::createFromFormat('D M d Y H:i:s \G\M\TO', $paymentDate);
				}
				catch (Exception $e) {
					throw new Exception('Unknown payment date format: ' . $paymentDate);
				}
			}
		}
		else if (isset($this['payment_request_date'])) {
			$paymentDate = $this['payment_request_date'];
			try {
				// payment_request_date foramt is "Wed Oct 05 17:50:46 PDT 2016" for Adaptive Payments IPNs.
				return Carbon::createFromFormat('D M d H:i:s T Y', $paymentDate);
			}
			catch (Exception $e) {
				throw new Exception('Unknown payment date format: ' . $paymentDate);
			}
		}
		else {
			return null;
		}
	}

	public function getStatus() {
		return strtoupper($this['payment_status']) ?: strtoupper($this['status']);
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
