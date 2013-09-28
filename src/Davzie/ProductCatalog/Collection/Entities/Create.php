<?php
namespace Davzie\ProductCatalog\Collection\Entities;
use Davzie\ProductCatalog\Entity;
use App;
use Input;
use Str;

class Create extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Collection';

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [];

    protected static $rules = [
        'name'          => 'required|max:255',
        'url'           => 'required|alpha_dash|unique:collections,url'
    ];

    public function __construct(){
        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('name') , '-' );
        parent::__construct();
    }

}