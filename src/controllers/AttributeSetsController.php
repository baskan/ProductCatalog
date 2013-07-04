<?php
namespace Davzie\ProductCatalog\Controllers;
use View;
use Redirect;
use Davzie\ProductCatalog\Attribute;
use Davzie\ProductCatalog\Attribute\Set;
use Davzie\ProductCatalog\Attribute\Set\Entities\Create as AttributeSetNew;
use Davzie\ProductCatalog\Attribute\Set\Entities\Edit as AttributeSetEdit;

class AttributeSetsController extends ManageBaseController {

    /**
     * The attributes object
     * @var Davzie\ProductCatalog\Attribute
     */
    protected $attributes;

    /**
     * The attribute sets object
     * @var Davzie\ProductCatalog\Attribute\Set
     */
    protected $attribute_sets;

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
    public function __construct( Set $attribute_sets , Attribute $attributes ){
        $this->attributes = $attributes;
        $this->attribute_sets = $attribute_sets;
        parent::__construct();
    }

    /**
     * Delete an attribute set based on the ID passed in
     * @param  integer $id The attribute set ID
     * @return Redirect
     */
    public function getDelete( $id )
    {
        $this->attribute_sets->where('id','=',$id)->delete();
        return Redirect::to('manage/attribute-sets')->with('success','<strong>Attribute Set Deleted</strong> The attribute set was properly removed.');
    }

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        return View::make( 'ProductCatalog::attribute_sets.dashboard' )
                ->with( 'sets' , $this->attribute_sets->getAll() );
    }

    /**
     * Edit the set
     * @param       integer  $id    The ID Of The Set To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null )
    {
        $set = $this->attribute_sets->find($id);

        if( !$set )
            return Redirect::to('manage/attribute-sets');

        $assignedAttributes = $set->attributes()->lists('key','key');

        return View::make('ProductCatalog::attribute_sets.edit')
                    ->with( 'assignedAttributes' , $assignedAttributes )
                    ->with( 'attributes' , $this->attributes->getAll() )
                    ->with( 'set' , $set );
    }

    /**
     * Accept the input from the new attribute set page
     * @return Redirect
     */
    public function postNew(){
        $entity = new AttributeSetNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/attribute-sets/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/attribute-sets/' )->with('success','Attribute Set Added');
    }

    /**
     * The new attribute set page
     * @access public
     * @return View
     */
    public function getNew(){
        return View::make('ProductCatalog::attribute_sets.new');
    }

    /**
     * Edit the attribute set, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new AttributeSetEdit( $id );

        if ( $entity->isValid() === false )
            return Redirect::to('manage/attribute-sets/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );

        // Hydrate it with data from the POST
        $entity->hydrate();
        return Redirect::to( 'manage/attribute-sets/' )->with('success','Attribute Set Updated.');
    }

}