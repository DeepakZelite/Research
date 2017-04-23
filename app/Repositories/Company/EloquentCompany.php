<?php

namespace Vanguard\Repositories\Company;

use Vanguard\Company;
use Carbon\Carbon;

class EloquentCompany implements CompanyRepository
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
	/*public function findByBatch($batch_id)
	{
		return Company::find($batch_id);
	}
    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Company::where('name', $name)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Company::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $parentId = null)
    {
        $query = Company::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('company_name', "like", "%{$search}%");
            });
        }

        $result = $query->where("parent_id", "=", $parentId)->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        $result->appends(['parent_id' => $parentId]);
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
        $company = $this->find($id);

        return $company->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return Company::count();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnAssignedCount($batchId)
    {
    	$query = Company::query();
    	if ($batchId != 0) {
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.batch_id', "=", "{$batchId}")
    				->whereNull('sub_batch_id');
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->count();
    	return $result;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTotalCompanyCount($batchId)
    {
    	$query = Company::query();
    	if ($batchId != 0) {
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.batch_id', "=", "{$batchId}");
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->count();
    	return $result;
    }
    
    /**
     * {@inheritdoc}
     */
    public function lists($column = 'name', $key = 'id')
    {
    	return Company::lists($column, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function newCompanysCount()
    {
        return Company::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return Company::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCompanyRecord($subBatchId, $userId)
    {
    	$query = Company::query();
    	if ($subBatchId != 0) {
    		$query = $query->where(function ($q) use($subBatchId, $userId) {
    			$q->where('companies.sub_batch_id', "=", "{$subBatchId}")
    			->where('companies.user_id', "=", "{$userId}")
    			->where('companies.status', "=", "Assigned");    			
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->orderBy('companies.updated_at', 'desc')->limit(1)->get();
    	//$result = $query->orderBy('companies.parent_id', 'desc')->limit(1)->get();
    	return $result;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCompaniesForBatch($batchId, $limit)
    {
    	$query = Company::query();
    	if ($batchId != 0) {
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.batch_id', "=", "{$batchId}")
    			->where('companies.status', "=", "UnAssigned")
    			->orderBy('id', 'ASC');
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->limit($limit)->get();
    	return $result;
    }
    
    
    /**
     * {@inheritdoc}
     * /
     */
    public function getCompaniesForSubBatchDelete($batchId)
    {
    	$query = Company::query();
    	if ($batchId != 0) {
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.sub_batch_id', "=", "{$batchId}")
    			->orderBy('id', 'ASC');
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->get();
    	return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubmittedCompanyCount($batchId)
    {
    	$query = Company::query();
    	if ($batchId != 0) {
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.batch_id', "=", "{$batchId}");
    			$q->where('companies.status',"=","Submitted");
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->count();
    	return $result;
    }
    
    /**
     * {@inheritDoc}
     * @see \Vanguard\Repositories\Company\CompanyRepository::getTotalCompany()
     */
    public function getTotalCompany($batchId)
    {
    	$query = Company::query();
    	$result = $query
    	->leftjoin('contacts', 'companies.id', '=', 'contacts.company_id')
    	->select('companies.*','contacts.*','contacts.additional_info1 as info1','contacts.additional_info2 as info2','contacts.additional_info3 as info3','contacts.additional_info4 as info4');
    
    	if ($batchId != 0) {
    
    
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.batch_id', "=", "{$batchId}");
    
    		});
    	} else {
    		return 0;
    	}
    
    	$result = $query->get();
    	return $result;
    }
    
    
    /**
     * 
     * {@inheritDoc}
     * @see \Vanguard\Repositories\Company\CompanyRepository::getChildCompanies()
     */
    public function getChildCompanies($parentId)
    {
    	return Company::where('parent_id', $parentId)->get();//lists('company_name','id');
    }
   
    public function getcompanies($batchId)
    {
    	$query = Company::query();
    	if ($batchId != 0) {
    		$query->where(function ($q) use($batchId) {
    			$q->where('companies.batch_id', "=", "{$batchId}");
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->select('id')->get();
    	return $result;
    }
    
    public function getCompaniesForProductivityReport($vendorId = null,$userId = null)
    {
    	$query = Company::query();
    	if($vendorId)
    	{
    		$query->where('companies.vendor_id',"=","{$vendorId}");
    	}
    	if($userId)
    	{
    		$query->where('companies.user_id',"=","{$userId}");
    	}
    	$result=$query->where('status',"=","Submitted")
    			->count();
    	
    	return $result;
    }
    
    public function getcompaniesforReport($vendorId = null,$userId = null)
    {
    	$query = Company::query();
    	if ($vendorId) 
    	{
    		$query->where('companies.vendor_id', "=", "{$vendorId}");
    	}
    	if($userId)
    	{
    		$query->where('$companies.user_id',"=","{$userId}");
    	}
    	$result = $query->select('id')->get();
    	return $result;
    }
}