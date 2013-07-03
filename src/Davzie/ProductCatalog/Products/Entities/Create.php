<?php
namespace Davzie\ProductCatalog\Products\Entities;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Input;
use Davzie\ProductCatalog\Entity;

class Create extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Product';

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

    public function __construct(){
        parent::__construct();
        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('title') , '-' );
    }

}