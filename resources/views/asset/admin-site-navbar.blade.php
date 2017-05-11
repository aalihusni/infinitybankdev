<div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu">
            <li class="site-menu-category">General</li>
            <li class="site-menu-item">
              <a class="animsition-link" href="{{URL::route('admin-home')}}">
                <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Dashboard</span>
              </a>
            </li>
            
            <li class="site-menu-item @yield('manage-faq-class')">
              <a href="{{URL::route('manage-faq')}}}">
                <i class="site-menu-icon md-apps" aria-hidden="true"></i>
                <span class="site-menu-title"> Manage FAQ</span>
              </a>
            </li>
            
            <li class="site-menu-item @yield('manage-email-class')">
              <a href="{{URL::route('admin-email')}}">
                <i class="site-menu-icon md-email" aria-hidden="true"></i>
                <span class="site-menu-title"> Emails</span>
              </a>
            </li>
            
            <li class="site-menu-item @yield('manage-pool-class')">
              <a href="{{URL::to('/')}}/admin/users/pool">
                <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
                <span class="site-menu-title"> Pool List</span>
              </a>
            </li>
            
            
            <li class="site-menu-item has-sub @yield('user-class')">
              <a href="javascript:void(0)">
                <i class="site-menu-icon md-accounts" aria-hidden="true"></i>
                <span class="site-menu-title">Member</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item @yield('nh-class')">
                  <a class="animsition-link" href="{{URL::to('/')}}/admin/users/member">
                  <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
                    <span class="site-menu-title">Active Member</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{URL::to('/')}}/admin/users/non-member">
                    <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
                    <span class="site-menu-title">Non Member</span>
                  </a>
                </li>
                
                <li class="site-menu-item @yield('disputes')">
                  <a href="{{URL::route('admin-manage-dispute-users')}}" class="animsition-link waves-effect waves-classic">
                    <i class="site-menu-icon fa fa-user" aria-hidden="true"></i>
                    <span class="site-menu-title"> Dispute </span>
                  </a>
                </li>
                
                
                
              </ul>
            </li>
            
            <li class="site-menu-item @yield('phgh-class')">
              <a href="">
                <i class="site-menu-icon md-flash" aria-hidden="true"></i>
                <span class="site-menu-title"> Region Bank</span>
              </a>
            </li>
            
             <li class="site-menu-item @yield('ph-class')">
              <a href="{{URL::to('/')}}/admin/ph">
                <i class="site-menu-icon md-flash" aria-hidden="true"></i>
                <span class="site-menu-title"> PH</span>
              </a>
            </li>
            
            <li class="site-menu-item @yield('gh-class')">
              <a href="{{URL::to('/')}}/admin/gh">
                <i class="site-menu-icon md-flash" aria-hidden="true"></i>
                <span class="site-menu-title"> GH</span>
              </a>
            </li>
            
            
            
            <li class="site-menu-item has-sub @yield('system-setting-class')">
              <a href="javascript:void(0)" class=" waves-effect waves-classic">
                <i aria-hidden="true" class="site-menu-icon md-border-all"></i>
                <span class="site-menu-title">System</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub" style="">
                
                <li class="site-menu-item @yield('setting-lang')">
                  <a href="{{URL::route('admin-system-language')}}" class="animsition-link waves-effect waves-classic">
                    <span class="site-menu-title">Language</span>
                  </a>
                </li>
                
                <li class="site-menu-item @yield('setting-lang-requests')">
                  <a href="{{URL::route('admin-language-translation-requests')}}" class="animsition-link waves-effect waves-classic">
                    <span class="site-menu-title">Translaton Requests</span>
                  </a>
                </li>
                
                <li class="site-menu-item @yield('leadership-requests')">
                  <a href="{{URL::route('admin-leadership-reqts')}}" class="animsition-link waves-effect waves-classic">
                    <span class="site-menu-title">Leadership Requests </span>
                    <span class="badge badge-danger">{{App\Model\LeadershipRequests::where(['status'=>0])->count()}}</span>
                  </a>
                </li>
                
                
                
              </ul>
            </li>
            
            
            
            
           
          </ul>
          
        </div>
      </div>
    </div>
    <div class="site-menubar-footer">
      <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
      data-original-title="Settings">
        <span class="icon md-settings" aria-hidden="true"></span>
      </a>
      <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
        <span class="icon md-eye-off" aria-hidden="true"></span>
      </a>
      <a href="{{url('/logout')}}" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
        <span class="icon md-power" aria-hidden="true"></span>
      </a>
    </div>
  </div>