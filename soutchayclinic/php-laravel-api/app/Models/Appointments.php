<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Appointments extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'appointments';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'appointment_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["patient_id","service_id","staff_id","appointment_date","status","notes"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				appointment_id LIKE ?  OR 
				notes LIKE ? 
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
			"appointment_id", 
			"patient_id", 
			"service_id", 
			"staff_id", 
			"appointment_date", 
			"status", 
			"notes" 
		];
	}

	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"appointment_id", 
			"patient_id", 
			"service_id", 
			"staff_id", 
			"appointment_date", 
			"status", 
			"notes" 
		];
	}

	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"appointment_id", 
			"patient_id", 
			"service_id", 
			"staff_id", 
			"appointment_date", 
			"status", 
			"notes" 
		];
	}

	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"appointment_id", 
			"patient_id", 
			"service_id", 
			"staff_id", 
			"appointment_date", 
			"status", 
			"notes" 
		];
	}

	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"appointment_id", 
			"patient_id", 
			"service_id", 
			"staff_id", 
			"appointment_date", 
			"status", 
			"notes" 
		];
	}

	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
