<?php 

namespace App\Exports;
use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class StaffViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Staff::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("staff_id", $this->rec_id);
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
