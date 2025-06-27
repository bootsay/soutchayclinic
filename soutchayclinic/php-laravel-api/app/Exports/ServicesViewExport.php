<?php 

namespace App\Exports;
use App\Models\Services;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ServicesViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Services::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("service_id", $this->rec_id);
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
