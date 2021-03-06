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
	 * @param BatchRepository $batchRepository
	 * @param UserRepository $userRepository
	 * @return the lists of assigned sub-batches to perticular user for capturing the data.
	 */
	public function subBatchList(BatchRepository $batchRepository, UserRepository $userRepository)
	{
		$perPage = 5;
		$statuses = ['' => trans('app.all')] + SubBatchStatus::lists1();
		$subBatches = $this->subBatches->paginate($perPage, Input::get('search'), $this->theUser->id,Input::get('status'));
		return view('subBatch.datacapturelist', compact('subBatches','statuses'));
	}
	
	/**
	 * Performs the company save action clicked on Save button click for updating the Company Records
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
	 * @param unknown $subBatchId
	 * @param Company $company
	 * @param CompanyRepository $companyRepository
	 * @param CountryRepository $countryRepository
	 * @param ProjectRepository $projectRepository
	 * @param CodeRepository $codeRepository
	 * @return on company-data screen if the record is in between first to secondlast reocrd otherwise return the list of datacapture. 
	 */
	public function capture($subBatchId, Company $company, CompanyRepository $companyRepository,CountryRepository $countryRepository,ProjectRepository $projectRepository,CodeRepository $codeRepository)
	{
		// Get the first to last saved company record from the sub batch.
		$editChild=false;
		$editCompany = true;
		$perPage = 2;
		$countries = $countryRepository->lists();
		$codes=$codeRepository->lists();
		$codes->prepend(trans('app.none'));
		$classication=$codeRepository->lists1();
		$classication->prepend(trans('app.none'));
		$subBatch=SubBatch::find($subBatchId);
		$projects=$projectRepository->find($subBatch->project_id);
		$companies = $companyRepository->getCompanyRecord($subBatchId, $this->theUser->id);
		if (sizeof($companies) > 0) {
			// open the company-staff capture screen for this company
			$company = $companies[0];
			$editContact = false;
			$contacts = $this->contactRepository->paginate($perPage, Input::get('search'), $company->id);
			return view('Company.company-data', compact('countries','codes','classication','subBatchId','childRecord', 'editCompany', 'company', 'contacts', 'editContact','projects','editChild'));
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
	 * Sets the status to Sumitted for the current company
	 * @param Company $company
	 * @param CompanyRepository $companyRepository
	 * @return the next company for capturing the data.
	 */
	public function submitCompany(Company $company,CompanyRepository $companyRepository) 
	{
		$comp=Company::find($company->id);
		$comp->status="Submitted";
		$comp->save();
		
		$subBatch=SubBatch::find($comp->sub_batch_id);
		$subBatch->status="In-Process";
		$subBatch->save();
		/* set the status of Completed for the batch if all company of that batches are submitted  */
		if($companyRepository->getTotalCompanyCount($comp->batch_id)==$companyRepository->getSubmittedCompanyCount($comp->batch_id))
		{
			$batch=batch::find($comp->batch_id);
			$batch->status=SubBatchStatus::COMPLETE;
			$batch->update();
		}
		return redirect()->route('dataCapture.capture', $company->sub_batch_id);
	}
	
	/**
	 * updating the perticular staff
	 * @param Contact $contact
	 * @param UpdateContactRequest $request
	 * @return on the same screen with success message.
	 */
	public function updateStaff(Contact $contact, UpdateContactRequest $request) 
	{
		$data = $request->all() + ['company_id' => $contact->company_id]
 		+ ['user_id' => $this->theUser->id];
 		$updatedContact = $this->contactRepository->update($contact->id,$data);
		$company = Company::find($contact->company_id);
		return redirect()->route('dataCapture.capture', $company->sub_batch_id)->withSuccess(trans('app.contact_created'));
	}

	/**
	 * for finding the ISD code by using company i.e. dependent of country changes the ISD code
	 * @param Request $request
	 * @param Country $countryId
	 * @param CountryRepository $countryRepository
	 * @return the ISD code For perticular Country
	 */
	public function getcountryCode(Country $country,CountryRepository $countryRepository)
	{
		$countryId =$country->id;
		if ($countryId == "") {
			$countryId = 1;
		}
		return $countryRepository->getCountryISDCode($countryId);
	}
	
	/**
	 * retriving the contact list dependent on company id.
	 * @param Contact $contactId
	 * @return the specific contact for editing the contact.
	 */
	public function getContact(Request $request,Contact $contactId)
	{
		$inputs = Input::all();
		$contactId = $inputs['contactId'];
		$contact=Contact::find($contactId);
		$editContact = true;
		return view('company.partials.contact-edit', compact('editContact', 'contact'));
	}
	
	/**
	 * creating the new contact, dependent on company id
	 * @param Company $companyId
	 * @return window for creating a new contact.
	 */
	public function createContact(Company $companyId)
	{
		$company=Company::find($companyId->id);
		$editContact = false;
		return view('company.partials.contact-edit', compact('editContact', 'company'));
	}
	
	/**
	 * for adding a child company of specfic cparent ompany
	 * @param Company $companyId
	 * @param CreateCompanyRequest $request
	 * @return datacapture scrren with child company.
	 */
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
	
	/**
	 * displaying all child companies of specific parent company for editing purpose.
	 * @param Company $company
	 * @return a list of all child companies.
	 */
	public function getChildren(Company $company)
	{
		$perPage = 5;
		$children = $this->companyRepository->paginate($perPage, Input::get('search'), $company->id);
		return view('company.partials.company-list', compact('company' ,'children'));
	}
	
	/**
	 * for reopening the specific child company for editing purpose
	 * @param Company $company
	 * @return datacapture scrren for editing.
	 */
	public function currentCompany(Company $company)
	{
		$compRecord = Company::find($company->id);
		$compRecord->status="Assigned";
		$compRecord->save();
		return redirect()->route('dataCapture.capture', $compRecord->sub_batch_id);
	}
	
	/**
	 * for checking the duplicate staff.
	 * @param Request $request
	 * @param ContactRepository $contactRepository
	 * @param Contact $contact
	 * @return the list if duplicate staff is avialable in database
	 */
	public function getduplicateRecord(Request $request,ContactRepository $contactRepository,Contact $contact)
	{
		$inputs = Input::all();
		$first	=$inputs['firstname'];
		$last 	=$inputs['lastname'];
		$jobtitle=$inputs['jobtitle'];
		$email	=$inputs['email'];
		$company_name=$inputs['company_name'];
		$website= $inputs['website'];
		$address= $inputs['address'];
		$city	= $inputs['city'];
		$state	= $inputs['state'];
		$zipcode= $inputs['zipcode'];
		$specility=$inputs['specility'];
		$phone	=$inputs['specility'];
		Log::info("Contact:::::". $first." ".$last." ".$jobtitle." ".$company_name." ".$website." ".$address." ".$city." ".$state." ".$zipcode." ".$specility." ".$phone);
		$perPage=5;
		$duplicate = $contactRepository->duplicate($first,$last,$jobtitle,$email,$company_name,$website,$address,$city,$state,$zipcode,$specility,$phone);
		//$duplicate = $this->companyRepository->paginate($perPage,null,null,$first);
		Log::info("Contact:::::". $duplicate);
		return view('company.partials.duplicate-list', compact('duplicate'));
	}
}