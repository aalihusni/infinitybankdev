
<li class="nav-parent @yield('kb-class')">
            <a>
                <i class="fa fa-book" aria-hidden="true"></i>
                <span>Knowledge Base</span> 
            </a>
            <ul class="nav nav-children">
                
                
                <li>
    <a href="{{URL::route('Manage-Leader')}}"><i class="fa fa-group fa-fw"></i> Leaders</a>
</li>
                
                <li class="@yield('kb-manage-art-class')">
                    <a href="{{URL('/Admin/Manage/Article')}}">
                        <i class="fa fa-edit" aria-hidden="true"></i> Manage Articles
                    </a>
                </li>
                
                <li class="@yield('kb-manage-cat-class')">
                    <a href="{{URL('/Admin/Manage/Category')}}">
                        <i class="fa fa-edit" aria-hidden="true"></i> Manage Categories
                    </a>
                </li>
                
                <li class="@yield('assigned-ticke-class')">
                    <a href="{{URL::route('admin-tickets',['Open'])}}">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> Tickets 
                    </a>
                </li>
                
                
                
               
                
            </ul>
</li>

<!-- 
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

-->