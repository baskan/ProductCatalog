<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Davzie\ProductCatalog\Models\Interfaces\CategoryRepository;

class CategoryEloquent extends Eloquent implements CategoryRepository {

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
        return $this->hasOne( 'Davzie\ProductCatalog\Models\CategoryRepository' , 'parent_id' );
    }

    /**
     * The products available in this category
     * @return Eloquent
     */
    public function products(){
        return $this->belongsToMany( 'Davzie\ProductCatalog\Models\ProductEloquent' , 'product_categories' , 'category_id' , 'product_id' );
    }

}