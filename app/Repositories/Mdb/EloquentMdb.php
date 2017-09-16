<?php
namespace Vanguard\Repositories\Mdb;

use Vanguard\Maindb;
use DB;
use Illuminate\Support\Facades\Log;

class EloquentMdb implements MdbRepository
{
	public function __construct()
	{
	
	}
	
	public function getDataDownloadFromDates($date=null)
	{
		$query = Maindb::query();
		if($date)
		{
			$query->where('created_at',">=","{$date}");
		}
		$result = $query->get();
		Log::debug("getDataDownloadFromDates MainDb Sql:". $query->toSql());
		return $result;
	}
	
	public function specificDownload($project_name=null,$project_code=null,$employee_size=null,$classification=null,$specification=null,$physician_size=null,$state=null)
	{
		$query = Maindb::query();
		if($project_name)
		{
			$query->where('project_name',"=","{$project_name}");
		}
		if($project_code)
		{
			$query->where('project_code',"=","{$project_code}");
		}
		if($employee_size)
		{
			Log::info("Physician Size:".$employee_size);
			$query->where('employee_size',"=","{$employee_size}");
		}
		if($classification)
		{
			$query->where('industry_classfication', "=", "{$classification}");
		}
		if($specification)
		{
			$query->where('specialization', "=", "{$specification}");
		}
		if($physician_size)
		{
			$query->where('physician_size', "=", "{$physician_size}");
		}
		if($state)
		{
			$query->where('state',"=","{$state}");
		}
		$result = $query->get();
		Log::debug("specificDownload MainDb Sql:". $query->toSql());
		return $result;
	}
	
	public function duplicatecheck($company_name=null,$website=null,$address=null,$city=null,$state=null,$zipcode=null,$phone=null,$prm=null,$first=null,$last=null,$jobtitle=null,$email=null,$specility=null)
	{
		$query = Maindb::query();
		if($company_name)
		{
			$query->where('company_name',"like","{$company_name}%");
		}
		if($website)
		{
			$query->where('website', "=", "{$website}");
		}
		if($address)
		{
			$query->where('address1', "like", "{$address}%");
		}
		if($city)
		{
			$query->where('city',"like", "{$city}%");
		}
		if($state)
		{
			$query->where('state',"like","{$state}%");
		}
		if($zipcode)
		{
			$query->where('zipcode',"=","{$zipcode}");
		}
		if($phone)
		{
			$query->where('branchNumber',"like","{$phone}%");
		}
		if($prm)
		{
			$query->where('prm','like',"{$prm}");
		}
		if ($first) {
			$query->where('first_name', "=", "{$first}");
		}
		if($last)
		{
			$query->where('last_name', "=", "{$last}");
		}
		if($jobtitle)
		{
			$query->where('job_title',"like","{$jobtitle}%");
		}
		if($email)
		{
			$query->where('staff_email', "=" ,"{$email}");
		}
		if($specility)
		{
			$query->where('specialization',"like","{$specility}%");
		}
		$result = $query->get();
		Log::debug("duplicate MainDb Sql:". $query->toSql());
		return $result;
	}
}