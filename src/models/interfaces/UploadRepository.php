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
     * The relationship that links to this upload...
     * @return Eloquent
     */
    public function link();

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

    /**
     * Get the usable src (public path and filename)
     * @return string
     */
    public function getSrc();

    /**
     * Get the absolute usable src ( /var/www/vhosts/domain.com/public/uploads/products/filename.jpg etc )
     * @return string
     */
    public function getAbsoluteSrc();

    /**
     * Get the path of the upload (public one)
     * @return string
     */
    public function getPath();

    /**
     * Get the absolute path to the server for the upload
     * @return string
     */
    public function getAbsolutePath();

    /**
     * Size up the current record and return the resulting filename
     * @param  integer  $width  The width of the resulting image
     * @param  integer  $height The height of the resulting image
     * @param  boolean  $crop   Decide whether to crop the image or not
     * @return string           The sized up stored resulting image
     */
    public function sizeImg( $width , $height , $crop = true );

}