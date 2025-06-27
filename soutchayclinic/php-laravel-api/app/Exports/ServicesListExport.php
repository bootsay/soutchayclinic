<?php 

namespace App\Exports;
use App\Models\Services;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ServicesListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Services::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Service Id',
			'Name',
			'Category',
			'Price',
			'Duration Min',
			'Description',
			'Is Active'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->service_id,
			$record->name,
			$record->category,
			$record->price,
			$record->duration_min,
			$record->description,
			$record->is_active
        ];
    }
}
