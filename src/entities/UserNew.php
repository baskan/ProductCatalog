<?php
namespace Davzie\ProductCatalog\Entities;
class UserNew extends Base {

    protected static $model = 'Davzie\ProductCatalog\Models\Interfaces\UserRepository';

    /**
     * We may want to specify fixed stuff to throw into the database, do so here.
     * @var array
     */
    protected static $defaultData = [
        'is_admin'=>1,
    ];

    protected static $rules = [
        'email'  => 'required|email|unique:users,email|max:255',
        'password'  => 'confirmed|max:255',
        'first_name'  => 'required|max:255',
        'last_name'  => 'required|max:255'
    ];

    public function hydrate(){
        // Create our data array and some solid defaults
        $data = [];
        $model = App::make( static::$model );
        // Check to see if we actually want timestamps, they might not be valid for this model for example
        $now = date('Y-m-d H:i:s');
        $model->created_at = $now;
        $model->updated_at = $now;

        // Add our default data that isn't post related from our static
        foreach( static::$defaultData as $field=>$val )
            $model->$field = $val;
        
        // Go through and add our post data into the data array too
        foreach( static::$rules as $field=>$val )
            $model->$field = Input::get($field);
        
        // Save the Insert ID and return it from the insertion
        return $model->save();
    }

}