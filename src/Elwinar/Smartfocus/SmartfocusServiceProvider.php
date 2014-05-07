<?php namespace Elwinar\Smartfocus;

use Illuminate\Support\ServiceProvider;

class SmartfocusServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('elwinar/smartfocus');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('smartfocus.datamassupdate', function()
		{
			return new DataMassUpdate;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('smartfocus.datamassupdate');
	}

}
