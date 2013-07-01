<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Redirect;
use Validator;
use Input;
use File;
use Request;
use Response;
use Davzie\ProductCatalog\Models\Interfaces\ProductRepository;
use Davzie\ProductCatalog\Models\Interfaces\CategoryRepository;
use Davzie\ProductCatalog\Entities\ProductNew;
use Davzie\ProductCatalog\Entities\ProductEdit;
use Davzie\ProductCatalog\Entities\ProductUpload;

class ProductsController extends ManageBaseController {

    /**
     * The products object
     * @var ProductEloquent
     */
    protected $products;

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
    public function __construct( ProductRepository $products , CategoryRepository $categories ){
        $this->products = $products;
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
        return View::make( 'ProductCatalog::products.dashboard' )
                ->with( 'products' , $this->products->getAll() );
    }

    /**
     * Edit the product
     * @param       string  $sku    The SKU Of The Product To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null ){
        $product = $this->products->with('categories')->find($id);

        // Redirect all requests where the product doesn't exist back to the main products dashboard
        if( !$product )
            return Redirect::to('manage/products');

        // Get the top level categories only, we nest from the view itself
        $categories = $this->categories->getTopLevel();

        // Setup the old data so it's easy to find
        $mainImage = Input::old('mainImage',false);
        if( $mainImage === false )
            if( $product->getMainImage() )
                $mainImage = $product->getMainImage()->id;

        // Setup the old data so it's easy to find
        $thumbnailImage = Input::old('thumbnailImage',false);
        if( $thumbnailImage === false )
            if( $product->getThumbnailImage() )
                $thumbnailImage = $product->getThumbnailImage()->id;

        return View::make('ProductCatalog::products.edit')
                    ->with( 'product' , $product )
                    ->with( 'mainImageId' , $mainImage )
                    ->with( 'thumbnailImageId' , $thumbnailImage )
                    ->with( 'categories' , $categories );
    }

    /**
     * The new product page
     * @access public
     * @return View
     */
    public function getNew(){
        return View::make('ProductCatalog::products.new');
    }

    /**
     * Accept the input from the new product page
     * @return Redirect
     */
    public function postNew(){
        $entity = new ProductNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/products/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/products/edit/'.$id )->with('success','<strong>Product Added</strong> More information is required before you can activate the product.');
    }

    /**
     * Edit the product, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new ProductEdit( $id );
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/products/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $entity->hydrate();

        return Redirect::to( 'manage/products/edit/'.$id )->with('success','Product Updated.');
    }

    /**
     * Upload an image for this product ID
     * @return Redirect
     */
    public function postUpload( $id ){
        // This should only be accessible via AJAX you know...
        if( !Request::ajax() )
            Response::json('error', 400);

        $entity = new ProductUpload( $id );

        if ( $entity->isValid() === false )
            return Response::make( $entity->errors() , 400 );

        // Hydrate it with data from the POST
        $success = $entity->hydrate();

        if( $success )
            return Response::json('success', 200);
        else
            return Response::json('error', 400);

    }

}