<?php
namespace Davzie\ProductCatalog\Product\Repositories;
use Eloquent as IEloquent;
use Illuminate\Support\Facades\App;
use Davzie\ProductCatalog\Product;
use Config;

class Eloquent extends IEloquent implements Product {

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
     * Get a product by a URL key
     * @param  string $url Get the product if the URL passed in matches it
     * @return Eloquent
     */
    public function getByUrl( $url ){
        return $this->where('url','=',$url)->first();
    }

    /**
     * Get the active products
     * @return Eloquent
     */
    public function scopeactiveProducts($query){
        return $query->where('enabled', '=', true);
    }

    /**
     * Get the full URL of the category
     * @return string
     */
    public function getFullUrlAttribute(){
        $segment = Config::get('ProductCatalog::routing.product_segment');
        return url( $segment.'/'.$this->url );
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
        return $this->belongsToMany( 'Davzie\ProductCatalog\Category\Repositories\Eloquent' , 'product_categories' , 'product_id' , 'category_id' );
    }

    /**
     * The media object to get the uploads available
     * @return Eloquent
     */
    public function media(){
        return $this->morphMany( 'Davzie\ProductCatalog\Upload\Repositories\Eloquent' , 'link')->orderBy('order','asc');
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
        $uploadModel = App::make('Davzie\ProductCatalog\Upload');
        $uploadModel->deleteByIdType( $product->id , 'products' );

        $product->delete();
        return true;
    }

    /**
     * Get the attribute set associated with this product
     * @return Eloquent
     */
    public function attributeSet(){
        return $this->belongsTo( 'Davzie\ProductCatalog\Attribute\Set\Repositories\Eloquent' );
    }

    /**
     * Get all the associated attributes via the set for the product
     * @return Eloquent
     */
    public function attributes(){
        return $this->belongsToMany( 'Davzie\ProductCatalog\Attribute\Repositories\Eloquent' , 'products_attributes' , 'product_id' , 'attribute_id' )
                    ->withPivot('value');
    }

    /**
     * Get the value that is set for the current product attribute by the key
     * @return Eloquent
     */
    public function getAttrValueByKey( $attributeKey )
    {
        $attribute = $this->attributes()->where( 'key' , '=' , $attributeKey )->first();

        if($attribute)
            return $attribute->pivot->value;

        return '';
    }

    /**
     * Get the value that is set for the current product attribute
     * @return Eloquent
     */
    public function getAttrValue( $attributeId ){
        $attribute = $this->attributes()->where( 'attribute_id' , '=' , $attributeId )->first();

        if($attribute)
            return $attribute->pivot->value;

        return '';
    }

    /**
     * Add values to product attributes to the product
     * @return boolean
     */
    public function addAttributeValues( Array $attributes ){
        $syncArray = [];
        foreach($attributes as $attrId=>$value)
            $syncArray[$attrId] = [ 'value' => $value ];

        $this->attributes()->sync( $syncArray );
    }

    /**
     * Retrieve a list of the filled out attributes and their corresponding values
     * @return Eloquent
     */
    public function getAvailableAttributes(){
        if( $this->attributeSet )
            return $this->attributeSet->attributes()->get();

        return false;
    }

    /**
     * Get the available attributes and group them by their group name (groups are indicated by group-name.attribute_name)
     * @param  string $groupName    To get only one group anem specify it ( for example, 'finance' )
     * @param  string $excludeGroup To exclude a group name, specify it here
     * @return Eloquent
     */
    public function getAvailableGroupedAttributes( $groupName = null , $excludeGroup = null ){
        $attributes = $this->getAvailableAttributes();
        $attributes_grouped = [];
        $transformName = function( $name ){
            return ucwords( str_replace( ['-','_'] , [' ',' '] , $name ) );
        };

        if(!$attributes)
            return [];

        foreach($attributes as $attribute){

            if( str_contains( $attribute->key , '.' ) ){
                $segments = explode( '.' , $attribute->key , 2 );
                $attributes_grouped[ $transformName( $segments[0] ) ][ $segments[1] ] = $attribute;
            }else{
                $attributes_grouped[0][] = $attribute;
            }

        }

        if( $groupName !== null ){
            $attributes_grouped = array_only( $attributes_grouped , $transformName( $groupName ) );
            $attributes_grouped = reset( $attributes_grouped );
        }

        if( $excludeGroup !== null )
            unset( $attributes_grouped[ $transformName( $excludeGroup ) ] );


        return $attributes_grouped;
    }

}