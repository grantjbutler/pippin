<?php

namespace Pippin;

use ReflectionClass;
use InvalidArgumentException;
use Exception;

use Pippin\Transport\TransportInterface;
use Pippin\Transport\cURLTransport;
use Pippin\IPNEnvironment;
use Pippin\IPNValidationRequestBuilder;

final class IPNValidator {

	private $environment;
	private $transportClass;

	public function __construct($environment = IPNEnvironment::SANDBOX) {
		$this->setEnvironment($environment);
		$this->setTransportClass(cURLTransport::class);
	}

	protected static function isValidTransportClass($transportClass) {
		try {
			return (new ReflectionClass($transportClass))->implementsInterface('Pippin\Transport\TransportInterface');
		}
		catch (Exception $e) {
			return false;
		}
	}

	public function getEnvironment() {
		return $this->environment;
	}

	public function setEnvironment($environment) {
		IPNEnvironment::validateEnvironment($environment);

		$this->environment = $environment;
	}

	public function getTransportClass() {
		return $this->transportClass;
	}

	public function setTransportClass($transportClass) {
		if (!static::isValidTransportClass($transportClass)) {
			throw new InvalidArgumentException('Transport class "' . $transportClass . '" does not implement Pippin\Transport\TransportInterface.');
		}

		$this->transportClass = $transportClass;
	}

	public function isValidIPN($IPNString) {
		$request = IPNValidationRequestBuilder::request($this->getEnvironment(), $IPNString);

		$transportClass = $this->getTransportClass();
		$transport = new $transportClass();
		$result = $transport->request($request);

		return strcmp($result, "VERIFIED") == 0;
	}

}
