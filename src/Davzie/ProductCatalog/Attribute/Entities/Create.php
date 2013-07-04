<?php
namespace Davzie\ProductCatalog\Attribute\Entities;
use Davzie\ProductCatalog\Entity;

class Create extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Attribute';

    protected static $rules = [
        'attribute_type_id'     =>  'required|integer|exists:attribute_types,id',
        'key'                   =>  'required|max:255|alpha_dash|unique:attributes,key',
        'name'                  =>  'required|max:255|unique:attributes,name'
    ];

}