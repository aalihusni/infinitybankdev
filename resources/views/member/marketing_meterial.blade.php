@extends('member.default')

@section('title')Marketing Meterial @Stop
@section('marketingmeterial-class')nav-active @Stop
@section('promo-class')nav-expanded nav-active @Stop
@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <div>{{ Session::get('success') }}</div>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel panel-default">
                        <div class="panel-body" style="padding-bottom:40px;">

                            <div class="col-md-4">
                                <p><h4>PDF Marketing Plan</h4></p>

                                <ul>
                                    <li><a href="../download/marketin_plan.pdf" target="_blank">Bitregion - Marketing Plan.pdf</a></li>
                                    <li><a href="../download/simple_marketing_plan.pdf" target="_blank">BitRegion - Simple Marketing Plan.pdf</a></li>
                                    <li><a href="../download/getting_started.pdf" target="_blank">Bitregion - Getting Started.pdf</a></li>
                                    <li><a href="../download/account_manager_guide.pdf" target="_blank">BitRegion - Account Manager Guide.pdf</a></li>
                                </ul>
                            </div>

                            <div class="col-md-4">
                                <p><h4>Presentation</h4></p>

                                <ul>
                                    <li><a href="../download/br_keynote.key" target="_blank">Bitregion Keynote</a></li>
                                    <li><a href="../download/br_powerpoint.pptx" target="_blank">Bitregion Powerpoint</a></li>
                                </ul>
                            </div>

                            <div class="col-md-4">
                                <p><h4>Videos</h4></p>

                                <ul>
                                    <li><a href="../download/vid_marketing_plan_eng.3gp" target="_blank">Marketing Plan (English) - Thomas Redwood</a></li>
                                    <li><a href="../download/vid_marketing_plan_cn.3gp" target="_blank">Marketing Plan (Chinese) - Aaron Liu</a></li>
                                    <li><a href="../download/vid_freedom.mp4" target="_blank">Bitregion Freedom</a></li>
                                    <li><a href="../download/vid_incrypto.mp4" target="_blank">Bitregion In Crypto</a></li>
                                    <li><a href="../download/vid_new_era.mp4" target="_blank">Bitregion New Era</a></li>
                                    <li><a href="../download/vid_power_of_believe.mp4" target="_blank">Bitregion The Power of Believe</a></li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        $('#basic').flagStrap({
            buttonSize: "btn-md btn-block",
            labelMargin: "10px",
            scrollable: true,
            scrollableHeight: "300px"
        });


    </script>
    @Stop