<?php
namespace Davzie\ProductCatalog\Attribute\Set\Entities;
use Davzie\ProductCatalog\Entity;

class Edit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Attribute\Set';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['name'] = 'required|max:255|unique:attribute_sets,name,'.$currentId;

        parent::__construct();
    }

}