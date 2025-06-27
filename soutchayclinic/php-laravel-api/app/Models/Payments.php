<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payments extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'payments';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'payment_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["appointment_id","amount","method","status"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				payment_id LIKE ?  OR 
				method LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%"
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
			"payment_id", 
			"appointment_id", 
			"amount", 
			"method", 
			"payment_date", 
			"status" 
		];
	}

	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"payment_id", 
			"appointment_id", 
			"amount", 
			"method", 
			"payment_date", 
			"status" 
		];
	}

	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"payment_id", 
			"appointment_id", 
			"amount", 
			"method", 
			"payment_date", 
			"status" 
		];
	}

	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"payment_id", 
			"appointment_id", 
			"amount", 
			"method", 
			"payment_date", 
			"status" 
		];
	}

	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"payment_id", 
			"appointment_id", 
			"amount", 
			"method", 
			"status" 
		];
	}

	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
