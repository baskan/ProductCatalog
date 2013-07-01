<?php
namespace Davzie\ProductCatalog\Entities;
use App;
use Input;
use Str;
class ProductEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\ProductRepository';

    protected static $rules = [
        'id'        => 'required|integer|exists:products,id',
        'title'     => 'required|max:255',
        'price'     => 'required|numeric',
        'enabled'   => 'integer',
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['sku'] = 'required|alpha_dash|unique:products,sku,'.$currentId;
        static::$rules['url'] = 'required|alpha_dash|unique:products,url,'.$currentId;

        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('title') , '-' );

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
        $uploadModel = App::make('Davzie\ProductCatalog\Models\Interfaces\UploadRepository');
        $uploadModel->deleteById( Input::get('deleteImage') );

        return true;
    }

}