<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Vanguard\Http\Requests;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Session\Session;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Repositories\Contact\ContactRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\Vendor\VendorRepository;
use Vanguard\Repositories\SubBatch\SubBatchRepository;
use Illuminate\Support\Facades\Log;
use DB;


class ReportsController extends Controller
{
	protected $theUser;
	private $batchId;
	private $batchRepository;
	private $projectRepository;
	private $vendorRepository;
	
	/**
	 * contructor
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:reports.manage');
		//$this->middleware('permission:reports.user');
		$this->theUser = Auth::user();
	}
	
	/**
	 * project status report list page
	 * @param VendorRepository $vendorRepository
	 * @param ProjectRepository $projectRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function index(VendorRepository $vendorRepository,ProjectRepository $projectRepository)
	{
		$batches=null;
		if ($this->theUser->username == 'admin')
		{
			$show=true;
			$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
		}
		else {
			$show=false;
			$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
		}
		$projects =	[''=>trans('app.all_project')] + $projectRepository->lists1();
		return view('report.project-status-report', compact('show','batches','projects', 'vendors'));
	}
	
	/**
	 * Go button click code for displying the batches report
	 * @param VendorRepository $vendorRepository
	 * @param ProjectRepository $projectRepository
	 * @param ContactRepository $contactRepository
	 * @param CompanyRepository $companyRepository
	 * @param BatchRepository $batchRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function getData(VendorRepository $vendorRepository,ProjectRepository $projectRepository,ContactRepository $contactRepository,CompanyRepository $companyRepository,BatchRepository $batchRepository)
	{
		$projects =	[''=>trans('app.all_project')] + $projectRepository->lists1();
		$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
		$project_code = Input::get('code');
		if($this->theUser->username == 'admin')
		{
			$show=true;
			$vendor_code  = Input::get('vendor_code');
		}
		else
		{
			$show=false;
			$vendors =$vendorRepository->find($this->theUser->vendor_id);
			$vendor_code= $vendors->vendor_code;
		}
		$batches=null;
		if($vendor_code!="" || $project_code!= "")
		{
			$batches = $batchRepository->getDataForProjectReport($vendor_code,$project_code);
		}
		if (sizeof($batches) > 0) {
			foreach($batches as $datas)
			{
				$count=0;
				$companies=$companyRepository->getcompanies($datas->id);
				if(sizeof($companies)>0)
				{
					foreach($companies as $company)
					{
						$abc=$contactRepository->getTotalContactCount($company->id);
						$count=$count+$abc;
					}
				}
				$datas["staff"] = "$count";
			}
		}
		return view('report.project-status-report',compact('show','batches','projects', 'vendors'));
	}
	
	
	/**
	 * productivity report for all vendors by default.
	 * @param VendorRepository $vendorRepository
	 * @param UserRepository $userRepository
	 * @param CompanyRepository $companyRepository
	 * @param ContactRepository $contactRepository
	 * @param SubBatchRepository $subBatchRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function productivityList(VendorRepository $vendorRepository,UserRepository $userRepository,CompanyRepository $companyRepository,ContactRepository $contactRepository,SubBatchRepository $subBatchRepository)
	{
		$vendors  = $vendorRepository->lists();
		$vendors -> prepend('select vendor','-1');
		if ($this->theUser->username == 'admin')
		{
			$show=true;
			$users = $userRepository->getVendorUsers(Input::get('vendor_code'));
			$users -> prepend('select user','0');
			$datas=null;
			$datas=DB::table('vendors')->select('id','vendors.vendor_code as code')->get();
			if(sizeof($datas)>0)
			{
				foreach($datas as &$data)
				{
					$count=null;
					//for calculating the hours spend for perticular vendor
					$a=$subBatchRepository->getTimespend($data->id);
					//for calculating the companies Processed
					$c=$companyRepository->getCompaniesForProductivityReport($data->id);
					//for calculating the record processed
					$companies=DB::table('companies')->where('vendor_id',"=","$data->id")->select('companies.id')->get();
					if(sizeof($companies)>1)
					{
						foreach($companies as $company)
						{
							$abc=$contactRepository->getTotalContactCount($company->id);
							$count=$count+$abc;
						}
					}
					//for calculating the time per hour
					$b=$a[0]->count;
					$per_hour=null;
					if($b > 0){
						$per_hour=$count/$b;
						$per_hour=round($per_hour);
					}
					$data=(array)$data;
					$data["username"]= "All";
					$data["hour_spend"] ="$b";
					$data["companies_processed"] = "$c";
					$data["processed_record"] = "$count";
					$data["per_hour"] = "$per_hour";
				}
			}
		}
		else 
		{ 
			$show=false;
			$users = $userRepository->getVendorUsers($this->theUser->vendor_id); 
			$users -> prepend('select user','0');
			$datas=null;
			$vendorId=$this->theUser->vendor_id;
			$userId 	=null;
			$datas=$vendorRepository->getReportData($vendorId,$userId);
			if(sizeof($datas)>0)
			{
				foreach($datas as $data)
				{
					$count=null;
					//for calculating the hours spend for perticular vendor
					$a=$subBatchRepository->getTimespend($data->vendor_id,$data->user_id);
					//for calculating the companies Processed
					$c=$companyRepository->getCompaniesForProductivityReport($data->vendorid,$data->user_id);
					//for calculating the record processed
					$companies=DB::table('companies')->where('vendor_id',"=","$data->vendor_id")->where('user_id',"=","$data->user_id")->select('companies.id')->get();
					if(sizeof($companies)>1)
					{
						foreach($companies as $company)
						{
							Log::info("Contact:::".$company->id);
							$abc=$contactRepository->getTotalContactCount($company->id);
							$count=$count+$abc;
						}
					}
					Log::info("Contact:::".$data->code." ".$data->username." ".$data->user_id." ".$data->vendor_id." ".$a[0]->count." ".$c." ".$count);
					$b=$a[0]->count;
					if($b > 0){
						$per_hour=$count/$b;
						$per_hour=round($per_hour);
					}
					$data["hour_spend"] ="$b";
					$data["companies_processed"] = "$c";
					$data["processed_record"] = "$count";
					$data["per_hour"] = "$per_hour";
				}
			}
		}
		
		return view('report.productivity-report', compact('show','datas','users', 'vendors'));
	}
	
	/**
	 * Go button click code for productivity report for displaying data of perticular vendor and user
	 * @param Request $request
	 * @param VendorRepository $vendorRepository
	 * @param CompanyRepository $companyRepository
	 * @param ContactRepository $contactRepository
	 * @param SubBatchRepository $subBatchRepository
	 * @return unknown
	 */
	public function getProductivityReport(Request $request,VendorRepository $vendorRepository,CompanyRepository $companyRepository,ContactRepository $contactRepository,SubBatchRepository $subBatchRepository)
	{
		$inputs = Input::all();
		if ($this->theUser->username == 'admin')
		{
			$vendorId	=$inputs['vendorId'];
		}
		else 
		{
			$vendorId=$this->theUser->vendor_id;
		}
		$userId 	=$inputs['userId'];
		Log::info("Contact:::::". $vendorId." ".$userId);
		$datas=null;
		$datas=$vendorRepository->getReportData($vendorId,$userId);
		if(sizeof($datas)>0)
		{
			foreach($datas as $data)
			{
				$count=null;
				//for calculating the hours spend for perticular vendor
				$a=$subBatchRepository->getTimespend($data->vendor_id,$data->user_id);
				//for calculating the companies Processed
				$c=$companyRepository->getCompaniesForProductivityReport($data->vendorid,$data->user_id);
				//for calculating the record processed
				//$companies=$companyRepository->getcompaniesforReport($data->vendor_id,$data->user_id);
				$companies=DB::table('companies')->where('vendor_id',"=","$data->vendor_id")->where('user_id',"=","$data->user_id")->select('companies.id')->get();
				if(sizeof($companies)>1)
				{
					foreach($companies as $company)
					{
						Log::info("Contact:::".$company->id);
						$abc=$contactRepository->getTotalContactCount($company->id);
						$count=$count+$abc;
					}
				}
				Log::info("Contact:::".$data->code." ".$data->username." ".$data->user_id." ".$data->vendor_id." ".$a[0]->count." ".$c." ".$count);
				$b=$a[0]->count;
				if($b > 0){
					$per_hour=$count/$b;
					$per_hour=round($per_hour);
				}
				$data["hour_spend"] ="$b";
				$data["companies_processed"] = "$c";
				$data["processed_record"] = "$count";
				$data["per_hour"] = "$per_hour";
			}
		}
		Log::info("Contact:::".$datas);
		return view('report.partials.productivity-table',compact('datas'));
		
	}
	
	public function myProductivityList(SubBatchRepository $subBatchRepository,CompanyRepository $companyRepository,ContactRepository $contactRepository)
	{
		$userId = 25;//$this->theUser->id;
		$username = $this->theUser->username;
		$a = $subBatchRepository->getTimespend(null,$userId);
		$b = $companyRepository->getCompaniesForProductivityReport(null,$userid);
		return view('report.my_productivity');
	}
}
