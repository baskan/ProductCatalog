<?php
namespace Davzie\ProductCatalog\User\Entities;
use Davzie\ProductCatalog\Entity;

class Edit extends Entity {

    protected static $model = 'Davzie\ProductCatalog\User';

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [
        'is_admin'=>1,
    ];

    protected static $rules = [
        'id'  => 'required|exists:users,id',
        'email'  => 'required|email|unique:users,email|max:255',
        'password'  => 'confirmed|max:255',
        'first_name'  => 'required|max:255',
        'last_name'  => 'required|max:255'
    ];

    public function __construct( $currentId ){
        $this->setCurrentId( $currentId );
        static::$rules['email'] = 'required|email|unique:users,email,'.$currentId.'|max:255';
        parent::__construct();
    }

}