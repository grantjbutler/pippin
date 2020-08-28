<?php

namespace Pippin;

use Illuminate\Support\ServiceProvider;

use Pippin\IPNValidator;
use Pippin\IPNEnvironment;
use Pippin\Transport\TransportInterface;
use Pippin\Transport\cURLTransport;

final class PayPalIPNServiceProvider extends ServiceProvider {
	
	public function register () {
		// Nothing to register. Intentially empty.
	}

	/**
     * Register bindings in the container.
     *
     * @return void
     */
	public function boot() {
		$this->publishes([
			__DIR__ . '/resources/config/pippin.php' => config_path('pippin.php')
		], 'config');
		
		$this->app->bind(TransportInterface::class, cURLTransport::class);

		$this->app->bind(IPNValidator::class, function ($app) {
			return new IPNValidator(config('pippin.environment'), $app->make(TransportInterface::class));
		});
	}

}
