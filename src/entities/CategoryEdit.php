<?php
namespace Davzie\ProductCatalog\Entities;
use App;
use Str;
use Input;

class CategoryEdit extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\CategoryRepository';

    protected static $rules = [
        'id'            =>  'required|integer|exists:categories,id',
        'name'          =>  'required|max:255',
        'enabled'       =>  'integer'
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['parent_id'] = 'integer|exists:categories,id|not_in:'.$currentId;
        static::$rules['url'] = 'required|alpha_dash|unique:categories,url,'.$currentId;

        // If we have a 0 through on parent ID then we can assume the user has not chosen anything
        // If we have a 0 through on parent ID then we can assume the user has not chosen anything
        if( Input::get('parent_id') == 0 ){
            unset( static::$rules['parent_id'] );
            static::$defaultData['parent_id'] = null;
        }

        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('name') , '-' );

        parent::__construct();
    }

}