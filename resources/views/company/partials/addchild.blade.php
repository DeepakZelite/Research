@include('partials.messages')

<div class="row">
	<!--First Section-->
	<div class="col-lg-12 col-md-8 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.child_company_lists')</div>
			<div class="panel-body">
			<div class="row">
				 <div class="form-group col-lg-12">
				 <table>
						@if (count($company))
                			@foreach ($company as $companies)
                    <tr>
                        <td><a href="{{ route('dataCapture.getSpecificChild', $companies->id) }}">{{ $companies->company_name }}</a></td>
                     </tr>
                		@endforeach
            		@endif
            </table>
				</div> 
				</div>
				<div class="row">
					<div class="col-md-8"></div>
					<div class="col-md-2">
					<!-- 	<button type="submit" id="btnsave" class="btn btn-primary">
							 {{ trans('app.edit') }}
						</button>-->
					</div> 
					<div class="col-md-2">
						<button type="button" id="btncancel" class="btn btn-default" data-dismiss="modal">
							<i class=""></i> {{ trans('app.cancel') }}
						</button>
					</div>
				</div>
 				
			</div>
			</div>
		</div>
	</div>