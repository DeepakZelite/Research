@include('partials.messages')


@if ($editContact) 
	{!! Form::open(['route' => ['dataCapture.updateStaff', $contact->id], 'id' => 'staff-form']) !!}
@else
	{!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'method' => 'PUT', 'id' => 'staff-form']) !!}
@endif

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">@lang('app.staff_details_big')
								<div class="pull-right" style="margin-top: -7px; margin-right: 1px;">
									<button type="button" class="btn btn-default" data-toggle="modal"
											data-target="#duplicateModel" id="btn_duplicate"
											onclick="getduplicateRecord();" data-dismiss="modal">
											<span class="glyphicon glyphicon-search"></span> @lang('app.duplicate_check')
									</button> 
								</div>
							</div>
							
							<div class="panel-body">

								<div class="container">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="pill" href="#staff_info">@lang('app.staff_info')</a></li>
										<li><a data-toggle="pill" href="#additional_info">@lang('app.additional-info')</a></li>
									</ul>

									<div class="tab-content">
										<div id="staff_info" class="tab-pane fade in active">
										<div class="form-group col-lg-4">										
												<div class="row">
													<div class="col-lg-3">
													<label for="salutation">@lang('app.salutation')</label>
													{!!Form::select('salutation', $data, $editContact ? $contact->salutation : old('salutation'), ['class'=>'form-control','id'=>'salutation']) !!}
													</div>
													<div class="col-lg-9">
														<label for="firstName">@lang('app.first_name')<i style="color: red;">*</i></label>
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
												<label for="staff_source">@lang('app.staff_source')<i style="color: red;">*</i></label>
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
												<input type="text" class="form-control" id="direct_phoneno" name="direct_phoneno" maxlength="255"
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
												{!!Form::select('staff_disposition', $disposition, $editContact ? $contact->staff_disposition : old('staff_disposition'), ['class'=>'form-control','id'=>'staff_disposition']) !!}
											</div>
										</div>
										<div id="additional_info" class="tab-pane fade">
											<div class="form-group col-lg-4">
												<label for="deparment_number">@lang('app.deparment_number')</label>
												<input type="text" class="form-control" maxlength="255" id="deparment_number" name="deparment_number"
													placeholder="@lang('app.deparment_number')" value="{{ $editContact ? $contact->deparment_number : old('deparment_number') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="alternate_phone">@lang('app.alternate_phone')</label>
												<input type="text" class="form-control" id="alternate_phone" name="alternate_phone"
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
												<input type="text" class="form-control" id="working_tenure" name="working_tenure"
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
													class="form-control" id="age" name="age" maxlength="255"
													placeholder="@lang('app.age')" value="{{ $editContact ? $contact->age : old('age') }}">

											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info1">@lang('app.contact_info1')</label>
												<input type="text" class="form-control"	id="additional_info1" name="additional_info1"
													placeholder="@lang('app.contact_info1')" value="{{ $editContact ? $contact->additional_info1 : old('additional_info1') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info2">@lang('app.contact_info2')</label>
												<input type="text" class="form-control" id="additional_info2" name="additional_info2"
													placeholder="@lang('app.contact_info2')" value="{{ $editContact ? $contact->additional_info2 : old('additional_info2') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info3">@lang('app.contact_info3')</label>
												<input type="text" class="form-control"	id="additional_info3" name="additional_info3"
													placeholder="@lang('app.contact_info3')" value="{{ $editContact ? $contact->additional_info3 : old('additional_info3') }}">
											</div>
											<div class="form-group col-lg-4">
												<label for="additional_info4">@lang('app.contact_info4')</label>
												<input type="text" class="form-control"	id="additional_info4" name="additional_info4"
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
						<button type="submit" id="btnContactSave" class="btn btn-primary">
							<i class="fa fa-save"></i> {{ $editContact ? trans('app.save') :
							trans('app.save') }}
						</button>
					</div>
					<div class="col-md-1">
						<button type="button" id="btnCancel" class="btn btn-default" data-dismiss="modal">
							<i class=""></i> {{ $editContact ? trans('app.cancel') :
							trans('app.cancel') }}
						</button>
					</div>
				</div>
<script>
$('#first_name').focus();	
	$("#btnContactSave").click(function(event)
	{
		if ($('#first_name').val() == '') {
		    $('#first_name').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#first_name').css('border-color', 'green');
		}

		if ($('#job_title').val() == '') {
		    $('#job_title').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#job_title').css('border-color', 'green');
		}

		if ($('#staff_source').val() == '') {
		    $('#staff_source').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#staff_source').css('border-color', 'green');
		}
		
		var re = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		var is_url=$('#website').val();
		if(re.test(is_url))
		{
			$('#website').css('border-color', 'red');
		    return false
		}
		else
		{
			$('#website').css('border-color', 'green');
		}

		if($('#staff_email').val() != '')
		{
			var regix = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
			var email= $('#staff_email').val();
			if(!regix.test(email))
			{
				$('#staff_email').css('border-color', 'red');
			    return false
			}
			else
			{
				$('#staff_email').css('border-color', 'green');
			}
		}

		if($('#alternate_email').val() != '')
		{
			var email1 = $('#alternate_email').val();
			if(!regix.test(email1))
			{
				$('#alternate_email').css('border-color', 'red');
			    return false
			}
			else
			{
				$('#alternate_email').css('border-color', 'green');
			}
		}
		return true;
	});
			
	var mod;
	var numeric = $('#direct_phoneno,#deparment_number,#age').keydown(function(e){
	  mod = e.which; 
	  if(!((e.which >= 96 && e.which <= 105)||(e.which >= 48 && e.which <= 57)) && (e.which != 8 && e.which != 46 && e.which != 37 && e.which != 39 && e.which != 9 && e.which !=35 && e.which != 36) && (mod && (e.which == 67 || e.which != 86))){
	      e.preventDefault();
	  }
	});
		
</script>
{{ Form::close() }}

