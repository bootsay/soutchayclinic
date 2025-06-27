<?php 

namespace App\Exports;
use App\Models\TreatmentRecords;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class TreatmentrecordsViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(TreatmentRecords::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("record_id", $this->rec_id);
    }


	public function headings(): array
    {
        return [
			'Record Id',
			'Appointment Id',
			'Notes',
			'Treatment Result',
			'Created At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->record_id,
			$record->appointment_id,
			$record->notes,
			$record->treatment_result,
			$record->created_at
        ];
    }
}
