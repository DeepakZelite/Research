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
		if ($this->theUser->vendor_id == "0")
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
		if($this->theUser->vendor_id == "0")
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
		if($vendor_code =="" && $project_code == "")
		{
			$vendor_code=null;
			$project_code=null;
			$batches = $batchRepository->getDataForProjectReport($vendor_code,$project_code);
		}
		else {
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
		$vendors -> prepend('select vendor','0');
		if ($this->theUser->vendor_id == "0")
		{
			$show=true;
			$users = $userRepository->getVendorUsers(Input::get('vendor_code'));
			$users -> prepend('select user','0');
		}
		else 
		{ 
			$show=false;
			$users = $userRepository->getVendorUsers($this->theUser->vendor_id); 
			$users -> prepend('select user','0');
		}
		return view('report.productivity-report', compact('show','users', 'vendors'));
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
		if ($this->theUser->vendor_id == "0")
		{
			$vendorId	=$inputs['vendorId'];
		}
		else 
		{
			$vendorId=$this->theUser->vendor_id;
		}
		$userId = $inputs['userId'];
		$fromDate = $inputs['fromDate'];
		$toDate = $inputs['toDate'];
		//Log::info("Contact:::::". $vendorId." ".$userId." ".$fromDate." ".$toDate);
		$datas=$contactRepository->getDataForReport($vendorId,$userId,$fromDate,$toDate);
		foreach ($datas as $data)
		{
			$records=$data->no_rows;
			$hours=$data->hrs;
			$myArray = explode(':', $hours);
			$h=$myArray[0];
			foreach($myArray as $time)
			{
				$m=$time;
			}
			$m=$m/60;
			$hours=$h+$m;
			$per_hour=0;
			if($hours!=0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
			if($vendorId== 0 && $userId == 0)
			{
				$data['first_name']="All";
			}
		}
		//Log::info("Contact:::::". $datas);
		
		return view('report.partials.productivity-table',compact('datas'));
	}
}
