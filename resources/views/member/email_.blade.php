@extends('member.default')

@section('title'){{trans('email.email')}} @Stop

@section('content')

<script type="text/javascript">

    $( "html" ).addClass( "sidebar-left-collapsed" );

</script>
        <!-- start: page -->
<section class="content-with-menu mailbox">
    <div class="content-with-menu-container" data-mailbox data-mailbox-view="folder">
        <div class="inner-menu-toggle">
            <a href="#" class="inner-menu-expand" data-open="inner-menu">
                {{trans('email.show_menu')}} <i class="fa fa-chevron-right"></i>
            </a>
        </div>

        <menu id="content-menu" class="inner-menu" role="menu">
            <div class="nano">
                <div class="nano-content">

                    <div class="inner-menu-toggle-inside">
                        <a href="#" class="inner-menu-collapse">
                            <i class="fa fa-chevron-up visible-xs-inline"></i><i class="fa fa-chevron-left hidden-xs-inline"></i> {{trans('email.hide_menu')}}
                        </a>

                        <a href="#" class="inner-menu-expand" data-open="inner-menu">
                            {{trans('email.show_menu')}} <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>

                    <div class="inner-menu-content">

                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ URL::route('emails') }}" class="menu-item active">{{trans('email.inbox')}} <span class="label label-primary text-weight-normal pull-right">{{ $email_count }}</span></a>
                            </li>
                        </ul>

                        <hr class="separator" />

                        <div class="sidebar-widget m-none">
                            <div class="widget-header">
                                <h6 class="title">{{trans('email.label')}}</h6>
                                <span class="widget-toggle">+</span>
                            </div>
                            <div class="widget-content">
                                <ul class="list-unstyled mailbox-bullets">
                                    @if (!empty($email_labels))
                                    @if (count($email_labels))
                                    @foreach($email_labels as $email_label)
                                    <li>
                                        <a href="?label={{ Crypt::encrypt($email_label->id) }}" class="menu-item">{{ $email_label->label }} <span class="ball" style="border-color: {{ $email_label->color }}"></span></a>
                                    </li>
                                    @endforeach
                                    @endif
                                    @endif
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </menu>

            @if(!empty($_GET['view']))
                @include('member.email_view')
            @else
                @include('member.email_inbox')
            @endif


    </div>
</section>
<!-- end: page -->

@Stop