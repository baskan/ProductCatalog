<?php
namespace Davzie\ProductCatalog\Models\Interfaces;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface UserRepository {

    /**
     * Determine if the user is just a customer
     * @return boolean True if the user is a customer
     */
    public function isCustomer();

    /**
     * Get the amount of active customers
     * @return Eloquent
     */
    public function scopeactiveCustomers($query);


    /**
     * Get the full name of the user
     * @return string
     */
    public function getFullName();

}