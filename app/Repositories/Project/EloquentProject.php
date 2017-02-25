<?php

namespace Vanguard\Repositories\Project;

use Vanguard\Project;
use Carbon\Carbon;

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

}