
@include('partials.messages')

@if ($editContact) 
	{!! Form::open(['route' => ['dataCapture.updateStaff', $company->id], 'id' => 'staff-form']) !!}
@else 
	{!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'method' => 'PUT', 'id' => 'staff-form']) !!}  
@endif

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">@lang('app.staff_details_big')</div>
							<div class="panel-body">

								<div class="container">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="pill" href="#staff_info">@lang('app.staff_info')</a></li>
										<li><a data-toggle="pill" href="#additional_info">@lang('app.additional-info')</a></li>
									</ul>

									<div class="tab-content">
										<div id="staff_info" class="tab-pane fade in active">
											<div class="form-group col-lg-4">
												<label for="firstName">@lang('app.first_name')<i
													style="color: red;">*</i></label>
												<div class="row">
													<div class="col-md-3">
														<select class="form-control" id="salutation"
															name="salutation">
															<option value="Mr.">Mr.</option>
															<option value="Mrs.">Mrs.</option>
															<option value="Miss">Miss</option>
															<option value="Dr.">Dr.</option>
															<option value="Ms.">Ms.</option>
															<option value="Prof.">Prof.</option>
														</select>
													</div>
													<div class="col-md-9">
														<input type="text" class="form-control" id="first_name"
															name="first_name" placeholder="@lang('app.first_name')"
															value="{{ $editContact ? $contact->first_name : old('first_name') }}">
													</div>
												</div>
											</div>
											<div class="form-group col-lg-4">
												<label for="middleName">@lang('app.middle_name')</label> <input
													type="text" class="form-control" id="middle_name"
													name="middle_name" placeholder="@lang('app.middle_name')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="name">@lang('app.last_name')</label> <input
													type="text" class="form-control" id="last_name"
													name="last_name" placeholder="@lang('app.last_name')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="job_title">@lang('app.job_title')<i
													style="color: red;">*</i></label> <input type="text"
													class="form-control" id="job_title" name="job_title"
													placeholder="@lang('app.job_title')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="specialization">@lang('app.specialization')</label>
												<input type="text" class="form-control" id="specialization"
													name="specialization"
													placeholder="@lang('app.specialization')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="staff_source">@lang('app.staff_source')</label>
												<input type="text" class="form-control" id="staff_source"
													name="staff_source" placeholder="@lang('app.staff_source')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="staff_emaile">@lang('app.staff_email')</label> <input
													type="text" class="form-control" id="staff_email"
													name="staff_email" placeholder="@lang('app.staff_email')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="direct_phoneno">@lang('app.direct_phoneno')</label>
												<input type="text" class="form-control" id="direct_phoneno"
													name="direct_phoneno"
													placeholder="@lang('app.direct_phoneno')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="qualification">@lang('app.qualification')</label>
												<input type="text" class="form-control" id="qualification"
													name="qualification"
													placeholder="@lang('app.qualification')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="email_source">@lang('app.email_source')</label>
												<input type="text" class="form-control" id="email_source"
													name="email_source" placeholder="@lang('app.email_source')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="Staff_Disposition">@lang('app.staff_disposition')</label>
												<select class="form-control" id="staff_disposition"
													name="staff_disposition">
													<option value="Verified">Verified</option>
													<option value="Not Verified">Not Verified</option>
													<option value="Acquired">Acquired</option>
													<option value="Left and Gone Away">Left and Gone Away</option>
													<option value="Retired">Retired</option>
												</select>
											</div>
										</div>
										<div id="additional_info" class="tab-pane fade">
											<div class="form-group col-lg-4">
												<label for="deparment_number">@lang('app.deparment_number')</label>
												<input type="text" class="form-control"
													id="deparment_number" name="deparment_number"
													placeholder="@lang('app.deparment_number')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="alternate_phone">@lang('app.alternate_phone')</label>
												<input type="text" class="form-control" id="alternate_phone"
													name="alternate_phone"
													placeholder="@lang('app.alternate_phone')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="alternate_email">@lang('app.alternate_email')</label>
												<input type="text" class="form-control" id="alternate_email"
													name="alternate_email"
													placeholder="@lang('app.alternate_email')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="email_type">@lang('app.email_type')</label> <input
													type="text" class="form-control" id="email_type"
													name="email_type" placeholder="@lang('app.email_type')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="shift_timing">@lang('app.shift_timing')</label>
												<input type="text" class="form-control" id="shift_timing"
													name="shift_timing" placeholder="@lang('app.shift_timing')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="working_tenure">@lang('app.working_tenure')</label>
												<input type="text" class="form-control" id="working_tenure"
													name="working_tenure"
													placeholder="@lang('app.working_tenure')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="paternership">@lang('app.paternership')</label>
												<input type="text" class="form-control" id="paternership"
													name="paternership" placeholder="@lang('app.paternership')"
													value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="staff_remarks">@lang('app.staff_remarks')</label>
												<input type="text" class="form-control" id=staff_remarks
													"
                           name="staff_remarks"
													placeholder="@lang('app.staff_remarks')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="age">@lang('app.age')</label> <input type="text"
													class="form-control" id="age" name="age"
													placeholder="@lang('app.age')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info1">@lang('app.contact_info1')</label>
												<input type="text" class="form-control"
													id="additional_info1" name="additional_info1"
													placeholder="@lang('app.contact_info1')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info2">@lang('app.contact_info2')</label>
												<input type="text" class="form-control"
													id="additional_info2" name="additional_info2"
													placeholder="@lang('app.contact_info2')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info3">@lang('app.contact_info3')</label>
												<input type="text" class="form-control"
													id="additional_info3" name="additional_info3"
													placeholder="@lang('app.contact_info3')" value="">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info4">@lang('app.contact_info4')</label>
												<input type="text" class="form-control"
													id="additional_info4" name="additional_info4"
													placeholder="@lang('app.contact_info4')" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-9"></div>
					<div class="col-md-1">
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-save"></i> {{ $editCompany ? trans('app.save') :
							trans('app.save') }}
						</button>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							<i class=""></i> {{ $editCompany ? trans('app.cancel') :
							trans('app.cancel') }}
						</button>
					</div>
				</div>

{{ Form::close() }}

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Vendor\UpdateVendorRequest', '#vendor-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Vendor\CreateVendorRequest', '#vendor-form') !!}
    @endif
@stop