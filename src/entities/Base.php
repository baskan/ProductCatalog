<?php
namespace Davzie\ProductCatalog\Entities;
use Validator;
use Input;
use Illuminate\Support\MessageBag;
use Exception;
use App;

class Base {

    /**
     * The rules for the form for validation
     * @return array
     */
    protected static $rules = [];

    /**
     * The model to hydrate into
     * @var mixed
     */
    protected static $model;

    /**
     * The errors
     * @var MessageBag
     */
    protected $errors;

    /**
     * The inserted record's ID
     * @var integer
     */
    protected $insertId;

    /**
     * Construct stuff
     */
    public function __construct(){
        $this->errors = new MessageBag();
    }

    /**
     * Check that the contents of POST are valid for this model
     * @return boolean
     */
    public function isValid(){

        $validation = Validator::make( Input::all() , static::$rules );

        if ( $validation->fails() ){
            foreach( $validation->messages()->all() as $error ){
                $this->errors->add('error',$error);
            }
            return false;
        }

        return true;
    }

    /**
     * Hydrate the model with data from the POST request
     * @return null
     */
    public function hydrate(){
        $data = [];
        foreach( static::$rules as $field=>$val ){
            $data[$field] = Input::get($field);
        }
        $model = App::make(static::$model);
        return $this->insertId = $model->insertGetId( $data );
    }

    /**
     * Return the MessageBag Instance
     * @return MessageBag
     */
    public function errors(){
        return $this->errors;
    }

}