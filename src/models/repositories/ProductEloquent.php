<?php
namespace Davzie\ProductCatalog\Models;
use Eloquent;
use Davzie\ProductCatalog\Models\Interfaces\ProductRepository;

class ProductEloquent extends Eloquent implements ProductRepository {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = array();

    /**
     * Get all the products in the system
     * @return Eloquent
     */
    public function getAllProducts(){
        return $this->all();
    }

    /**
     * Get the active products
     * @return Eloquent
     */
    public function scopeactiveProducts($query){
        return $query->where('enabled', '=', true);
    }


    /**
     * Get the full price of the product (delivery, tax and product cost)
     * @return string
     */
    public function getFullPrice(){
        return $this->price;
    }

}