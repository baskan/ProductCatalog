<?php
    // Filters go here sir.
    Route::filter('pageFilter', 'Davzie\ProductCatalog\Filters\Page'); // Used to authenticate admin users

    // Routing specific to the catalog system
    Route::controller( 'manage/attribute-sets' , 'Davzie\ProductCatalog\Controllers\AttributeSetsController' );
    Route::controller( 'manage/users' , 'Davzie\ProductCatalog\Controllers\UsersController' );
    Route::controller( 'manage/categories' , 'Davzie\ProductCatalog\Controllers\CategoriesController' );
    Route::controller( 'manage/products' , 'Davzie\ProductCatalog\Controllers\ProductsController' );
    Route::controller( 'manage' , 'Davzie\ProductCatalog\Controllers\ManageController' );