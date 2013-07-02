<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use App;
use Davzie\ProductCatalog\Models\Interfaces\ProductRepository;

class ProductEloquent extends Eloquent implements ProductRepository {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = [];

    /**
     * Get all the products in the system
     * @return Eloquent
     */
    public function getAll(){
        return $this->all();
    }

    /**
     * Get the active products
     * @return Eloquent
     */
    public function scopeactiveProducts($query){
        return $query->where('enabled', '=', true);
    }


    /**
     * Get the full price of the product (delivery, tax and product cost)
     * @return string
     */
    public function getFullPrice(){
        return $this->price;
    }

    /**
     * Get a product by its SKU
     * @param  string $sku The Product SKU
     * @return Eloquent    The product found
     */
    public function getBySku( $sku ){
        return $this->where('sku','=',$sku)->first();
    }

    /**
     * The categories available in this product
     * @return Eloquent
     */
    public function categories(){
        return $this->belongsToMany( 'Davzie\ProductCatalog\Models\CategoryEloquent' , 'product_categories' , 'product_id' , 'category_id' );
    }

    /**
     * The media object to get the uploads available
     * @return Eloquent
     */
    public function media(){
        return $this->morphMany( 'Davzie\ProductCatalog\Models\UploadEloquent' , 'link')->orderBy('order','asc');
    }

    /**
     * Get the image to be used as a thumbnail for this product
     * @return Eloquent
     */
    public function getThumbnailImage(){
        return $this->media()->where('thumbnail_image' , '=' , true)->first();
    }

    /**
     * Get the main image that will be used (usually the first image / hero image)
     * @return Eloquent
     */
    public function getMainImage(){
        return $this->media()->where('main_image' , '=' , true)->first();
    }

    /**
     * Get the images that can be used in the gallery
     * @return Eloquent
     */
    public function getGalleryImages(){
        return $this->media()->where('gallery' , '=' , true)->get();
    }

    /**
     * Set the main image for this product to the upload ID passed in
     * @param   integer $uploadId The upload ID
     * @return  boolean
     */
    public function setMainImage( $uploadId ){
        $this->media()->update( [ 'main_image' => false ] );
        $this->media()->where('id','=',$uploadId)->update( [ 'main_image' => true ] );
    }

    /**
     * Set the thumbnail image for this product to the upload ID passed in
     * @param   integer $uploadId The upload ID
     * @return  boolean
     */
    public function setThumbnailImage( $uploadId ){
        $this->media()->update( [ 'thumbnail_image' => false ] );
        $this->media()->where('id','=',$uploadId)->update( [ 'thumbnail_image' => true ] );
    }

    /**
     * Set the images that should NOT be in the gallery for the array of ID's passed in
     * @param   mixed[integer|array] $uploadId The upload ID
     * @return  boolean
     */
    public function setGalleryImages( $uploadIds ){
        if( !is_array($uploadIds) )
            $uploadIds = [ $uploadIds ];

        $this->media()->update( [ 'gallery' => true ] );
        $this->media()->whereIn('id',$uploadIds )->update( [ 'gallery' => false ] );
    }

    /**
     * Delete a product by its product ID
     * @param  integer $id The Product ID
     * @return boolean
     */
    public function deleteById( $id ){
        $product = $this->find($id);
        // Ensure that the product images that need to be deleted get deleted
        $uploadModel = App::make('Davzie\ProductCatalog\Models\Interfaces\UploadRepository');
        $uploadModel->deleteByIdType( $product->id , 'products' );

        $product->delete();
        return true;
    }

    /**
     * Get the attribute set associated with this product
     * @return Eloquent
     */
    public function attributeSet(){
        return $this->belongsTo( 'Davzie\ProductCatalog\Models\AttributeSetEloquent' );
    }

}