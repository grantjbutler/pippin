<?php

use Psr\Http\Message\RequestInterface;
use Pippin\Transport\TransportInterface;

class StubbedSuccessTransport implements TransportInterface {

	public function request(RequestInterface $request) {
		return 'VERIFIED';
	}

}

class StubbedFailureTransport implements TransportInterface {

	public function request(RequestInterface $request) {
		return 'INVALID';
	}

}
