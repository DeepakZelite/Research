<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Http\Requests\Company\CreateCompanyRequest;
use Vanguard\Http\Requests\Company\UpdateCompanyRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Company\CompanyRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Company;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


/**
 * Class CompanysController - Controls all the operations for company entity
 * @package Vanguard\Http\Controllers
 */
class CompanysController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companys;

    /**
     * CompanysController constructor.
     * @param CompanyRepository $users
     */
    public function __construct(CompanyRepository $companys)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->middleware('permission:companys.manage');
        $this->companys = $companys;
    }

    /**
     * Display paginated list of all companys.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $perPage = 5;
        $companys = $this->companys->paginate($perPage, Input::get('search'), Input::get('status'));
        $statuses = ['' => trans('app.all')] + UserStatus::lists1();
        return view('company.list', compact('companys', 'statuses'));
    }

    /**
     * Displays form for creating a new company.
     *
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$statuses = UserStatus::lists1();
    	$edit = false;
        return view('company.add-edit', compact('edit','statuses'));
    }

    /**
     * Stores new company into the database.
     *
     * @param CreateCompanyRequest $request
     * @return mixed
     */
    public function store(CreateCompanyRequest $request)
    {
        $data = $request->all();
        $company = $this->companys->create($data);
        return redirect()->route('company.list')
           ->withSuccess(trans('app.company_created'));
               
    }

    /**
     * Displays edit company form.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Company $company)
    {
    	$statuses = UserStatus::lists1();
        $edit = true;
        return view('company.add-edit', compact('edit', 'company','statuses'));
    }

    /**
     * Update specified company with provided data.
     *
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update(Company $company, UpdateCompanyRequest $request)
    {
    	$this->companys->update($company->id, $request->all());
    	return redirect()->route('company.list')
    		->withSuccess(trans('app.company_updated'));
    }
  }