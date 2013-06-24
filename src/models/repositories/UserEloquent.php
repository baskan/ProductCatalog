<?php
namespace Davzie\ProductCatalog\Models;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;
use Davzie\ProductCatalog\Models\Interfaces\UserRepository;

class UserEloquent extends Eloquent implements UserInterface, RemindableInterface, UserRepository {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password','is_admin','updated_at');

	/**
	 * These are the mass-assignable keys
	 * @var array
	 */
	protected $fillable = array('first_name', 'last_name', 'email');

	/**
	 * Determine if the user is just a customer
	 * @return boolean True if the user is a customer
	 */
	public function isCustomer(){
		return !$this->is_admin;
	}

	/**
	 * Get the amount of active customers
	 * @return Eloquent
	 */
	public function scopeactiveCustomers($query){
		return $query->where('is_admin', '=', false);
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the full name of the user
	 * @return string
	 */
	public function getFullName(){
		return $this->first_name.' '.$this->last_name;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * The transactions for the user
	 * @return [type] [description]
	 */
	public function transactions(){
		return $this->hasMany('Transaction\Eloquent','user_id');
	}

}