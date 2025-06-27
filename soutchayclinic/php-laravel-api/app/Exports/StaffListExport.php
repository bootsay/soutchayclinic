<?php 

namespace App\Exports;
use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class StaffListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Staff::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Staff Id',
			'Name',
			'Role',
			'Phone',
			'Email',
			'Is Active'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->staff_id,
			$record->name,
			$record->role,
			$record->phone,
			$record->email,
			$record->is_active
        ];
    }
}
