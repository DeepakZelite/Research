<?php

namespace Vanguard\Repositories\Batch;

use Vanguard\Batch;

interface BatchRepository
{
    /**
     * Paginate registered users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $vendorId = null, $status = null,$vendorCode =null,$projectcode = null);

    /**
     * Find user by its id.
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
    public function newBatchesCount();

     /**
     * Get latest {$count} users from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);
 
    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'name', $key = 'id');
 
    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function getVendorBatches($vendorId);
    
    /**
     * 
     * @param unknown $vendor_code
     * @param unknown $project_code
     */
    public function getDataForProjectReport($vendor_code = null, $project_code = null);
    
    /**
     * for geting the batch count for perticular date
     * @param unknown $batch
     */
    public function getBatchNameCount($batch = null);
}