<?php
namespace Davzie\ProductCatalog\Attribute\Set\Repositories;
use Eloquent as IEloquent;
use Davzie\ProductCatalog\Attribute\Set;

class Eloquent extends IEloquent implements Set {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attribute_sets';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = [];


    /**
     * Get all the stuffs in the system
     * @return Eloquent
     */
    public function getAll(){
        return $this->orderBy('name','asc')->get();
    }

    /**
     * The reverse product relationship
     * @return Eloquent
     */
    public function products(){
        return $this->hasMany( 'Davzie\ProductCatalog\Product\Repositories\Eloquent' , 'attribute_set_id' );
    }

    /**
     * The relationship that associates the attributes to the set
     * @return Eloquent
     */
    public function attributes(){
        return $this->belongsToMany( 'Davzie\ProductCatalog\Attribute\Repositories\Eloquent' , 'attribute_attribute_sets' , 'attribute_set_id' , 'attribute_id'  );
    }

}