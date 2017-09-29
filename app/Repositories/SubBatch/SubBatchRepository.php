<?php

namespace Vanguard\Repositories\SubBatch;

use Vanguard\SubBatch;

interface SubBatchRepository
{
	/**
	 * Paginate registered users.
	 *
	 * @param $perPage
	 * @param null $search
	 * @param null $status
	 * @param null $vendorId
	 * @return mixed
	 */
	public function paginate($perPage, $search = null, $userId = null, $status = null, $vendorId = null);

	/**
	 * Find subBatch by its id.
	 *
	 * @param $id
	 * @return null|User
	 */
	public function find($id);

	/**
	 * Find user by email.
	 *
	 * @param $email
	 * @return null|User
	 */
	public function findByName($name);

	/**
	 * Create new user.
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data);

	/**
	 * Update user specified by it's id.
	 *
	 * @param $id
	 * @param array $data
	 * @return mixed
	 */
	public function update($id, array $data);

	/**
	 * Delete user with provided id.
	 *
	 * @param $id
	 * @return mixed
	 */
	public function delete($id);

	/**
	 * Number of users in database.
	 *
	 * @return mixed
	 */
	public function count();

	/**
	 * Number of users registered during current month.
	 *
	 * @return mixed
	 */
	public function newSubBatchesCount();

	/**
	 * Get latest {$count} users from database.
	 *
	 * @param $count
	 * @return mixed
	 */
	public function latest($count = 20);
	
	/**
	 * Get latest {$count} users from database.
	 *
	 * @param $count
	 * @return mixed
	 */
	public function getMaxSeqNo($batchId);

	/**
	 * 
	 * @param unknown $vendorId
	 * @param unknown $useId
	 */
	public function getTimespend($vendorId = null,$userId = null);
	
	/**
	 * retive the count of In-process Batch of perticular user
	 * @param unknown $userId
	 */
	public function getUserInProcessCount($userId);
}