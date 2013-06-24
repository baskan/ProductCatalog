<?php
    Route::filter('pageFilter', 'Davzie\ProductCatalog\Filters\Page'); // Used to authenticate admin users

    // Routing specific to the catalog system
    Route::controller( 'manage' , 'Davzie\ProductCatalog\ManageController' );