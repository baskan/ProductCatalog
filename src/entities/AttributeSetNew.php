<?php
namespace Davzie\ProductCatalog\Entities;

class AttributeSetNew extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeSetRepository';

    protected static $rules = [
        'name'          => 'required|max:255|unique:attribute_sets,name'
    ];

}