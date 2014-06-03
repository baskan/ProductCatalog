<?php
namespace Davzie\ProductCatalog\User\Repositories;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Davzie\ProductCatalog\User;
use Eloquent as IEloquent;
use Hash;

class Eloquent extends IEloquent implements UserInterface, RemindableInterface, User {

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
	 * Get all users in the system
	 * @return Eloquent
	 */
	public function getAll(){
		return $this->all();
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
	
public function getRememberToken()
{
    return $this->remember_token;
}

public function setRememberToken($value)
{
    $this->remember_token = $value;
}

public function getRememberTokenName()
{
    return 'remember_token';
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
     * A mutator to ensure that when password's get set, they are actually hashed
     * @param string $value The new password
     */
    public function setPasswordAttribute($value){
    	$this->attributes['password'] = Hash::make( $value );
    }

}