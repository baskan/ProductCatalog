<?php
namespace Davzie\ProductCatalog\Entities;
use App;

class ProductEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\ProductRepository';

    protected static $rules = [
        'id'        => 'required|integer|exists:products,id',
        'title'     => 'required|max:255',
        'price'     => 'required|numeric',
        'enabled'   => 'integer',
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['sku'] = 'required|alpha_dash|unique:products,sku,'.$currentId;
        static::$rules['url'] = 'required|alpha_dash|unique:products,url,'.$currentId;

        parent::__construct();
    }

}