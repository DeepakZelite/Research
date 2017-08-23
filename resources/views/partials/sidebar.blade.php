<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-avatar">
                <div class="dropdown">
                    <div>
                        <img alt="image" class="img-circle" width="100" src="{{ Auth::user()->present()->avatar }}">
                    </div>
                    <div class="name"><strong>{{ Auth::user()->present()->nameOrEmail }}</strong></div>
                </div>
            </li>
            @if(Auth::user()->present()->vendor_id == "0")
            <li class="{{ Request::is('/') ? 'active open' : ''  }}">
                <a href="{{ route('dashboard') }}" class="{{ Request::is('/') ? 'active' : ''  }}">
                    <i class="fa fa-dashboard fa-fw"></i> @lang('app.dashboard')
                </a>
            </li>
            @endif

            @permission('users.manage')
                <li class="{{ Request::is('user*') || Request::is('vendor*') ? 'active open' : ''  }}">
                    <a href="#">
                        <i class="fa fa-user fa-fw"></i>
                        @lang('app.user_management')
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                             <li>
                                <a href="{{ route('vendor.list') }}" class="{{ Request::is('vendor*') ? 'active' : ''  }}">
                                    @lang('app.manage_vendor')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.list') }}" class="{{ Request::is('user*') ? 'active' : ''  }}">
                                    @lang('app.manage_user')
                                </a>
                            </li>
                              
                    </ul>
                </li>
            @endpermission


            @permission('projects.manage')
                <li class="{{ Request::is('project*') ? 'active open' : ''  }}">
                    <a href="{{ route('project.list') }}" class="{{ Request::is('project*') ? 'active' : ''  }}">
                        <i class="fa fa-users fa-fw"></i> @lang('app.projects')
                    </a>
                </li>
            @endpermission

            @permission('batches.manage')
                <li class="{{ Request::is('batch*') ? 'active open' : ''  }}">
                    <a href="{{ route('batch.list') }}" class="{{ Request::is('batch*') ? 'active' : ''  }}">
                        <i class="fa fa-slideshare fa-fw"></i> @lang('app.batches')
                    </a>
                </li>
            @endpermission

            @permission('companys.manage')
                <li class="{{ Request::is('dataCapture*') ? 'active open' : ''  }}">
                    <a href="{{ route('dataCapture.list') }}" class="{{ Request::is('dataCapture*') ? 'active' : ''  }}">
                        <i class="fa fa-desktop fa-fw"></i> @lang('app.dataCapture')
                    </a>
                </li>
            @endpermission

            @permission('batch.allocation')
                <li class="{{ Request::is('subBatch*') ? 'active open' : ''  }}">
                    <a href="{{ route('subBatch.list') }}" class="{{ Request::is('subBatch*') ? 'active' : ''  }}">
                        <i class="fa fa-tasks fa-fw"></i> @lang('app.subBatches')
                    </a><!-- fa-list-ul fa-1x -->
                </li>
            @endpermission

			@permission('quality.manage')
                <li class="{{ Request::is('quality*') ? 'active open' : ''  }}">
                    <a href="{{ route('quality.list') }}" class="{{ Request::is('quality*') ? 'active' : ''  }}">
                        <i class="fa-list-ul fa-1x"></i> @lang('app.qc_data')
                     </a>
                </li>
            @endpermission
            
            @permission('batch.reallocation')
            	<li class="{{ Request::is('reallocation*') ? 'active open' : '' }}">
                	<a href="{{ route('reallocation') }}" class="{{ Request::is('reallocation*') ? 'active' : '' }}">
                		<i class="fa fa-refresh fa-1x"></i> @lang('app.reallocation')
                	</a>
                </li>
            @endpermission
            
            @permission('reports.manage')
                <li class="{{ Request::is('productivity*') || Request::is('report*') ? 'active open' : ''  }}">
                    <a href="#">
                        <i class="fa fa-flag-checkered fa-fw"></i>
                        @lang('app.reports')
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                             <li>
                                <a href="{{ route('report.list') }}" class="{{ Request::is('report*') ? 'active' : ''  }}">
                                    @lang('app.project_status_report')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('productivity')}}" class="{{ Request::is('productivity*') ? 'active' : ''  }}">
                                    @lang('app.productivity_report')
                                </a>
                            </li>
                    </ul>
                </li>
            @endpermission

            @permission('reports.user')
                  <li class="{{ Request::is('report*') ? 'active open' : ''  }}">
                       <a href="{{ route('report.myProductivity') }}" class="{{ Request::is('report*') ? 'active' : ''  }}">
                           <i class="fa fa-flag-checkered fa-fw"></i>@lang('app.report')
                       </a>
                  </li>
            @endpermission
        </ul>
    </div>
    
                      
    
    
    <!-- /.sidebar-collapse -->
</div>