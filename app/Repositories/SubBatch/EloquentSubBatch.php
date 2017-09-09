<?php

namespace Vanguard\Repositories\SubBatch;

use Vanguard\SubBatch;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use DB;

class EloquentSubBatch implements SubBatchRepository
{
 
	public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return SubBatch::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return SubBatch::where('name', $name)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return SubBatch::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $userId = null, $status = null,$vendorId = null)
    {
    	$query = SubBatch::query();
    
    	if ($search) {
    		$query->where(function ($q) use($search) {
    			$q->where('batches.name', "like", "%{$search}%");
    			$q->orwhere('users.username',"like","%{$search}%");
    			$q->orwhere('sub_batches.company_count',"like","%{$search}%");
    			$q->orwhere('projects.code',"like","%{$search}%");
    		});
    	}
    	
    	if ($userId) {
    		$query->where(function ($q) use($userId) {
    			$q->where('sub_batches.user_id', "=", "{$userId}");
    		});
    	}
    	
    	if ($vendorId) {
    		$query->where(function ($q) use($vendorId) {
    			$q->where('sub_batches.vendor_id', "=", "{$vendorId}");
    		});
    	}
    	
    	if ($status) {
    		$query->where(function ($q) use($status) {
    			$q->where('sub_batches.status', "=", "{$status}");
    		});
    	}
    
    	$result = $query
    	->leftjoin('batches', 'batches.id', '=', 'sub_batches.batch_id')
    	->leftjoin('users', 'users.id', '=', 'sub_batches.user_id')
    	->leftjoin('projects','projects.id','=','sub_batches.project_id')
    	->select('sub_batches.*','projects.brief_file as brief_file' ,'batches.name as batch_name', 'users.username', 'sub_batches.seq_no as sub_batch_name','projects.code as project_code')
    	->sortable()
    	->orderBy('sub_batches.status')
    	->paginate($perPage);

    	//$result = $query->orderBy('created_at', 'desc')->paginate($perPage);
    	   
    	if ($search) {
    		$result->appends(['search' => $search]);
    		$result->appends(['userId' => $userId]);
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
        $subBatch = $this->find($id);

        return $subBatch->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return SubBatch::count();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMaxSeqNo($batchId)
    {
    	return SubBatch::where('batch_id', $batchId)->max('seq_no');
    }

    /**
     * {@inheritdoc}
     */
    public function newSubBatchesCount()
    {
        return SubBatch::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return SubBatch::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getTimespend($vendorId = null,$userId = null)
    {
    	$query = SubBatch::query();
    	if($vendorId)
    	{
    		$query -> where('vendor_id', "=" ,"{$vendorId}");
    	}
    	if($userId)
    	{
    		$query -> where('user_id',"=","{$userId}");
    	}
    	$result = $query
    			->select(DB::raw('sum(TIMESTAMPDIFF(hour,created_at,updated_at)) as count'),'batch_id')
    			->get();
    	return $result;
    }
    
	/** 
	 * {@inheritDoc}
	 */
    public function getUserInProcessCount($userId)
    {
    	$query = SubBatch::query();
    	$result = $query->where('status',"=",'In-process')
    					->where('user_id',"=","{$userId}")
    					->count();
 		return $result;
    }
}