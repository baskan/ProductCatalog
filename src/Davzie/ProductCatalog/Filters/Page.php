<?php
namespace Davzie\ProductCatalog\Filters;
use Auth;
use Redirect;

class Page {

    /**
     * If the user is not logged in or is a customer only then we need to get them outta here.
     * @return mixed
     */
    public function filter()
    {

        if ( Auth::guest() )
            return Redirect::guest('manage/login');

    }

}