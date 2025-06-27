<?php 

namespace App\Exports;
use App\Models\Payments;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class PaymentsViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Payments::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("payment_id", $this->rec_id);
    }


	public function headings(): array
    {
        return [
			'Payment Id',
			'Appointment Id',
			'Amount',
			'Method',
			'Payment Date',
			'Status'
        ];
    }


    public function map($record): array
    {
        return [
			$record->payment_id,
			$record->appointment_id,
			$record->amount,
			$record->method,
			$record->payment_date,
			$record->status
        ];
    }
}
