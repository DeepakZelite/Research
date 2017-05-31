<?php

namespace Vanguard\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Vanguard\SubBatch;
use Vanguard\Batch;
use Vanguard\Repositories\SubBatch\SubBatchRepository;
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Http\Requests\SubBatch\CreateSubBatchRequest;
use Vanguard\Support\Enum\SubBatchStatus;
use Vanguard\Company;

/**
 * Class SubSubBatchesController - Controls all the operations for SubBatch entity
 * @package Vanguard\Http\Controllers
 */
class SubBatchesController extends Controller
{
	/**
	 * @var SubBatchRepository
	 */
	private $subBatches;
	private $batches;
	private $users;
	protected $theUser;
	private $batchId;
	private $companyRepository;
	private $batchRepository;
	private $projectRepository;
	
	/**
	 * SubSubBatchesController constructor.
	 * @param SubBatchRepository $subBatches
	 * @param CompanyRepository $companyRepository
	 */
	public function __construct(SubBatchRepository $subBatches,CompanyRepository $companyRepository)
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:batch.allocation');
		$this->subBatches = $subBatches;
		$this->theUser = Auth::user();
		$this->companyRepository = $companyRepository;
	}

	/**
	 * Display paginated list of all subSubBatches.
	 * @param BatchRepository $batchRepository
	 * @param UserRepository $userRepository
	 * @param ProjectRepository $projectRepository
	 * @return list of subbatches with batches and user drop down list.
	 */
	public function index(BatchRepository $batchRepository, UserRepository $userRepository,CompanyRepository $companyRepository)
	{
		$perPage = 5;
		$subBatches = $this->subBatches->paginate($perPage, Input::get('search'),null,Input::get('status'),$this->theUser->vendor_id);
		$statuses = ['' => trans('app.all')] + SubBatchStatus::lists1();
		$vendorId = $this->theUser->vendor_id;
		$batches = $batchRepository->getVendorBatches($vendorId);
		$batches->prepend('Select Batch', '0');
		$users = $userRepository->getVendorUsers($vendorId);
		$users->prepend('Select User', '0');
		foreach($subBatches as $subBatch)
		{
			$subBatch['count'] = $companyRepository->getAssignedCompanyCountForSubBatch($subBatch->id);
		}
		return view('subBatch.list', compact('subBatches', 'statuses', 'batches', 'users'));
	}
	
	/**
	 * Stores new SubBatch into the database also changes in companies table
	 * @param CreateSubBatchRequest $request
	 * @param Batch $batch
	 * @param CompanyRepository $companyRepository
	 * @return on same page with success message and displaying new subbatch which is created.
	 */
	public function store(CreateSubBatchRequest $request,Batch $batch,CompanyRepository $companyRepository)
	{
		$batchId = $request->input('batch_id');
		$batch=batch::find($request->input('batch_id'));
		if($companyRepository->getUnAssignedCount($batchId)>= $request->company_count)
		{
			$newSeqNo = $this->subBatches->getMaxSeqNo($request->input('batch_id'))+1;
			$vendorId =$this->theUser->vendor_id;// = Auth::user()->id;// $this->theUser->vendor_id;
			//return $vendorId;
			$data = $request->all() + ['status' => SubBatchStatus::ASSIGNED] + ['seq_no' => $newSeqNo] +['project_id' => "$batch->project_id"] + ['vendor_id'=>"$vendorId"];
			$subBatch = $this->subBatches->create($data);
			$companies = $this->companyRepository->getCompaniesForBatch($request->input('batch_id'), $request->input('company_count'));
			if (count($companies)) {
				foreach ($companies as $company) {
					$company->status = "Assigned";
					$company->user_id = $request->input('user_id');
					$company->sub_batch_id = $subBatch->id;
					$company->update();
				}
			}
			$batch->status=SubBatchStatus::INPROCESS;
			$batch->update();
				return redirect()->route('subBatch.list')
				->withSuccess(trans('app.sub_batch_created'));
		}
		else 
		{
			return redirect()->route('subBatch.list')
			->withErrors(trans('app.sub_batch_not_created'));
		}
	}
	
	/**
	 * retriving the total company count and unassigned count based on dropdownlist of batches.
	 * @param Request $request
	 * @param CompanyRepository $companyRepository
	 * @return count of total company and unassigned company
	 */
	public function getCompanyCount(Request $request, CompanyRepository $companyRepository) {
		$batchId =$request->input('batchId');
		if ($batchId == "") {
			$batchId = 0;
		}
		$userId = $request->input('userId');
		if ($userId == "") {
			$userId = 0;
		}
		return $companyRepository->getTotalCompanyCount($batchId) . ',' . $companyRepository->getUnAssignedCount($batchId);		
	}
	
	/**
	 * for deleting the sub-batch and updating the company table data
	 * @param SubBatch $subBatch
	 * @param CompanyRepository $companyRepository
	 * @return on the same page with success message
	 */
	public function delete(SubBatch $subBatch,CompanyRepository $companyRepository)
	{
		$subBatch1=SubBatch::find($subBatch->id);
		$companies = $this->companyRepository->getCompaniesForSubBatchDelete($subBatch1->id);
		if (count($companies)) {
			foreach ($companies as $company) {
				$company->status = "UnAssigned";
				$company->user_id = "";
				$company->sub_batch_id = null;
				$company->update();
			}
		}
		if($companyRepository->getTotalCompanyCount($subBatch1->batch_id) == $companyRepository->getUnAssignedCount($subBatch1->batch_id))
		{
			$batch=batch::find($subBatch1->batch_id);
			$batch->status=SubBatchStatus::ASSIGNED;
			$batch->update();
		}
		$this->subBatches->delete($subBatch->id);
		return redirect()->route('subBatch.list')->withSuccess(trans('app.sub_batch_deleted'));
	}
}