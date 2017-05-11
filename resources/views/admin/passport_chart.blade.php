@extends('admin.default')

@section('title')Passport Chart @Stop
@section('homeclass')nav-active @Stop

@section('content')

        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Passport'],
                            @foreach($passport_chart as $passport)
                            ['{{ $passport->created_at }}',  {{ $passport->xtotal }}],
                        @endforeach
                    ]);

                    var options = {
                        title: 'Daily Passport Purchased - {{ $passport_chart_sum->xtotal }}',
                        hAxis: {title: 'Daily',  titleTextStyle: {color: '#333'}},
                        vAxis: {minValue: 0}
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </div>
        <div class="row">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Passport (BTC)'],
                            @foreach($passport_chart_btc as $passport)
                            ['{{ $passport->created_at }}',  {{ $passport->xtotal }}],
                        @endforeach
                    ]);

                    var options = {
                        title: 'Daily Passport Purchased (BTC) - {{ $passport_chart_btc_sum->xtotal }}',
                        hAxis: {title: 'Daily',  titleTextStyle: {color: '#333'}},
                        vAxis: {minValue: 0}
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
                    chart.draw(data, options);
                }
            </script>
            <div id="chart_div2" style="width: 100%; height: 500px;"></div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop