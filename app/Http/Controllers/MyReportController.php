<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;

use Vanguard\Http\Requests;
use Vanguard\Repositories\Contact\ContactRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Repositories\Report\ReportRepository;
use Auth;
use Illuminate\Support\Facades\Log;

class MyReportController extends Controller
{
	/**
	 * contructor
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:reports.user');
		$this->theUser = Auth::user();
	}
	
	/**
	 * report list of perticular user
	 * @param ContactRepository $contactRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function myProductivityList(ContactRepository $contactRepository,CompanyRepository $companyRepository,ReportRepository $reportRepository)
	{
		$userId=$this->theUser->id;
		$username = $this->theUser->username;
		//$datas=$contactRepository->getDataForReport(null,$userId);
		$datas=$reportRepository->get_data_for_report($userId);
		foreach ($datas as $data)
		{
			$company_count=$companyRepository->getCompaniesForProductivityReport($data->vendor_id,$userId);
			$SubsidiaryCount =$companyRepository->getSubsidiaryCompaniesForProductivityReport($data->vendor_id,$userId);
			$data->subsidiary_count = $SubsidiaryCount;
			$data->comp_count=$company_count;
			$records=$data->no_rows;
			$minute=$data->hrs;
			$time=gmdate("H:i", ($minute * 60));
			$hours=gmdate("H",($minute*60));
			//Log::info("Contact:::::". $time);
			$data->hrs =$time;
			$per_hour=0;
			if($hours!= 0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
		}
		
		return view('report.my_productivity',compact('datas'));
	}
	
	/**
	 * search the user report by from date to To Date
	 * @param Request $request
	 * @param ContactRepository $contactRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function searchReportList(Request $request,ContactRepository $contactRepository,CompanyRepository $companyRepository,ReportRepository $reportRepository)
	{
		$fromDate=$request->Start_Date;
		$toDate=$request->Expected_date;
		$userId = $this->theUser->id;
		//$datas = $contactRepository->getDataForReport(null,$userId,$fromDate,$toDate);
		$datas=$reportRepository->get_data_for_report($userId,$fromDate,$toDate);
		foreach ($datas as $data)
		{
			$company_count=$companyRepository->getCompaniesForProductivityReport($data->vendor_id,$userId,$fromDate,$toDate);
			$SubsidiaryCount =$companyRepository->getSubsidiaryCompaniesForProductivityReport($data->vendor_id,$userId,$fromDate,$toDate);
			$data->comp_count=$company_count;
			$data->subsidiary_count = $SubsidiaryCount;
			$records=$data->no_rows;
			$minute=$data->hrs;
			$time=gmdate("H:i", ($minute * 60));
			$hours=gmdate("H",($minute*60));
			//Log::info("Contact:::::". $time);
			$data->hrs =$time;
			$per_hour=0;
			if($hours!= 0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
		}
		return view('report.my_productivity',compact('datas'));
	}
}
