<?php
namespace Davzie\ProductCatalog;
use Validator;
use Input;
use Illuminate\Support\MessageBag;
use App;
use Config;
use Auth;

class UploadEntity {

    /**
     * The uploads object
     * @var UploadRepository
     */
    protected $uploads;

    /**
     * The name of the model, this is required as it creates the relation between the upload and the model in question
     * @var string
     */
    protected static $model;

    /**
     * The type of upload, basically will be the initial path of the uploads /products /categories etc.
     * @var string
     */
    protected static $type;

    /**
     * The rules to apply to stuffs
     * @var array
     */
    protected static $rules;

    /**
     * The current record ID to work with ( not upload record, but product, category etc )
     * @var integer
     */
    protected $currentId;

    /**
     * The errors
     * @var MessageBag
     */
    protected $errors;

    public function __construct( $id ){
        $this->uploads = App::make('Davzie\ProductCatalog\Models\Interfaces\UploadRepository');
        $this->currentId = $id;
        $this->errors = new MessageBag();
    }
    

    /**
     * Determine if the uploads are valid
     * @return boolean
     */
    public function isValid(){
        $validation = Validator::make( [ 'id' => $this->currentId , 'file' => Input::file('file') ] , static::$rules );

        if ( $validation->fails() ){
            foreach( $validation->messages()->all() as $error ){
                $this->errors->add('error',$error);
            }
            return false;
        }

        return true;
    }

    /**
     * Hydrate the uploads model accordingly and move all the files around
     * @return boolean Successful or not basically...
     */
    public function hydrate(){
        $base_path = Config::get('ProductCatalog::app.upload_base_path');
        // Setup some useful variables
        $randomKey  = sha1( time() . microtime() );
        $extension  = Input::file('file')->getClientOriginalExtension();
        $filename   = $randomKey.'.'.$extension;
        $path       = '/'.$base_path.'/' . static::$type . '/' . $this->currentId;

        // Move the file and determine if it was succesful or not
        $upload_success = Input::file('file')->move( public_path() . $path , $filename );

        // Do our model insertion activity
        if( $upload_success ){

            $now = date('Y-m-d H:i:s');
            $data = [
                'link_type'     =>  static::$model,
                'link_id'       =>  $this->currentId,
                'path'          =>  static::$type,
                'filename'      =>  $filename,
                'extension'     =>  $extension,
                'order'         =>  999,
                'user_id'       =>  Auth::user()->id,
                'created_at'    =>  $now,
                'updated_at'    =>  $now
            ];

            // Insert the data into the uploads model
            return $this->uploads->insertGetId( $data );
        }

        // If we ever get here it means we have some serious-ass errors, lets figure out what they are.
        $this->errors->add('error','There was an error uploading the file to the correct path.');
        return false;
    }

    /**
     * Return the MessageBag Instance
     * @return MessageBag
     */
    public function errors(){
        return $this->errors;
    }

}