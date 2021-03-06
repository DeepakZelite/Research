<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;

use Vanguard\Http\Requests;
use Vanguard\Repositories\Contact\ContactRepository;
use Illuminate\Support\Facades\Log;
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
	public function myProductivityList(ContactRepository $contactRepository)
	{
		$userId=$this->theUser->id;
		$username = $this->theUser->username;
		$datas=$contactRepository->getDataForReport(null,$userId);
		foreach ($datas as $data)
		{
			$records=$data->no_rows;
			$hours=$data->hrs;
			$per_hour=null;
			if($hours!=0)
			{
				$per_hour=round($records/$hours);
			}
			$data['per_hour']=$per_hour;
		}
		Log::info("Contact:::::". $datas);
		return view('report.my_productivity',compact('datas'));
	}
	
	/**
	 * search the user report by from date to To Date
	 * @param Request $request
	 * @param ContactRepository $contactRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function searchReportList(Request $request,ContactRepository $contactRepository)
	{
		$fromDate=$request->Start_Date;
		$toDate=$request->Expected_date;
		$userId = $this->theUser->id;
		$datas = $contactRepository->getDataForReport(null,$userId,$fromDate,$toDate);
		//return $datas;
		return view('report.my_productivity',compact('datas'));
	}
}
