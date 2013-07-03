<?php
namespace Davzie\ProductCatalog\Entities;
use Davzie\ProductCatalog\Entity;

class AttributeEdit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeRepository';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['name'] = 'required|max:255|unique:attributes,name,'.$currentId;

        parent::__construct();
    }

}