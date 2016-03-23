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
		$request->initialize([], ['mc_currency' => '17000'], [], [], [], [
			'REQUEST_METHOD' => 'POST'
		], 'mc_currency=17000');

		$this->assertTrue($request->authorize());

		$ipn = $request->getIPN();
		$this->assertNotNull($ipn);
		$this->assertEquals($ipn->getData()['mc_currency'], '17000');
	}

	function testIsIPNInvalid() {
		$validator = new IPNValidator();
		$validator->setTransportClass(StubbedFailureTransport::class);

		$request = new IPNRequest($validator);
		$request->initialize([], ['mc_currency' => '17000'], [], [], [], [
			'REQUEST_METHOD' => 'POST'
		], 'mc_currency=17000');

		$this->assertFalse($request->authorize());
		$this->assertNull($request->getIPN());
	}

}
