<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Davzie\ProductCatalog\Models\Interfaces\AttributeSetRepository;

class AttributeSetEloquent extends Eloquent implements AttributeSetRepository {

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

}