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
    public function getAll();

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

    /**
     * Get a product by its SKU
     * @param  string $sku The Product SKU
     * @return Eloquent    The product found
     */
    public function getBySku( $sku );

    /**
     * The categories available in this product
     * @return Eloquent
     */
    public function categories();

    /**
     * The media object to get the uploads available
     * @return Eloquent
     */
    public function media();

}