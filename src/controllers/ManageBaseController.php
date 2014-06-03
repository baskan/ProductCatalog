<?php
namespace Davzie\ProductCatalog\Controllers;
use \Illuminate\Routing\Controller;
use View;

class ManageBaseController extends Controller{

    protected $whitelist = array();

    /**
     * Initializer.
     *
     * @access   public
     * @return   void
     */
    public function __construct()
    {
        $this->beforeFilter('pageFilter', array('except' => $this->whitelist));
        $composed_views = [
            'ProductCatalog::*'
        ];
        View::composer($composed_views, 'Davzie\ProductCatalog\Composers\Page');
    }

}