
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
						placeholder="@lang('app.zipcode')" maxlength="6" onkeypress="return isNumberKey(event)"
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
					<label for="employee_size">@lang('app.employee_size')</label> 
					{!! Form::select('code', $codes,'', ['class' =>'form-control','id'=>'code']) !!}
				<!-- 	<input type="text" class="form-control" id="employee_size" maxlength="5" onkeypress="return isNumberKey(event)"
						name="employee_size" placeholder="@lang('app.employee_size')"
						value="{{ $editCompany ? $company->employee_size : old('employee_size') }}"> -->
				</div>
				<div class="form-group col-lg-2">
					<label for="industry_classfication">@lang('app.industry_classfication')</label>
					{!! Form::select('code1', $codes1,'', ['class' =>'form-control','id'=>'code1']) !!}
				<!-- 	<input type="text" class="form-control" id="industry_classfication" name="industry_classfication"
						placeholder="@lang('app.industry_classfication')" value="{{ $editCompany ? $company->industry_classfication : old('industry_classfication') }}"> -->
				</div>
				<div class="form-group col-lg-2">
					<label for="physician_size">@lang('app.physician_size')</label> <input
						type="text" class="form-control" id="physician_size" maxlength="5" onkeypress="return isNumberKey(event)"
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

<!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<div id="myModal1" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
			@if ($editCompany) 
				{!! Form::open(['route' => ['dataCapture.updateCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!} 
			@else 
				{!! Form::open(['route' => ['dataCapture.storeCompany', $company->id], 'id' => 'company-form']) !!} 
			@endif
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">@lang('app.additional-info')</div>
							<div class="panel-body">
								<div class="form-group col-lg-6">
									<label for="company_remark">@lang('app.company_remark')</label>
									<input type="text" class="form-control" id="company_remark"
										name="company_remark"
										placeholder="@lang('app.company_remark')"
										value="{{ $editCompany ? $company->employee_size : old('company_remark') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="foundation_year">@lang('app.foundation_year')</label>
									<input type="text" class="form-control" id="foundation_year"
										name="foundation_year" maxlength="4" onkeypress="return isNumberKey(event)"
										placeholder="@lang('app.foundation_year')"
										value="{{ $editCompany ? $company->foundation_year : old('foundation_year') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info1">@lang('app.additional_info1')</label>
									<input type="text" class="form-control" id="additional_info1"
										name="additional_info1"
										placeholder="@lang('app.additional_info1')"
										value="{{ $editCompany ? $company->additional_info1 : old('additional_info1') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info2">@lang('app.additional_info2')</label>
									<input type="text" class="form-control" id="additional_info2"
										name="additional_info2"
										placeholder="@lang('app.additional_info2')"
										value="{{ $editCompany ? $company->additional_info2 : old('additional_info2') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info3">@lang('app.additional_info3')</label>
									<input type="text" class="form-control" id="additional_info3"
										name="additional_info3"
										placeholder="@lang('app.additional_info3')"
										value="{{ $editCompany ? $company->additional_info3 : old('additional_info3') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info4">@lang('app.additional_info4')</label>
									<input type="text" class="form-control" id="additional_info4"
										name="additional_info4"
										placeholder="@lang('app.additional_info4')"
										value="{{ $editCompany ? $company->additional_info4 : old('additional_info4') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="annual_revenue">@lang('app.annual_revenue')</label>
									<input type="text" class="form-control" id="annual_revenue"
										name="annual_revenue"  maxlength="10"
										placeholder="@lang('app.annual_revenue')"
										value="{{ $editCompany ? $company->annual_revenue : old('annual_revenue') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="products_services">@lang('app.products_services')</label>
									<input type="text" class="form-control" id="products_services"
										name="products_services"
										placeholder="@lang('app.products_services')"
										value="{{ $editCompany ? $company->products_services : old('products_services') }}">
								</div>

								<div class="form-group col-lg-6">
									<label for="number_of_beds">@lang('app.number_of_beds')</label>
									<input type="text" class="form-control" id="number_of_beds"
										name="number_of_beds" onkeypress="return isNumberKey(event)" maxlength="5"
										placeholder="@lang('app.number_of_beds')"
										value="{{ $editCompany ? $company->number_of_beds : old('number_of_beds') }}">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-7"></div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> {{ $editCompany ? trans('app.save') :
								trans('app.save') }}
							</button>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">
								<i class=""></i> {{ $editCompany ? trans('app.cancel') :
								trans('app.cancel') }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


{{ Form::close() }}

@section('scripts')

<script>

hideMenu();
function hideMenu() {
	as.toggleSidebar()
}

$('#myModal').on('shown.bs.modal', function() {
	  $('#firstName').focus();
	});
	
	$("#country").change(function() {
			 var batchId = $( this ).val();
             $.ajax({
                 method: "GET",
                 url: "http://localhost:88/Research/public/dataCapture/getcountryCode",
             })
	});
	$('#add_child_record').click(function(){
    $('#company_name').attr('readonly',false);
    $('#parent_company').attr('readonly',false);

	});

	function isNumberKey(evt)
	{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
	  	return false;
			return true;
	}
    </script>
@stop

@section('scripts') 
	hideMenu();
function hideMenu() {
	as.toggleSidebar()
}
@endsection