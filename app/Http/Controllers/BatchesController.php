<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Http\Requests\Batch\CreateBatchRequest;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Batch;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Repositories\Vendor\VendorRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Support\Enum\SubBatchStatus;
use DB;
use Excel;
use App\Http\Requests;


/**
 * Class BatchesController - Controls all the operations for batch entity
 * @package Vanguard\Http\Controllers
 */
class BatchesController extends Controller
{
	/**
	 * @var BatchRepository
	 */
	private $batches;
	private $theUser;
	
	/**
	 * BatchesController constructor.
	 * @param BatchRepository $users
	 */
	public function __construct(BatchRepository $batches)
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:batches.manage');
		$this->batches = $batches;
		$this->theUser = Auth::user();
	}

	/**
	 * Display paginated list of all batches with some filter.
	 * @param VendorRepository $vendorRepository
	 * @param ProjectRepository $projectRepository
	 * @return the list of batches.
	 */
	public function index(VendorRepository $vendorRepository,ProjectRepository $projectRepository)
	{
		$perPage = 5;
		if ($this->theUser->username == 'admin') {
			$batches = $this->batches->paginate($perPage, Input::get('search'), null , Input::get('status'),Input::get('vendor_code'),Input::get('code'));
		} 
		else {
			$batches = $this->batches->paginate($perPage, Input::get('search'), $this->theUser->vendor_id,Input::get('status'));
		}
		
		$statuses = ['' => trans('app.all_status')] + SubBatchStatus::lists();
		$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
		$projects =	[''=>trans('app.all_project')] + $projectRepository->lists1();
		return view('batch.list', compact('batches', 'statuses','vendors','projects')); 
	}

	/**
	 * Displays form for creating a new batch.
	 * @param ProjectRepository $projectRepository
	 * @param VendorRepository $vendorRepository
	 * @return open add new company window.
	 */
	public function create(ProjectRepository $projectRepository, VendorRepository $vendorRepository)
	{
		$projects = $projectRepository->lists();
		$projects->prepend('Select project', '0');
		$vendors = $vendorRepository->lists();
		$vendors->prepend('select vendors','0');
		$edit = false;
		return view('batch.add-edit', compact('edit', 'projects', 'vendors'));
	}

	/**
	 * Stores new batch into the database and upload the companies dependent on that batch id.
	 * @param CreateBatchRequest $request
	 * @return on list of batches page with success message.
	 */
	public function store(CreateBatchRequest $request)
	{
		$data = $request->all()+ ['status' => SubBatchStatus::ASSIGNED];
		
		//logic for uploading the excel sheet for companies.
		if($request->hasFile('attachement')){
			$path = $request->file('attachement')->getRealPath();
			$data1 = Excel::load($path, function($reader) {
			})->get();
		if($data1->count())
		{
			$batch = $this->batches->create($data);
			if(!empty($data1) && $data1->count()){
				foreach ($data1 as $key => $value) {
					$insert[] = ['batch_id'=>$batch->id,'status' => 'UnAssigned','company_instructions' => $value->company_instructions, 'company_id' => $value->company_id,'parent_company' => $value->parent_company, 'company_name' => $value->company_name,'address1' => $value->address1, 'address2' => $value->address2,'city' => $value->city, 'state' => $value->state,'zipcode' => $value->zipcode, 'country' => $value->country,'isd_code' => $value->international_code, 'switchboardnumber' => $value->switchboardnumber,'branchNumber' => $value->branch_number, 'addresscode' => $value->addresscode,'website' => $value->website, 'company_email' => $value->company_email,
							'products_services' => $value->products_services, 'industry_classfication' => $value->industry_classfication,'employee_size' => $value->employee_size, 'physician_size' => $value->physician_size,'annual_revenue' => $value->annual_revenue, 'number_of_beds' => $value->number_of_beds,'foundation_year' => $value->foundation_year, 'company_remark' => $value->company_remark,'additional_info1' => $value->additional_info1, 'additional_info2' => $value->additional_info2,'additional_info3' => $value->additional_info3, 'additional_info4' => $value->additional_info4];
				}
				if(!empty($insert)){
					DB::table('companies')->insert($insert);
				}
			}
		}
		else
		{
			return redirect()->route('batch.create')->withErrors('Thier is no record in excel sheet');	
		}
		}
		return redirect()->route('batch.list') ->withSuccess(trans('app.batch_created')); 
	}

	/**
	 * downloading the excel shit if status is completed.
	 * @param Batch $batch
	 * @param CompanyRepository $companyRepository
	 * @return unknown
	 */
	public function download(Batch $batch, CompanyRepository $companyRepository)
	{	
		$data = $companyRepository->getTotalCompany($batch->id); //get('$batch->id')->toArray();
		//return $data;
		return Excel::create('Report', function($excel) use ($data) {
			$excel->sheet('companies', function($sheet) use ($data)
			{
				$sheet->fromArray($data);
			});
		})->download('xlsx');
	}
	
	/**
	 * displaying the deleted the batches 
	 * @param Batch $batch
	 * @return on same page with success message.
	 */
	public function delete(Batch $batch)
	{
		$this->batches->delete($batch->id);
		return redirect()->route('batch.list')
		->withSuccess(trans('app.batch_deleted'));
	}
}