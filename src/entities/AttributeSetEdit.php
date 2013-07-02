<?php
namespace Davzie\ProductCatalog\Entities;

class AttributeSetEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeSetRepository';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['name'] = 'required|max:255|unique:attribute_sets,name,'.$currentId;

        parent::__construct();
    }

}