<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;

use Vanguard\Http\Requests;
use Vanguard\Repositories\Contact\ContactRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Auth;

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
	public function myProductivityList(ContactRepository $contactRepository,CompanyRepository $companyRepository)
	{
		$userId=$this->theUser->id;
		$username = $this->theUser->username;
		$datas=$contactRepository->getDataForReport(null,$userId);
		foreach ($datas as $data)
		{
			$company_count=$companyRepository->getCompaniesForProductivityReport($data->vendor_id,$data->user_id);
			$data->comp_count=$company_count;
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
			$per_hour=null;
			if($hours!= 0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
		}
		//Log::info("Contact:::::". $datas);
		return view('report.my_productivity',compact('datas'));
	}
	
	/**
	 * search the user report by from date to To Date
	 * @param Request $request
	 * @param ContactRepository $contactRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function searchReportList(Request $request,ContactRepository $contactRepository,CompanyRepository $companyRepository)
	{
		$fromDate=$request->Start_Date;
		$toDate=$request->Expected_date;
		$userId = $this->theUser->id;
		$datas = $contactRepository->getDataForReport(null,$userId,$fromDate,$toDate);
		foreach ($datas as $data)
		{
			$company_count=$companyRepository->getCompaniesForProductivityReport($data->vendor_id,$data->user_id);
			$data->comp_count=$company_count;
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
			$per_hour=null;
			if($hours!= 0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
		}
		//Log::info("Contact:::::". $datas);
		return view('report.my_productivity',compact('datas'));
	}
}
