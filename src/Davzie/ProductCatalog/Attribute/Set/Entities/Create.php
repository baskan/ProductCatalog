<?php
namespace Davzie\ProductCatalog\Attribute\Set\Entities;
use Davzie\ProductCatalog\Entity;

class Create extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Attribute\Set';

    protected static $rules = [
        'name'          => 'required|max:255|unique:attribute_sets,name'
    ];

}