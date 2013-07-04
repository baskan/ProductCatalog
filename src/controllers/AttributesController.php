<?php
namespace Davzie\ProductCatalog\Controllers;
use View;
use Redirect;
use Davzie\ProductCatalog\Attribute;
use Davzie\ProductCatalog\Attribute\Type as AttributeType;
use Davzie\ProductCatalog\Attribute\Entities\Edit as AttributeEdit;
use Davzie\ProductCatalog\Attribute\Entities\Create as AttributeNew;

class AttributesController extends ManageBaseController {

    /**
     * The attribute object
     * @var Attribute
     */
    protected $attributes;

    /**
     * The attribute types available
     * @var AttributeType
     */
    protected $attribute_types;

    /**
     * Let's whitelist all the methods we want to allow guests to visit!
     *
     * @access   protected
     * @var      array
     */
    protected $whitelist = [];

    /**
     * Construct shit
     */
    public function __construct( Attribute $attributes , AttributeType $attribute_types ){
        $this->attributes = $attributes;
        $this->attribute_types = $attribute_types;
        parent::__construct();
    }

    /**
     * Delete an attribute based on the ID passed in
     * @param  integer $id The attribute set ID
     * @return Redirect
     */
    public function getDelete( $id )
    {
        $this->attributes->deleteById( $id );
        return Redirect::to('manage/attributes')->with('success','Attribute Deleted');
    }

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        return View::make( 'ProductCatalog::attributes.dashboard' )
                ->with( 'attributes' , $this->attributes->getAll() );
    }

    /**
     * Edit the object
     * @param       integer  $id    The ID Of The Set To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null )
    {
        $attribute = $this->attributes->find($id);

        if( !$attribute )
            return Redirect::to('manage/attributes');

        $attribute_types = $this->attribute_types->getAll()->lists( 'name' , 'id' );
        $attributeValuesView = View::make( 'ProductCatalog::attributes.partials.attributes.text' )
                                    ->with( 'attribute' , $attribute );

        return View::make('ProductCatalog::attributes.edit')
                    ->with( 'attribute' , $attribute )
                    ->with( 'attributeValuesView' , $attributeValuesView )
                    ->with( 'attribute_types' , $attribute_types );
    }

    /**
     * Accept the input from the new attribute set page
     * @return Redirect
     */
    public function postNew(){
        $entity = new AttributeNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/attributes/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/attributes/' )->with('success','Attribute Added');
    }

    /**
     * The new attribute set page
     * @access public
     * @return View
     */
    public function getNew(){
        $attribute_types = $this->attribute_types->getAll()->lists( 'name' , 'id' );
        return View::make('ProductCatalog::attributes.new')
                    ->with( 'attribute_types' , $attribute_types );
    }

    /**
     * Edit the attribute set, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new AttributeEdit( $id );

        if ( $entity->isValid() === false )
            return Redirect::to('manage/attributes/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );

        // Hydrate it with data from the POST
        $entity->hydrate();
        return Redirect::to( 'manage/attributes/' )->with('success','Attribute Updated.');
    }

}