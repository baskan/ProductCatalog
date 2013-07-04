<?php
namespace Davzie\ProductCatalog\Attribute\Set\Entities;
use Davzie\ProductCatalog\Entity;
use Input;
use App;

class Edit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\Attribute\Set';

    protected static $rules = [];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );

        // Dynamic Rules
        static::$rules['name'] = 'required|max:255|unique:attribute_sets,name,'.$currentId;

        parent::__construct();
    }

    /**
     * Run our own hydration stuffs
     * @return boolean
     */
    public function hydrate(){
        parent::hydrate();
        $attributeSetModel = App::make( static::$model )->find( $this->currentId );
        $attributeSetModel->attributes()->sync( Input::get('assigned_attributes', []) );
        return true;
    }

}