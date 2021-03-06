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
            <li class="{{ Request::is('/') ? 'active open' : ''  }}">
                <a href="{{ route('dashboard') }}" class="{{ Request::is('/') ? 'active' : ''  }}">
                    <i class="fa fa-dashboard fa-fw"></i> @lang('app.dashboard')
                </a>
            </li>
            
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
			<!-- 
            @permission('users.activity')
                <li class="{{ Request::is('activity*') ? 'active open' : ''  }}">
                    <a href="{{ route('activity.index') }}" class="{{ Request::is('activity*') ? 'active' : ''  }}">
                        <i class="fa fa-list-alt fa-fw"></i> @lang('app.activity_log')
                    </a>
                </li>
            @endpermission
 			-->
       <!-- @permission(['roles.manage', 'permissions.manage'])
                 <li class="{{ Request::is('role*') || Request::is('permission*') ? 'active open' : ''  }}">
                     <a href="#">
                         <i class="fa fa-user fa-fw"></i>
                        @lang('app.roles_and_permissions')
                         <span class="fa arrow"></span>
                     </a>
                     <ul class="nav nav-second-level collapse">
                         @permission('roles.manage')
                             <li>
                                <a href="{{ route('role.index') }}" class="{{ Request::is('role*') ? 'active' : ''  }}">
                                     @lang('app.roles')
                                 </a>
                             </li>
                         @endpermission
                           @permission('permissions.manage') 
                              <li> 
                                  <a href="{{ route('permission.index') }}" 
                                     class="{{ Request::is('permission*') ? 'active' : ''  }}">@lang('app.permissions')</a> 
                              </li> 
                          @endpermission 
                     </ul>
                 </li>
             @endpermission   -->
			<!-- 
            @permission(['settings.general', 'settings.auth', 'settings.notifications'])
            <li class="{{ Request::is('settings*') ? 'active open' : ''  }}">
                <a href="#">
                    <i class="fa fa-gear fa-fw"></i> @lang('app.settings')
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    @permission('settings.general')
                        <li>
                            <a href="{{ route('settings.general') }}"
                               class="{{ Request::is('settings') ? 'active' : ''  }}">
                                @lang('app.general')
                            </a>
                        </li>
                    @endpermission
                    @permission('settings.auth')
                        <li>
                            <a href="{{ route('settings.auth') }}"
                               class="{{ Request::is('settings/auth*') ? 'active' : ''  }}">
                                @lang('app.auth_and_registration')
                            </a>
                        </li>
                    @endpermission
                    @permission('settings.notifications')
                        <li>
                            <a href="{{ route('settings.notifications') }}"
                               class="{{ Request::is('settings/notifications*') ? 'active' : ''  }}">
                                @lang('app.notifications')
                            </a>
                        </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
             -->
             
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
            
            @permission('batch.allocation')
                <li class="{{ Request::is('subBatch*') ? 'active open' : ''  }}">
                    <a href="{{ route('subBatch.list') }}" class="{{ Request::is('subBatch*') ? 'active' : ''  }}">
                        <i class="fa fa-tasks fa-fw"></i> @lang('app.subBatches')
                    </a><!-- fa-list-ul fa-1x -->
                </li>
            @endpermission
           
            @permission('companys.manage')
                <li class="{{ Request::is('dataCapture*') ? 'active open' : ''  }}">
                    <a href="{{ route('dataCapture.list') }}" class="{{ Request::is('dataCapture*') ? 'active' : ''  }}">
                        <i class="fa fa-desktop fa-fw"></i> @lang('app.dataCapture')
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
                                <a href="{{ route('report.productivity')}}" class="{{ Request::is('productivity*') ? 'active' : ''  }}">
                                    @lang('app.productivity_report')
                                </a>
                            </li>
                    </ul>
                </li>
            @endpermission
            
            @permission('reports.user')
                <li>
                  <li class="{{ Request::is('myproductivityreport*') ? 'active open' : ''  }}">
                       <a href="{{ route('report.myProductivity') }}" class="{{ Request::is('myproductivityreport*') ? 'active' : ''  }}">
                           <i class="fa fa-flag-checkered fa-fw"></i>@lang('app.report')
                       </a>
                  </li>
            @endpermission
        </ul>
    </div>
    
                      
    
    
    <!-- /.sidebar-collapse -->
</div>