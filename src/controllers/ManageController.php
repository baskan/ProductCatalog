<?php
namespace Davzie\ProductCatalog;
use View;
class ManageController extends ManageBaseController {

    public function getIndex()
    {
        return View::make('ProductCatalog::login');
    }

}