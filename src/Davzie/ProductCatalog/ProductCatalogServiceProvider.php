<?php namespace Davzie\ProductCatalog;

use Illuminate\Support\ServiceProvider;
use Davzie\ProductCatalog\Commands\ClearCacheCommand;

class ProductCatalogServiceProvider extends ServiceProvider {

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
		$this->package('Davzie/ProductCatalog');
		include __DIR__.'/../../routes.php'; // Do some routing here specific to this package
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Davzie\ProductCatalog\User','Davzie\ProductCatalog\User\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Product','Davzie\ProductCatalog\Product\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Category','Davzie\ProductCatalog\Category\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Upload','Davzie\ProductCatalog\Upload\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Attribute','Davzie\ProductCatalog\Attribute\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Attribute\Set','Davzie\ProductCatalog\Attribute\Set\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Attribute\Type','Davzie\ProductCatalog\Attribute\Type\Repositories\Eloquent');

		// Register our clear cache commands etc
		$this->app['command.productcatalog.clearcache'] = $this->app->share(function($app)
	    {
	        return new ClearCacheCommand();
	    });
	 
	    $this->commands('command.productcatalog.clearcache');

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}