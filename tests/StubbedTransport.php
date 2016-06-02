<?php

use Pippin\Transport\TransportInterface;

class StubbedSuccessTransport implements TransportInterface {

	public function request($method, $url, $body) {
		return 'VERIFIED';
	}

}

class StubbedFailureTransport implements TransportInterface {

	public function request($method, $url, $body) {
		return 'INVALID';
	}

}
