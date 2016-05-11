<?php

namespace Pippin\Transport;

use Psr\Http\Message\RequestInterface;

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

	public function request(RequestInterface $request) {
		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $request->getHeaders());
		curl_setopt($this->curl, CURLOPT_URL, (string)$request->getUri());

		$body = $request->getBody();
		if (!is_null($body)) {
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, (string)$body);
		}

		return curl_exec($this->curl);
	}

}
