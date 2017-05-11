@extends('admin.default')

@section('title')PH Chart @Stop
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
                        ['Date', '{{ strtoupper($type) }}'],
                        @foreach($charts as $chart)
                        ['{{ $chart->created_at }}',  {{ $chart->btc }}],
                        @endforeach
                    ]);

                    var options = {
                        title: 'Daily {{ strtoupper($type) }} (Pledge)',
                        hAxis: {title: 'Daily',  titleTextStyle: {color: '#333'}},
                        vAxis: {minValue: 0}
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@Stop