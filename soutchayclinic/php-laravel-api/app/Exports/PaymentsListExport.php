<?php 

namespace App\Exports;
use App\Models\Payments;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class PaymentsListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Payments::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
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
