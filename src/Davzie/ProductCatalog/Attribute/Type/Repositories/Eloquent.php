<?php
namespace Davzie\ProductCatalog\Attribute\Type\Repositories;
use Davzie\ProductCatalog\Attribute\Type;
use Eloquent as IEloquent;
use App;

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

    /**
     * Get the type class back based on the ID passed in
     * @param  integer $typeId The Type ID
     * @return TypeInterface
     */
    public function getType( $typeId ){
        $type = $this->find($typeId);

        if( !$type )
            throw new UnexpectedValueException($typeId);

        return App::make( 'Davzie\\ProductCatalog\\Attribute\\Type\\'.$type->class );
    }

}