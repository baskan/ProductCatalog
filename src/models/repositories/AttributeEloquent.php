<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Davzie\ProductCatalog\Models\Interfaces\AttributeRepository;

class AttributeEloquent extends Eloquent implements AttributeRepository {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attributes';

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

    /**
     * Delete an attribute by its ID
     * @param  integer $id The attribute ID
     * @return I don't know...
     */
    public function deleteById($id){
        return $this->where('id','=',$id)->delete();
    }

}