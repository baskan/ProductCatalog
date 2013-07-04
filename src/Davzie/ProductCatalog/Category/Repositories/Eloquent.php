<?php
namespace Davzie\ProductCatalog\Category\Repositories;
use Eloquent as IEloquent;
use Davzie\ProductCatalog\Category;

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

}