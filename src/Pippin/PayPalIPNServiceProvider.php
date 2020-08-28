<?php

namespace Pippin;

use Illuminate\Support\ServiceProvider;

use Pippin\IPNValidator;
use Pippin\IPNEnvironment;

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
		
		$this->app->bind(Pippin\Transport\TransportInterface::class, Pippin\Transport\cURLTransport::class);

		$this->app->bind(IPNValidator::class, function ($app) {
			return new IPNValidator(config('pippin.environment'), $app->make(Pippin\Transport\TransportInterface::class));
		});
	}

}
