<?php
namespace Davzie\ProductCatalog\Entities;
use App;
use Input;
use Str;

class CategoryNew extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\CategoryRepository';

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [
        'enabled'=>1,
    ];

    protected static $rules = [
        'name'  => 'required|max:255',
        'url'   =>  'required|alpha_dash|unique:categories,url',
    ];

    public function __construct(){
        // Default Data
        static::$defaultData['slug'] = Str::slug( Input::get('name') , '-' );
        parent::__construct();
    }

}