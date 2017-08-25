<?php

namespace Vanguard\Repositories\Mdb;


interface MdbRepository
{
	/**
	 * return data for download purpose
	 */
	public function getDataDownloadFromDates($date=null);
	
	/**
	 * get the specific fileter data download
	 * @param unknown $project_name
	 * @param unknown $project_code
	 * @param unknown $employee_size
	 * @param unknown $classification
	 * @param unknown $specification
	 * @param unknown $physician_size
	 * @param unknown $state
	 */
	public function specificDownload($project_name=null,$project_code=null,$employee_size=null,$classification=null,$specification=null,$physician_size=null,$state=null);
	
	/**
	 * check the duplicate record if available then return record
	 * @param unknown $company_name
	 * @param unknown $website
	 * @param unknown $address
	 * @param unknown $city
	 * @param unknown $state
	 * @param unknown $zipcode
	 * @param unknown $phone
	 * @param unknown $prm
	 * @param unknown $first
	 * @param unknown $last
	 * @param unknown $jobtitle
	 * @param unknown $email
	 * @param unknown $specility
	 */
	public function duplicatecheck($company_name=null,$website=null,$address=null,$city=null,$state=null,$zipcode=null,$phone=null,$prm=null,$first=null,$last=null,$jobtitle=null,$email=null,$specility=null);
}