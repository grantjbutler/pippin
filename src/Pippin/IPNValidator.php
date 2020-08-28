<?php

namespace Pippin;

use ReflectionClass;
use InvalidArgumentException;
use Exception;

use Pippin\Transport\TransportInterface;
use Pippin\Transport\cURLTransport;
use Pippin\IPNEnvironment;

final class IPNValidator {

	private $environment;
	private $transport;

	public function __construct($environment, TransportInterface $transport) {
		$this->setEnvironment($environment);
		$this->transport = $transport;
	}

	public function getEnvironment() {
		return $this->environment;
	}

	public function setEnvironment($environment) {
		IPNEnvironment::validateEnvironment($environment);

		$this->environment = $environment;
	}

	public function isValidIPN($IPNString) {
		$requestBody = 'cmd=_notify-validate&' . $IPNString;
		$url = IPNEnvironment::urlForEnvironment($this->environment);
		
		$result = $this->transport->request('POST', $url, $requestBody);

		return strcmp($result, "VERIFIED") == 0;
	}

}
