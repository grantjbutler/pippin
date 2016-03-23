<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Sandbox Evnironments
	|--------------------------------------------------------------------------
	|
	| Here you can specify the environments in which IPNs should be validated
	| against PayPal's sandbox IPN validation service, instead of their
	| production IPN validation service.
	|
	*/
	'sandbox_environments' => [
		'development',
		'staging'
	],

	/*
	|--------------------------------------------------------------------------
	| Transport Class
	|--------------------------------------------------------------------------
	|
	| Here you can specify which Transport class to use when talking with
	| PayPal's IPN validation service. The class set here must implement the
	| Pippin\Transport interface. By default, the cURLTransport is used.
	|
	*/
	'transport_class' => Pippin\Transport\cURLTransport::class,

];
