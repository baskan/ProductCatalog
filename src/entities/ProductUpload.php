<?php
namespace Davzie\ProductCatalog\Entities;
use App;

class ProductUpload extends BaseUpload {

    /**
     * The rules to apply to stuffs
     * @var array
     */
    protected static $rules = [
        'id'        => 'required|exists:products,id',
        'file'      => 'image|max:3000'
    ];

    /**
     * The type of upload, basically will be the initial path of the uploads /products /categories etc.
     * @var string
     */
    protected static $type = 'products';

}