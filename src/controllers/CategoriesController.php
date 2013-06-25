<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Redirect;
use Validator;
use Input;
use Davzie\ProductCatalog\Models\CategoryEloquent;

class CategoriesController extends ManageBaseController {

    /**
     * The categories object
     * @var CategoryEloquent
     */
    protected $categories;

    /**
     * Let's whitelist all the methods we want to allow guests to visit!
     *
     * @access   protected
     * @var      array
     */
    protected $whitelist = [];

    /**
     * Construct shit
     */
    public function __construct( CategoryEloquent $categories ){
        $this->categories = $categories;
        parent::__construct();
    }

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        return View::make( 'ProductCatalog::categories.dashboard' )
                ->with( 'categories' , $this->categories->getAll() );
    }

    /**
     * Edit the category
     * @param       string  $sku    The Slug Of The Category To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $slug = null ){
        $category = $this->categories->getBySlug($slug);
        if( !$category )
            return Redirect::to('manage/categories');

        return View::make('ProductCatalog::categories.edit')
                    ->with( 'category' , $category );
    }

}