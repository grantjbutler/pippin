<?php

namespace Pippin\Transport;

use Psr\Http\Message\RequestInterface;

interface TransportInterface {

	public function request(RequestInterface $request);

}
