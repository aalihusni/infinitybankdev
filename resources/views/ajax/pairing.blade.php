

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">{{trans('pairing.flex_pairing')}}</h2>
                        <p class="panel-subtitle">{{trans('pairing.info_about_pairing')}}</p>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url'=>'members/change-password','method'=>'POST', 'class'=>'form-horizontal form-bordered')) !!}

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing.next_pair_in')}}</label>
                            <div class="col-lg-9">
                                <p class="form-control-static"><span id="ms_timer"></span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-md-3 control-label">{{trans('pairing.current_pairing')}}</label>
                            <div class="col-lg-6">
                                <p class="form-control-static">0.00000000</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <section class="panel panel-featured panel-featured-dark">
                                <header class="panel-heading -align-right">
                                    <h2 class="panel-title text-center">0.00000000</h2>
                                    <p class="panel-subtitle text-center">{{trans('pairing.left')}}</p>
                                </header>
                            </section>
                        </div>

                        <div class="col-lg-6">
                            <section class="panel panel-primary">
                                <header class="panel-heading">
                                    <span class="fa fa-chevron-left pull-left movepair-left"></span>
                                    <span class="fa fa-chevron-right pull-right movepair-right"></span>
                                    <h2 class="panel-title text-center">0.00000000</h2>
                                    <p class="panel-subtitle text-center">{{trans('pairing.middle')}}</p>
                                </header>
                            </section>
                        </div>

                        <div class="col-lg-3">
                            <section class="panel panel-featured panel-featured-dark">
                                <header class="panel-heading">
                                    <h2 class="panel-title text-center">0.00000000</h2>
                                    <p class="panel-subtitle text-center">{{trans('pairing.right')}}</p>
                                </header>
                            </section>
                        </div>



                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-subtitle">{{trans('pairing.pair_history')}}</p>
                    </div>
                    <div class="panel-body">
                        <table id="datatable-default" class="table table-bordered table-striped mb-none dataTable no-footer">
                            <thead>
                            <tr>
                                <td>{{trans('pairing.time_date')}}</td>
                                <td>{{trans('pairing.description')}}</td>
                                <td>{{trans('pairing.debit')}}</td>
                                <td>{{trans('pairing.credit')}}</td>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


<script type="text/javascript">
    $(function(){
        $("#ms_timer").countdowntimer({
            dateAndTime : "{{ Carbon\Carbon::now()->endOfMonth() }}",
		size : "xs",
        borderColor : "transparent",
        backgroundColor : "transparent",
        fontColor : "#777",
		regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
      		regexpReplaceWith: "$1 days, $2 hours, $3 minutes, $4 seconds."
    });
    });

    (function( $ ) {

        'use strict';

        var datatableInit = function() {

            $('#datatable-default').dataTable();

        };

        $(function() {
            datatableInit();
        });

    }).apply( this, [ jQuery ]);
</script>