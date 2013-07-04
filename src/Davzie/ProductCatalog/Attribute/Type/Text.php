<?php namespace Davzie\ProductCatalog\Attribute\Type;
use Davzie\ProductCatalog\Attribute\Type\TypeInterface;

class Text extends Base implements TypeInterface{

    /**
     * The ID of this type in the database
     */
    public static $id = 1;

    /**
     * The name of the type of field
     */
    protected static $name = 'text';

}