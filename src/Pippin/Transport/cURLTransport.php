<?php

namespace Pippin\Transport;

use RuntimeException;

class cURLTransport implements TransportInterface {

	private $curl;

	public function __construct() {
		if (!extension_loaded('curl')) {
			throw new RuntimeException('The cURL extension must be installed to use the cURLTransport class.');
		}

		$this->curl = curl_init();

		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($this->curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
	}

	public function request($method, $url, $body) {
		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);

		return curl_exec($this->curl);
	}

}
