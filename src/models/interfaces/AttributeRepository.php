<?php
namespace Davzie\ProductCatalog\Models\Interfaces;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface AttributeRepository {

    /**
     * Get all the stuffs in the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * Delete an attribute by its ID
     * @param  integer $id The attribute ID
     * @return boolean
     */
    public function deleteById($id);

}