<?php

namespace Vanguard\Repositories\Report;


interface ReportRepository
{
	/**
	 * Find user by its id.
	 *
	 * @param $id
	 * @return null|User
	 */
	public function find($id);
	
	/**
	 * get the id for updating the stop time
	 */
	public function get_id_for_stoptime($user_id);
	
	/**
	 * get report of perticular user
	 * @param unknown $user_id
	 */
	public function get_data_for_report($user_id=null,$start_date=null,$end_date=null,$vendorId=null,$batchId=null);
}