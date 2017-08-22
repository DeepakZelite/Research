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
use Illuminate\Support\Facades\Log;

class QualityController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:quality.manage');
		$this->theUser = Auth::user();
	}
	
	public function list(ProjectRepository $projectRepository, CodeRepository $codeRepository)
	{
		$projects_name = [''=>trans('')]+$projectRepository->getprojectNameList();		//[''=>trans('app.all_project_name')]+
		$projects =	[''=>trans('')] + $projectRepository->lists1(); 	//[''=>trans('app.all_project')] +
		$codes=$codeRepository->lists();
		$codes->prepend(trans('app.all'));
		$classfication=$codeRepository->lists1();
		$classfication->prepend(trans('app.all'));
		$timelist = array("All","Last 1 Month","Last 3 Month","Last 6 Month","Last 1 Year");
		return view('quality.list', compact('timelist','projects_name','projects','codes','classfication'));
	}
	
    public function create()
    {
    	return view('quality.add');
    }
    
    public function store(Request $request)
    {
    	if($request->hasFile('attachement')){
    		$path = $request->file('attachement')->getRealPath();
    		$data1 = Excel::load($path, function($reader) {})->get();
    		$count = $data1->count();
    		if($data1->count())
    		{
    			for($i = 0; $i < $count; $i++)
    			{
    				DB::table('qualities')->insert(['project_name'=>$data1[$i]->project_name, 'project_code'=> $data1[$i]->project_code,'batch_name'=>$data1[$i]->batch_name, 'username'=>$data1[$i]->username, 'company_id' => $data1[$i]->company_id, 'parent_company' => $data1[$i]->parent_company, 'company_name' => $data1[$i]->company_name,'address1' => $data1[$i]->address1, 'address2' => $data1[$i]->address2,'city' => $data1[$i]->city, 'state' => $data1[$i]->state,'zipcode' => $data1[$i]->zipcode, 'country' => $data1[$i]->country,'isd_code' => $data1[$i]->international_code, 'switchboardnumber' => $data1[$i]->switchboardnumber,'branchNumber' => $data1[$i]->branch_number, 'addresscode' => $data1[$i]->addresscode,'website' => $data1[$i]->website, 'company_email' => $data1[$i]->company_email, 'products_services' => $data1[$i]->products_services, 'industry_classfication' => $data1[$i]->industry_classfication,'employee_size' => $data1[$i]->employee_size, 'physician_size' => $data1[$i]->physician_size,'annual_revenue' => $data1[$i]->annual_revenue, 'number_of_beds' => $data1[$i]->number_of_beds,'foundation_year' => $data1[$i]->foundation_year, 'company_remark' => $data1[$i]->company_remark,'prm'=> $data1[$i]->prm,'company_additional_info1' => $data1[$i]->company_additional_info1, 'company_additional_info2' => $data1[$i]->company_additional_info2,'company_additional_info3' => $data1[$i]->company_additional_info3, 'company_additional_info4' => $data1[$i]->company_additional_info4,'company_additional_info5' => $data1[$i]->company_additional_info5, 'company_additional_info6' => $data1[$i]->company_additional_info6,'company_additional_info7' => $data1[$i]->company_additional_info7, 'company_additional_info8' => $data1[$i]->company_additional_info8,
    						'staff_id' => $data1[$i]->staff_id, 'salutation' => $data1[$i]->salutation, 'first_name' => $data1[$i]->first_name, 'last_name' => $data1[$i]->last_name, 'middle_name' => $data1[$i]->middle_name, 'job_title' => $data1[$i]->job_title, 'specialization'=>$data1[$i]->specialization, 'staff_source'=> $data1[$i]->staff_source, 'staff_email'=> $data1[$i]->staff_email,'direct_phoneno'=>$data1[$i]->direct_phoneno,'email_source'=>$data1[$i]->email_source,'qualification'=>$data1[$i]->qualification,'staff_disposition'=>$data1[$i]->staff_disposition,'deparment_number'=>$data1[$i]->deparment_number,'alternate_phone'=>$data1[$i]->alternate_phone,'alternate_email'=>$data1[$i]->alternate_email,'email_type'=>$data1[$i]->email_type,'shift_timing'=>$data1[$i]->shift_timing,'working_tenure'=>$data1[$i]->working_tenure,'paternership'=>$data1[$i]->paternership,'age'=>$data1[$i]->age,'staff_remarks'=>$data1[$i]->staff_remarks, 'contact_additional_info1'=>$data1[$i]->contact_additional_info1, 'contact_additional_info2'=>$data1[$i]->contact_additional_info2, 'contact_additional_info3'=>$data1[$i]->contact_additional_info3, 'contact_additional_info4'=>$data1[$i]->contact_additional_info4, 'contact_additional_info5'=>$data1[$i]->contact_additional_info5, 'contact_additional_info6'=>$data1[$i]->contact_additional_info6, 'contact_additional_info7' => $data1[$i]->contact_additional_info7, 'contact_additional_info8'=>$data1[$i]->contact_additional_info8, 'created_at'=>Carbon::now() ]);
    			}
    		}
    		return redirect()->route('quality.list')->withSuccess(trans('app.quality_data_uploaded_successfully'));
    	}
    	return redirect()->route('quality.create')->withErrors(trans('app.select_a_excel_file'));
    }
    
    public function download(Request $request)
    {
    	$data = null;
    	if($request->option == 'All')
    	{
    		if($request->timespan == 1)
    		{
    			$date = Carbon::now()->subDays(30);
    			$data = DB::table('qualities')
    					->where('created_at',">=","{$date}")
    					->get();
    		}else if($request->timespan == 2)
    		{
    			$date = Carbon::now()->subDays(90);
    			$data = DB::table('qualities')
    					->where('created_at',">=","{$date}")
    					->get();
    		}else if($request->timespan == 3)
    		{
    			$date = Carbon::now()->subDays(180);
    			$data = DB::table('qualities')
    					->where('created_at',">=","{$date}")
    					->get();
    		}else if($request->timespan == 4)
    		{
   	 			$date = Carbon::now()->subDays(365);
    			$data = DB::table('qualities')
    					->where('created_at',">=","{$date}")
    					->get();
    		}else{
    			$data = DB::table('qualities')
    					->get();
    		}
    	}else
    	{
    		if($request->project_name != '')
    		{
    			$data = DB::table('qualities')
    					->where('project_name',"=",$request->project_name)
    					->get();
    		}
    		if($request->project_code != '')
    		{
    			$data = DB::table('qualities')
    					->where('project_code',"=",$request->project_code)
    					->get();
    		}
    		if($request->employee_size != 0)
    		{
    			$data = DB::table('qualities')
    					->where('employee_size',"=",$request->employee_size)
    					->get();
    		}
    		if($request->industry_classfication != '0')
    		{
    			$data = DB::table('qualities')
    					->where('industry_classfication',"=",$request->industry_classfication)
    					->get();
    		}
    		if($request->specialization != '')
    		{
    			$data = DB::table('qualities')
    					->where('specialization',"=",$request->specialization)
    					->get();
    		}
    		if($request->physician_size != "")
    		{
    			$data = DB::table('qualities')
    					->where('physician_size',"=",$request->physician_size)
    					->get();
    		}
    		if($request->state != '')
    		{
    			$data = DB::table('qualities')
    					->where('state',"=",$request->state)
    					->get();
    		}
    		
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
    		return redirect()->route('quality.list')->withErrors(trans('app.no_record_found'));
    	}
    }
    
}
