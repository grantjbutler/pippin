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
	'environment' => env('PIPPIN_ENVIRONMENT', 'sandbox')

];
