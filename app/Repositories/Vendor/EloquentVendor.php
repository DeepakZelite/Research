<?php

namespace Vanguard\Repositories\Vendor;

use Vanguard\Vendor;
use Carbon\Carbon;

class EloquentVendor implements VendorRepository
{
 
	public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Vendor::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Vendor::where('name', $name)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Vendor::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null)
    {
        $query = Vendor::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('name', "like", "%{$search}%");
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
    
    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $vendor = $this->find($id);

        return $vendor->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return Vendor::count();
    }

    /**
     * {@inheritdoc}
     */
    public function newVendorsCount()
    {
        return Vendor::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return Vendor::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }

}