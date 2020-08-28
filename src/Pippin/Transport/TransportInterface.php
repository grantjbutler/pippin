<?php

namespace Pippin\Transport;

interface TransportInterface {

	public function request(string $method, string $url, string $body): string;

}
