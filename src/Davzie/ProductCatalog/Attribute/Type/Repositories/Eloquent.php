<?php
namespace Davzie\ProductCatalog\Attribute\Type\Repositories;
use Davzie\ProductCatalog\Attribute\Type;
use Eloquent as IEloquent;

class Eloquent extends IEloquent implements Type {

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