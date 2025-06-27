<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatientsAddRequest;
use App\Http\Requests\PatientsEditRequest;
use App\Models\Patients;
use Illuminate\Http\Request;

use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientsListExport;
use App\Exports\PatientsViewExport;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Config;
use Exception;

class PatientsController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$query = Patients::query();
		if($request->search){
			$search = trim($request->search);
			Patients::search($query, $search);
		}
		$orderby = $request->orderby ?? "patients.patient_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a single field name
		}
		// if request format is for export example:- product/index?export=pdf
		if($this->getExportFormat()){
			return $this->ExportList($query, $request); // export current query
		}

		$records = $this->paginate($query, Patients::listFields());
		return $this->respond($records);
	}
	/**
     * Load csv|json data
     * @return data
     */
	function importdata(Request $request){
		$importSettings = config("upload.import");
		$maxFileSize = intval($importSettings["max_file_size"]) * 1000; //in kilobyte
		$validator = Validator::make($request->all(), 
			[
				"file" => "file|required|max:$maxFileSize|mimes:csv,txt",
			]
		);
		if ($validator->fails()) {
			return $this->reject($validator->errors(), 400);
		}
		$csvOptions = array(
			'fields' => '', //leave empty to use the first row as the columns
			'delimiter' => ',', 
			'quote' => '"'
		);
		$filePath = $request->file('file')->getRealPath();
		$modeldata = $this->parse_csv_data($filePath, $csvOptions);
		$result = Patients::insert($modeldata);
		return $this->respond($result);
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view(Request $request, $rec_id = null){
		$query = Patients::query();
		// if request format is for export example:- product/view/344?export=pdf
		if($this->getExportFormat()){
			return $this->ExportView($query, $rec_id, $request);
		}

		$record = $query->findOrFail($rec_id, Patients::viewFields());
		return $this->respond($record);
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function add(PatientsAddRequest $request){
		$modeldata = $request->validated();
		
		//save Patients record
		$record = Patients::create($modeldata);
		$rec_id = $record->patient_id;
		return $this->respond($record);
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(PatientsEditRequest $request, $rec_id = null){
		$query = Patients::query();
		$record = $query->findOrFail($rec_id, Patients::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $request->validated();
			$record->update($modeldata);
		}
		return $this->respond($record);
	}
	

	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
	 * @param  \Illuminate\Http\Request
	 * @param string $rec_id //can be separated by comma 
     * @return \Illuminate\Http\Response
     */
	function delete(Request $request, $rec_id = null){
		$arr_id = explode(",", $rec_id);
		$query = Patients::query();
		$query->whereIn("patient_id", $arr_id);
		$query->delete();
		return $this->respond($arr_id);
	}
	

	/**
     * Export table records to different format
	 * supported format:- PDF, CSV, EXCEL, HTML
	 * @param \Illuminate\Database\Eloquent\Model $query
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	private function ExportList($query, $request){
		ob_end_clean(); // clean any output to allow file download
		$filename = "ListPatientsReport-" . date_now();

		$format = $this->getExportFormat();

		if($format == "print"){
			$records = $query->get(Patients::exportListFields());
			return view("reports.patients-list", ["records" => $records]);
		}
		elseif($format == "pdf"){
			$records = $query->get(Patients::exportListFields());
			$pdf = PDF::loadView("reports.patients-list", ["records" => $records]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new PatientsListExport($query), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new PatientsListExport($query), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
		}
	}
	

	/**
     * Export single record to different format
	 * supported format:- PDF, CSV, EXCEL, HTML
	 * @param \Illuminate\Database\Eloquent\Model $record
	 * @param string $rec_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	private function ExportView($query, $rec_id, $request){
		ob_end_clean();// clean any output to allow file download
		$filename ="ViewPatientsReport-" . date_now();
		$format = $this->getExportFormat();
		if($format == "print"){
			$record = $query->findOrFail($rec_id, Patients::exportViewFields());
			return view("reports.patients-view", ["record" => $record]);
		}
		elseif($format == "pdf"){
			$record = $query->findOrFail($rec_id, Patients::exportViewFields());
			$pdf = PDF::loadView("reports.patients-view", ["record" => $record]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new PatientsViewExport($query, $rec_id), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new PatientsViewExport($query, $rec_id), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
		}
	}
}
