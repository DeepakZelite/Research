
@if ($editCompany) 
	{!! Form::open(['route' => ['dataCapture.updateCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!} 
@else 
	{!! Form::open(['route' => ['dataCapture.storeCompany', $company->id], 'id' => 'company-form']) !!} 
@endif
<div class="row">
	<!--First Section-->
	<div class="col-lg-12 col-md-8 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.company_details_big')</div>

			<div class="panel-body">
				<div class="form-group col-lg-2">
					<label for="company_name">@lang('app.company_name')<i
						style="color: red;">*</i></label> <input type="text"
						class="form-control" id="company_name" name="company_name"
						placeholder="@lang('app.company_name')" readonly="readonly"
						value="{{ $editCompany ? $company->company_name : old('company_name') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.child_company')</label> <input
						type="text" class="form-control" id="parent_company"
						name="parent_company" placeholder="@lang('app.child_company')"
						readonly="readonly"
						value="{{ $editCompany ? $company->parent_company : old('parent_company') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.company_instructions')</label> <input
						type="text" class="form-control" id="company_instructions"
						name="company_instructions"
						placeholder="@lang('app.company_instructions')"
						value="{{ $editCompany ? $company->company_instructions : old('company_instructions') }}">
				</div>

				<div class="form-group col-lg-2">
					<label for="address1">@lang('app.address1')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="address1"
						name="address1" placeholder="@lang('app.address1')"
						value="{{ $editCompany ? $company->address1 : old('address1') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.address2')</label> <input type="text"
						class="form-control" id="address2" name="address2"
						placeholder="@lang('app.address2')"
						value="{{ $editCompany ? $company->address2 : old('address2') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="city">@lang('app.city')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="city" name="city"
						placeholder="@lang('app.city')"
						value="{{ $editCompany ? $company->city : old('city') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="state">@lang('app.state')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="state" name="state"
						placeholder="@lang('app.state')"
						value="{{ $editCompany ? $company->state : old('state') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="zipcode">@lang('app.zipcode')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="zipcode" name="zipcode"
						placeholder="@lang('app.zipcode')"
						value="{{ $editCompany ? $company->zipcode : old('zipcode') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="address">@lang('app.country')<i style="color: red;">*</i></label>
					{!! Form::select('country', $countries,'', ['class' =>
					'form-control','id'=>'country']) !!}
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.switchboardnumber')</label>
					<div class="row">
						<div class="col-md-5">{!! Form::select('international_code',
							$countriesISDCodes,'', ['class' =>
							'form-control','calling_code'=>'international_code']) !!}</div>
						<div class="col-md-7">
							<input type="text" class="form-control" id="switchboardnumber"
								name="switchboardnumber"
								placeholder="@lang('app.switchboardnumber')"
								value="{{ $editCompany ? $company->switchboardnumber : old('switchboardnumber') }}">
						</div>
					</div>
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.website')</label> <input type="text"
						class="form-control" id="website" name="website"
						placeholder="@lang('app.website')"
						value="{{ $editCompany ? $company->website : old('website') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.company_email')</label> <input
						type="text" class="form-control" id="company_email"
						name="company_email" placeholder="@lang('app.company_email')"
						value="{{ $editCompany ? $company->company_email : old('company_email') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="branchNumber">@lang('app.branchNumber')</label> <input
						type="text" class="form-control" id="branchNumber"
						name="branchNumber" placeholder="@lang('app.branchNumber')"
						value="{{ $editCompany ? $company->branchNumber : old('branchNumber') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="addresscode">@lang('app.addresscode')</label> <input
						type="text" class="form-control" id="addresscode"
						name="addresscode" placeholder="@lang('app.addresscode')"
						value="{{ $editCompany ? $company->addresscode : old('addresscode') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="employee_size">@lang('app.employee_size')</label> <input
						type="text" class="form-control" id="employee_size"
						name="employee_size" placeholder="@lang('app.employee_size')"
						value="{{ $editCompany ? $company->employee_size : old('employee_size') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="industry_classfication">@lang('app.industry_classfication')</label>
					<input type="text" class="form-control" id="industry_classfication"
						name="industry_classfication"
						placeholder="@lang('app.industry_classfication')"
						value="{{ $editCompany ? $company->industry_classfication : old('industry_classfication') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="physician_size">@lang('app.physician_size')</label> <input
						type="text" class="form-control" id="physician_size"
						name="physician_size" placeholder="@lang('app.physician_size')"
						value="{{ $editCompany ? $company->physician_size : old('physician_size') }}">
				</div>
				<!--                 <div class="form-group col-lg-2"> -->
				<!--                     <label for="name">@lang('app.website')</label> -->
				<!--                     <input type="text" class="form-control" id="website" -->
				<!--                            name="website" placeholder="@lang('app.website')" value="{{ $editCompany ? $company->website : old('name') }}"> -->
				<!--                 </div> -->
				<!--                 <div class="form-group col-lg-2"> -->
				<!--                     <label for="name">@lang('app.website')</label> -->
				<!--                     <input type="text" class="form-control" id="website" -->
				<!--                            name="website" placeholder="@lang('app.website')" value="{{ $editCompany ? $company->website : old('name') }}"> -->
				<!--                 </div> -->

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-9"></div>
	<div class="col-md-2">
		<button type="button" class="btn btn-primary" data-toggle="modal"
			data-target="#myModal1">
			<i class="glyphicon glyphicon-plus"></i> {{
			trans('app.additional-info') }}
		</button>
	</div>
	<div class="col-md-1">
		<button type="submit" class="btn btn-primary">
			<i class="fa fa-save"></i> {{ $editCompany ? trans('app.save') :
			trans('app.save') }}
		</button>
	</div>
</div>

{{ Form::close() }}