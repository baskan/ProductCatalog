<?php
namespace Davzie\ProductCatalog\Controllers;
use View;
use Redirect;
use Request;
use Response;
use Input;
use App;
use Davzie\ProductCatalog\Category;
use Davzie\ProductCatalog\Collection;
use Davzie\ProductCatalog\Category\Entities\Create as CategoryNew;
use Davzie\ProductCatalog\Category\Entities\Edit as CategoryEdit;
use Davzie\ProductCatalog\Category\Entities\Upload;

class CategoriesController extends ManageBaseController {

    /**
     * The categories object
     * @var Category
     */
    protected $categories;

    /**
     * The collections object
     * @var Collection
     */
    protected $collections;

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
    public function __construct( Category $categories , Collection $collections ){
        $this->categories = $categories;
        $this->collections = $collections;
        parent::__construct();
    }

    /**
     * Delete a category based on the ID passed in
     * @param  integer $id The category ID
     * @return Redirect
     */
    public function getDelete( $id ){
        $this->categories->deleteById( $id );
        return Redirect::to('manage/categories')->with('success','<strong>Category Deleted</strong> The category was properly removed.');
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
                ->with( 'orderedCategoriesHTML' , $this->categories->displayOrderedAdminHTML() )
                ->with( 'orderedCategories' , $this->categories->all() );
    }

    /**
     * Edit the category
     * @param       string  $sku    The Slug Of The Category To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null ){
        $category = $this->categories->find($id);
        if( !$category )
            return Redirect::to('manage/categories');

        // Determine if the category parent should be disabled or not
        $hasSubCategories = $category->hasChildren();
        $categoryDropdown = $this->getCategoriesDropdownHTML();

        // Setup the old data so it's easy to find
        $mainImage = Input::old('mainImage',false);
        if( $mainImage === false and $category->getMainImage() )
                $mainImage = $category->getMainImage()->id;

        // Setup the old data so it's easy to find
        $thumbnailImage = Input::old('thumbnailImage',false);
        if( $thumbnailImage === false and $category->getThumbnailImage() )
                $thumbnailImage = $category->getThumbnailImage()->id;

        // Get all collections that have products
        $collections = $this->collections->allWithProducts();
        $collections_lists = [ 0 => 'Assign Collection' ] + $collections->lists('name','id');

        return View::make('ProductCatalog::categories.edit')
                    ->with( 'category' , $category )
                    ->with( 'mainImageId' , $mainImage )
                    ->with( 'collections' , $collections )
                    ->with( 'collections_lists' , $collections_lists )
                    ->with( 'thumbnailImageId' , $thumbnailImage )
                    ->with( 'categoryDropdown' , $categoryDropdown )
                    ->with( 'hasSubCategories' , $hasSubCategories );
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
        return Redirect::to( 'manage/categories/' )->with('success','<strong>Category Added</strong> Fill out the description field to show category specific data on category pages.');
    }

    /**
     * The new product page
     * @access public
     * @return View
     */
    public function getNew(){
        $categoryDropdown = $this->getCategoriesDropdownHTML();

        return View::make('ProductCatalog::categories.new')
                    ->with( 'categoryDropdown' , $categoryDropdown );
    }

    /**
     * Edit the product, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new CategoryEdit( $id );

        if ( $entity->isValid() === false )
            return Redirect::to('manage/categories/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $entity->hydrate();
        return Redirect::to( 'manage/categories/' )->with('success','Category Updated.');
    }

    /**
     * Upload an image for this category ID
     * @return Response
     */
    public function postUpload( $id ){
        // This should only be accessible via AJAX you know...
        if( !Request::ajax() )
            Response::json('error', 400);

        $entity = new Upload( $id );

        if ( $entity->isValid() === false )
            return Response::make( $entity->errors() , 400 );

        // Hydrate it with data from the POST
        $success = $entity->hydrate();

        if( $success )
            return Response::json('success', 200);
        else
            return Response::json('error', 400);

    }

    /**
     * Set the order of the images
     * @return Response
     */
    public function postOrderImages(){
        // This should only be accessible via AJAX you know...
        if( !Request::ajax() )
            Response::json('error', 400);

        // Ensure that the product images that need to be deleted get deleted
        $uploadModel = App::make('Davzie\ProductCatalog\Upload');
        $uploadModel->setOrder( Input::get('data') );

        return Response::json('success', 200);
    }

    /**
     * Get the list of available options for use in the categories dropdown menu
     * @return array
     */
    private function getCategoriesDropdownHTML(){
        $list = array( 0 => 'None (Top Level)' );
        foreach( $this->categories->getFlattenedCategories() as $category ){
            $list[ $category->id ] = $category->getLevelIndicator('-') . ' ' . $category->name;
        }
        return $list;
    }

}