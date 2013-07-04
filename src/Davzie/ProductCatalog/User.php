<?php
namespace Davzie\ProductCatalog;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface User {

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

    /**
     * Get all users from the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * A mutator to ensure that when password's get set, they are actually hashed
     * @param string $value The new password
     */
    public function setPasswordAttribute($value);

}