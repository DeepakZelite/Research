<?php

namespace Vanguard\Repositories\Project;

use Vanguard\Project;

interface ProjectRepository
{
    /**
     * Paginate registered users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null);

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
    public function newProjectsCount();

     /**
     * Get latest {$count} users from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);
    
    
    public function lists1();
    
    /**
     * get the dropdown list for report
     */
    public function getprojectNameList();
    
    public function getProjectCompanyCount($projectId = null);
}