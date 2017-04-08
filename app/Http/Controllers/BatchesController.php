<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Http\Requests\Batch\CreateBatchRequest;
use Vanguard\Http\Requests\Batch\UpdateBatchRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Support\Enum\UserStatus;
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
use App\Upload;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;


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
	 * Display paginated list of all batches.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
		
		$statuses = ['' => trans('app.all')] + SubBatchStatus::lists();
		$vendors  =	[''=>trans('app.all')] + $vendorRepository->lists1();
		$projects =	[''=>trans('app.all')] + $projectRepository->lists1();
		return view('batch.list', compact('batches', 'statuses','vendors','projects')); 
	}

	/**
	 * Displays form for creating a new batch.
	 *
	 * @param CountryRepository $countryRepository
	 * @param RoleRepository $roleRepository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
	 * Stores new batch into the database.
	 *
	 * @param CreateBatchRequest $request
	 * @return mixed
	 */
	public function store(CreateBatchRequest $request)
	{
		$data = $request->all()+ ['status' => SubBatchStatus::ASSIGNED];
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
					//dd('Insert Record successfully.');
				}
			}
		}
		else
		{
			return redirect()->route('batch.create')->withErrors('Thier is no record in excel sheet');	
		}
		}

		return redirect()->route('batch.list')
		->withSuccess(trans('app.batch_created'));
		 
	}

	/**
	 * Displays edit batch form.
	 *
	 * @param Batch $batch
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Batch $batch, ProjectRepository $projectRepository, VendorRepository $vendorRepository)
	{
		$projects = $projectRepository->lists();
		$vendors = $vendorRepository->lists();
		$edit = true;
		return view('batch.add-edit', compact('edit', 'batch', 'projects', 'vendors'));
	}

	/**
	 * Update specified batch with provided data.
	 *
	 * @param Role $role
	 * @param UpdateRoleRequest $request
	 * @return mixed
	 */
	public function update(Batch $batch, UpdateBatchRequest $request)
	{
		$this->batches->update($batch->id, $request->all()+ ['status' => SubBatchStatus::ASSIGNED]);
		if($request->hasFile('attachement')){
			$path = $request->file('attachement')->getRealPath();
			$data1 = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data1) && $data1->count()){
				foreach ($data1 as $key => $value) {
					$insert[] = ['batch_id'=>$batch->id,'company_instructions' => $value->company_instructions, 'company_id' => $value->company_id,'parent_company' => $value->parent_company, 'company_name' => $value->company_name,'address1' => $value->address1, 'address2' => $value->address2,'city' => $value->city, 'state' => $value->state,'zipcode' => $value->zipcode, 'country' => $value->country,'international_code' => $value->international_code, 'switchboardnumber' => $value->switchboardnumber,'branchNumber' => $value->branch_number, 'addresscode' => $value->addresscode,'website' => $value->website, 'comapny_email' => $value->comapny_email,
							'products_services' => $value->products_services, 'industry_classfication' => $value->industry_classfication,'employee_size' => $value->employee_size, 'physician_size' => $value->physician_size,'annual_revenue' => $value->annual_revenue, 'number_of_beds' => $value->number_of_beds,'foundation_year' => $value->foundation_year, 'company_remark' => $value->company_remark,'additional_info1' => $value->additional_info1, 'additional_info2' => $value->additional_info2,'additional_info3' => $value->additional_info3, 'additional_info4' => $value->additional_info4];
				}
				if(!empty($insert)){
					DB::table('companies')->insert($insert);
					//dd('Insert Record successfully.');
				}
			}
			}
			
		
		return redirect()->route('batch.list')
		->withSuccess(trans('app.batch_updated'));
	}
	
	public function download(Batch $batch, CompanyRepository $companyRepository)
	{	
		$data = $companyRepository->getTotalCompany($batch->id); //get('$batch->id')->toArray();
		//return $data;
		return Excel::create('Report', function($excel) use ($data) {
			$excel->sheet('companies', function($sheet) use ($data)
			{
				$sheet->fromArray($data);
				/* $companies= [];
				 foreach ($data as $key => $value) {
				 $company['Company Id']= $value['company_id'];
				 $company['Company Name']= $value['company_name'];
				 $company['Child Company']= $value['child_company'];
				 $company['Address Line1']= $value['address1'];
				 $company['Address Line2']= $value['address2'];
				 $company['City']= $value['city'];
				 $company['State']= $value['state'];
				 $company['Zipcode']=$value['zipcode'];
				 $company['Country']=$value['country'];
				 $company['InterNational Code']=$value['international_code'];
				 $company['SwitchBoard Number']=$value['switchboardnumber'];
				 $company['Branch Number']=$value['branchNumber'];
				 $company['Address Code']=$value['addresscode'];
				 $company['Website']=$value['website'];
				 $company['Company Email']=$value['company_email'];
				 $company['Products & Services']=$value['products_services'];
				 $company['Industry Classification']=$value['industry_classfication'];
				 $company['Employee Size']=$value['employee_size'];
				 $company['Annual Revenue']=$value['annual_revenue'];
				 $company['Number Of Beds']=$value['number_of_beds'];
				 $company['Foundation Year']=$value['foundation_year'];
				 $company['Company Remark']=$value['company_remark'];
				 $company['Additional Info1']=$value['additional_info1'];
				 $company['Additional Info2']=$value['additional_info2'];
				 $company['Additional Info3']=$value['additional_info3'];
				 $company['Additional Info4']=$value['additional_info4'];

				 $company['First Name']=$value['first_name'];
				 $company['Middle Name']=$value['middle_name'];
				 $company['Last Name']=$value['last_name'];
				 $company['Job Title']=$value['job_title'];
				 $company['Specialization']=$value['specialization'];
				 $company['Staff Soure']=$value['staff_source'];
				 $company['Staff Email']=$value['staff_email'];
				 $company['Direct PhoneNo']=$value['direct_phoneno'];
				 $company['Email Source']=$value['email_source'];
				 $company['Qualification']=$value['qualification'];
				 $company['Staff Disposition']=$value['staff_disposition'];
				 $company['Department Number']=$value['deparment_number'];
				 $company['Alternate Phone']=$value['alternate_phone'];
				 $company['Alternate Email']=$value['alternate_email'];
				 $company['Email Type']=$value['email_type'];
				 $company['Shift Timing']=$value['shift_timing'];
				 $company['Working Tenure']=$value['working_tenure'];
				 $company['Paternership']=$value['paternership'];
				 $company['Age']=$value['age'];
				 $company['Staff Remarks']=$value['staff_remarks'];
				 $company['Contact Additional Info 1']=$value['info1'];
				 $company['Contact Additional Info 2']=$value['info2'];
				 $company['Contact Additional Info 3']=$value['info3'];
				 $company['Contact Additional Info 4']=$value['info4'];
				 
				 $companies[] = $company;
				 }
				 $sheet->fromArray($companies);*/
			});
		})->download('xlsx');
		//return $data;
	}
	
	public function delete(Batch $batch)
	{
		$this->batches->delete($batch->id);
		return redirect()->route('batch.list')
		->withSuccess(trans('app.batch_deleted'));
	}
}