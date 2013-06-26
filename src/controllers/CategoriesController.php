<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Redirect;
use Validator;
use Input;
use Davzie\ProductCatalog\Models\Interfaces\CategoryRepository;
use Davzie\ProductCatalog\Entities\CategoryNew;

class CategoriesController extends ManageBaseController {

    /**
     * The categories object
     * @var CategoryRepository
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
    public function __construct( CategoryRepository $categories ){
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

    /**
     * Accept the input from the new category page
     * @return Redirect
     */
    public function postNew(){
        $entity = new CategoryNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/categories/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/categories/edit/'.$id )->with('success','<strong>Category Added</strong> Fill out the description field to show category specific data on category pages.');
    }

    /**
     * The new product page
     * @access public
     * @return View
     */
    public function getNew(){
        return View::make('ProductCatalog::categories.new');
    }


}