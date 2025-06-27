<?php 

namespace App\Exports;
use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ProductsListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Products::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Product Id',
			'Name',
			'Category',
			'Stock Quantity',
			'Cost Price',
			'Sale Price'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->product_id,
			$record->name,
			$record->category,
			$record->stock_quantity,
			$record->cost_price,
			$record->sale_price
        ];
    }
}
