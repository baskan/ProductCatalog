Laravel 4 Product Catalog
===============

We all know that developing with Magento can be a bit of a pain. This package aleviates the requirement to do so for simple sites that require just a catalog system that is managable through an admin backend.

Setup Your Composer JSON File
---------------------
Once Laravel 4 is installed, navigate to the root of the installation and edit your composer.json so that your require has this package in it and you also have the "repositories" section which tells composer to pull the repository from Github directly rather than trying to find it on Packagist:

    "require": {
        "laravel/framework": "4.0.*",
        "Davzie/ProductCatalog":"*"
    },
    "repositories":[
        {
            "type":"git",
            "url":"git@github.com:davzie/ProductCatalog.git"
        }
    ],

Great! Now run:

    composer update

You should see the dependancies now install themselves. Like magic!

Setting Up Your Local Installation (Service Providers and Auth)
---------------------
Now we need to add our service provider for the package into your local installation. Edit `app/config/app.php` and add this to the 'providers' key:

    'Davzie\ProductCatalog\ProductCatalogServiceProvider'

In app/config/auth.php Change The 'Model' Key To:

    'Davzie\ProductCatalog\User\Repositories\Eloquent'

Fantastic. Now your installation can:

* Access the package and all classes and setup commands etc
* Authentication now uses the package's model meaning you *could* delete app/models/User.php 

Last Steps: Migrations, Seeds and Publishing Assets
------------------------------------
In order to have our package work as-expected with all images, CSS and JS working we need to publish the assets to our public directory. Fortunately Laravel makes this extremely easy:
    
    php artisan asset:publish 'Davzie/ProductCatalog'

Let's also migrate and seed our database so that it has the required tables (ensure app/config/database.php is up-to-date):

    php artisan migrate --package="Davzie/ProductCatalog"
    php artisan db:seed --class="Davzie\\ProductCatalog\\Seeds\\DatabaseSeeder" 

    
That's it, you're done!