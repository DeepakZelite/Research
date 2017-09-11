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
use Vanguard\Repositories\Report\ReportRepository;
use Illuminate\Support\Facades\Log;


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
		if ($this->theUser->vendor_id == "0")
		{
			$show=true;
			$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
			$projects =	[''=>trans('app.all_project')] + $projectRepository->lists1();
			$projects_name = [''=>trans('app.all_project_name')]+$projectRepository->getprojectNameList();
		}
		else {
			$show=false;
			$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
			$projects =	[''=>trans('app.all_project')] + $projectRepository->getProjectCode($this->theUser->vendor_id);
			$projects_name = [''=>trans('app.all_project_name')]+$projectRepository->getProjectName($this->theUser->vendor_id);
		}
		return view('report.project-status-report', compact('show','batches','projects', 'vendors','projects_name'));
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
		//$projects =	[''=>trans('app.all_project')] + $projectRepository->lists1();
		$vendors  =	[''=>trans('app.all_vendor')] + $vendorRepository->lists1();
		//$projects_name = [''=>trans('app.all_project_name')]+$projectRepository->getprojectNameList();
		$project_code = Input::get('code');
		$project_name = Input::get('name');
		if($this->theUser->vendor_id == "0")
		{
			$show=true;
			$vendor_code  = Input::get('vendor_code');
			$projects =	[''=>trans('app.all_project')] + $projectRepository->lists1();
			$projects_name = [''=>trans('app.all_project_name')]+$projectRepository->getprojectNameList();
		}
		else
		{
			$show=false;
			$vendors =$vendorRepository->find($this->theUser->vendor_id);
			$vendor_code= $vendors->vendor_code;
			$projects =	[''=>trans('app.all_project')] + $projectRepository->getProjectCode($this->theUser->vendor_id);
			$projects_name = [''=>trans('app.all_project_name')]+$projectRepository->getProjectName($this->theUser->vendor_id);
		}
		$batches=null;
		if($vendor_code =="" && $project_code == "")
		{
			$vendor_code=null;
			$project_code=null;
			$batches = $batchRepository->getDataForProjectReport($vendor_code,$project_code,$project_name);
		}
		else {
			$batches = $batchRepository->getDataForProjectReport($vendor_code,$project_code,$project_name);
		}
		Log::debug($batches);
		if (sizeof($batches) > 0) {
			foreach($batches as $datas)
			{
				$count=0; $email=0;
				$companies=$companyRepository->getcompanies($datas->id);
				Log::debug($companies);
				$company_processed = $companyRepository->getSubmittedCompanyCount($datas->id);
				$subsidarycount = $companyRepository->getSubmittedSubsidiaryCompanyCount($datas->id,null);
				Log::debug("company_count:".$company_processed."Subsidary count: ".$subsidarycount);
				if(sizeof($companies)>0)
				{
					foreach($companies as $company)
					{
						$abc=$contactRepository->getTotalContactCount($company->id);
						$count=$count+$abc;
 						$a = $contactRepository->getTotalEmailCount($company->id);
 						$email = $email + $a;
					}
				}
				$datas["comp_process_count"] = "$company_processed";
				$datas["subsidary_process_count"] = "$subsidarycount";
				$datas["staff"] = "$count";
				$datas["email_count"] = "$email";
			}
		}
		return view('report.project-status-report',compact('show','batches','projects', 'vendors','projects_name'));
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
	public function productivityList(VendorRepository $vendorRepository,UserRepository $userRepository,CompanyRepository $companyRepository,ContactRepository $contactRepository,SubBatchRepository $subBatchRepository,BatchRepository $batchRepository)
	{
		$vendors  = $vendorRepository->lists();
 		$vendors -> prepend('','');
 		$batches = $batchRepository->lists();
 		$batches -> prepend('','');
		if ($this->theUser->vendor_id == "0")
		{
			$show=true;
			$users = $userRepository->getVendorUsers(Input::get('vendor_code'));
			$users -> prepend('','');
		}
		else 
		{ 
			$show=false;
			$users = $userRepository->getVendorUsers($this->theUser->vendor_id); 
			$users -> prepend('','');
		}
		return view('report.productivity-report', compact('show','users','batches', 'vendors'));
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
	public function getProductivityReport(Request $request,ReportRepository $reportRepository,VendorRepository $vendorRepository,CompanyRepository $companyRepository,ContactRepository $contactRepository,SubBatchRepository $subBatchRepository)
	{
		$inputs = Input::all();
		$userId = $inputs['userId'];
		$batchId = $inputs['batchId'];
		$fromDate = $inputs['fromDate'];
		$toDate = $inputs['toDate'];
		if ($this->theUser->vendor_id == "0")
		{
			$vendorId	=$inputs['vendorId'];
		}
		else if($batchId != '')
		{
			$vendorId = '';
		}
		else 
		{
			$vendorId=$this->theUser->vendor_id;
		}
		Log::debug("vendor ".$vendorId." user ".$userId ." batch".$batchId);
			$datas=$reportRepository->get_data_for_report($userId,$fromDate,$toDate,$vendorId,$batchId);
			Log::debug("datas ".$datas);
			foreach ($datas as $data)
			{
			$company_count=0;
			if($vendorId == 0 && $userId == 0 && $batchId == 0)
			{
				$company_count=$companyRepository->getCompaniesForProductivityReport($data->vendor_id,null,$fromDate,$toDate);
				$SubsidiaryCount =$companyRepository->getSubsidiaryCompaniesForProductivityReport($data->vendor_id,null,$fromDate,$toDate);
				$staff_process_count = $contactRepository->getProcessRecordCount($data->vendor_id,null,$fromDate,$toDate);
				$email_process_count = $contactRepository->getEmailRecordCount($data->vendor_id,null,$fromDate,$toDate);
				$data['first_name']="All";
				$data['last_name']="";
			}
			else if($vendorId == 0 && $userId == 0 && $batchId != 0)
			{
				$company_count = $companyRepository->getSubmittedCompanyCountForReport($batchId,$data->id);
				$SubsidiaryCount =$companyRepository->getSubmittedSubsidiaryCompanyCount($batchId,$data->id);
				$staff_process_count = $contactRepository->getProcessRecordCountForBatch($batchId,$data->id,$data->start_time,$data->stop_time,$batchId);
				$email_process_count = $contactRepository->getEmailRecordCountForBatch($batchId,$data->id,$data->start_time,$data->stop_time,$batchId);
			}
			else
			{
				$company_count=$companyRepository->getCompaniesForProductivityReport($data->vendor_id,$data->id,$fromDate,$toDate);
				$SubsidiaryCount =$companyRepository->getSubsidiaryCompaniesForProductivityReport($data->vendor_id,$data->id,$fromDate,$toDate);
				$staff_process_count = $contactRepository->getProcessRecordCount($data->vendor_id,$data->id,$fromDate,$toDate);
				$email_process_count = $contactRepository->getEmailRecordCount($data->vendor_id,$data->id,$fromDate,$toDate);
			}
			Log::debug("Total Company Count". $company_count ."  Total subsidiary count:". $SubsidiaryCount."  Total Staff Process Count".$staff_process_count ."  Total Email Process Count: ".$email_process_count);
			$data->comp_count=$company_count;
			$data->email_count=$email_process_count;
			$data->subsidiary_count = $SubsidiaryCount;
			$data->no_rows = $staff_process_count;
			$records=$data->no_rows;
			$minute=$data->hrs;
			$hours= intval($minute/60);
			$min = $minute%60;
			$time = $hours.":".$min;
			Log::debug($time);
			$data->hrs =$time;
			$per_hour=0;
			if($hours!=0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
			if($vendorId == 0 && $userId == 0 && $batchId == 0)
			{
				
				$data['first_name']="All";
				$data['last_name']="";
			}
			Log::debug("All Data For Report".$datas);
			}
		
		return view('report.partials.productivity-table',compact('datas'));
	}
}
