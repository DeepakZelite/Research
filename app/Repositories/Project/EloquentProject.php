<?php

namespace Vanguard\Repositories\Project;

use Vanguard\Project;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;

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
                $q->orwhere('No_Companies', "like", "%{$search}%");
                $q->orwhere('Expected_staff', "like", "%{$search}%");
            });
        }

        $result = $query->sortable()->paginate($perPage);

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
    	return Project::lists($column, $key);
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
}