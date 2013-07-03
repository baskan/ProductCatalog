<?php
namespace Davzie\ProductCatalog\Entities;
use Davzie\ProductCatalog\Entity;

class AttributeSetEdit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeSetRepository';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['name'] = 'required|max:255|unique:attribute_sets,name,'.$currentId;

        parent::__construct();
    }

}