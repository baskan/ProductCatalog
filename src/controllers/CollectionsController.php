<?php
namespace Davzie\ProductCatalog\Controllers;
use View, Redirect,Request,Response,Input,App;
use Davzie\ProductCatalog\Collection;
use Davzie\ProductCatalog\Collection\Entities\Create as CollectionNew;
use Davzie\ProductCatalog\Collection\Entities\Edit as CollectionEdit;


class CollectionsController extends ManageBaseController {

    /**
     * The collections object
     * @var Collection
     */
    protected $collections;

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
    public function __construct( Collection $collections ){
        $this->collections = $collections;
        parent::__construct();
    }

    /**
     * Delete a category based on the ID passed in
     * @param  integer $id The category ID
     * @return Redirect
     */
    public function getDelete( $id ){
        $this->collections->deleteById( $id );
        return Redirect::to('manage/collections')->with('success','<strong>Collection Deleted</strong> The collection was properly removed.');
    }

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        return View::make( 'ProductCatalog::collections.dashboard' )
                ->with( 'collections' , $this->collections->getAll() );
    }

    /**
     * Edit the category
     * @param       string  $sku    The Slug Of The Category To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null ){
        $collection = $this->collections->find($id);

        if( !$collection )
            return Redirect::to('manage/collections');

        return View::make('ProductCatalog::collections.edit')
                    ->with( 'collection' , $collection );
    }

    /**
     * Accept the input from the new category page
     * @return Redirect
     */
    public function postNew(){
        $entity = new CollectionNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/collections/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/collections/' )->with('success','<strong>Collection Added</strong>');
    }

    /**
     * The new product page
     * @access public
     * @return View
     */
    public function getNew(){
        return View::make('ProductCatalog::collections.new');
    }

    /**
     * Edit the product, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new CollectionEdit( $id );

        if ( $entity->isValid() === false )
            return Redirect::to('manage/collections/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $entity->hydrate();
        return Redirect::to( 'manage/collections/' )->with('success','Collection Updated.');
    }

}