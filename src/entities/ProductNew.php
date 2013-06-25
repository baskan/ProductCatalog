<?php
namespace Davzie\ProductCatalog\Entities;
use App;

class ProductNew extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\ProductRepository';

    protected static $rules = [
        'title'  => 'required|max:255',
        'price' => 'required|numeric',
        'sku' => 'required|alpha_dash|unique:products,sku'
    ];

}