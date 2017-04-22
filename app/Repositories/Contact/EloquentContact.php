<?php

namespace Vanguard\Repositories\Contact;

use Vanguard\Contact;
use Carbon\Carbon;
use League\Flysystem\Adapter\NullAdapter;

class EloquentContact implements ContactRepository
{
 
	public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Contact::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Contact::where('name', $name)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Contact::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $companyId = null,$first=null)
    {
        $query = Contact::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('code', "like", "%{$search}%");
            });
        }
        if($first)
        {
        	$query->where('first_name',"=","{$first}");
        }
        if ($companyId) {
        	$query->where('company_id', "=", "{$companyId}");
        }
        
        $result = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        if ($companyId) {
        	$result->appends(['company_Id' => $companyId]);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        return $this->find($id)->update($data);
    }
    
    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $project = $this->find($id);

        return $project->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return Contact::count();
    }
    
    /**
     * {@inheritdoc}
     */
    public function lists($column = 'code', $key = 'id')
    {
    	return Contact::lists($column, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function newContactsCount()
    {
        return Contact::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return Contact::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Vanguard\Repositories\Contact\ContactRepository::duplicat()
     */
    public function duplicate($first = null,$last = null,$jobTitle = null,$email = null,$companyName = null,$website = null,$address =null,$city = null,$state = null,$zipcode =null,$specility = null,$phone = null)
    {	
    	$query = Contact::query();
    	
    	if($companyName)
    	{
    		$query->where('companies.company_name',"like","{$companyName}%");
    	}
    	if($website)
    	{
    		$query->where('companies.website', "=", "{$website}");
    	}
    	if($address)
    	{
    		$query->where('companies.address1', "like", "{$address}%"); 
    	}
    	if($city)
    	{
    		$query->where('companies.city',"like", "{$city}%");
    	}
    	if($state)
    	{
    		$query->where('companies.state',"like","{$state}%");
    	}
    	if($zipcode)
    	{
    		$query->where('companies.zipcode',"=","{$zipcode}");
    	}
    	if($phone)
    	{
    		$query->where('companies.branchNumber',"like","{$phone}%");
    	}
    	if ($first) {
    		$query->where('contacts.first_name', "=", "{$first}");
    	}
    	if($last)
    	{
    		$query->where('contacts.last_name', "=", "{$last}");
    	}
    	if($jobTitle)
    	{
    		$query->where('contacts.job_title',"like","{$jobTitle}%");
    	}
    	if($email)
    	{
    		$query->where('contacts.staff_email', "=" ,"{$email}");
    	}
    	if($specility)
    	{
    		$query->where('contacts.specialization'."like","{$specility}%");
    	}
    	$result = $query
    	->leftjoin('companies', 'companies.id', '=', 'contacts.company_id')
    	->select('companies.*','contacts.*');
    	$result= $query->get();
    	return $result;
    }

}