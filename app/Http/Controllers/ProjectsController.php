<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Http\Requests\Project\CreateProjectRequest;
use Vanguard\Http\Requests\Project\UpdateProjectRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Project;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class ProjectsController - Controls all the operations for project entity
 * @package Vanguard\Http\Controllers
 */
class ProjectsController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projects;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $users
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->middleware('permission:projects.manage');
        $this->projects = $projects;
    }

    /**
     * Display paginated list of all projects.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $perPage = 2;
        $projects = $this->projects->paginate($perPage, Input::get('search'));
        $statuses = ['' => trans('app.all')] + UserStatus::lists(); // Check-Deepak
        return view('project.list', compact('projects', 'statuses')); // Check-Deepak
    }

    /**
     * Displays form for creating a new project.
     *
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$edit = false;
        return view('project.add-edit', compact('edit'));
    }

    /**
     * Stores new project into the database.
     *
     * @param CreateProjectRequest $request
     * @return mixed
     */
    public function store(CreateProjectRequest $request)
    {
        $data = $request->all();
        $project = $this->projects->create($data);
        return redirect()->route('project.list')
            ->withSuccess(trans('app.project_created'));
    }

    /**
     * Displays edit project form.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $edit = true;
        return view('project.add-edit', compact('edit', 'project'));
    }

    /**
     * Update specified project with provided data.
     *
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update(Project $project, UpdateProjectRequest $request)
    {
    	$this->projects->update($project->id, $request->all());
    	return redirect()->route('project.list')
    		->withSuccess(trans('app.project_updated'));
    }
  }