<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Products extends Model 
{
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'products';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'product_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = ["name","category","stock_quantity","cost_price","sale_price"];
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				product_id LIKE ?  OR 
				name LIKE ?  OR 
				category LIKE ? 
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
			"product_id", 
			"name", 
			"category", 
			"stock_quantity", 
			"cost_price", 
			"sale_price" 
		];
	}

	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"product_id", 
			"name", 
			"category", 
			"stock_quantity", 
			"cost_price", 
			"sale_price" 
		];
	}

	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"product_id", 
			"name", 
			"category", 
			"stock_quantity", 
			"cost_price", 
			"sale_price" 
		];
	}

	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"product_id", 
			"name", 
			"category", 
			"stock_quantity", 
			"cost_price", 
			"sale_price" 
		];
	}

	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"product_id", 
			"name", 
			"category", 
			"stock_quantity", 
			"cost_price", 
			"sale_price" 
		];
	}

	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
	public $timestamps = false;
}
