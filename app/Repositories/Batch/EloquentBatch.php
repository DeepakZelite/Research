<?php

namespace Vanguard\Repositories\Batch;

use Vanguard\Batch;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;

class EloquentBatch implements BatchRepository
{
 
	public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Batch::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Batch::where('name', $name)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Batch::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $vendorId = null, $status = null,$vendorCode =null,$projectcode = null)
    {
        $query = Batch::query();
        
        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('batches.name', "like", "%{$search}%");
                $q->orwhere('projects.code',"like","%{$search}%");
                $q->orwhere('vendors.name',"like","%{$search}%");
                $q->orwhere('projects.No_Companies',"like","%{$search}%");
            });
        }

        $query = $query
        ->leftjoin('projects', 'projects.id', '=', 'batches.project_id')
        ->leftjoin('vendors', 'vendors.id', '=', 'batches.vendor_id');
        
        if ($vendorId) {
        	$query = $query->where('vendors.id', '=', $vendorId);
        }
        if($vendorCode)
        {
        	$query= $query->where('vendors.vendor_code','=',$vendorCode);
        }
        if($projectcode)
        {
        	$query=$query->where('projects.code','=',$projectcode);
        }
        if ($status) {
        	$query = $query->where('batches.status', '=', $status);
        }
        $result = $query->select('batches.*', 'projects.code as project_code', 'vendors.vendor_code as vendor_code','projects.No_Companies as No_Companies')
        ->sortable()->paginate($perPage);

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
    
    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $batch = $this->find($id);

        return $batch->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return Batch::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newBatchesCount()
    {
        return Batch::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return Batch::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function lists($column = 'name', $key = 'id')
    {
    	return Batch::lists($column, $key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getVendorBatches($vendorId)
    {
    	return Batch::where('vendor_id', $vendorId)->lists('name', 'id');
    	
    }
    
    public function getDataForProjectReport($vendor_code = null, $project_code = null)
    {
    	$query = Batch::query();
    	if($project_code)
    	{
    		$query->where('projects.code',"=","{$project_code}");
    	}
    	if($vendor_code)
    	{
    		$query->where('vendors.vendor_code',"=","{$vendor_code}");
    	}
    	$result=$query
    	->leftjoin('projects', 'projects.id', '=', 'batches.project_id')
    	->leftjoin('vendors', 'vendors.id', '=', 'batches.vendor_id')
    	->select('vendors.vendor_code','projects.code','projects.No_Companies as companies','batches.id','batches.name','batches.status');
    	$result= $query->get();
    	return $result;
    }
    
    public function getBatchNameCount($batch = null)
    {
    	$query = Batch::query();
    	if($batch)
    	{
    		$query->where('name',"like","{$batch}%");
    	}
    	else{
    		return 0;
    	}
    	$result = $query->count();
    	return $result;
    }
}