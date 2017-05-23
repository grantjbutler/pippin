<?php

use Pippin\IPN;

use PHPUnit\Framework\TestCase;

class IPNTest extends TestCase {

	function testIPNReturnsData() {
		$sampleData = [
			'txn_id' => 'e8d7334423af0713ce8367c0a6aebba8',
			'payer_email' => 'han.solo@milleniumfalcon.net',
			'receiver_email' => 'thug.jabba@thehutts.com',
			'mc_currency' => '17000'
		];

		$ipn = new IPN([], $sampleData);
		$this->assertEquals($ipn->getPayerEmail(), $sampleData['payer_email']);
		$this->assertEquals($ipn->getData(), $sampleData);
	}

	function testIPNReturnsNull() {
		$sampleData = [
			'mc_currency' => '17000'
		];

		$ipn = new IPN([], $sampleData);
		$this->assertEquals($ipn->getPayerEmail(), null);
		$this->assertEquals($ipn->getData(), $sampleData);
	}

	/**
	 * @expectedException RuntimeException
	 */
	function testIPNDisallowsSettingOffset() {
		$ipn = new IPN([], []);
		$ipn['custom'] = 'Hello, world';
	}

	/**
	 * @expectedException RuntimeException
	 */
	function testIPNDisallowsUnsettingOffset() {
		$ipn = new IPN([], ['custom' => 'Hello, world']);
		unset($ipn['custom']);
	}

	function testIPNReturnsIssetForOffset() {
		$ipn = new IPN([], ['custom' => 'Hello, world']);

		$this->assertTrue(isset($ipn['custom']));
		$this->assertFalse(isset($ipn['mc_currency']));
	}

	function testIPNGetsOffset() {
		$ipn = new IPN([], ['custom' => 'Hello, world']);

		$this->assertEquals($ipn['custom'], 'Hello, world');
		$this->assertEquals($ipn['custom'], $ipn->getCustom());
	}

}
