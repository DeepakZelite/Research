@include('partials.messages')

@if ($editContact) 
	{!! Form::open(['route' => ['dataCapture.updateStaff', $contact->id], 'id' => 'staff-form']) !!}
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
													<div class="col-lg-3">
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
													<div class="col-lg-9">
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
													value="{{ $editContact ? $contact->middle_name : old('middle_name') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="name">@lang('app.last_name')</label> <input
													type="text" class="form-control" id="last_name"
													name="last_name" placeholder="@lang('app.last_name')"
													value="{{ $editContact ? $contact->last_name : old('last_name') }}">
											</div>
											<div class="form-group col-lg-4 pull-left">
											<label for="job_title">@lang('app.job_title')<i
													style="color: red;">*</i></label>
											<input type="text" class="form-control" id="job_title" name="job_title"
													placeholder="@lang('app.job_title')" value="{{ $editContact ? $contact->job_title : old('job_title') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="specialization">@lang('app.specialization')</label>
												<input type="text" class="form-control" id="specialization" name="specialization"
													placeholder="@lang('app.specialization')" value="{{ $editContact ? $contact->specialization : old('specialization') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="staff_source">@lang('app.staff_source')</label>
												<input type="text" class="form-control" id="staff_source"
													name="staff_source" placeholder="@lang('app.staff_source')"
													value="{{ $editContact ? $contact->staff_source : old('staff_source') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="staff_emaile">@lang('app.staff_email')</label> <input
													type="text" class="form-control" id="staff_email"
													name="staff_email" placeholder="@lang('app.staff_email')"
													value="{{ $editContact ? $contact->staff_email : old('staff_email') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="direct_phoneno">@lang('app.direct_phoneno')</label>
												<input type="text" class="form-control" id="direct_phoneno"
													name="direct_phoneno" maxlength="10" onkeypress="return isNumberKey(event)"
													placeholder="@lang('app.direct_phoneno')" value="{{ $editContact ? $contact->direct_phoneno : old('direct_phoneno') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="qualification">@lang('app.qualification')</label>
												<input type="text" class="form-control" id="qualification"
													name="qualification"
													placeholder="@lang('app.qualification')" value="{{ $editContact ? $contact->qualification : old('qualification') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="email_source">@lang('app.email_source')</label>
												<input type="text" class="form-control" id="email_source"
													name="email_source" placeholder="@lang('app.email_source')"
													value="{{ $editContact ? $contact->email_source : old('email_source') }}">
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
												<input type="text" class="form-control" maxlength="10"
													id="deparment_number" name="deparment_number" onkeypress="return isNumberKey(event)"
													placeholder="@lang('app.deparment_number')" value="{{ $editContact ? $contact->deparment_number : old('deparment_number') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="alternate_phone">@lang('app.alternate_phone')</label>
												<input type="text" class="form-control" id="alternate_phone"
													name="alternate_phone" maxlength="10" onkeypress="return isNumberKey(event)"
													placeholder="@lang('app.alternate_phone')" value="{{ $editContact ? $contact->alternate_phone : old('alternate_phone') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="alternate_email">@lang('app.alternate_email')</label>
												<input type="text" class="form-control" id="alternate_email"
													name="alternate_email"
													placeholder="@lang('app.alternate_email')" value="{{ $editContact ? $contact->alternate_email : old('alternate_email') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="email_type">@lang('app.email_type')</label> <input
													type="text" class="form-control" id="email_type"
													name="email_type" placeholder="@lang('app.email_type')"
													value="{{ $editContact ? $contact->email_type : old('email_type') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="shift_timing">@lang('app.shift_timing')</label>
												<input type="text" class="form-control" id="shift_timing"
													name="shift_timing" placeholder="@lang('app.shift_timing')"
													value="{{ $editContact ? $contact->shift_timing : old('shift_timing') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="working_tenure">@lang('app.working_tenure')</label>
												<input type="text" class="form-control" id="working_tenure"
													name="working_tenure"
													placeholder="@lang('app.working_tenure')" value="{{ $editContact ? $contact->working_tenure : old('working_tenure') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="paternership">@lang('app.paternership')</label>
												<input type="text" class="form-control" id="paternership"
													name="paternership" placeholder="@lang('app.paternership')"
													value="{{ $editContact ? $contact->paternership : old('paternership') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="staff_remarks">@lang('app.staff_remarks')</label>
												<input type="text" class="form-control" id="staff_remarks" name="staff_remarks"
													placeholder="@lang('app.staff_remarks')" value="{{ $editContact ? $contact->staff_remarks : old('staff_remarks') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="age">@lang('app.age')</label> <input type="text"
													class="form-control" id="age" name="age" maxlength="2" onkeypress="return isNumberKey(event)"
													placeholder="@lang('app.age')" value="{{ $editContact ? $contact->age : old('age') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info1">@lang('app.contact_info1')</label>
												<input type="text" class="form-control"
													id="additional_info1" name="additional_info1"
													placeholder="@lang('app.contact_info1')" value="{{ $editContact ? $contact->additional_info1 : old('additional_info1') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info2">@lang('app.contact_info2')</label>
												<input type="text" class="form-control"
													id="additional_info2" name="additional_info2"
													placeholder="@lang('app.contact_info2')" value="{{ $editContact ? $contact->additional_info2 : old('additional_info2') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info3">@lang('app.contact_info3')</label>
												<input type="text" class="form-control"
													id="additional_info3" name="additional_info3"
													placeholder="@lang('app.contact_info3')" value="{{ $editContact ? $contact->additional_info3 : old('additional_info3') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info4">@lang('app.contact_info4')</label>
												<input type="text" class="form-control"
													id="additional_info4" name="additional_info4"
													placeholder="@lang('app.contact_info4')" value="{{ $editContact ? $contact->additional_info4 : old('additional_info4') }}">
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
							<i class="fa fa-save"></i> {{ $editContact ? trans('app.save') :
							trans('app.save') }}
						</button>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							<i class=""></i> {{ $editContact ? trans('app.cancel') :
							trans('app.cancel') }}
						</button>
					</div>
				</div>
<script>

	$('#first_name').focus();
	$("#staff-form").click(function(event)
	{
		if ($('#first_name').val() == '') {
		    $('#first_name').css('border-color', 'red');
		    //$('#first_name').focus();
		    return false;
		}
		else {
		    $('#first_name').css('border-color', 'green');
		}

		if ($('#job_title').val() == '') {
		    $('#job_title').css('border-color', 'red');
		    //$('#job_title').focus();
		    return false;
		}
		else {
		    $('#job_title').css('border-color', 'green');
		}
		return true;
	});
		$('#staff_email').on('input', function() 
		{
			var input=$(this);
			var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
			var is_email=re.test(input.val());
			if(is_email){$('#staff_email').css('border-color', 'green');}
			else
			{
				$('#staff_email').css('border-color', 'red');
			}
		});
		$('#alternate_email').on('input', function() 
		{
			var input=$(this);
			var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
			var is_email=re.test(input.val());
			if(is_email){$('#alternate_email').css('border-color', 'green');}
			else
			{
				$('#alternate_email').css('border-color', 'red');
			}
		});
</script>
{{ Form::close() }}

@section('scripts')
<script>
hideMenu();
function hideMenu() {
	as.toggleSidebar()
}
function isNumberKey(evt)
{
	alert("hiii");
  		var charCode = (evt.which) ? evt.which : event.keyCode
  		if (charCode > 31 && (charCode < 48 || charCode > 57))
    	return false;
  		return true;
}
</script>
@stop