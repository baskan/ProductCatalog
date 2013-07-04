<?php
namespace Davzie\ProductCatalog\Attribute;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface Set {

    /**
     * Get all the stuffs in the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * The reverse product relationship
     * @return Eloquent
     */
    public function products();

    /**
     * The relationship that associates the attributes to the set
     * @return Eloquent
     */
    public function attributes();

}