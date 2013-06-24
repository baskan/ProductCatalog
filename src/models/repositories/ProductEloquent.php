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
    protected $fillable = [];

    /**
     * Get all the products in the system
     * @return Eloquent
     */
    public function getAll(){
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

    /**
     * Get a product by its SKU
     * @param  string $sku The Product SKU
     * @return Eloquent    The product found
     */
    public function getBySku( $sku ){
        return $this->where('sku','=',$sku)->first();
    }

}