<?php

require_once('StubbedTransport.php');

use Pippin\IPNEnvironment;
use Pippin\IPNValidator;
use Pippin\Transport\cURLTransport;

use PHPUnit\Framework\TestCase;

class IPNValidatorTest extends TestCase {

	function testEnvironmentIsSet() {
		$validator = new IPNValidator(IPNEnvironment::SANDBOX, new StubbedSuccessTransport());
		$this->assertEquals($validator->getEnvironment(), IPNEnvironment::SANDBOX);

		$validator->setEnvironment(IPNEnvironment::PRODUCTION, new StubbedSuccessTransport());
		$this->assertEquals($validator->getEnvironment(), IPNEnvironment::PRODUCTION);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	function testExceptionIsThrownOnInvalidEnvironment() {
		$validator = new IPNValidator(IPNEnvironment::SANDBOX, new StubbedSuccessTransport());
		$validator->setEnvironment("STAGING");
	}

	function testIsIPNValid() {
		$validator = new IPNValidator(IPNEnvironment::SANDBOX, new StubbedSuccessTransport());

		$this->assertTrue($validator->isValidIPN('mc_currency=17000'));
	}

	function testIsIPNInvalid() {
		$validator = new IPNValidator(IPNEnvironment::SANDBOX, new StubbedFailureTransport());

		$this->assertFalse($validator->isValidIPN('mc_currency=17000'));
	}

}
