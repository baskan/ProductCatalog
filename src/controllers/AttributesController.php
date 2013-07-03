<?php
namespace Davzie\ProductCatalog\Controllers;
use View;
use Redirect;
use Davzie\ProductCatalog\Models\Interfaces\AttributeRepository;
use Davzie\ProductCatalog\Entities\AttributeNew;
use Davzie\ProductCatalog\Entities\AttributeEdit;

class AttributesController extends ManageBaseController {

    /**
     * The attribute object
     * @var AttributeRepository
     */
    protected $attributes;

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
    public function __construct( AttributeRepository $attributes ){
        $this->attributes = $attributes;
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
        $set = $this->attributes->find($id);

        if( !$set )
            return Redirect::to('manage/attributes');

        return View::make('ProductCatalog::attributes.edit')
                    ->with( 'set' , $set );
    }

    /**
     * Accept the input from the new attribute set page
     * @return Redirect
     */
    public function postNew(){
        $entity = new AttributeSetNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/attributes/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/attributes/' )->with('success','Attribute Set Added');
    }

    /**
     * The new attribute set page
     * @access public
     * @return View
     */
    public function getNew(){
        return View::make('ProductCatalog::attributes.new');
    }

    /**
     * Edit the attribute set, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new AttributeSetEdit( $id );

        if ( $entity->isValid() === false )
            return Redirect::to('manage/attributes/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );

        // Hydrate it with data from the POST
        $entity->hydrate();
        return Redirect::to( 'manage/attributes/' )->with('success','Attribute Set Updated.');
    }

}