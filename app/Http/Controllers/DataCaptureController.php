<?php

namespace Vanguard\Http\Controllers;


use Auth;
use Illuminate\Http\Request;
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
use Vanguard\Repositories\Project\ProjectRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\SubBatch;
use Vanguard\Batch;
use Vanguard\Http\Requests\Contact\UpdateContactRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Code\CodeRepository;
use Vanguard\Support\Enum\SubBatchStatus;
use Vanguard\Http\Requests\Company\CreateCompanyRequest;
use Vanguard\Country;
use Illuminate\Support\Facades\Log;

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
	public function subBatchList(BatchRepository $batchRepository, UserRepository $userRepository)
	{
		$perPage = 5;
		// Un-Comment to see only assigned subbatches in the data capture menu
		//$subBatches = $this->subBatches->paginate($perPage, Input::get('search'), $this->theUser->id, 'Assigned');
		$statuses = ['' => trans('app.all')] + SubBatchStatus::lists1();
		$subBatches = $this->subBatches->paginate($perPage, Input::get('search'), $this->theUser->id,Input::get('status'));
		return view('subBatch.datacapturelist', compact('subBatches','statuses'));
	}
	
	/**
	 * Performs the company save action clicked on Save button click
	 * 
	 * @param Company $company
	 * @param UpdateCompanyRequest $request
	 * @return on the same screen with success message.
	 */
	public function updateCompany(Company $company, UpdateCompanyRequest $request) 
	{
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
	public function capture($subBatchId, Company $company, CompanyRepository $companyRepository,CountryRepository $countryRepository,ProjectRepository $projectRepository,CodeRepository $codeRepository)
	{
		// Get the first or last saved company record from the sub batch.
		$editChild=false;
		$editCompany = true;
		$perPage = 2;
		$countries = $countryRepository->lists();
		$countriesISDCodes = $countryRepository->lists1();
		$codes=$codeRepository->lists();
		$codes->prepend('None');
		$codes1=$codeRepository->lists1();
		$codes1->prepend('None');
		$subBatch=SubBatch::find($subBatchId);
		$projects=$projectRepository->find($subBatch->project_id);
		$companies = $companyRepository->getCompanyRecord($subBatchId, $this->theUser->id);
		//return $companies;
		if (sizeof($companies) > 0) {
			// open the company-staff capture screen for this company
			$company = $companies[0];
			$editContact = false;
			//$childCompanies=$companyRepository->getChildCompanies($company->id);
			//if(sizeof($childCompanies)>0){$childRecord=true;}else{$childRecord=false;}
			$contacts = $this->contactRepository->paginate($perPage, Input::get('search'), $company->id);
			return view('Company.company-data', compact('countries','countriesISDCodes','codes','codes1','subBatchId','childRecord', 'editCompany', 'company', 'contacts', 'editContact','projects','editChild'));
		
		
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
		
		$subBatch=SubBatch::find($comp->sub_batch_id);
		$subBatch->status="In-Process";
		$subBatch->save();
		//return $companyRepository->getTotalCompanyCount($comp->batch_id).",".$companyRepository->getSubmittedCompanyCount($comp->batch_id);
		if($companyRepository->getTotalCompanyCount($comp->batch_id)==$companyRepository->getSubmittedCompanyCount($comp->batch_id))
		{
			$batch=batch::find($comp->batch_id);
			$batch->status=SubBatchStatus::COMPLETE;
			$batch->update();
		}
		return redirect()->route('dataCapture.capture', $company->sub_batch_id);
	}

  /**
	 * Set the Front end view to create a new child company.
	 */
	public function createChildCompany() 
	{
		$editCompany = false; 	
	}
	
	public function updateStaff(Contact $contact, UpdateContactRequest $request) 
	{
		$data = $request->all() + ['company_id' => $contact->company_id]
 		+ ['user_id' => $this->theUser->id];
 		$updatedContact = $this->contactRepository->update($contact->id,$data);
		$company = Company::find($contact->company_id);
		return redirect()->route('dataCapture.capture', $company->sub_batch_id)->withSuccess(trans('app.contact_created'));
	}
	
	
	public function getcountryCode(Country $countryId,CountryRepository $countryRepository)
	{
		$batchId =$countryId->id;
		Log::info("Contact:::::". $batchId);
		if ($batchId == "") {
			$batchId = 1;
		}
		return $countryRepository->getCountryISDCode($batchId);
	}
	
	public function getContact(Contact $contactId)
	{
		$contact=Contact::find($contactId->id);
		$editContact = true;
		//$editChild=false;
		//return $contact;
		return view('company.partials.contact-edit', compact('editContact', 'contact'));
	}
	
	public function createContact(Company $companyId)
	{
		$company=Company::find($companyId->id);
		$editContact = false;
		return view('company.partials.contact-edit', compact('editContact', 'company'));
	}
	
	public function addCompany(Company $companyId, CreateCompanyRequest $request)
	{
		$data =['parent_id' => $companyId->id] + 
		['user_id' => $this->theUser->id] + 
		['batch_id' => $companyId->batch_id] +
		['sub_batch_id' => $companyId->sub_batch_id] +
		['status' => 'Assigned'] +
		['company_name' => $request->new_company_name] + 
		['parent_company' => $companyId->company_name] +
		['company_instructions' => $companyId->company_instructions];
 		$newCompany = $this->companyRepository->create($data);
 		return redirect()->route('dataCapture.capture', $companyId->sub_batch_id)->withSuccess(trans('app.Added_Child_Company'));
	}
	
	
	public function childCompanyRecord(Company $companyId,CompanyRepository $companyRepository)
	{
		//$company1=Company::find($companyId->id);
		$company=$companyRepository->getChildCompanies($companyId->id);
		Log::info("Contact:::::". $company);
		$editCompany = false;
		return view('company.partials.addchild', compact('editCompany', 'company'));
	}
	
	public function getSpecificChild(Company $companyId,ContactRepository $contactRepository,CompanyRepository $companyRepository,CountryRepository $countryRepository,ProjectRepository $projectRepository,CodeRepository $codeRepository)
	{
		// Get the first or last saved company record from the sub batch.
		$editChild=true;
		$company=$companyId;
		$editCompany = true;
		$perPage = 2;
		$countries = $countryRepository->lists();
		$codes=$codeRepository->lists();
		$codes->prepend('None');
		$codes1=$codeRepository->lists1();
		$codes1->prepend('None');
		$subBatch=SubBatch::find($company->sub_batch_id);
		$projects=$projectRepository->find($subBatch->project_id);
		$editContact = false;
		$childCompanies=$companyRepository->getChildCompanies($company->id);
		if(sizeof($childCompanies)>0){$childRecord=true;}else{$childRecord=false;}
		$contacts = $this->contactRepository->paginate($perPage, Input::get('search'), $companyId->id);
		return view('Company.company-data', compact('countries','codes','codes1','subBatchId','childRecord', 'editCompany', 'company', 'contacts', 'editContact','projects','editChild'));
	}
	
	public function updateChildCompany(Company $company, UpdateCompanyRequest $request)
	{
		//return $request->all();
		//return $company->id;
		$this->companyRepository->update($company->id, $request->all());
		return redirect()->route('dataCapture.getSpecificChild', $company->id)->withSuccess(trans('app.company_updated'));
	}

	public function getChildren(Company $company)
	{
		$perPage = 5;
		//return $company->id;
		$children = $this->companyRepository->paginate($perPage, Input::get('search'), $company->id);
		//$editContact = true;
		
		return view('company.partials.company-list', compact('company' ,'children'));
	}
	
	public function currentCompany(Company $company)
	{
		$compRecord = Company::find($company->id);
		$compRecord->status="Assigned";
		//$compRecord->timestamps = false;
		$compRecord->save();
		return redirect()->route('dataCapture.capture', $compRecord->sub_batch_id);
	}
	
	public function cancelCompany(Company $company)
	{
		$compRecord = Company::find($company->id);
		$compRecord->status="Submitted";
		$compRecord->timestamps = false;
		$compRecord->save();
		return redirect()->route('dataCapture.capture', $compRecord->sub_batch_id);
	}
}