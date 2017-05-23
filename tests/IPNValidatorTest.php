<?php

require_once('StubbedTransport.php');

use Pippin\IPNEnvironment;
use Pippin\IPNValidator;
use Pippin\Transport\cURLTransport;

use PHPUnit\Framework\TestCase;

class IPNValidatorTest extends TestCase {

	function testEnvironmentIsSet() {
		$validator = new IPNValidator();
		$this->assertEquals($validator->getEnvironment(), IPNEnvironment::SANDBOX);

		$validator->setEnvironment(IPNEnvironment::PRODUCTION);
		$this->assertEquals($validator->getEnvironment(), IPNEnvironment::PRODUCTION);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	function testExceptionIsThrownOnInvalidEnvironment() {
		$validator = new IPNValidator();
		$validator->setEnvironment("STAGING");
	}

	function testTransportClassIsSet() {
		$validator = new IPNValidator();
		$this->assertEquals($validator->getTransportClass(), cURLTransport::class);

		$validator->setTransportClass(StubbedSuccessTransport::class);
		$this->assertEquals($validator->getTransportClass(), StubbedSuccessTransport::class);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	function testExceptionIsThrownOnInvalidTransportClass() {
		$validator = new IPNValidator();
		$validator->setTransportClass(IPNValidatorTest::class);
	}

	function testIsIPNValid() {
		$validator = new IPNValidator();
		$validator->setTransportClass(StubbedSuccessTransport::class);

		$this->assertTrue($validator->isValidIPN('mc_currency=17000'));
	}

	function testIsIPNInvalid() {
		$validator = new IPNValidator();
		$validator->setTransportClass(StubbedFailureTransport::class);

		$this->assertFalse($validator->isValidIPN('mc_currency=17000'));
	}

}
