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

		if (array_key_exists('charset', $IPNData) && is_string($IPNData['charset'])) {
			$charset = $IPNData['charset'];
			foreach ($IPNData as $key => $value) {
				$IPNData[$key] = mb_convert_encoding($value, 'utf-8', $charset);
			}
		}

		$transactions = TransactionFactory::transactionsFromIPNData($IPNData);

		return new IPN($transactions, $IPNData);
	}

}
