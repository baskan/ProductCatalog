<?php
namespace Davzie\ProductCatalog\Collection\Entities;
use Davzie\ProductCatalog\Entity;
use App;
use Str;
use Input;

class Edit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Collection';

    protected static $rules = [
        'id'            =>  'required|integer|exists:collections,id',
        'name'          =>  'required|max:255',
        'featured'      =>  'integer',
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['url'] = 'required|alpha_dash|unique:collections,url,'.$currentId;

        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('name') , '-' );

        parent::__construct();
    }

}