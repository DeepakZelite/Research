<?php

namespace Vanguard\Repositories\Company;

use Vanguard\Company;

interface CompanyRepository
{
    /**
     * Paginate registered users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $parentId = null);

    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'name', $key = 'id');
    
    
    /**
     * Find user by its id.
     *
     * @param $id
     * @return null|User
     */
    public function find($id);
	//public function findByBatch($batch_id);
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

    //public function update($batch_id,array $data);
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
     * No of unassigned companies.
     *
     * @return mixed
     */
    public function getUnAssignedCount($batchId);
    
    /**
     * No of total no of companies in batch.
     *
     * @return mixed
     */
    public function getTotalCompanyCount($batchId);
    
    /**
     * Number of users registered during current month.
     *
     * @return mixed
     */
    public function newCompanysCount();

     /**
     * Get latest {$count} users from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);
    
    /**
     * Get the latest or last saved company record.
     *
     * @return mixed
     */
    public function getCompanyRecord($subBatchId, $userId);
    
    /**
     * Get the un-assigned companies for batch.
     *
     * @return mixed
     */
    public function getCompaniesForBatch($batchId, $limit);
    
    /**
     * Get the un-assigned companies for batch.
     *
     * @return mixed
     */
    public function getCompaniesForSubBatchDelete($batchId);
    
    
    
    /**
     * 
     * @param unknown $batchId
     */
    public function getSubmittedCompanyCount($batchId);

    
    /**
     * 
     * @param unknown $batchId
     */
    public function getTotalCompany($batchId);

    /**
     * 
     * @param unknown $parentId
     */
    public function getChildCompanies($parentId);
    
    /**
     * 
     * @param unknown $batchId
     */
    public function getcompanies($batchId);
    
    /**
     * 
     * @param unknown $vendorId
     * @param unknown $userId
     */
    //public function getCompaniesForProductivityReport($vendorId = null,$userId = null);
    public function getCompaniesForProductivityReport($vendorId = null,$userId = null,$start_date=null,$end_date=null);
    
    /**
     * get companies id for report
     * @param unknown $vendorId
     * @param unknown $userId
     */
    public function getcompaniesforReport($vendorId = null,$userId = null);
    
    /**
     * for retriving the perticular sub-batch Completed Record for Displaying in dataCapture
     * @param unknown $subBatchId
     */
    public function getAssignedCompanyCountForSubBatch($subBatchId = null);
    
    /**
     * get subsidiary count for report
     * @param unknown $vendorId
     * @param unknown $userId
     * @param unknown $start_date
     * @param unknown $end_date
     */
    public function getSubsidiaryCompaniesForProductivityReport($vendorId = null,$userId = null,$start_date=null,$end_date=null);
    
    /**
     * to get all companies of perticular batch for reassigned purpose.
     * @param unknown $batch_id
     */
    public function getCompaniesForBatchForReallocation($batch_id);
    
    public function getSubmittedCompanyCountForReport($batchId,$userId);
    
    public function getSubmittedSubsidiaryCompanyCount($batchId=null,$userId=null);
}