<?php
namespace Davzie\ProductCatalog\Attribute;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface Type {

    /**
     * Get all the stuffs in the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * Get the type class back based on the ID passed in
     * @param  integer $typeId The Type ID
     * @return TypeInterface
     */
    public function getType( $typeId );

}