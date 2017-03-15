<?php

namespace Vanguard\Repositories\Batch;

use Vanguard\Batch;
use Carbon\Carbon;

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
    public function paginate($perPage, $search = null)
    {
        $query = Batch::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('batches.name', "like", "%{$search}%");
            });
        }

       // $result = $query->paginate($perPage);

        $result = $query
        ->leftjoin('projects', 'projects.id', '=', 'batches.project_id')
        ->leftjoin('vendors', 'vendors.id', '=', 'batches.vendor_id')
        ->select('batches.*', 'projects.name as project_name', 'vendors.name as vendor_name')
        ->paginate($perPage);

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
    

}