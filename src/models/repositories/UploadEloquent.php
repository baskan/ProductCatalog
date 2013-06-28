<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
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
     * The relationship that links this back to the product
     * @return Eloquent
     */
    public function product(){
        return $this->belongsTo( 'Davzie\ProductCatalog\Models\ProductEloquent' );
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

}