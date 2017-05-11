<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/lineicons/css/lineicons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />
<link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />
<link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />
<link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugin/polygot/css/polyglot-language-switcher.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugin/flagstrap/css/flags.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugin/countdownTimer/CSS/jquery.countdownTimer.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/morris/morris.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/pnotify/pnotify.custom.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/jorgchart/jquery.jOrgChart.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/jorgchart/prettify.css')}}" />

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div id="ref_generation" class="col-lg-3">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        Referral Hierarchy
                    </div>
                    {{--*/ $first_ref = "" /*--}}
                    @if (!empty($referrers))
                        @foreach($referrers as $referrer)
                            <div class="panel-footer">
                                {!! $first_ref !!}
                                <span class="seemore" data-id="{{ $referrer['id'] }}" href="#">
                                    <span class="pull-left">{{ $referrer['alias'] }}</span>
                                </span>
                                <span class="pull-right"><strong>{{ $referrer['referrals_count'] }}</strong></span>
                                <div class="clearfix"></div>
                            </div>
                            {{--*/ $first_ref = '<img class="ref_pointer" src="'.asset('assets/images/ref_arrow.png').'"/>' /*--}}
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-default modal-dismiss">Close</button>
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->