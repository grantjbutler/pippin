<?php

use Pippin\Transport\TransportInterface;

class StubbedSuccessTransport implements TransportInterface {

	public function request(string $method, string $url, string $body): string {
		return 'VERIFIED';
	}

}

class StubbedFailureTransport implements TransportInterface {

	public function request(string $method, string $url, string $body): string {
		return 'INVALID';
	}

}
