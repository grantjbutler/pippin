<?php

namespace Pippin;

use Zend\Diactoros\Request;
use Pippin\IPNEnvironment;

final class IPNValidationRequestBuilder {

	public static function request($environment, $IPNString) {
		$requestBody = 'cmd=_notify-validate&' . $IPNString;
		$url = IPNEnvironment::urlForEnvironment($environment);
		return new Request($url, 'POST', 'data://text/plain,' . $requestBody);
	}

}
