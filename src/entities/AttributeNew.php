<?php
namespace Davzie\ProductCatalog\Entities;

class AttributeNew extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeRepository';

    protected static $rules = [
        'attribute_type_id'     =>  'required|integer|exists:attribute_types,id',
        'key'                   =>  'required|max:255|alpha_dash|unique:attributes,key',
        'name'                  =>  'required|max:255|unique:attributes,name'
    ];

}