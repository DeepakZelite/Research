<?php

namespace Vanguard\Http\Controllers;

use Vanguard\Http\Requests\Vendor\CreateVendorRequest;
use Vanguard\Http\Requests\Vendor\UpdateVendorRequest;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\Vendor\VendorRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\Vendor;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class VendorsController - Controls all the operations for vendor entity
 * @package Vanguard\Http\Controllers
 */
class VendorsController extends Controller
{
    /**
     * @var VendorRepository
     */
    private $vendors;

    /**
     * VendorsController constructor.
     * @param VendorRepository $users
     */
    public function __construct(VendorRepository $vendors)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->middleware('permission:vendors.manage');
        $this->vendors = $vendors;
    }

    /**
     * Display paginated list of all vendors.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $perPage = 2;
        $vendors = $this->vendors->paginate($perPage, Input::get('search'));
        $statuses = ['' => trans('app.all')] + UserStatus::lists(); // Check-Deepak
        return view('vendors.list', compact('vendors', 'statuses')); // Check-Deepak
    }

    /**
     * Displays form for creating a new vendor.
     *
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
    	$edit = false;
        return view('vendors.add-edit', compact('edit'));
    }

    /**
     * Stores new vendor into the database.
     *
     * @param CreateVendorRequest $request
     * @return mixed
     */
    public function store(CreateVendorRequest $request)
    {
        $data = $request->all();
        $vendor = $this->vendors->create($data);
        return redirect()->route('vendor.list')
            ->withSuccess(trans('app.vendor_created'));
               
    }

    /**
     * Displays edit vendor form.
     *
     * @param Vendor $vendor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Vendor $vendor)
    {
        $edit = true;
        return view('vendors.add-edit', compact('edit', 'vendor'));
    }

    /**
     * Update specified vendor with provided data.
     *
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update(Vendor $vendor, UpdateVendorRequest $request)
    {
    	$this->vendors->update($vendor->id, $request->all());
    	return redirect()->route('vendor.list')
    		->withSuccess(trans('app.vendor_updated'));
    }
  }