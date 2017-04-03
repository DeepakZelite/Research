@include('partials.messages')

<div class="row">
	<!--First Section-->
	<div class="col-lg-12 col-md-8 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.add_child_company_details_big')</div>

			<div class="panel-body">
			{!! Form::open(['route' => ['dataCapture.addCompany', $company1->id], 'method' => 'PUT', 'id' => 'add-company-form']) !!} 
			<div class="row">
				 <div class="form-group col-lg-12">
					<label for="child_companies">@lang('app.child_companies')<i
						style="color: red;">*</i></label>
						{!! Form::select('company_name', $company,'', ['class' =>'form-control','id'=>'company_name1']) !!}
				</div> 
				<div class="form-group col-lg-12">
					<label for="new_company_name">@lang('app.company_name')<i
						style="color: red;">*</i></label> <input type="text"
						class="form-control" id="new_company_name" name="new_company_name"
						placeholder="@lang('app.company_name')"
						value="">
				</div>
				</div>
				<div class="row">
					<div class="col-md-8"></div>
					<div class="col-md-2">
						<button type="submit" id="btnsave" class="btn btn-primary">
							<i class="fa fa-save"></i> {{ trans('app.save') }}
						</button>
					</div>
					<div class="col-md-2">
						<button type="button" id="btncancel" class="btn btn-default" data-dismiss="modal">
							<i class=""></i> {{ trans('app.cancel') }}
						</button>
					</div>
				</div>
				
				{{ Form::close() }}
 				
			</div>
			</div>
		</div>
	
<script>
$("#company_name1").change(function () {
	var batchId = $( this ).val();
	alert(batchId);
	$.ajax({
        method: "GET",
        url: "http://localhost:88/Research/public/dataCapture/"+batchId+"/getSpecificChild",
        success: function(data){
            }
    })
});
	$('#new_company_name').focus();
	$("#btnsave").click(function(event)
	{
		if ($('#new_company_name').val() == '') {
		    $('#new_company_name').css('border-color', 'red');
		    //$('#first_name').focus();
		    return false;
		}
		else {
		    $('#new_company_name').css('border-color', 'green');
		}
		return true;
	});

	
</script>
	</div>