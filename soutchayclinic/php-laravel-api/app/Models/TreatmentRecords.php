<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TreatmentRecords extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'treatment_records';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'record_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["appointment_id","notes","treatment_result"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				record_id LIKE ?  OR 
				notes LIKE ?  OR 
				treatment_result LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%"
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
			"record_id", 
			"appointment_id", 
			"notes", 
			"treatment_result", 
			"created_at" 
		];
	}

	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"record_id", 
			"appointment_id", 
			"notes", 
			"treatment_result", 
			"created_at" 
		];
	}

	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"record_id", 
			"appointment_id", 
			"notes", 
			"treatment_result", 
			"created_at" 
		];
	}

	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"record_id", 
			"appointment_id", 
			"notes", 
			"treatment_result", 
			"created_at" 
		];
	}

	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"record_id", 
			"appointment_id", 
			"notes", 
			"treatment_result" 
		];
	}

	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
