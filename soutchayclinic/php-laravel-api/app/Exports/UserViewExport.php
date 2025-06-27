<?php 

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class UserViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(User::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("userid", $this->rec_id);
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
