<?php

namespace Pippin;

use Pippin\IPN;

final class IPNParser {

	public function parse($IPNString) {
		$IPNData = [];
		$pairs = explode('&', $IPNString);
		foreach ($pairs as $pair) {
			$keyValue = explode('=', $pair);
			if (count($keyValue) == 2) {
				$IPNData[urldecode($keyValue[0])] = urldecode($keyValue[1]);
			}
		}

		return new IPN($IPNData);
	}

}
