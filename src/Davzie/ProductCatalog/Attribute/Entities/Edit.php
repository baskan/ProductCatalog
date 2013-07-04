<?php
namespace Davzie\ProductCatalog\Attribute\Entities;
use Davzie\ProductCatalog\Entity;
use Input;

class Edit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Attribute';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['name'] = 'required|max:255|unique:attributes,name,'.$currentId;
        static::$defaultData['default'] = Input::get('default');

        parent::__construct();
    }

}