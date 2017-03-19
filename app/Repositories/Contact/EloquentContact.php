<?php

namespace Vanguard\Repositories\Contact;

use Vanguard\Contact;
use Carbon\Carbon;

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
    public function paginate($perPage, $search = null, $companyId = null)
    {
        $query = Contact::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('code', "like", "%{$search}%");
            });
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

}