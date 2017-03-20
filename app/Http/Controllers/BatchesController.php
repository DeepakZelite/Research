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
use Vanguard\Support\Enum\SubBatchStatus;
use DB;
use App\Upload;
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
	 * Display paginated list of all batches.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$perPage = 5;
		if ($this->theUser->username == 'admin') {
			$batches = $this->batches->paginate($perPage, Input::get('search'));
		} 
		else {
			$batches = $this->batches->paginate($perPage, Input::get('search'), $this->theUser->vendor_id);
		}
		$statuses = ['' => trans('app.all')] + UserStatus::lists(); 
		return view('batch.list', compact('batches', 'statuses')); 
		
		
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
		$batch = $this->batches->create($data);
		
		if($request->hasFile('attachement')){
			$path = $request->file('attachement')->getRealPath();
			$data1 = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data1) && $data1->count()){
				foreach ($data1 as $key => $value) {
					$insert[] = ['batch_id'=>$batch->id,'status' => 'un-assigned','company_instructions' => $value->company_instructions, 'company_id' => $value->company_id,'parent_company' => $value->parent_company, 'company_name' => $value->company_name,'address1' => $value->address1, 'address2' => $value->address2,'city' => $value->city, 'state' => $value->state,'zipcode' => $value->zipcode, 'country' => $value->country,'international_code' => $value->international_code, 'switchboardnumber' => $value->switchboardnumber,'branchNumber' => $value->branch_number, 'addresscode' => $value->addresscode,'website' => $value->website, 'comapny_email' => $value->comapny_email,
							'products_services' => $value->products_services, 'industry_classfication' => $value->industry_classfication,'employee_size' => $value->employee_size, 'physician_size' => $value->physician_size,'annual_revenue' => $value->annual_revenue, 'number_of_beds' => $value->number_of_beds,'foundation_year' => $value->foundation_year, 'company_remark' => $value->company_remark,'additional_info1' => $value->additional_info1, 'additional_info2' => $value->additional_info2,'additional_info3' => $value->additional_info3, 'additional_info4' => $value->additional_info4];
				}
				if(!empty($insert)){
					DB::table('companies')->insert($insert);
					//dd('Insert Record successfully.');
				}
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
	
	public function delete(Batch $batch)
	{
		$this->batches->delete($batch->id);
		return redirect()->route('batch.list')
		->withSuccess(trans('app.user_deleted'));
	}
}