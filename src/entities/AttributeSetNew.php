<?php
namespace Davzie\ProductCatalog\Entities;
use Davzie\ProductCatalog\Entity;

class AttributeSetNew extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\AttributeSetRepository';

    protected static $rules = [
        'name'          => 'required|max:255|unique:attribute_sets,name'
    ];

}