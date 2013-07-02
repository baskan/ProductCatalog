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

    /**
     * Get the image to be used as a thumbnail for this product
     * @return Eloquent
     */
    public function getThumbnailImage();

    /**
     * Get the main image that will be used (usually the first image / hero image)
     * @return Eloquent
     */
    public function getMainImage();

    /**
     * Get the images that can be used in the gallery
     * @return Eloquent
     */
    public function getGalleryImages();

    /**
     * Set the main image for this product to the upload ID passed in
     * @param   integer $uploadId The upload ID
     * @return  boolean
     */
    public function setMainImage( $uploadId );

    /**
     * Set the thumbnail image for this product to the upload ID passed in
     * @param   integer $uploadId The upload ID
     * @return  boolean
     */
    public function setThumbnailImage( $uploadId );

    /**
     * Set the images that should NOT be in the gallery for the array of ID's passed in
     * @param   mixed[integer|array] $uploadId The upload ID
     * @return  boolean
     */
    public function setGalleryImages( $uploadIds );

    /**
     * Delete a product by its product ID
     * @param  integer $id The Product ID
     * @return boolean
     */
    public function deleteById( $id );

    /**
     * Get the attribute set associated with this product
     * @return Eloquent
     */
    public function attribute_set();

}