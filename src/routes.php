<?php
    App::bind('Davzie\ProductCatalog\Models\Interfaces\UserRepository','Davzie\ProductCatalog\Models\UserEloquent');
    App::bind('Davzie\ProductCatalog\Models\Interfaces\ProductRepository','Davzie\ProductCatalog\Models\ProductEloquent');
    App::bind('Davzie\ProductCatalog\Models\Interfaces\CategoryRepository','Davzie\ProductCatalog\Models\CategoryEloquent');

    // Filters go here sir.
    Route::filter('pageFilter', 'Davzie\ProductCatalog\Filters\Page'); // Used to authenticate admin users

    // Routing specific to the catalog system
    Route::controller( 'manage/categories' , 'Davzie\ProductCatalog\Controllers\CategoriesController' );
    Route::controller( 'manage/products' , 'Davzie\ProductCatalog\Controllers\ProductsController' );
    Route::controller( 'manage' , 'Davzie\ProductCatalog\Controllers\ManageController' );