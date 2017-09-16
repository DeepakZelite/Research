<div class="panel panel-default">
    <div class="panel-heading">@lang('app.user_details')</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="first_name">@lang('app.role')<i style="color:red;">*</i></label>
                    @if($edit)
                    	{!! Form::select('role', $roles, $edit ? $user->roles->first()->id : '',
                        	['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'role', $profile ? 'disabled' : '']) !!}
                    @else
                    	  {!! Form::select('role', $roles, $edit ? $user->roles->first()->id : '',
                        	['class' => 'form-control', 'id' => 'role', $profile ? 'disabled' : '']) !!}
                    @endif 
                </div>
                <div class="form-group">
                    <label for="vendor_id">@lang('app.select_vendor')<i style="color:red;">*</i></label>
                    @if($edit)
                    	{!! Form::select('vendor_id', $vendors, $edit ? $user->vendor_id : '',
                        	['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'vendor_id',$profile ? 'disabled' : '']) !!}
                    @else
                    	{!! Form::select('vendor_id', $vendors, $edit ? $user->vendor_id : '',
                        	['class' => 'form-control', 'id' => 'vendor_id',$profile ? 'disabled' : '']) !!}
                    @endif
                </div>
                <div class="form-group">
                    <label for="first_name">@lang('app.first_name')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="first_name"
                           name="first_name" placeholder="@lang('app.first_name')" value="{{ $edit ? $user->first_name : '' }}">
                </div>
                <div class="form-group">
                    <label for="last_name">@lang('app.last_name')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="last_name"
                           name="last_name" placeholder="@lang('app.last_name')" value="{{ $edit ? $user->last_name : '' }}">
                </div>
                <div class="form-group">
                    <label for="status">@lang('app.status')<i style="color:red;">*</i></label>
                    @if($edit)
                    	{!! Form::select('status', $statuses, $edit ? $user->status : '',
                        	['class' => 'form-control', 'id' => 'status', $profile ? 'disabled' : '']) !!}
                    @else
                    	{!! Form::select('status', $statuses, $edit ? $user->status : '',
                        	['class' => 'form-control','disabled' => 'disabled', 'id' => 'status', $profile ? 'disabled' : '']) !!}
                    @endif                    	
                </div>
            </div>
<!-- 
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthday">@lang('app.date_of_birth')</label>
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type='text' name="birthday" id='birthday' value="{{ $edit ? $user->birthday : '' }}" class="form-control" />
                            <span class="input-group-addon" style="cursor: default;">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">@lang('app.phone')</label>
                    <input type="text" class="form-control" id="phone"
                           name="phone" placeholder="@lang('app.phone')" value="{{ $edit ? $user->phone : '' }}">
                </div>
                <div class="form-group">
                    <label for="address">@lang('app.address')</label>
                    <input type="text" class="form-control" id="address"
                           name="address" placeholder="@lang('app.address')" value="{{ $edit ? $user->address : '' }}">
                </div>
                <div class="form-group">
                    <label for="address">@lang('app.country')</label>
                    {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control']) !!}
                </div>
            </div>
 -->
            @if ($edit)
            	<div class="col-xs-4 col-sm-4 col-md-8 col-lg-8"></div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-primary" id="update-details-btn">
                        <i class="fa fa-refresh"></i>
                        @lang('app.update_details')
                    </button>
                </div>
                @if($profile)
                	<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        				<a href="{{ route('dashboard') }}" class="btn btn-primary" id="cancel">
            				@lang('app.cancel')
        				</a>
    				</div>
                @else
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        			<a href="{{ route('user.list') }}" class="btn btn-primary" id="cancel">
            			@lang('app.cancel')
        			</a>
    			</div>
    			@endif
            @endif
        </div>
    </div>
</div>