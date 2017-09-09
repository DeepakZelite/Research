<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Http\Requests;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Repositories\SubBatch\SubBatchRepository;
use Auth;
use Vanguard\Repositories\Project\ProjectRepository;
use Illuminate\Support\Facades\Input;

class ReallocationController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:batch.reallocation');
		$this->theUser = Auth::user();
	}
	
	public function reallocation(ProjectRepository $projectRepository,BatchRepository $batchRepository, CompanyRepository $companyRepository)
	{
		$project_id=Input::get('project_code');
		$batch_id = Input::get('batch_code');
		$projects =	[''=>trans('')] + $projectRepository->lists();
		$batches = [''=>trans('')] + $batchRepository->getProjectBatches($project_id);
		if(count($batches) <= 1)
		{
			$batch_id=0;
		}
		$companies = $companyRepository->getCompaniesForBatchForReallocation($batch_id);
		return view('quality.reallocate',compact('projects','batches','companies'));
	}
	
	public function reassign(Request $request, CompanyRepository $companyRepository, SubBatchRepository $subbatchRepository, BatchRepository $batchRepository)
	{
		$data=$request->agree;
		if(count($data) > 0)
		{
			foreach($data as $data1)
			{
				$company = $companyRepository->find($data1);
				$company -> status = 'Assigned';
				$company -> save();
	
				$subBatch = $subbatchRepository->find($company->sub_batch_id);
				$subBatch ->status = 'In-Process';
				$subBatch ->notify = 'Reassign';
				$subBatch ->save();
				 
				$batch = $batchRepository->find($company->batch_id);
				$batch ->status = 'In-Process';
				$batch ->save();
			}
			return redirect()->route('reallocation')->withSuccess(trans('app.company_reallocation_successfully_done'));
		}else
		{
			return redirect()->route('reallocation')->withErrors(trans('app.no_company_is_selected'));
		}
	}
}
