<?php

use Pippin\IPNValidationRequestBuilder;
use Pippin\IPNEnvironment;

class IPNValidationRequestBuilderTest extends PHPUnit_Framework_TestCase {

	function testBuilderBuildsRequest() {
		$IPNString = 'mc_currency=17000';
		$environment = IPNEnvironment::PRODUCTION;

		$request = IPNValidationRequestBuilder::request($environment, $IPNString);
		$this->assertEquals($request->getMethod(), 'POST');
		$this->assertEquals((string)$request->getBody(), 'cmd=_notify-validate&mc_currency=17000');
		$this->assertEquals((string)$request->getUri(), IPNEnvironment::urlForEnvironment($environment));
	}

}
