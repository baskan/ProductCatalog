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


}