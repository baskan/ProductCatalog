<?php
namespace Davzie\ProductCatalog\Category\Entities;
use Illuminate\Support\Facades\App;
use Davzie\ProductCatalog\UploadEntity;

class Upload extends UploadEntity {

    /**
     * The rules to apply to stuffs
     * @var array
     */
    protected static $rules = [
        'id'        => 'required|exists:categories,id',
        'file'      => 'image|max:3000'
    ];

    /**
     * The type of upload, basically will be the initial path of the uploads /products /categories etc.
     * @var string
     */
    protected static $type = 'categories';

    /**
     * The name of the model, this is required as it creates the relation between the upload and the model in question
     * NOTE: This cannot be the interface that would usually be resolved through IoC
     * @var string
     */
    protected static $model = 'Davzie\ProductCatalog\Category\Repositories\Eloquent';

}