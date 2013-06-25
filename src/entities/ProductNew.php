<?php
namespace Davzie\ProductCatalog\Entities;
use App;

class ProductNew extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\ProductRepository';

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [
        'enabled'=>0,
    ];

    protected static $rules = [
        'title'  => 'required|max:255',
        'price' => 'required|numeric',
        'sku' => 'required|alpha_dash|unique:products,sku'
    ];

}