<?php
namespace Davzie\ProductCatalog\Models\Interfaces;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface AttributeSetRepository {

    /**
     * Get all the stuffs in the system
     * @return Eloquent
     */
    public function getAll();

}