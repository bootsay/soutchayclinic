<?php 

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class UserListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(User::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Userid',
			'Username',
			'Displayname',
			'Email',
			'Phonenumber',
			'User Role Id'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->userid,
			$record->username,
			$record->displayname,
			$record->email,
			$record->phonenumber,
			$record->user_role_id
        ];
    }
}
