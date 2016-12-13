@extends('layouts.master')

@section('title', $year . ' Annual Summary')

@section('navbar-type', 'fixed-top')


@section('content')
  @if(is_null($year))
    <script>
      $(document).ready(function() {
        $(".yearSelect").select2({
          placeholder: "Select a Year",
          allowClear: true
        });
        $('.yearSelect').val('').trigger('change');
        $('#find').click(function (){
          window.location = "/summaries/annual/" + $(".yearSelect").val();
        });
      });
    </script>
  @endif
  @if(!is_null($year))
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>

    google.charts.load('current', {'packages':['corechart']});

    function drawAvgChart() {
      // Some raw data (not necessarily accurate)
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Month');
      dataTable.addColumn('number', 'Average Temperature');
      dataTable.addColumn('number', 'Departure From Normal');

      dataTable.addRows([
         <?php
           $i = 1;
           $str = "";
           foreach($monthlyObs as $ob){
             $str .= "['" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'," . $ob->avg . "," . $ob->depart_temp_avg;

             if(isset($monthlyObs[$i])){
               $str .= "],";
             } else {
               $str .= "]";
             }

             $i++;
           }
           echo $str;
         ?>
      ]);

      var options = {
        //title : 'Temperature',
        vAxis: {
          title: 'Temperature (°F)'
        },
        hAxis: {
          title: 'Month'
        },
        legend: 'top',
        seriesType: 'bars',
        series: [
          {color: 'rgb(211,47,47)', visibleInLegend: true},
          {color: 'rgb(48,63,159)', visibleInLegend: true},
          {color: 'rgb(83,197,17)', visibleInLegend: true},
        ],
        chartArea: {'width': '80%', 'height': '75%'},
      };

      var chart = new google.visualization.ComboChart(document.getElementById('avgtempChart'));
      chart.draw(dataTable, options);
    }

    function drawPrecipChart() {
      // Some raw data (not necessarily accurate)
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Month');
      dataTable.addColumn('number', 'Total Precipitation');
      dataTable.addColumn('number', 'Departure From Normal');

      dataTable.addRows([
         <?php
           $i = 1;
           $str = "";
           foreach($monthlyObs as $ob){
             $str .= "['" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'," . $ob->total_precip . "," . ($ob->total_precip - $avg_precip_array[$ob->month-1]);

             if(isset($monthlyObs[$i])){
               $str .= "],";
             } else {
               $str .= "]";
             }

             $i++;
           }
           echo $str;
         ?>
      ]);

      var options = {
        //title : 'Temperature',
        vAxis: {
          title: 'Precipitation (in.)'
        },
        hAxis: {
          title: 'Month'
        },
        legend: 'top',
        seriesType: 'bars',
        series: [
          {color: 'rgb(211,47,47)', visibleInLegend: true},
          {color: 'rgb(48,63,159)', visibleInLegend: true},
          {color: 'rgb(83,197,17)', visibleInLegend: true},
        ],
        chartArea: {'width': '80%', 'height': '75%'},
      };

      var chart = new google.visualization.ComboChart(document.getElementById('precipChart'));
      chart.draw(dataTable, options);
    }

    function drawGrtsPrecipChart() {
      // Some raw data (not necessarily accurate)
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Month');
      dataTable.addColumn('number', 'Greatest Precipitation');
      dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

      dataTable.addRows([
         <?php
           $i = 1;
           $str = "";
           foreach($monthlyObs as $ob){
             $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . $ob->grts_precip_dates . "</h4>" . ($ob->grts_precip == -77 ? 'Trace' : $ob->grts_precip) . "</div>";
             $str .= "['" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'," . (($ob->grts_precip == -77) ? 0.01 : $ob->grts_precip) . ",'" . $tooltip . "'";

             if(isset($monthlyObs[$i])){
               $str .= "],";
             } else {
               $str .= "]";
             }

             $i++;
           }
           echo $str;
         ?>
      ]);

      var options = {
        //title : 'Temperature',
        vAxis: {
          title: 'Precipitation (in.)'
        },
        hAxis: {
          title: 'Month'
        },
        legend: 'none',
        seriesType: 'bars',
        series: [
          {color: 'rgb(48,63,159)', visibleInLegend: true},
        ],
        chartArea: {'width': '80%', 'height': '75%'},
        tooltip: { isHtml: true }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('grtsPrecipChart'));
      chart.draw(dataTable, options);
    }

    function drawSnowfallChart() {
      // Some raw data (not necessarily accurate)
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Month');
      dataTable.addColumn('number', 'Total Snowfall');
      dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

      dataTable.addRows([
         <?php
           $i = 1;
           $str = "";
           foreach($monthlyObs as $ob){
             $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "</h4>" . ($ob->total_sf == -77 ? 'Trace' : $ob->total_sf) . "</div>";
             $str .= "['" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'," . (($ob->total_sf == -77) ? 0.01 : $ob->total_sf) . ",'" . $tooltip . "'";

             if(isset($monthlyObs[$i])){
               $str .= "],";
             } else {
               $str .= "]";
             }

             $i++;
           }
           echo $str;
         ?>
      ]);

      var options = {
        //title : 'Temperature',
        vAxis: {
          title: 'Total Snowfall (in.)'
        },
        hAxis: {
          title: 'Month'
        },
        seriesType: 'bars',
        legend: 'none',
        series: [
          {color: 'rgb(48,63,159)', visibleInLegend: true},
        ],
        chartArea: {'width': '80%', 'height': '75%'},
        tooltip: { isHtml: true }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('snowfallChart'));
      chart.draw(dataTable, options);
    }

    function drawSnowDepthChart() {
      // Some raw data (not necessarily accurate)
      var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Month');
      dataTable.addColumn('number', 'Greatest Snow Depth');
      dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

      dataTable.addRows([
         <?php
           $i = 1;
           $str = "";
           foreach($monthlyObs as $ob){
             $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "</h4>" . ($ob->grts_sd == -77 ? 'Trace' : $ob->grts_sd) . "</div>";
             $str .= "['" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'," . (($ob->grts_sd == -77) ? 0.01 : $ob->grts_sd) . ",'" . $tooltip . "'";

             if(isset($monthlyObs[$i])){
               $str .= "],";
             } else {
               $str .= "]";
             }

             $i++;
           }
           echo $str;
         ?>
      ]);

      var options = {
        //title : 'Temperature',
        vAxis: {
          title: 'Snow Depth (in.)'
        },
        hAxis: {
          title: 'Month'
        },
        legend: 'none',
        seriesType: 'bars',
        series: [
          {color: 'rgb(48,63,159)', visibleInLegend: true},
        ],
        chartArea: {'width': '80%', 'height': '75%'},
        tooltip: { isHtml: true }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('snowDepthChart'));
      chart.draw(dataTable, options);
    }

    function viewTextSummary(){
      $('#textSummary').show();
      $('#charts').hide();
      $('#textBtn').attr('disabled','disabled');
      $('#chartsBtn').removeAttr('disabled');
    }

    function viewCharts(){
      $('#textSummary').hide();
      $('#charts').show();
      $('#textBtn').removeAttr('disabled');
      $('#chartsBtn').attr('disabled','disabled');
      drawAvgChart();
      drawPrecipChart();
      drawGrtsPrecipChart();
      drawSnowfallChart();
      drawSnowDepthChart();
    }

    function iframeLoaded() {
      var iFrameID = document.getElementById('textSummaryiFrame');
      if(iFrameID) {
        // here you can make the height, I delete it first, then I make it again
        iFrameID.height = "";
        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }
    }
    $(document).ready(function() {
      $('#textSummaryiFrame').load(function(){
          iframeLoaded();
      });

      $('#textBtn').attr('disabled','disabled');

      $(window).resize(function (){
        drawAvgChart();
        drawPrecipChart();
        drawGrtsPrecipChart();
        drawSnowfallChart();
        drawSnowDepthChart();
      });

    });
  </script>
  @endif
  <div id="" class="container" style="min-height: 650px;">
    @if(is_null($year))
      <h2 style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #777;">Find Summary</h2>
      <div class="row better-row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="text-align: center" placeholder="Select a Year">
          <select class="yearSelect" style="width: 100%">
            <?php
              for($i = 2011; $i <= date("Y"); $i++){
                echo "<option value=\"" . $i . "\">" . $i . "</option>";
              }
            ?>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="text-align: center; margin-bottom: 5px;">
          <input type="button" id="find" class="btn btn-success" style="width: 100%" value="Find Summary" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
      </div>
    @endif
    @if(!is_null($year))
      <div class="row better-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
          <h1>{{$year}} Annual Summary</h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="summaryBtns" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left; margin-bottom:5px;">
          <a href="{{route('summaries.annual.home')}}" class="btn btn-info"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp; Back</a>
          <a href="#" id="textBtn" onclick="viewTextSummary()" class="btn btn-primary"><span class="glyphicon glyphicon-font" aria-hidden="true"></span>&nbsp; View Text Summary</a>
          <a href="#" id="chartsBtn" onclick="viewCharts()" class="btn btn-primary"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span>&nbsp; View Charts</a>
          <a href="{{route('summaries.annual.text', ['year' => $year])}}" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>&nbsp; Open Text Summary</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="charts" style="display:none;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Average Temperature and Departure from Normal (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div id="avgtempChart" style="width: 100%; min-height: 555px;"></div>
          </div>
          <br>
          <br>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Total Precipitation and Monthly Precipitation Departure (in.)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div id="precipChart" style="width: 100%; min-height: 555px;"></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Greatest Precipitation Day (in.)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div id="grtsPrecipChart" style="width: 100%; min-height: 555px;"></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Total Snowfall (in.)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div id="snowfallChart" style="width: 100%; min-height: 555px;"></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Greatest Snow Depth (in.)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div id="snowDepthChart" style="width: 100%; min-height: 555px;"></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left; min-height: 20px;"></div>
        </div>
        <div id="textSummary">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <iframe id="textSummaryiFrame" style="width:100%; border:none;" src="{{route('summaries.annual.text', ['year' => $year])}}"></iframe>
          </div>
        </div>
      </div>
    @endif

  </div>
@endsection
