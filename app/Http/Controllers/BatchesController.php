<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Http\Requests\Batch\CreateBatchRequest;
use Vanguard\Http\Requests\Batch\UpdateBatchRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Batch;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Repositories\Vendor\VendorRepository;

/**
 * Class BatchesController - Controls all the operations for batch entity
 * @package Vanguard\Http\Controllers
 */
class BatchesController extends Controller
{
	/**
	 * @var BatchRepository
	 */
	private $batches;

	/**
	 * BatchesController constructor.
	 * @param BatchRepository $users
	 */
	public function __construct(BatchRepository $batches)
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:batches.manage');
		$this->batches = $batches;
	}

	/**
	 * Display paginated list of all batches.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$perPage = 5;
		$batches = $this->batches->paginate($perPage, Input::get('search'));
		$statuses = ['' => trans('app.all')] + UserStatus::lists(); // Check-Deepak
		return view('batch.list', compact('batches', 'statuses')); // Check-Deepak
	}

	/**
	 * Displays form for creating a new batch.
	 *
	 * @param CountryRepository $countryRepository
	 * @param RoleRepository $roleRepository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(ProjectRepository $projectRepository, VendorRepository $vendorRepository)
	{
		$projects = $projectRepository->lists();
		$vendors = $vendorRepository->lists();
		$edit = false;
		return view('batch.add-edit', compact('edit', 'projects', 'vendors'));
	}

	/**
	 * Stores new batch into the database.
	 *
	 * @param CreateBatchRequest $request
	 * @return mixed
	 */
	public function store(CreateBatchRequest $request)
	{
		$data = $request->all();
		$batch = $this->batches->create($data);
		return redirect()->route('batch.list')
		->withSuccess(trans('app.batch_created'));
		 
	}

	/**
	 * Displays edit batch form.
	 *
	 * @param Batch $batch
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Batch $batch, ProjectRepository $projectRepository, VendorRepository $vendorRepository)
	{
		$projects = $projectRepository->lists();
		$vendors = $vendorRepository->lists();
		$edit = true;
		return view('batch.add-edit', compact('edit', 'batch', 'projects', 'vendors'));
	}

	/**
	 * Update specified batch with provided data.
	 *
	 * @param Role $role
	 * @param UpdateRoleRequest $request
	 * @return mixed
	 */
	public function update(Batch $batch, UpdateBatchRequest $request)
	{
		$this->batches->update($batch->id, $request->all());
		return redirect()->route('batch.list')
		->withSuccess(trans('app.batch_updated'));
	}
}