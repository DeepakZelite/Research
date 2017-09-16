<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Http\Requests;
use Auth;
use DB;
use Excel;
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Repositories\Code\CodeRepository;
use Carbon\Carbon;
use Vanguard\Repositories\Mdb;
use Illuminate\Support\Facades\Log;
use Vanguard\Repositories\Mdb\MdbRepository;

class QualityController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:quality.manage');
		$this->theUser = Auth::user();
	}
	
	public function list()
	{
		return view('quality.list');
	}
	
    public function create()
    {
    	return view('quality.add');
    }
    
    public function optionlist(ProjectRepository $projectRepository, CodeRepository $codeRepository)
    {
    	$projects_name = [''=>trans('')]+$projectRepository->getprojectNameList();		//[''=>trans('app.all_project_name')]+
    	$projects =	[''=>trans('')] + $projectRepository->lists1(); 	//[''=>trans('app.all_project')] +
    	$codes = ['' => trans('app.all')] + $codeRepository->lists()->toArray() + ["unavailable"=>"Unavailable"];
    	$classfication=$codeRepository->lists1();
    	$classfication->prepend(trans('app.all'));
    	$timelist = array("All","Last 1 Month","Last 3 Month","Last 6 Month","Last 1 Year");
    	return view('quality.optionlist', compact('timelist','projects_name','projects','codes','classfication'));
    }
    
    public function store(Request $request)
    {
    	if($request->hasFile('attachement')){
    		$path = $request->file('attachement')->getRealPath();
    		$data1 = Excel::load($path, function($reader) {})->get();
    		$count = $data1->count();
    		if($data1->count())
    		{
    			foreach ($data1 as $key => $value) {
    				if(!empty($value->company_name))
    				{
    					$insert[] = ['project_name'=>$value->project_name, 'project_code'=> $value->project_code,'batch_name'=>$value->batch_name, 'username'=>$value->username, 'company_id' => $value->company_id, 'parent_id'=>$value->parent_id , 'company_instructions'=>$value->company_instructions, 'parent_company' => $value->parent_company, 'company_name' => $value->company_name,'address1' => $value->address1, 'address2' => $value->address2,'city' => $value->city, 'state' => $value->state,'zipcode' => $value->zipcode, 'country' => $value->country,'isd_code' => $value->isd_code, 'switchboardnumber' => $value->switchboardnumber,'branchNumber' => $value->branch_number, 'addresscode' => $value->addresscode,'website' => $value->website, 'company_email' => $value->company_email, 'products_services' => $value->products_services, 'industry_classfication' => $value->industry_classfication,'employee_size' => $value->employee_size, 'physician_size' => $value->physician_size,'annual_revenue' => $value->annual_revenue, 'number_of_beds' => $value->number_of_beds,'foundation_year' => $value->foundation_year, 'company_remark' => $value->company_remark,'prm'=> $value->prm,'company_additional_info1' => $value->company_additional_info1, 'company_additional_info2' => $value->company_additional_info2,'company_additional_info3' => $value->company_additional_info3, 'company_additional_info4' => $value->company_additional_info4,'company_additional_info5' => $value->company_additional_info5, 'company_additional_info6' => $value->company_additional_info6,'company_additional_info7' => $value->company_additional_info7, 'company_additional_info8' => $value->company_additional_info8,
     								'staff_id' => $value->staff_id, 'salutation' => $value->salutation, 'first_name' => $value->first_name, 'last_name' => $value->last_name, 'middle_name' => $value->middle_name, 'job_title' => $value->job_title, 'specialization'=>$value->specialization, 'staff_source'=> $value->staff_source, 'staff_email'=> $value->staff_email,'direct_phoneno'=> $value->direct_phoneno,'email_source'=> $value->email_source,'qualification'=>$value->qualification,'staff_disposition'=>$value->staff_disposition,'deparment_number'=> $value->deparment_number,'alternate_phone'=> $value->alternate_phone,'alternate_email'=> $value->alternate_email,'email_type'=>$value->email_type,'shift_timing'=>$value->shift_timing,'working_tenure'=>$value->working_tenure,'paternership'=>$value->paternership,'age'=>$value->age,'staff_remarks'=>$value->staff_remarks, 'contact_additional_info1'=>$value->contact_additional_info1, 'contact_additional_info2'=>$value->contact_additional_info2, 'contact_additional_info3'=>$value->contact_additional_info3, 'contact_additional_info4'=> $value->contact_additional_info4, 'contact_additional_info5'=>$value->contact_additional_info5, 'contact_additional_info6'=>$value->contact_additional_info6, 'contact_additional_info7' => $value->contact_additional_info7, 'contact_additional_info8'=>$value->contact_additional_info8, 'type'=>$value->type ,'created_at'=>Carbon::now() ];
    				}else
    				{
    					return redirect()->route('quality.create')->withErrors(trans('app.company_name_or_first_name_are_mandatory'));
    				}
    			}
    			if(!empty($insert)){
    				DB::table('mdb')->insert($insert);
    			}
    		}
    		return redirect()->route('quality.list')->withSuccess(trans('app.quality_data_uploaded_successfully'));
    	}
    	return redirect()->route('quality.create')->withErrors(trans('app.select_a_excel_file'));
    }
    
    public function download(Request $request,MdbRepository $mdbRepository)
    {
    	$data = null;
    	if($request->option == 'All')
    	{
    		$date=null;
    		if($request->timespan == 1)
    		{
    			$date = Carbon::now()->subDays(30);
    		}else if($request->timespan == 2)
    		{
    			$date = Carbon::now()->subDays(90);
    		}else if($request->timespan == 3)
    		{
    			$date = Carbon::now()->subDays(180);
    		}else if($request->timespan == 4)
    		{
   	 			$date = Carbon::now()->subDays(365);
    		}
    		$data = $mdbRepository->getDataDownloadFromDates($date);
    	}else
    	{
    		$data = $mdbRepository->specificDownload($request->project_name,$request->project_code,$request->employee_size,$request->industry_classfication,$request->specialization,$request->physician_size,$request->state);
    	}
    	$data= json_decode( json_encode($data), true);
    	if(count($data) != 0)
    	{
    		Log::debug('Download Data from MDB:', $data);
    		return Excel::create('Report', function($excel) use ($data) {
    			$excel->sheet('companies', function($sheet) use ($data)
    			{
    				$sheet->fromArray($data);
    			});
    		})->download('xlsx');
    	}
    	else{
    		return redirect()->route('quality.optionlist')->withErrors(trans('app.no_record_found'));
    	}
    }  
}
