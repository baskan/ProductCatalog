<?php
namespace Davzie\ProductCatalog\Controllers;
use Davzie\ProductCatalog\Models\Interfaces\UserRepository;
use View;
class UsersController extends ManageBaseController {

    /**
     * The user object
     * @var UserRepository
     */
    protected $users;

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
    public function __construct( UserRepository $users ){
        $this->users = $users;
        parent::__construct();
    }

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        return View::make( 'ProductCatalog::users.dashboard' )
                ->with( 'users' , $this->users->getAll() );
    }

    /**
     * Edit the user
     * @param       string  $sku    The SKU Of The Product To Edit
     * @access      public
     * @return      View
     */
    public function getEdit( $id = null ){
        $user = $this->users->find($id);

        // Redirect all requests where the product doesn't exist back to the main products dashboard
        if( !$user )
            return Redirect::to('manage/users');

        return View::make('ProductCatalog::users.edit')
                    ->with( 'user' , $user );
    }

    /**
     * The new user page
     * @access public
     * @return View
     */
    public function getNew(){
        return View::make('ProductCatalog::users.new');
    }

    /**
     * Accept the input from the new user page
     * @return Redirect
     */
    public function postNew(){
        $entity = new ProductNew();
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/products/new')->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $id = $entity->hydrate();
        return Redirect::to( 'manage/products/edit/'.$id )->with('success','<strong>Product Added</strong> More information is required before you can activate the product.');
    }

    /**
     * Edit the user, dayum this rocks
     * @return Redirect
     */
    public function postEdit( $id ){
        $entity = new ProductEdit( $id );
        
        if ( $entity->isValid() === false )
            return Redirect::to('manage/products/edit/'.$id)->withInput()->with( 'errors' , $entity->errors() );
        
        // Hydrate it with data from the POST
        $entity->hydrate();

        return Redirect::to( 'manage/products/edit/'.$id )->with('success','Product Updated.');
    }

}