<?php 

namespace App\Exports;
use App\Models\Patients;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class PatientsListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Patients::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Patient Id',
			'Full Name',
			'Gender',
			'Birth Date',
			'Phone',
			'Email',
			'Address',
			'Created At'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->patient_id,
			$record->full_name,
			$record->gender,
			$record->birth_date,
			$record->phone,
			$record->email,
			$record->address,
			$record->created_at
        ];
    }
}
