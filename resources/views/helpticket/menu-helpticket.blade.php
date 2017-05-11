<li class="nav-parent @yield('kb-class')">
            <a>
                <i class="fa fa-book" aria-hidden="true"></i>
                <span>{{trans('knowledge.menu_1')}}</span> 
            </a>
            <ul class="nav nav-children">
                <li class="@yield('kb-cats-class')">
                    <a href="{{URL::route('member-category-list')}}">
                       <i class="fa fa-list-ul" aria-hidden="true"></i> {{trans('knowledge.menu_2')}}
                    </a>
                </li>
                <li class="@yield('kb-art-class')">
                    <a href="{{URL::route('member-article-list')}}">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> {{trans('knowledge.menu_3')}}
                    </a>
                </li>
                @if(Auth::user()->leader_at != '0000-00-00 00:00:00')
                <li class="@yield('kb-manage-art-class')">
                    <a href="{{URL('/article')}}">
                        <i class="fa fa-edit" aria-hidden="true"></i> {{trans('knowledge.menu_4')}}
                    </a>
                </li>
                
                <li class="@yield('kb-manage-cat-class')">
                    <a href="{{URL('/category')}}">
                        <i class="fa fa-edit" aria-hidden="true"></i> {{trans('knowledge.menu_5')}}
                    </a>
                </li>
                
                <li class="@yield('assigned-ticke-class')">
                    <a href="{{URL::route('assigned.ticket',['Open'])}}">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> {{trans('knowledge.menu_6')}}
                    </a>
                </li>
                @endif
                
                
                <li class="@yield('ticket-create-class')">
                    <a href="{{URL::route('create-ticket')}}">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> {{trans('knowledge.menu_7')}}
                    </a>
                </li>
                
                <li class="@yield('my-ticke-class')">
                    <a href="{{URL::route('my-tickets')}}">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> {{trans('knowledge.menu_8')}}
                    </a>
                </li>
                
                
            </ul>
</li>