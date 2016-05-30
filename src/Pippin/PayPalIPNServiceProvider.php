<?php

namespace Pippin;

use Illuminate\Support\ServiceProvider;

use Pippin\IPNValidator;
use Pippin\IPNEnvironment;

final class PayPalIPNServiceProvider extends ServiceProvider {

	private function environmentFromConfig() {
		$appEnvironment = app()->environment();
		$sandboxEnvironments = config('pippin.sandbox_environments');
		if (in_array($appEnvironment, $sandboxEnvironments)) {
			return IPNEnvironment::SANDBOX;
		}

		return IPNEnvironment::PRODUCTION;
	}

	/**
     * Register bindings in the container.
     *
     * @return void
     */
	public function boot() {
		$this->publishes([
			__DIR__ . '/resources/config/pippin.php' => config_path('pippin.php')
		]);
		
		$self = $this;
		$this->app->singleton(IPNValidator::class, function($app) use($self) {
			$environment = $self->environmentFromConfig();
			$validator = new IPNValidator($environment);
			$validator->setTransportClass(config('pippin.transport_class'));
			return $validator;
		});
	}

}
