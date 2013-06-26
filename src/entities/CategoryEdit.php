<?php
namespace Davzie\ProductCatalog\Entities;
use App;
use Str;
use Input;

class CategoryEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\CategoryRepository';

    protected static $rules = [
        'id'        =>  'required|integer|exists:categories,id',
        'name'      =>  'required|max:255',
        'enabled'   => 'integer'
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['url'] = 'required|alpha_dash|unique:categories,url,'.$currentId;

        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('name') , '-' );

        parent::__construct();
    }

}