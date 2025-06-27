<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\TreatmentRecordsAddRequest;
use App\Http\Requests\TreatmentRecordsEditRequest;
use App\Models\TreatmentRecords;
use Illuminate\Http\Request;

use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TreatmentrecordsListExport;
use App\Exports\TreatmentrecordsViewExport;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Config;
use Exception;

class TreatmentRecordsController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$query = TreatmentRecords::query();
		if($request->search){
			$search = trim($request->search);
			TreatmentRecords::search($query, $search);
		}
		$orderby = $request->orderby ?? "treatment_records.record_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a single field name
		}
		// if request format is for export example:- product/index?export=pdf
		if($this->getExportFormat()){
			return $this->ExportList($query, $request); // export current query
		}

		$records = $this->paginate($query, TreatmentRecords::listFields());
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
		$result = TreatmentRecords::insert($modeldata);
		return $this->respond($result);
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view(Request $request, $rec_id = null){
		$query = TreatmentRecords::query();
		// if request format is for export example:- product/view/344?export=pdf
		if($this->getExportFormat()){
			return $this->ExportView($query, $rec_id, $request);
		}

		$record = $query->findOrFail($rec_id, TreatmentRecords::viewFields());
		return $this->respond($record);
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function add(TreatmentRecordsAddRequest $request){
		$modeldata = $request->validated();
		
		//save TreatmentRecords record
		$record = TreatmentRecords::create($modeldata);
		$rec_id = $record->record_id;
		return $this->respond($record);
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(TreatmentRecordsEditRequest $request, $rec_id = null){
		$query = TreatmentRecords::query();
		$record = $query->findOrFail($rec_id, TreatmentRecords::editFields());
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
		$query = TreatmentRecords::query();
		$query->whereIn("record_id", $arr_id);
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
		$filename = "ListTreatmentRecordsReport-" . date_now();

		$format = $this->getExportFormat();

		if($format == "print"){
			$records = $query->get(TreatmentRecords::exportListFields());
			return view("reports.treatmentrecords-list", ["records" => $records]);
		}
		elseif($format == "pdf"){
			$records = $query->get(TreatmentRecords::exportListFields());
			$pdf = PDF::loadView("reports.treatmentrecords-list", ["records" => $records]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new TreatmentrecordsListExport($query), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new TreatmentrecordsListExport($query), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
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
		$filename ="ViewTreatmentRecordsReport-" . date_now();
		$format = $this->getExportFormat();
		if($format == "print"){
			$record = $query->findOrFail($rec_id, TreatmentRecords::exportViewFields());
			return view("reports.treatmentrecords-view", ["record" => $record]);
		}
		elseif($format == "pdf"){
			$record = $query->findOrFail($rec_id, TreatmentRecords::exportViewFields());
			$pdf = PDF::loadView("reports.treatmentrecords-view", ["record" => $record]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new TreatmentrecordsViewExport($query, $rec_id), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new TreatmentrecordsViewExport($query, $rec_id), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
		}
	}
}
