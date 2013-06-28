<?php
namespace Davzie\ProductCatalog\Models\Interfaces;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface UploadRepository {

    /**
     * Get all the uploads in the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * The relationship that links this back to the product
     * @return Eloquent
     */
    public function product();

    /**
     * Get the thumbnail image
     * @return Eloquent
     */
    public function thumbnailImage();

    /**
     * Get the thumbnail image
     * @return Eloquent
     */
    public function mainImage();

    /**
     * Get the images that are eligible to be showin in a gallery
     * @return Collection
     */
    public function galleryImages();

}