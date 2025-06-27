<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class User extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'user';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'userid';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["username","password","displayname","email","phonenumber","user_role_id"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				userid LIKE ?  OR 
				username LIKE ?  OR 
				password LIKE ?  OR 
				DisplayName LIKE ?  OR 
				Email LIKE ?  OR 
				PhoneNumber LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
		];
		//setting search conditions
		$query->whereRaw($search_condition, $search_params);

	}
	

	/**
     * return list page fields of the model.
     * 
     * @return array
     */
	public static function listFields(){
		return [ 
			"userid", 
			"username", 
			"DisplayName AS displayname", 
			"Email AS email", 
			"PhoneNumber AS phonenumber", 
			"user_role_id" 
		];
	}

	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"userid", 
			"username", 
			"DisplayName AS displayname", 
			"Email AS email", 
			"PhoneNumber AS phonenumber", 
			"user_role_id" 
		];
	}

	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"userid", 
			"username", 
			"DisplayName AS displayname", 
			"Email AS email", 
			"PhoneNumber AS phonenumber", 
			"user_role_id" 
		];
	}

	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"userid", 
			"username", 
			"DisplayName AS displayname", 
			"Email AS email", 
			"PhoneNumber AS phonenumber", 
			"user_role_id" 
		];
	}

	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"userid", 
			"username", 
			"DisplayName AS displayname", 
			"Email AS email", 
			"PhoneNumber AS phonenumber", 
			"user_role_id" 
		];
	}

	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
