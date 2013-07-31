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
use App;
use Davzie\ProductCatalog\Product;
use Davzie\ProductCatalog\Category;
use Davzie\ProductCatalog\Attribute;
use Davzie\ProductCatalog\Attribute\Set as AttributeSet;
use Davzie\ProductCatalog\Product\Entities\Create;
use Davzie\ProductCatalog\Product\Entities\Edit;
use Davzie\ProductCatalog\Product\Entities\Upload;


class ProductsController extends ManageBaseController {

    /**
     * The products object
     * @var Product
     */
    protected $products;

    /**
     * The categories object
     * @var Category
     */
    protected $categories;

    /**
     * The attribute sets object
     * @var Davzie\ProductCatalog\Attribute\Set
     */
    protected $attribute_sets;

    /**
     * The attribute object
     * @var Attribute
     */
    protected $attributes;

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
    public function __construct( Product $products , Category $categories , AttributeSet $attribute_sets , Attribute $attributes ){
        $this->products = $products;
        $this->categories = $categories;
        $this->attributes = $attributes;
        $this->attribute_sets = $attribute_sets;
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
                ->with( 'products' , $this->products->all() );
    }

    /**
     * Edit the product
     * @param       string  $sku    The SKU Of The Product To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null ){
        $product = $this->products->with('categories')->with('attributeSet')->find($id);

        // Redirect all requests where the product doesn't exist back to the main products dashboard
        if( !$product )
            return Redirect::to('manage/products');

        // Get the top level categories only, we nest from the view itself
        $categories = $this->categories->getTopLevel();
        $attribute_sets = [ 0 => 'None' ] + $this->attribute_sets->getAll()->lists('name','id');

        // Setup the old data so it's easy to find
        $mainImage = Input::old('mainImage',false);
        if( $mainImage === false and $product->getMainImage() )
                $mainImage = $product->getMainImage()->id;

        // Setup the old data so it's easy to find
        $thumbnailImage = Input::old('thumbnailImage',false);
        if( $thumbnailImage === false and $product->getThumbnailImage() )
                $thumbnailImage = $product->getThumbnailImage()->id;


        // We need to render the attribute views that we can edit for the product, lets see if our product actually has attributes first
        $attributeViews = [];
        if( $product->getAvailableAttributes() ){

            // Setup our old data
            $oldData = Input::old( 'attributes' , [] );

            // Loop through the attributes
            foreach($product->getAvailableAttributes() as $attribute){

                // Get the attribute object so we can access certain methods
                $attr = $this->attributes->find( $attribute->id );
                if($attr){

                    // Old data should override stored data, lets ensure that happens here
                    $old = array_key_exists( $attribute->id , $oldData ) ? $oldData[ $attribute->id ] : null;
                    if( $old === null ){
                        $saved_value = $product->getAttrValue( $attribute->id );
                        if( !$saved_value or $saved_value == '' ){
                            $value = $attribute->default;
                        }else{
                            $value = $saved_value;
                        }

                    }else{
                        $value = $old;
                    }
                    
                    // Render the resulting view into an array that we eventually render
                    $attributeViews[] = View::make( 'ProductCatalog::products.partials.attributes.'.$attr->type()->getViewName() )
                                            ->with( 'attribute' , $attr )
                                            ->with( 'value'     , $value);
                }

            }

        }

        // Make the end view, whoop!
        return View::make('ProductCatalog::products.edit')
                    ->with( 'product' , $product )
                    ->with( 'attributeViews' , $attributeViews )
                    ->with( 'mainImageId' , $mainImage )
                    ->with( 'attribute_sets' , $attribute_sets )
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
     * Delete a category based on the ID passed in
     * @param  integer $id The category ID
     * @return Redirect
     */
    public function getDelete( $id ){
        $this->products->deleteById($id);
        return Redirect::to('manage/products')->with('success','<strong>Product Deleted</strong> The product was properly removed.');
    }

    /**
     * Accept the input from the new product page
     * @return Redirect
     */
    public function postNew(){
        $entity = new Create();
        
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
        $entity = new Edit( $id );
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/products/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $entity->hydrate();

        return Redirect::to( 'manage/products/edit/'.$id )->with('success','Product Updated.');
    }

    /**
     * Upload an image for this product ID
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

}