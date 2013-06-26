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
     * Determine whether to input timestamps or not
     * @var boolean
     */
    protected static $timestamps = true;

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [];

    /**
     * The ID of the record you're currently UPDATING
     * If null we will insert records
     * @var integer
     */
    protected $currentId;

    /**
     * Construct stuff
     */
    public function __construct(){
        $this->errors = new MessageBag();
    }

    /**
     * Set the current ID that we're working with
     * @param integer $id The ID of the record
     */
    public function setCurrentId( $id ){
        $this->currentId = $id;
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

        // If this evalutes to true then we are editing an existing record so we use a different method
        if( null !== $this->currentId )
            return $this->save();

        // Create our data array and some solid defaults
        $data = [];

        // Check to see if we actually want timestamps, they might not be valid for this model for example
        if( static::$timestamps === true ){
            $now = date('Y-m-d H:i:s');
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
        }

        // Add our default data that isn't post related from our static
        foreach( static::$defaultData as $field=>$val )
            $data[$field] = $val;
        
        // Go through and add our post data into the data array too
        foreach( static::$rules as $field=>$val )
            $data[$field] = Input::get($field);
        
        // Save the Insert ID and return it from the insertion
        return $this->insertId = App::make( static::$model )->insertGetId( $data );
    }

    /**
     * Save any existing data into an existing record
     * @return boolean
     */
    private function save(){
        $product = App::make( static::$model )->find( $this->currentId );

        // Check to see we actually got a product here
        if( !$product )
            return false;

        // Add our default data that isn't post related from our static
        foreach( static::$defaultData as $field=>$val )
            $product->$field = $val;
        
        // Go through and add our post data into the data array too
        foreach( static::$rules as $field=>$val )
            $product->$field =  Input::get($field);

        return $product->save();
    }

    /**
     * Return the MessageBag Instance
     * @return MessageBag
     */
    public function errors(){
        return $this->errors;
    }

}