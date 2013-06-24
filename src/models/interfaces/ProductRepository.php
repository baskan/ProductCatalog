<?php
namespace Davzie\ProductCatalog\Models\Interfaces;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface ProductRepository {

    /**
     * Get all the products in the system
     * @return Eloquent
     */
    public function getAllProducts();

    /**
     * Get the active products
     * @return Eloquent
     */
    public function scopeactiveProducts($query);


    /**
     * Get the full price of the product (delivery, tax and product cost)
     * @return string
     */
    public function getFullPrice();

}