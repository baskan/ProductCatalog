<?php
namespace Davzie\ProductCatalog\Entities;
use App;

class ProductEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\ProductRepository';

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [
        'enabled'=>0,
    ];

    protected static $rules = [
        'id'        => 'required|integer|exists:products,id',
        'title'     => 'required|max:255',
        'price'     => 'required|numeric',
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['sku'] = 'required|alpha_dash|unique:products,sku,'.$currentId;
        static::$rules['url'] = 'required|alpha_dash|unique:products,url,'.$currentId;

        parent::__construct();
    }

}