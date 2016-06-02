<?php

namespace Pippin\Transport;

interface TransportInterface {

	public function request($method, $url, $body);

}
