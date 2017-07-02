<?php

namespace Vanguard\Repositories\Contact;

use Vanguard\Contact;

interface ContactRepository
{
    /**
     * Paginate registered contacts.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null,$companyId = null,$first=null);

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
    public function newContactsCount();

     /**
     * Get latest {$count} users from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);
    
    /**
     * for checking the duplicate data for specific fields.
     * @param unknown $first
     * @param unknown $last
     * @param unknown $jobTitle
     * @param unknown $email
     * @param unknown $companyName
     * @param unknown $website
     * @param unknown $address
     * @param unknown $city
     * @param unknown $state
     * @param unknown $zipcode
     */
    public function duplicate($first = null, $last = null,$jobTitle = null,$email = null,$companyName = null,$website = null,$address =null,$city = null,$state = null,$zipcode =null,$prm = null);
    
    /**
     * for geting the count of perticular company.
     * @param unknown $companyId
     */
    public function getTotalContactCount($companyId);
    
    /**
     * for geting the data for creating the report
     * @param unknown $vendorId
     * @param unknown $userId
     * @param unknown $fromDate
     * @param unknown $toDate
     */
    public function getDataForReport($vendorId = null,$userId = null,$fromDate = null, $toDate = null);
    
    
    public function getProcessRecordFromDate($start,$end);
    
    public function getProcessRecordCount($vendorId = null,$userId = null,$fromDate = null, $toDate = null);
    
}