<?php namespace Davzie\ProductCatalog\Attribute\Type;

abstract class Base {

    /**
     * The ID of this type in the database
     */
    public static $id;

    /**
     * The name of the type of field
     */
    protected static $name;

    /**
     * The view name to get when editing stuffs etc
     * @return string
     */
    public function getViewName(){
        return static::$name;
    }

    /**
     * The name to get when showing the types etc
     * @return string
     */
    public function getName(){
        return ucwords(static::$name);
    }

}