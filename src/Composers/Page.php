<?php
namespace Davzie\ProductCatalog\Composers;
use Auth;
use Session;

class Page{

    /**
     * Compose the view with the following variables bound do it
     * @param  View $view The View
     * @return null
     */
    public function compose($view)
    {
        $view->with('user', Auth::user())
             ->with('success',Session::get('success'));
    }

}