<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Staff extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'staff';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'staff_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["name","role","phone","email","is_active"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				staff_id LIKE ?  OR 
				name LIKE ?  OR 
				role LIKE ?  OR 
				phone LIKE ?  OR 
				email LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%","%$text%"
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
			"staff_id", 
			"name", 
			"role", 
			"phone", 
			"email", 
			"is_active" 
		];
	}

	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"staff_id", 
			"name", 
			"role", 
			"phone", 
			"email", 
			"is_active" 
		];
	}

	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"staff_id", 
			"name", 
			"role", 
			"phone", 
			"email", 
			"is_active" 
		];
	}

	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"staff_id", 
			"name", 
			"role", 
			"phone", 
			"email", 
			"is_active" 
		];
	}

	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"staff_id", 
			"name", 
			"role", 
			"phone", 
			"email", 
			"is_active" 
		];
	}

	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
