<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Davzie\ProductCatalog\Models\Interfaces\AttributeTypeRepository;

class AttributeTypeEloquent extends Eloquent implements AttributeTypeRepository {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attribute_types';

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
        return $this->orderBy('id','asc')->get();
    }

}