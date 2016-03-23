<?php

use Pippin\IPN;

class IPNTest extends PHPUnit_Framework_TestCase {

	function testIPNReturnsData() {
		$sampleData = [
			'txn_id' => 'e8d7334423af0713ce8367c0a6aebba8',
			'payer_email' => 'han.solo@milleniumfalcon.net',
			'receiver_email' => 'thug.jabba@thehutts.com',
			'mc_currency' => '17000'
		];

		$ipn = new IPN($sampleData);
		$this->assertEquals($ipn->getTransactionId(), $sampleData['txn_id']);
		$this->assertEquals($ipn->getPayerEmail(), $sampleData['payer_email']);
		$this->assertEquals($ipn->getReceiverEmail(), $sampleData['receiver_email']);
		$this->assertEquals($ipn->getData(), $sampleData);
	}

	function testIPNReturnsNull() {
		$sampleData = [
			'mc_currency' => '17000'
		];

		$ipn = new IPN($sampleData);
		$this->assertEquals($ipn->getTransactionId(), null);
		$this->assertEquals($ipn->getPayerEmail(), null);
		$this->assertEquals($ipn->getReceiverEmail(), null);
		$this->assertEquals($ipn->getData(), $sampleData);
	}

}
