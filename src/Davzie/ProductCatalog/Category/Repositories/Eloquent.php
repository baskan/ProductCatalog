<?php
namespace Davzie\ProductCatalog\Category\Repositories;
use Illuminate\Support\Collection as LaravelCollection;
use Eloquent as IEloquent;
use Davzie\ProductCatalog\Category;
use Davzie\ProductCatalog\Collection;
use Config, App, View;

class Eloquent extends IEloquent implements Category {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = [];


    /**
     * Get all in the system
     * @return Eloquent
     */
    public function getAll(){
        return $this->all();
    }

    /**
     * Get all subcategories, ie, everything in the second level (not top level)
     * @return Collection
     */
    public function getAllSubcategories()
    {
        $collection = new LaravelCollection;
        if( $top = $this->getTopLevel() ){
            foreach($top as $cat){
                if( $cat->children ){
                    foreach($cat->children as $child){
                        if( $child->products()->count() > 0 ){
                            $collection->put($child->id,$child);
                        }
                    }
                }
            }
        }
        return $collection;
    }

    /**
     * Get a category by a URL key
     * @param  string $url Get the category if the URL passed in matches it
     * @return Eloquent
     */
    public function getByUrl( $url ){
        return $this->where('url','=',$url)->first();
    }

    /**
     * Get the full URL of the category
     * @return string
     */
    public function getFullUrlAttribute(){
        $url = '';
        if( $this->parent )
            $url .= $this->parent->url.'/';

        $url .= $this->url;

        $segment = Config::get('ProductCatalog::routing.category_segment');

        return url( $segment.'/'.$url );
    }

    /**
     * Get all products associated with a collection and category
     * @return Eloquent
     */
    public function filterByCollection( Category $category , Collection $collection ){
        $products = $this->grabAllProducts( $category );
        $filtered = array();
        if($products){
            foreach($products as $product){
                if( $product->collection_id == $collection->id )
                    $filtered[$product->id] = $product;
            }
        }
        return $filtered;
    }

    /**
     * Get the active categories
     * @return Eloquent
     */
    public function scopeactiveCategories($query){
        return $query->where('enabled', '=', true);
    }

    /**
     * Get a category by its slug
     * @param  string $slug The Category's Slug
     * @return Eloquent    The category retrieved
     */
    public function getBySlug( $slug ){
        return $this->where('slug','=',$slug)->first();
    }

    /**
     * Get the parent category if it exists
     * @return Eloquent
     */
    public function parent(){
        return $this->belongsTo( 'Davzie\ProductCatalog\Category\Repositories\Eloquent' , 'parent_id' );
    }

    /**
     * Delete a category by its category ID
     * @param  integer $id The Category ID
     * @return boolean
     */
    public function deleteById( $id ){
        $category = $this->find($id);
        // Ensure that the category images that need to be deleted get deleted
        $uploadModel = App::make('Davzie\ProductCatalog\Upload');
        $uploadModel->deleteByIdType( $category->id , 'categories' );

        $category->delete();
        return true;
    }

    /**
     * Get the child categories if they exists
     * @return Eloquent
     */
    public function children(){
        return $this->hasMany( 'Davzie\ProductCatalog\Category\Repositories\Eloquent' , 'parent_id' );
    }

    /**
     * The products available in this category
     * @return Eloquent
     */
    public function products(){
        return $this->belongsToMany( 'Davzie\ProductCatalog\Product\Repositories\Eloquent' , 'product_categories' , 'category_id' , 'product_id' );
    }

    /**
     * Get categories that do not have a parent category, ie. top level
     * @return Eloquent
     */
    public function getTopLevel( $id = null ){
        if( null === $id ){
            return $this->whereNull('parent_id')->get();
        }else{
            // Lets convert this ID to an array, because it clearly isn't. If we pass an array in we can exclude other top level categories too
            if( !is_array($id) )
                $id = array($id);

            return $this->whereNull('parent_id')->whereNotIn('id',$id)->get();
        }
    }

    /**
     * Determine whether or not the category in question has children / sub categories
     * @return boolean True if it does, false if it doesn't
     */
    public function hasChildren(){
        if( $this->children()->count() > 0 )
            return true;
        
        return false;
    }

    /**
     * The media object to get the uploads available
     * @return Eloquent
     */
    public function media(){
        return $this->morphMany( 'Davzie\ProductCatalog\Upload\Repositories\Eloquent' , 'link')->orderBy('order','asc');
    }

    /**
     * Get the main image of the category
     * @return Eloquent
     */
    public function getMainImage(){
        return $this->media()->where('main_image' , '=' , true)->first();
    }

    /**
     * Get the thumbnail image associated with this category
     * @return Upload   The upload object
     */
    public function getThumbnailImage(){

        if( $uploaded = $this->media()->where('thumbnail_image' , '=' , true)->first() )
            return $this->media()->where('thumbnail_image' , '=' , true)->first();

        $associated_image = $this->media()->first();
        if( $associated_image !== null )
            return $associated_image;

        $first_cat = $this->children()->first();
        if( $first_cat and $first_cat->media()->first() )
            return $first_cat->media()->first();

        $first_product = $this->products()->first();
        if( $first_product and $first_product->getThumbnailImage() )
            return $first_product->getThumbnailImage();

        if( $first_cat ){
            $first_category_products = $first_cat->products()->first();
            if( $first_category_products and $first_category_products->getThumbnailImage() )
                return $first_category_products->getThumbnailImage();
        }

        return null;
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
     * Ensure the collections get associated to uploads properly
     * @param void
     */
    public function setCollectionImages( $uploadIds )
    {
        if( !is_array($uploadIds) )
            return;

        $this->media()->update( [ 'collection_id' => null ] );

        foreach($uploadIds as $uploadId=>$collectionId){
            if( $collectionId && $collectionId !== 0)
                $this->media()->where('id','=',$uploadId )->update( [ 'collection_id' => $collectionId ] );    
        }
        $this->media()->whereIn('id',$uploadIds )->update( [ 'gallery' => false ] );
    }

    /**
     * Determine whether or not this category should show filters only
     * @return boolean True if the category is filterable
     */
    public function isFilterable()
    {
        return $this->filterable;
    }

    /**
     * Sometimes it may be necessary to retrieve all products including those in child categories, this should do that.
     * @return Collection
     */
    public function getAllProductsIncludingChildren()
    {
        return $this->grabAllProducts( $this );
    }

    /**
     * Get the TRs for the admin area
     * @return View
     */
    public function displayOrderedAdminHTML()
    {
        $views = '';
        $flattened = $this->getFlattenedCategories();
        foreach($flattened as $category){
            $views .= View::make( 'ProductCatalog::categories.partials.dashboard-category-listing' )->with('category',$category);
        }
        return $views;
    }

    /**
     * Recursivelly find and order all of the categories properly in a flattened state, the view shows the heirachy
     * @param  Category $category The Category To Start With
     * @return array
     */
    public function getFlattenedCategories( $category = null )
    {
        if( is_null($category) )
            $categories = $this->getTopLevel();
        else
            $categories = $category->children()->get();

        $ordered = array();

        if( $categories ){
            foreach( $categories as $cat ){
                $ordered[ $cat->id ] = $cat;
                $ordered = $ordered + $this->getFlattenedCategories( $cat );
            }
        }

        return $ordered;
    }

    /**
     * Sometimes we want to indicate what level we're at in dropdowns or in the backend menu, this produces counts of characters and a final character
     * to show this, similar to -> or ---> 
     * @param  string $indicator The indicator (in the example above the dash)
     * @param  string $final     The final arrow if required ( could be > as above )
     * @return string
     */
    public function getLevelIndicator( $indicator = '-' , $final = '' )
    {
        $return = '';
        if( $this->level() > 0 ){
            for ($i = 0; $i < $this->level(); $i++){
                $return .= $indicator;
            }
            $return .= $final;
        }
        return $return;
    }

    /**
     * The numerical level of the category in heirachy. Level 0 is the highest
     * @return integer
     */
    public function level()
    {
        return $this->workOutLevel( $this );
    }

    /**
     * A recursable function for working out the level the category is in the heirachy
     * @param  Category $category     The category to find the level for
     * @param  integer  $currentLevel The current level number (defaults to 0 for any custom calls)
     * @return integer
     */
    private function workOutLevel( Category $category , $currentLevel = 0 )
    {
        if( $category->parent )
            return $this->workOutLevel( $category->parent , $currentLevel+1 );

        return $currentLevel;
    }

    /**
     * The function that actually goes and recursively collects all products from passed in category and children categories
     * @param  Category $category The category to recursively check
     * @return Array
     */
    private function grabAllProducts( Category $category )
    {
        $child_products = $products = array();

        if( $category->products()->count() > 0 ){
            foreach( $category->products as $product ){
                $products[ $product->id ] = $product;
            }
        }

        if( $category->children()->count() > 0 ){
            foreach( $category->children as $child ){
                $child_products[] = $this->grabAllProducts( $child );
            }
        }

        if($child_products){
            foreach($child_products as $cp){
                if($cp){
                    foreach($cp as $prod){
                        if( !isset($products[$prod->id]) ){
                            $products[$prod->id] = $prod;
                        }
                    }
                }
            }
        }

        return $products;
    }

    /**
     * Get all available collections in this category
     * @return Collection
     */
    public function getCollections( Category $category )
    {
        $products = $this->grabAllProducts( $category );

        if( !$products )
            return null;

        $ids = array();
        foreach($products as $product){
            if( !is_null($product->collection_id) )
                $ids[$product->collection_id] = $product->collection_id;
        }

        return App::make('Davzie\ProductCatalog\Collection')->whereIn('id',$ids)->orderBy('name','asc')->get();
    }

}