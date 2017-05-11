<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{URL::route('admin-home')}}"><i class="fa fa-home fa-fw"></i> Admin Home</a>
            </li>
            <li>
                <a href="{{URL::route('manage-faq')}}"><i class="fa fa-question-circle fa-fw"></i> Manage FAQ</a>
            </li>
            <li>
                <a href="{{URL::route('admin-email')}}"><i class="fa fa-envelope fa-fw"></i> Emails</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/users/pool"><i class="fa fa-group fa-fw"></i> Member Verification</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/users/unapproved/member"><i class="fa fa-group fa-fw"></i> Verification Approval(s)</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/testimonial"><i class="fa fa-video-camera fa-fw"></i> Testimonial Approval(s)</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/image-gallery"><i class="fa fa-image fa-fw x"></i> Gallery</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/users/pool"><i class="fa fa-group fa-fw"></i> Pool List</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/users/member"><i class="fa fa-group fa-fw"></i> Member List</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/users/non-member"><i class="fa fa-group fa-fw"></i> Non-Member List</a>
            </li>
            <li>
                <a>
                    <i class="fa fa-university"></i>
                    <span>Region Bank</span>
                </a>
                <ul class="nav nav-children">
                    <li>
                        <a href="{{URL::to('/')}}/admin/ph">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> PH</a>
                    </li>
                    <li>
                        <a href="{{URL::to('/')}}/admin/gh">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> GH</a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-university"></i>
                    <span>Micro Bank</span>
                </a>
                <ul class="nav nav-children">
                    <li>
                        <a href="{{URL::to('/')}}/admin/micro-ph">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> Micro PH</a>
                    </li>
                    <li>
                        <a href="{{URL::to('/')}}/admin/micro-gh">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> Micro GH</a>
                    </li>
                </ul>
            </li>
            <li>
            <a>
            	<i class="fa fa-university"></i>
                <span>AGB</span> 
            </a>
            <ul class="nav nav-children">
            <li>
                <a href="{{URL::to('/')}}/admin/pagb-stats">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> PAGB-STATS</a>
            </li>
            <li>
                <a href="{{URL::to('/')}}/admin/user-stats">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> USER STATS</a>
            </li>
            </ul>
            </li>
            
            <li>
                    <a href="{{URL::route('admin-leadership-reqts')}}">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> Leadership Requests  <span class="badge badge-danger">{{App\Model\LeadershipRequests::where(['status'=>0])->count()}}</span>
                    </a>
             </li>
            
            <li>
                <a href="{{URL::route('manage-news')}}"><i class="fa fa-bullhorn fa-fw"></i> Announcement</a>
            </li>
            @include('helpticket.menu-helpticket-admin')
            
            <li>
            <a>
            	<i class="fa fa-university"></i>
                <span>System</span>
            </a>
            <ul class="nav nav-children">
            <li>
                <a href="{{URL::route('admin-system-language')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> Language</a>
            </li>
            <li>
                <a href="{{URL::route('admin-language-translation-requests')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i> Translation Requests</a>
            </li>
            <li>
                <a href="{{URL::route('admin-manage-dispute-users')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i> Dispute</a>
            </li>
            <li>
                <a href="{{URL::route('admin-manage-videos')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i> Manage Videos</a>
            </li>
            </ul>
            </li>
            <li>
                <a href="{{URL::route('cron')}}"><i class="fa fa-gears"></i> Cron Log</a>
            </li>
            <li>
                <a href="{{URL::route('settings')}}"><i class="fa fa-gear"></i> Settings</a>
            </li>
        </ul>
    </div>
</div>