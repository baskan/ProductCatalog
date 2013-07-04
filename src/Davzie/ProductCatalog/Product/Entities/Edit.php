<?php
namespace Davzie\ProductCatalog\Product\Entities;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Str;
use Davzie\ProductCatalog\Entity;

class Edit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Product';

    protected static $rules = [
        'id'                    => 'required|integer|exists:products,id',
        'title'                 => 'required|max:255',
        'price'                 => 'required|numeric',
        'attribute_set_id'      => 'integer|exists:attribute_sets,id',
        'enabled'               => 'integer',
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['sku'] = 'required|alpha_dash|unique:products,sku,'.$currentId;
        static::$rules['url'] = 'required|alpha_dash|unique:products,url,'.$currentId;

        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('title') , '-' );


        // If we have a 0 through on attribute set ID then we can assume the user has not chosen anything
        if( Input::get('attribute_set_id') == 0 ){
            unset( static::$rules['attribute_set_id'] );
            static::$defaultData['attribute_set_id'] = null;
        }

        parent::__construct();
    }

    /**
     * Run our own hydration stuffs
     * @return boolean
     */
    public function hydrate(){
        parent::hydrate();
        $productModel = App::make( static::$model )->find( $this->currentId );
        
        $productModel->categories()->sync( Input::get('categories', []) );
        $productModel->setMainImage( Input::get('mainImage') );
        $productModel->setThumbnailImage( Input::get('thumbnailImage') );
        $productModel->setGalleryImages( Input::get('hideFromGallery') );

        // Ensure that the product images that need to be deleted get deleted
        $uploadModel = App::make('Davzie\ProductCatalog\Upload');
        $uploadModel->deleteById( Input::get('deleteImage') );

        return true;
    }

}