<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Redirect;
use Validator;
use Input;
use Davzie\ProductCatalog\Models\Interfaces\ProductRepository;
use Davzie\ProductCatalog\Entities\ProductNew;
use Davzie\ProductCatalog\Entities\ProductEdit;

class ProductsController extends ManageBaseController {

    /**
     * The products object
     * @var ProductEloquent
     */
    protected $products;

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
    public function __construct( ProductRepository $products ){
        $this->products = $products;
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
        $product = $this->products->find($id);
        if( !$product )
            return Redirect::to('manage/products');

        return View::make('ProductCatalog::products.edit')
                    ->with( 'product' , $product );
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
        $id = $entity->hydrate();
        return Redirect::to( 'manage/products/edit/'.$id )->with('success','Product Updated.');
    }

}