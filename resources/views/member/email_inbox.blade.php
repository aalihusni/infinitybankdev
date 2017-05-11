<div class="inner-body mailbox-folder">
            <!-- START: .mailbox-header -->
            <header class="mailbox-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mailbox-title text-weight-light m-none">
                            <a id="mailboxToggleSidebar" class="sidebar-toggle-btn trigger-toggle-sidebar">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line line-angle1"></span>
                                <span class="line line-angle2"></span>
                            </a>

                            {{trans('email.inbox')}}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="search">
                            <div class="input-group input-search">
                                <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
													<span class="input-group-btn">
														<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
													</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END: .mailbox-header -->

            <!-- START: .mailbox-actions -->
            <div class="mailbox-actions">
                <ul class="list-unstyled m-none pt-lg pb-lg">
                    <li class="ib mr-sm">
                        <div class="btn-group">
                            <a href="#" class="item-action fa fa-chevron-down dropdown-toggle" data-toggle="dropdown"></a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::route('emails') }}">{{trans('email.all')}}</a></li>
                                <li><a href="?status={{ Crypt::encrypt(1) }}">{{trans('email.read')}}</a></li>
                                <li><a href="?status={{ Crypt::encrypt(0) }}">{{trans('email.unread')}}</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="ib mr-sm">
                        @if(!empty($_GET['label']))
                            <a class="item-action fa fa-refresh" href="?label={{ $_GET['label'] }}" title="Reload"></a>
                        @elseif(!empty($_GET['status']))
                            <a class="item-action fa fa-refresh" href="?status={{ $_GET['status'] }}" title="Reload"></a>
                        @else
                            <a class="item-action fa fa-refresh" href="{{ URL::route('emails') }}" title="Reload"></a>
                        @endif
                    </li>
                    <li class="ib mr-sm">
                        <a class="item-action licon-envelope-open" href="#" title="Mark Read"></a>
                    </li>
                    <li class="ib mr-sm">
                        <a class="item-action licon-envelope" href="#" title="Mark Unread"></a>
                    </li>
                    <!--
                    <li class="ib">
                        <a class="item-action fa fa-times text-danger" href="#"></a>
                    </li>
                    -->
                </ul>
            </div>
            <!-- END: .mailbox-actions -->

            @if (!empty($email_labels))
                @if (count($email_labels))
                    @foreach($email_labels as $email_label)
                        {{--*/ $label = "label".$email_label->id /*--}}
                        {{--*/ $$label = $email_label->color  /*--}}
                    @endforeach
                @endif
            @endif

            <div id="mailbox-email-list" class="mailbox-email-list">
                <div class="nano">
                    <div class="nano-content">
                        <ul id="" class="list-unstyled">
                            @foreach ($emails as $email)
                            @if ($email->status)
                                {{--*/ $strong_start = "" /*--}}
                                {{--*/ $strong_end = "" /*--}}
                            @else
                                {{--*/ $strong_start = "<strong>" /*--}}
                                {{--*/ $strong_end = "</strong>" /*--}}
                            @endif
                            <li class="unread">
                                <a href="?view={{ Crypt::encrypt($email->id) }}">
                                    {{--*/ $label = "label".$email->label /*--}}
                                    <i class="mail-label" style="border-color: {{ $$label }}"></i>
                                    <div class="col-sender">
                                        <div class="checkbox-custom checkbox-text-primary ib">
                                            <input type="checkbox" id="mail1">
                                            <label for="mail1"></label>
                                        </div>
                                        <p class="m-none ib">{!! $strong_start !!}BitRegion{!! $strong_end !!}</p>
                                    </div>
                                    <div class="col-mail">
                                        <p class="m-none mail-content">
                                            <span class="subject">{!! $strong_start !!}{{ $email->subject }}{!! $strong_end !!}</span>
                                        </p>
                                            <p class="m-none mail-date">11:35 am</p>
                                    </div>
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
    </div>