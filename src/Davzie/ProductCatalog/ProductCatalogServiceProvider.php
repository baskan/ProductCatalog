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
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\UserRepository','Davzie\ProductCatalog\Models\UserEloquent');
		$this->app->bind('Davzie\ProductCatalog\Product','Davzie\ProductCatalog\Products\Repositories\Eloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\CategoryRepository','Davzie\ProductCatalog\Models\CategoryEloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\UploadRepository','Davzie\ProductCatalog\Models\UploadEloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\AttributeSetRepository','Davzie\ProductCatalog\Models\AttributeSetEloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\AttributeTypeRepository','Davzie\ProductCatalog\Models\AttributeTypeEloquent');
		$this->app->bind('Davzie\ProductCatalog\Models\Interfaces\AttributeRepository','Davzie\ProductCatalog\Models\AttributeEloquent');

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