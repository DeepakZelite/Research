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
    public function paginate($perPage, $search = null)
    {
        $query = Company::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('company_name', "like", "%{$search}%");
            });
        }

        $result = $query->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
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
    /* public function update($batch_id,array $data)
     {
     	return $this->find($batch_id->update($data));
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
    				->whereNull('sub_batch_id')
    				->orwhere('sub_batch_id',"=","0");
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
    		$query->where(function ($q) use($subBatchId, $userId) {
    			$q->where('companies.sub_batch_id', "=", "{$subBatchId}")
    			->where('companies.user_id', "=", "{$userId}")
    			->where('companies.status', "=", "Assigned")
    			->orderBy('id', 'ASC');
    		});
    	} else {
    		return 0;
    	}
    	$result = $query->limit(1)->get();
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
}