<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Config;
use Davzie\ProductCatalog\Models\Interfaces\UploadRepository;

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
        return $this->all();
    }

    /**
     * The relationship that links to this upload...
     * @return Eloquent
     */
    public function link(){
        return $this->morphTo();
    }

    /**
     * Get the thumbnail image
     * @return Eloquent
     */
    public function thumbnailImage(){
        return $this->where( 'thumbnail' , '=' , true )->first();
    }

    /**
     * Get the thumbnail image
     * @return Eloquent
     */
    public function mainImage(){
        return $this->where( 'main' , '=' , true )->first();
    }

    /**
     * Get the images that are eligible to be showin in a gallery
     * @return Collection
     */
    public function galleryImages(){
        return $this->where( 'gallery' , '=' , true )->get();
    }

    /**
     * Get the usable src (public path and filename)
     * @return string
     */
    public function getSrc(){
        $base_path = Config::get('ProductCatalog::app.upload_base_path');
        return url( $base_path.$this->path.'/'.$this->link_id.'/'.$this->filename );
    }

    /**
     * Get the absolute usable src ( /var/www/vhosts/domain.com/public/uploads/products/filename.jpg etc )
     * @return string
     */
    public function getAbsoluteSrc(){
        $base_path = Config::get('ProductCatalog::app.upload_base_path');
        return public_path().$base_path.'/'.$this->path.'/'.$this->link_id.'/'.$this->filename;
    }

}