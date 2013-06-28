<?php
namespace Davzie\ProductCatalog\Entities;
use App;

class BaseUpload {

    /**
     * The uploads object
     * @var UploadRepository
     */
    protected $uploads;

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

        // Tidy grouped method for getting new file name
        $getNewFileName = function( $fileObj ){
            $randomKey = sha1( time() . microtime() );
            $extension = $fileObj->getClientOriginalExtension();
            return $randomKey.'.'.$extension;
        };

        $filename   = $getNewFileName( Input::file('file') );
        $path       = public_path() . '/uploads/' . static::$type . '/' . $id;

        $upload_success = Input::file('file')->move( $path , $filename );

        if( $upload_success ){
            // Do model stuff here
            return true;
        }

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