<?php 

namespace App\Exports;
use App\Models\Appointments;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class AppointmentsViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Appointments::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("appointment_id", $this->rec_id);
    }


	public function headings(): array
    {
        return [
			'Appointment Id',
			'Patient Id',
			'Service Id',
			'Staff Id',
			'Appointment Date',
			'Status',
			'Notes'
        ];
    }


    public function map($record): array
    {
        return [
			$record->appointment_id,
			$record->patient_id,
			$record->service_id,
			$record->staff_id,
			$record->appointment_date,
			$record->status,
			$record->notes
        ];
    }
}
