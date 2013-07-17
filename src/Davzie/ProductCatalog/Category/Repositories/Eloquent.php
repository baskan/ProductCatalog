<?php
namespace Davzie\ProductCatalog\Category\Repositories;
use Eloquent as IEloquent;
use Davzie\ProductCatalog\Category;
use Config;
use App;

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
        return $this->media()->first();
    }

    /**
     * Get the thumbnail image associated with this category
     * @return Upload   The upload object
     */
    public function getThumbnailImage(){
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

}