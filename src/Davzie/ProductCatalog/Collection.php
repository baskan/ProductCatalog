<?php
namespace Davzie\ProductCatalog;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface Collection {

    /**
     * Get all in the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * Get a category by its slug
     * @param  string $slug The Category's Slug
     * @return Eloquent    The category retrieved
     */
    public function getBySlug( $slug );

    /**
     * The products available in this category
     * @return Eloquent
     */
    public function products();

    /**
     * Delete a category by its category ID
     * @param  integer $id The Category ID
     * @return boolean
     */
    public function deleteById( $id );

    /**
     * The media object to get the uploads available
     * @return Eloquent
     */
    public function media();

    /**
     * Get the thumbnail image associated with this category
     * @return Upload   The upload object
     */
    public function getThumbnailImage();

    /**
     * Get the main image of the category
     * @return Eloquent
     */
    public function getMainImage();

}