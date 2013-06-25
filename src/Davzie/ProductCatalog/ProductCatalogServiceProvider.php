<?php namespace Davzie\ProductCatalog;

use Illuminate\Support\ServiceProvider;

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
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\UserRepository','Davzie\ProductCatalog\Models\UserEloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\ProductRepository','Davzie\ProductCatalog\Models\ProductEloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\CategoryRepository','Davzie\ProductCatalog\Models\CategoryEloquent');
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