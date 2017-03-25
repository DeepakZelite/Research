<?php

namespace Vanguard\Http\Controllers;


use Auth;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Session\Session;
use Vanguard\Company;
use Vanguard\Contact;
use Vanguard\Http\Requests\Company\UpdateCompanyRequest;
use Vanguard\Http\Requests\Contact\CreateContactRequest;
use Vanguard\Repositories\Batch\BatchRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Repositories\Contact\ContactRepository;
use Vanguard\Repositories\SubBatch\SubBatchRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\SubBatch;
use Vanguard\Batch;
use Vanguard\Http\Requests\Contact\UpdateContactRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Support\Enum\SubBatchStatus;
use Vanguard\Employee;
use Vanguard\Repositories\Employee\EmployeeRepository;

/**
 * Class DataCaptureController - Controls all the operations for Company and Staff entity
 * @package Vanguard\Http\Controllers
 */
class DataCaptureController extends Controller
{
	private $subBatches;
	protected $theUser;
	private $batchId;
	private $companyRepository;
	private $contactRepository;
	private $batchRepository;
	
	/**
	 * Constructs the data capture screen requisites
	 * @param SubBatchRepository $subBatches
	 * @param CompanyRepository $companyRepository
	 * @param ContactRepository $contactRepository
	 */
	public function __construct(SubBatchRepository $subBatches, CompanyRepository $companyRepository, ContactRepository $contactRepository)
	{
		$this->middleware('auth');
		$this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware('permission:companys.manage');
		$this->subBatches = $subBatches;
		$this->theUser = Auth::user();
		$this->companyRepository = $companyRepository;
		$this->contactRepository = $contactRepository;
	}

	/**
	 * Display paginated list of all subSubBatches assigned to logged in user.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(BatchRepository $batchRepository, UserRepository $userRepository)
	{
		$perPage = 5;
		// Un-Comment to see only assigned subbatches in the data capture menu
		//$subBatches = $this->subBatches->paginate($perPage, Input::get('search'), $this->theUser->id, 'Assigned');
		$subBatches = $this->subBatches->paginate($perPage, Input::get('search'), $this->theUser->id);
		return view('subBatch.datacapturelist', compact('subBatches'));
	}
	
	
	/**
	 * Displays form for creating a new batch.
	 *
	 * @param CountryRepository $countryRepository
	 * @param RoleRepository $roleRepository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
/*	public function create(Company $company, CompanyRepository $companyRepository,CountryRepository $countryRepository)
	{
		// Get the first or last saved company record from the sub batch.
		$perPage = 2;
		$countries = $countryRepository->lists();
		$countries1=$countryRepository->lists1();// remove this and add staffs
		$edit=false;
		return view('Company.company-data', compact('countries','countries1', 'edit'));
	}*/
	/**
	 * Performs the company save action clicked on Save button click
	 * 
	 * @param Company $company
	 * @param UpdateCompanyRequest $request
	 * @return on the same screen with success message.
	 */
	public function storeCompany(Company $company, UpdateCompanyRequest $request) 
	{
		return $request->all();
		$this->companyRepository->update($company->id, $request->all());
		return redirect()->route('dataCapture.capture', $company->sub_batch_id)->withSuccess(trans('app.company_updated'));
	}
	
	/**
	 * Adds new contact record in the database against the company.
	 * 
	 * @param Company $company
	 * @param CreateContactRequest $request
	 * @return on the same screen with newly added contact on the screen being the first record
	 */
	public function storeStaff(Company $company, CreateContactRequest $request) 
	{
		$data = $request->all() + ['company_id' => $company->id]
		+ ['user_id' => $this->theUser->id];
		$contact = $this->contactRepository->create($data);
		return redirect()->route('dataCapture.capture', $company->sub_batch_id)->withSuccess(trans('app.contact_created'));
	}
	
	/**
	 * Starts data capture process starting from the first or last saved record.
	 * 
	 * @param unknown $subBatchId
	 * @param Company $company
	 * @param CompanyRepository $companyRepository
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|unknown
	 */
	public function capture($subBatchId, Company $company, CompanyRepository $companyRepository,CountryRepository $countryRepository)
	{
		// Get the first or last saved company record from the sub batch.
		$edit = true;
		$perPage = 2;
		$countries = $countryRepository->lists();
		$countries1=$countryRepository->lists1();
		//$employees=$employeeRepository->lists();
		//return $employees;
		$companies = $companyRepository->getCompanyRecord($subBatchId, $this->theUser->id);
		if (sizeof($companies) > 0) {
			// open the company-staff capture screen for this company
			$company = $companies[0];
			$contacts = $this->contactRepository->paginate($perPage, Input::get('search'), $company->id); // remove this and add staffs
			return view('Company.company-data', compact('countries','countries1','subBatchId', 'edit', 'company', 'contacts'));
		} else {
			// All the company records are submitted in this sub batch.
			// Set the status of sub-batch to Submitted and redirect to sub-batch list
			$subBatch=SubBatch::find($subBatchId);
			$subBatch->status="Submitted";
			$subBatch->save();
			return redirect()->route('dataCapture.list')->withSuccess(trans('app.batch_submitted'));
		}
	}
	
	/**
	 * Sets the status to Sumitted for the current company.
	 * @param Company $company
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function submitCompany(Company $company,CompanyRepository $companyRepository) 
	{
		$comp=Company::find($company->id);
		$comp->status="Submitted";
		$comp->save();
		if($companyRepository->getTotalCompanyCount($comp->batch_id)==$companyRepository->getSubmittedCompanyCount($comp->batch_id))
		{
			$batch=batch::find($comp->batch_id);
			$batch->status=SubBatchStatus::COMPLETE;
			$batch->update();
		}
		return redirect()->route('dataCapture.capture', $company->sub_batch_id);
	}	
	
	
	/////////////
	
	public function updateStaff(Contact $contact, UpdateContactRequestest $request) 
	{
		$data = $request->all();
		$data = $request->all() + ['company_id' => $company->id]
		+ ['user_id' => $this->theUser->id];
		$contact = $this->contactRepository->update($contact->id,$data);
		return redirect()->route('dataCapture.capture', $company->sub_batch_id)->withSuccess(trans('app.contact_created'));
	}
	
	
	public function getcountryCode(Request $request, CountryRepository $countryRepository)
	{
		$countryid = $request->input('batchId');
		return $countryid;
	}
}