<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Redirect;
use Validator;
use Input;
use File;
use Response;
use Davzie\ProductCatalog\Models\Interfaces\ProductRepository;
use Davzie\ProductCatalog\Models\Interfaces\CategoryRepository;
use Davzie\ProductCatalog\Entities\ProductNew;
use Davzie\ProductCatalog\Entities\ProductEdit;

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
        $categories = $this->categories->getTopLevel();
        if( !$product )
            return Redirect::to('manage/products');

        return View::make('ProductCatalog::products.edit')
                    ->with( 'product' , $product )
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