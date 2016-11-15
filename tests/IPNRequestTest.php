<?php

require_once('StubbedTransport.php');

use Pippin\IPNEnvironment;
use Pippin\IPNValidator;
use Pippin\IPNRequest;

class IPNRequestTest extends PHPUnit_Framework_TestCase {

	function testIsIPNValid() {
		$validator = new IPNValidator();
		$validator->setTransportClass(StubbedSuccessTransport::class);

		$request = new IPNRequest($validator);
		$request->initialize([], [
			'mc_gross' => '17000',
			'mc_currency' => 'USD',
			'txn_id' => 'X93NOE56',
			'payment_status' => 'Completed',
			'receiver_email' => 'han.solo@milleniumfalcon.com',
		], [], [], [], [
			'REQUEST_METHOD' => 'POST'
		], 'mc_gross=17000&mc_currency=USD&txn_id=X93NOE56&payment_status=Completed&receiver_email=han.solo@milleniumfalcon.com');

		$this->assertTrue($request->authorize());

		$ipn = $request->getIPN();
		$this->assertNotNull($ipn);
		$this->assertEquals($ipn->getData()['mc_gross'], '17000');
	}

	function testIsIPNInvalid() {
		$validator = new IPNValidator();
		$validator->setTransportClass(StubbedFailureTransport::class);

		$request = new IPNRequest($validator);
		$request->initialize([], [
			'mc_gross' => '17000',
			'mc_currency' => 'USD',
			'txn_id' => 'X93NOE56',
			'payment_status' => 'Completed',
			'receiver_email' => 'han.solo@milleniumfalcon.com'
		], [], [], [], [
			'REQUEST_METHOD' => 'POST'
		], 'mc_gross=17000&mc_currency=USD&txn_id=X93NOE56&payment_status=Completed&receiver_email=han.solo@milleniumfalcon.com');

		$this->assertFalse($request->authorize());
		$this->assertNull($request->getIPN());
	}

}
