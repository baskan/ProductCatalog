<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Redirect;
use Validator;
use Input;
use Davzie\ProductCatalog\Models\ProductEloquent;

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
    public function __construct( ProductEloquent $products ){
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
    public function getEdit( $sku = null ){
        $product = $this->products->getBySku($sku);
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
        return $_POST;
    }

}