<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Services extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'services';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'service_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["name","category","price","duration_min","description","is_active"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				service_id LIKE ?  OR 
				name LIKE ?  OR 
				category LIKE ?  OR 
				description LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%"
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
			"service_id", 
			"name", 
			"category", 
			"price", 
			"duration_min", 
			"description", 
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
			"service_id", 
			"name", 
			"category", 
			"price", 
			"duration_min", 
			"description", 
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
			"service_id", 
			"name", 
			"category", 
			"price", 
			"duration_min", 
			"description", 
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
			"service_id", 
			"name", 
			"category", 
			"price", 
			"duration_min", 
			"description", 
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
			"service_id", 
			"name", 
			"category", 
			"price", 
			"duration_min", 
			"description", 
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
