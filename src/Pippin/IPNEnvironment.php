<?php

namespace Pippin;

use InvalidArgumentException;

final class IPNEnvironment {

	const PRODUCTION = 'production';
	const SANDBOX = 'sandbox';

	static function validateEnvironment($environment) {
		if ($environment != static::PRODUCTION &&
			$environment != static::SANDBOX) {
			throw new InvalidArgumentException('Unknown environment "' . $environment . '".');
		}
	}

	static function urlForEnvironment($environment) {
		self::validateEnvironment($environment);

		if ($environment == static::PRODUCTION) {
			return 'https://www.paypal.com/cgi-bin/webscr';
		}
		else if ($environment == static::SANDBOX) {
			return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
	}

}
