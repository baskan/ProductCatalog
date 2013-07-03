<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Config;
use File;
use Exception;
use Davzie\ProductCatalog\Models\Interfaces\UploadRepository;
use Davzie\ProductCatalog\ImgHelper;
class UploadEloquent extends Eloquent implements UploadRepository {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'uploads';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = [];


    /**
     * Get all the uploads in the system
     * @return Eloquent
     */
    public function getAll(){
        return $this->orderBy('order','asc')->get();
    }

    /**
     * The relationship that links to this upload...
     * @return Eloquent
     */
    public function link(){
        return $this->morphTo();
    }

    /**
     * Get the usable src (public path and filename)
     * @return string
     */
    public function getSrc(){
        return $this->getPath().$this->filename;
    }

    /**
     * Delete an upload by it's database ID
     * @param  mixed[integer|array]     $id     The database ID
     * @return boolean                          True if deleted
     */
    public function deleteById( $id ){
        if( !is_array($id) )
            $id = array( $id );

        // Delete The Items From The File Store
        $this->physicallyDelete( $this->whereIn( 'id' , $id )->get() );

        // Now delete the items from the database
        $this->whereIn( 'id' , $id )->delete();

        return true;
    }

    /**
     * Delete an upload by it's type and link ID
     * @param  integer     $id     The link record ID
     * @param  integer     $type   The link type
     * @return boolean             True if deleted
     */
    public function deleteByIdType( $id , $type ){
        // Delete the images directory for these types / links
        $base_path = Config::get('ProductCatalog::app.upload_base_path');
        $toDelete  = public_path().'/'.$base_path.$type.'/'.$id;
        File::deleteDirectory( $toDelete );

        // Now return the result of deleting all the records that match
        return $this->where('path','=',$type)->where('link_id','=',$id)->delete();
    }

    /**
     * Physically delete all files related to the uploads collection passed in
     * @return boolean
     */
    private function physicallyDelete( $uploads ){

        // Return false if we have no uploads passed in
        if( !$uploads )
            return false;

        // Loop through each upload object
        foreach($uploads as $upload){
            // If the original file actually exists that is specified in the DB, then lets delete if
            if( File::isFile( $upload->getAbsoluteSrc() ) )
                File::delete( $upload->getAbsoluteSrc() );

            // Setup the caching path
            $cache = $upload->getAbsolutePath().'/cached/';

            if( File::isDirectory( $cache ) ){
                // Loop through each item in the cache for this particular product ID
                foreach( File::files($cache) as $cacheItem ){
                    // We want to remove the extension and the . to see if the thing exists
                    $filename = $this->stripExtensions( $upload->filename );

                    // If the path we have actually contains the filename we can remove it, given
                    // that the path is always a unique SHA1 checksum we shouldn't have any conflicts,
                    // but if we did it wouldn't matter beacuse it's just a cache
                    if( str_contains( $cacheItem , $filename ) )
                        File::delete($cacheItem);
                }
            }
        }

        return true;
    }

    /**
     * Strip the extensions from the filename and just return the filename, we need this to append stuff
     * @param  string $filename The filename to strip
     * @return string
     */
    private function stripExtensions( $filename ){
        return preg_replace("/\\.[^.\\s]{3,4}$/", "", $filename);
    }

    /**
     * Get the absolute usable src ( /var/www/vhosts/domain.com/public/uploads/products/filename.jpg etc )
     * @return string
     */
    public function getAbsoluteSrc(){
        return $this->getAbsolutePath().$this->filename;
    }

    public function getAbsolutePath(){
        $base_path = Config::get('ProductCatalog::app.upload_base_path');
        return public_path().'/'.$base_path.$this->path.'/'.$this->link_id.'/';
    }

    public function getPath(){
        $base_path = Config::get('ProductCatalog::app.upload_base_path');
        return url( $base_path.$this->path.'/'.$this->link_id.'/' );
    }

    /**
     * Size up the current record and return the resulting filename
     * @param  integer  $width  The width of the resulting image
     * @param  integer  $height The height of the resulting image
     * @param  boolean  $crop   Decide whether to crop the image or not
     * @return string           The sized up stored resulting image
     */
    public function sizeImg( $width , $height , $crop = true ){
        // Get our image helper, pass in requirements and get our new image filename
        $helper = new ImgHelper( $this );
        $helper->width = $width;
        $helper->height = $height;
        $helper->crop = $crop;

        return $helper->get();
    }

    /**
     * Set the order of the ID's from 0 to the array length passed in
     * @param array $ids The Upload IDs
     */
    public function setOrder( $ids ){
        // Don't do anything if nothing is passed in
        if(!$ids)
            return;

        // Set single integer to arrays
        if( !is_array($ids) )
            $ids = [ $ids ];

        // Loop through each id and update the database accordingly
        foreach($ids as $order=>$id){
            $this->where('id','=',$id)->update( [ 'order'=>$order ] );
        }
        
        return true;
    }

}