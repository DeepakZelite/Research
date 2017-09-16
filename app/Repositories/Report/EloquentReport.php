<?php
namespace Vanguard\Repositories\Report;

use Vanguard\Report;
use DB;
use Carbon\Carbon;

class EloquentReport implements ReportRepository
{
	public function __construct()
	{
	
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function find($id)
	{
		return Company::find($id);
	}
	
	/**
	 * 
	 */
	public function get_id_for_stoptime($user_id)
	{
		$query = Report::query();
		$result=$query->from(DB::raw("report_details where created_at=(select max(created_at) from report_details where user_id=".$user_id.")"))
						->select('id')
						->get();
		return $result;
	}
	
	public function get_data_for_report($user_id=null,$start_date=null,$end_date=null,$vendorId=null,$batchId=null)
	{
		$query = Report::query();
		if($user_id)
		{
			$query->where('report_details.user_id',"=","{$user_id}");
		}
		if($vendorId)
		{
			$query->where('users.vendor_id',"=","{$vendorId}");
		}
		if($start_date)
		{
			$start_date =$start_date . " 00:00:01";
			$query->where('report_details.start_time',">=","{$start_date}");
		}
		
		if($end_date == null )
		{
			$end_date=Carbon::now();//->format('Y-m-d h:M:s');//Carbon::today()
			$query->where('report_details.stop_time',"<=","{$end_date}");
		}
		else
		{
			$end_date =$end_date . " 23:59:59";
			$query->where('report_details.stop_time',"<=","{$end_date}");
		}
		
		if($batchId)
		{
			$query->where('report_details.batch_id',"=","{$batchId}");
		}
		
		if($vendorId == 0 && $user_id == 0 && $batchId == 0)
		{
			$result = $query
			->leftjoin('users', 'users.id', '=', 'report_details.user_id')
			->leftjoin('vendors','vendors.id','=','users.vendor_id')
			->select(DB::raw('users.id,users.first_name,users.last_name,users.vendor_id,vendors.vendor_code,sum(report_details.records) as no_rows,sum(report_details.time) as hrs'))
			->groupBy('users.vendor_id')
			->get();
			return $result;
		}
		else {
		$result = $query
				->leftjoin('users', 'users.id', '=', 'report_details.user_id')
				->leftjoin('vendors','vendors.id','=','users.vendor_id')
				->select(DB::raw('users.id,users.first_name,users.last_name,users.vendor_id,vendors.vendor_code,sum(report_details.records) as no_rows,sum(report_details.time) as hrs,min(start_time) as start_time,max(stop_time) as stop_time'))
				->groupBy('users.id')
				->get();
		return $result;
		}
	}
}