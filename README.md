Laravel 4 Product Catalog
===============

We all know that developing with Magento can be a bit of a pain. This package aleviates the requirement to do so for simple sites that require just a catalog system that is managable through an admin backend.

Setup
---------------------
Once Laravel 4 is installed, navigate to the folder it is installed in and ensure you have a vendor director. Move into that directory and run:

    git clone git@github.com:davzie/ProductCatalog.git ./Davzie/ProductCatalog/
    php artisan migrate --package="Davzie/ProductCatalog"
    php artisan db:seed --class="Davzie\\ProductCatalog\\Seeds\\DatabaseSeeder" 
    php artisan asset:publish 'Davzie/ProductCatalog'
    
Those commands will:

* Setup your local vendor directory with a version controlled version of the backend system
* Setup your system to load all required libraries and routings
* Migrate your database setup to match what the backend system expects (see `app/config/database` for database setup first)
* Seed the required tables that were just migrated to allow for default data to be entered
* Publish the assets required (css, javascript etc) to the public directory of your application