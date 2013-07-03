<?php
namespace Davzie\ProductCatalog\Entities;

class AttributeEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeRepository';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['attribute_type_id'] = 'required|integer|exists:attribute_types,id';
        static::$rules['key'] = 'required|max:255|unique:attributes,key,'.$currentId;
        static::$rules['name'] = 'required|max:255|unique:attributes,name,'.$currentId;

        parent::__construct();
    }

}