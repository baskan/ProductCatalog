<?php
namespace Davzie\ProductCatalog\Controllers;
use Illuminate\Support\MessageBag;
use View;
use Auth;
use Redirect;
use Validator;
use Session;
use Input;
use Davzie\ProductCatalog\Product;

class ManageController extends ManageBaseController {

    /**
     * The products object
     * @var Product
     */
    protected $products;

    /**
     * Let's whitelist all the methods we want to allow guests to visit!
     *
     * @access   protected
     * @var      array
     */
    protected $whitelist = array(
        'getLogin',
        'getLogout',
        'postLogin'
    );

    /**
     * Construct shit
     */
    public function __construct( Product $products ){
        $this->products = $products;
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
        return View::make( 'ProductCatalog::dashboard' )->with('product_count', $this->products->activeProducts()->count() );
    }

    /**
     * Log the user out
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return Redirect::to('manage/login')->with('success','Succesfully logged out.');
    }

    /**
     * Login form page.
     *
     * @access   public
     * @return   View
     */
    public function getLogin()
    {

        // If logged in, redirect to admin area
        if (Auth::check())
        {
            return Redirect::to('manage');
        }

        return View::make('ProductCatalog::login')->with('success' , Session::get('success'));
    }

    /**
     * Login form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postLogin()
    {
        // Declare the rules for the form validation.
        $rules = [
            'email'    => 'Required|Email',
            'password' => 'Required'
        ];

        // Validate the inputs.
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        if ($validator->passes())
        {
            // Try to log the user in.
            if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
            {
                $user = Auth::user();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                // Redirect to the users page.
                return Redirect::to('manage')->with('success', 'You have logged in successfully');
            }
            else
            {
                // Redirect to the login page.
                return Redirect::to('manage/login')->with('errors', new MessageBag(['Invalid Email and Password']) );
            }
        }

        // Something went wrong.
        return Redirect::to('manage/login')->withErrors( $validator->messages() )->withInput();
    }

}