<?php namespace App\Providers;

/**
 * Class HasherServiceProvider
 *
 * @author Justin Bevan justin@smokerschoiceusa.com
 * @package App\Providers
 */

use Illuminate\Support\ServiceProvider;
use App\Services\Hasher\Hasher;

class HasherServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Package boot method
	 */
	public function boot()
	{
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerHasher();
	}

	/**
	 * Register the application bindings.
	 *
	 * @return void
	 */
	private function registerHasher()
	{
		$this->app->bind('hasher', function ($app) {
			return new Hasher($app);
		});
	}
}