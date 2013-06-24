<?php
    App::bind('Davzie\ProductCatalog\Models\Interfaces\UserRepository','Davzie\ProductCatalog\Models\UserEloquent');

    Route::filter('pageFilter', 'Davzie\ProductCatalog\Filters\Page'); // Used to authenticate admin users

    // Routing specific to the catalog system
    Route::controller( 'manage' , 'Davzie\ProductCatalog\ManageController' );