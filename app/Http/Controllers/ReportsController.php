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
use Vanguard\Batch;
use Vanguard\Repositories\Vendor\VendorRepository;
use Illuminate\Support\Facades\Log;
use DB;


class ReportsController extends Controller
{
	protected $theUser;
	private $batchId;
	private $batchRepository;
	private $projectRepository;
	private $vendorRepository;
	
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:reports.manage');
		$this->theUser = Auth::user();
	}
	
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
	
	public function productivityList(VendorRepository $vendorRepository,UserRepository $userRepository)
	{
		$vendors  = $vendorRepository->lists();
		$vendors -> prepend('select vendor','-1');
		if($vendorId="")
		{
			$vendorId=-1;
		}
		$users = $userRepository->getVendorUsers(Input::get('vendor_code'));
		$users -> prepend('select user','0');
		$datas=null;
		$datas=DB::table('vendors')->select('vendors.vendor_code as code')->get();
				/*->join('users','vendors.id',"=",'users.vendor_id')
				->select('vendors.vendor_code','users.username')
				->get();*/
		$vendorId=Input::get('vendor_code');
		if($vendorId!=0)
		{
			$datas=DB::table('vendors')
			->join('users','vendors.id',"=",'users.vendor_id')
			 ->select('vendors.vendor_code as code','users.username')
			 ->where('vendors.id',"=","$vendorId")
			 ->get();
		}
		return view('report.productivity-report', compact('datas','users', 'vendors'));
	}
}
