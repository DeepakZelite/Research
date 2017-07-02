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
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Debug\Tests\Fixtures\ToStringThrower;
use Vanguard\Project;


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
	public function index(VendorRepository $vendorRepository,ProjectRepository $projectRepository,CompanyRepository $companyRepository)
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
		$type = array("Unnamed Task","Named Tasked");
		$projects = $projectRepository->lists();
		$projects = $projectRepository->lists();
		$projects->prepend('Select project', '0');
		$vendors = $vendorRepository->lists();
		$vendors->prepend('select vendors','0');
		$edit = false;
		return view('batch.add-edit', compact('edit','type','projects', 'vendors'));
	}

	/**
	 * Stores new batch into the database and upload the companies dependent on that batch id.
	 * @param CreateBatchRequest $request
	 * @return on list of batches page with success message.
	 */
	public function store(CreateBatchRequest $request,ProjectRepository $projectRepository,BatchRepository $batchRepository)
	{
		//logic for uploading the excel sheet for companies.
		if($request->hasFile('attachement')){
			$path = $request->file('attachement')->getRealPath();
			$data1 = Excel::load($path, function($reader) {})->get();
		$count = $data1->count();
		$data = $request->all()+ ['status' => SubBatchStatus::ASSIGNED]+['company_count'=>$count];
		$companies=$projectRepository->getProjectCompanyCount($request->project_id);
		$company_count = $companies -> No_Companies;
		$batches = $batchRepository->getCompanyCountBasedOnProject($request->project_id);
		if($data1->count())
		{
			$count = $batches + $data1->count();
			if($count <= $company_count)
			{
				$batch = $this->batches->create($data);
				if($request->type_id == 1)
				{
					Log::info("Named Task");
					$id=0;
					for($i = 0; $i < $count; $i++)
					{
						if($i != 0)
						{
							if(!empty($data1[$i]->company_name))
							{
							if(!empty($data1[($i-1)]->company_name) && !empty($data1[($i-1)]->first_name))
							{
							if($data1[($i - 1)]->company_name == $data1[$i]->company_name)
							{
								DB::table('contacts')->insert(['company_id'=>$id,'first_name'=>$data1[$i]->first_name ,'last_name'=>$data1[$i]->last_name,'middle_name'=>$data1[$i]->middle_name,'job_title'=>$data1[$i]->job_title,'specialization'=>$data1[$i]->specialization,'staff_source'=>$data1[$i]->staff_source,'staff_email'=>$data1[$i]->staff_email,'direct_phoneno'=>$data1[$i]->direct_phoneno,'email_source'=>$data1[$i]->email_source,'qualification'=>$data1[$i]->qualification,'staff_disposition'=>$data1[$i]->staff_disposition,'deparment_number'=>$data1[$i]->deparment_number,'alternate_phone'=>$data1[$i]->alternate_phone,'alternate_email'=>$data1[$i]->alternate_email,'email_type'=>$data1[$i]->email_type,'shift_timing'=>$data1[$i]->shift_timing,'working_tenure'=>$data1[$i]->working_tenure,'paternership'=>$data1[$i]->paternership,'age'=>$data1[$i]->age,'staff_remarks'=>$data1[$i]->staff_remarks,'additional_info1'=>$data1[$i]->info1,'additional_info2' => $data1[$i]->info2,'additional_info3' => $data1[$i]->info3, 'additional_info4' => $data1[$i]->info4,'additional_info5' => $data1[$i]->info5, 'additional_info6' => $data1[$i]->info6,'additional_info7' => $data1[$i]->info7, 'additional_info8' => $data1[$i]->info8, 'type' => 'named' ]);
							}
							else
							{
								$id = DB::table('companies')->insertGetId(['batch_id'=>$batch->id,'status' => 'UnAssigned','company_instructions' => $data1[$i]->company_instructions, 'parent_company' => $data1[$i]->parent_company, 'company_name' => $data1[$i]->company_name,'address1' => $data1[$i]->address1, 'address2' => $data1[$i]->address2,'city' => $data1[$i]->city, 'state' => $data1[$i]->state,'zipcode' => $data1[$i]->zipcode, 'country' => $data1[$i]->country,'isd_code' => $data1[$i]->international_code, 'switchboardnumber' => $data1[$i]->switchboardnumber,'branchNumber' => $data1[$i]->branch_number, 'addresscode' => $data1[$i]->addresscode,'website' => $data1[$i]->website, 'company_email' => $data1[$i]->company_email,
										'products_services' => $data1[$i]->products_services, 'industry_classfication' => $data1[$i]->industry_classfication,'employee_size' => $data1[$i]->employee_size, 'physician_size' => $data1[$i]->physician_size,'annual_revenue' => $data1[$i]->annual_revenue, 'number_of_beds' => $data1[$i]->number_of_beds,'foundation_year' => $data1[$i]->foundation_year, 'company_remark' => $data1[$i]->company_remark,'additional_info1' => $data1[$i]->additional_info1, 'additional_info2' => $data1[$i]->additional_info2,'additional_info3' => $data1[$i]->additional_info3, 'additional_info4' => $data1[$i]->additional_info4,'additional_info5' => $data1[$i]->additional_info5, 'additional_info6' => $data1[$i]->additional_info6,'additional_info7' => $data1[$i]->additional_info7, 'additional_info8' => $data1[$i]->additional_info8]);

								DB::table('contacts')->insert(['company_id'=>$id,'first_name'=>$data1[$i]->first_name ,'last_name'=>$data1[$i]->last_name,'middle_name'=>$data1[$i]->middle_name,'job_title'=>$data1[$i]->job_title,'specialization'=>$data1[$i]->specialization,'staff_source'=>$data1[$i]->staff_source,'staff_email'=>$data1[$i]->staff_email,'direct_phoneno'=>$data1[$i]->direct_phoneno,'email_source'=>$data1[$i]->email_source,'qualification'=>$data1[$i]->qualification,'staff_disposition'=>$data1[$i]->staff_disposition,'deparment_number'=>$data1[$i]->deparment_number,'alternate_phone'=>$data1[$i]->alternate_phone,'alternate_email'=>$data1[$i]->alternate_email,'email_type'=>$data1[$i]->email_type,'shift_timing'=>$data1[$i]->shift_timing,'working_tenure'=>$data1[$i]->working_tenure,'paternership'=>$data1[$i]->paternership,'age'=>$data1[$i]->age,'staff_remarks'=>$data1[$i]->staff_remarks,'additional_info1'=>$data1[$i]->info1,'additional_info2' => $data1[$i]->info2,'additional_info3' => $data1[$i]->info3, 'additional_info4' => $data1[$i]->info4,'additional_info5' => $data1[$i]->info5, 'additional_info6' => $data1[$i]->info6,'additional_info7' => $data1[$i]->info7, 'additional_info8' => $data1[$i]->info8, 'type' => 'named' ]);
							}
							}else 
							{
							$this->batches->delete($batch->id);
							return redirect()->route('batch.create')->withErrors('There Is No Company Name Or First Name');
							}
							}	
						}else
						{
							$id = DB::table('companies')->insertGetId(['batch_id'=>$batch->id,'status' => 'UnAssigned','company_instructions' => $data1[$i]->company_instructions, 'parent_company' => $data1[$i]->parent_company, 'company_name' => $data1[$i]->company_name,'address1' => $data1[$i]->address1, 'address2' => $data1[$i]->address2,'city' => $data1[$i]->city, 'state' => $data1[$i]->state,'zipcode' => $data1[$i]->zipcode, 'country' => $data1[$i]->country,'isd_code' => $data1[$i]->international_code, 'switchboardnumber' => $data1[$i]->switchboardnumber,'branchNumber' => $data1[$i]->branch_number, 'addresscode' => $data1[$i]->addresscode,'website' => $data1[$i]->website, 'company_email' => $data1[$i]->company_email,
									'products_services' => $data1[$i]->products_services, 'industry_classfication' => $data1[$i]->industry_classfication,'employee_size' => $data1[$i]->employee_size, 'physician_size' => $data1[$i]->physician_size,'annual_revenue' => $data1[$i]->annual_revenue, 'number_of_beds' => $data1[$i]->number_of_beds,'foundation_year' => $data1[$i]->foundation_year, 'company_remark' => $data1[$i]->company_remark,'additional_info1' => $data1[$i]->additional_info1, 'additional_info2' => $data1[$i]->additional_info2,'additional_info3' => $data1[$i]->additional_info3, 'additional_info4' => $data1[$i]->additional_info4,'additional_info5' => $data1[$i]->additional_info5, 'additional_info6' => $data1[$i]->additional_info6,'additional_info7' => $data1[$i]->additional_info7, 'additional_info8' => $data1[$i]->additional_info8]);

							DB::table('contacts')->insert(['company_id'=>$id,'first_name'=>$data1[$i]->first_name ,'last_name'=>$data1[$i]->last_name,'middle_name'=>$data1[$i]->middle_name,'job_title'=>$data1[$i]->job_title,'specialization'=>$data1[$i]->specialization,'staff_source'=>$data1[$i]->staff_source,'staff_email'=>$data1[$i]->staff_email,'direct_phoneno'=>$data1[$i]->direct_phoneno,'email_source'=>$data1[$i]->email_source,'qualification'=>$data1[$i]->qualification,'staff_disposition'=>$data1[$i]->staff_disposition,'deparment_number'=>$data1[$i]->deparment_number,'alternate_phone'=>$data1[$i]->alternate_phone,'alternate_email'=>$data1[$i]->alternate_email,'email_type'=>$data1[$i]->email_type,'shift_timing'=>$data1[$i]->shift_timing,'working_tenure'=>$data1[$i]->working_tenure,'paternership'=>$data1[$i]->paternership,'age'=>$data1[$i]->age,'staff_remarks'=>$data1[$i]->staff_remarks,'additional_info1'=>$data1[$i]->info1,'additional_info2' => $data1[$i]->info2,'additional_info3' => $data1[$i]->info3, 'additional_info4' => $data1[$i]->info4,'additional_info5' => $data1[$i]->info5, 'additional_info6' => $data1[$i]->info6,'additional_info7' => $data1[$i]->info7, 'additional_info8' => $data1[$i]->info8, 'type' => 'named' ]);
						}	
					}
				}else{
					if(!empty($data1) && $data1->count()){
						foreach ($data1 as $key => $value) {
							if(!empty($value->company_name))
							{
							$insert[] = ['batch_id'=>$batch->id,'status' => 'UnAssigned','company_instructions' => $value->company_instructions, 'parent_company' => $value->parent_company, 'company_name' => $value->company_name,'address1' => $value->address1, 'address2' => $value->address2,'city' => $value->city, 'state' => $value->state,'zipcode' => $value->zipcode, 'country' => $value->country,'isd_code' => $value->international_code, 'switchboardnumber' => $value->switchboardnumber,'branchNumber' => $value->branch_number, 'addresscode' => $value->addresscode,'website' => $value->website, 'company_email' => $value->company_email,
								'products_services' => $value->products_services, 'industry_classfication' => $value->industry_classfication,'employee_size' => $value->employee_size, 'physician_size' => $value->physician_size,'annual_revenue' => $value->annual_revenue, 'number_of_beds' => $value->number_of_beds,'foundation_year' => $value->foundation_year, 'company_remark' => $value->company_remark,'additional_info1' => $value->additional_info1, 'additional_info2' => $value->additional_info2,'additional_info3' => $value->additional_info3, 'additional_info4' => $value->additional_info4, 'additional_info5' => $value->additional_info5, 'additional_info6' => $value->additional_info6, 'additional_info7' => $value->additional_info7, 'additional_info8' => $value->additional_info8];
							}else 
							{
								$this->batches->delete($batch->id);
								return redirect()->route('batch.create')->withErrors('There Is No Company Name');
							}
						}
						if(!empty($insert)){
							DB::table('companies')->insert($insert);
						}
					}
				}
			}
			else
			{
				return redirect()->route('batch.create')->withErrors(trans('app.total_batch_company_count_should_not_greater_than_project_count'));
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
	

	public function getbatchName(Request $request,VendorRepository $vendorRepository,ProjectRepository $projectRepository,BatchRepository $batchRepository)
	{
		$vendorId =$request->input('vendorId');
		$projectId = $request->input('projectId');
		$vendors=$vendorRepository->find($vendorId);
		$projects=$projectRepository->find($projectId);
		$today = Carbon::now()->format('ymd');
		$a=null;
		if($vendorId != 0 && $projectId != 0)
		{
			$a=$vendors->vendor_code."_".$projects->code."_".$today."_B";
		}
		$count=$batchRepository->getBatchNameCount($a);
		$count=$count+1;
		if($count <= 9)
		{
			return $vendors->vendor_code."_".$projects->code."_".$today."_B0".$count;
		}
		else
		{
			return $vendors->vendor_code."_".$projects->code."_".$today."_B".$count;
		}
	}
}