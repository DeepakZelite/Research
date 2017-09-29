<?php

namespace Vanguard\Repositories\Project;

use Vanguard\Project;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Log;

class EloquentProject implements ProjectRepository
{
 
	public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Project::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Project::where('name', $name)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Project::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null)
    {
        $query = Project::query();

        if ($search) {
            $query->where(function ($q) use($search) {
                $q->where('code', "like", "%{$search}%");
                $q->orwhere('name',"like","%{$search}%");
                $q->orwhere('No_Companies', "like", "%{$search}%");
                $q->orwhere('Expected_staff', "like", "%{$search}%");
            });
        }

        $result = $query->sortable()->orderBy('created_at', 'DESC')->paginate($perPage);

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
        $project = $this->find($id);

        return $project->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return Project::count();
    }
    
    /**
     * {@inheritdoc}
     */
    public function lists($column = 'code', $key = 'id')
    {
    	return Project::lists($column, $key)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function newProjectsCount()
    {
        return Project::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function latest($count = 20)
    {
        return Project::orderBy('created_at', 'DESC')
            ->limit($count)
            ->get();
    }
	
    public function lists1()
    {
    	return Project::select('code')->lists('code','code')->toArray();
    }
    
    public function getprojectNameList()
    {
    	return Project::select('name')->lists('name','name')->toArray();
    }
    
    public function getProjectCompanyCount($projectId = null)
    {
    	$query = Project::query();
    	
    	if($projectId)
    	{
    		$query->where('id', "=", "{$projectId}");
    	}
    	$result=$query->select('No_Companies')->get()->first();
    	return $result;
    }
    
    public function getProjectCode($vendorId=null)
    {
    	$query = Project::query();
    	if($vendorId)
    	{
    		$query->where('batches.vendor_id',"=","{$vendorId}");
    	}
    	$result=$query->select('projects.code')
    				->join('batches', 'batches.project_id', '=', 'projects.id')
    				->distinct('projects.project_id')
    				->lists('code','code')
    				->toArray();
    	Log::debug("getProjectCode Sql:". $query->toSql());
    	return $result;
    }
    
    public function getProjectName($vendorId=null)
    {
    	$query = Project::query();
    	if($vendorId)
    	{
    		$query->where('batches.vendor_id',"=","{$vendorId}");
    	}
    	$result=$query->select('projects.name')
    				->join('batches', 'batches.project_id', '=', 'projects.id')
    				->distinct('projects.project_id')
    				->lists('name','name')
    				->toArray();
    	Log::debug("getProjectCode Sql:". $query->toSql());
    	return $result;
    }
}