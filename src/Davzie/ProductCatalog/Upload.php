<?php
namespace Davzie\ProductCatalog;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface Upload {

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
     * Delete an upload by it's database ID
     * @param  mixed[integer|array]     $id     The database ID
     * @return boolean                          True if deleted
     */
    public function deleteById( $id );

    /**
     * Delete an upload by it's type and link ID
     * @param  integer     $id     The link record ID
     * @param  integer     $type   The link type
     * @return boolean             True if deleted
     */
    public function deleteByIdType( $id , $type );

    /**
     * Size up the current record and return the resulting filename
     * @param  integer  $width  The width of the resulting image
     * @param  integer  $height The height of the resulting image
     * @param  boolean  $crop   Decide whether to crop the image or not
     * @return string           The sized up stored resulting image
     */
    public function sizeImg( $width , $height , $crop = true );

    /**
     * Set the order of the ID's from 0 to the array length passed in
     * @param array $ids The Upload IDs
     */
    public function setOrder( $ids );

}