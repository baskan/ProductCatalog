<?php
    
    // Routing specific to the catalog system
    Route::controller( Config::get('ProductCatalog::app.route') , 'Davzie\ProductCatalog\ManageController' );