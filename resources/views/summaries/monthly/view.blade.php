@extends('layouts.master')

@section('title', (isset($summary)) ? date('F', mktime(0, 0, 0, $summary->month, 10)) . ' Monthly Summary' : 'Monthly Summary' )

@section('navbar-type', 'fixed-top')


@section('content')
  @if(!isset($summary))
    <script>
      $(document).ready(function() {
        $(".monthSelect").select2({
          placeholder: "Select a Month",
          allowClear: true
        });
        $('.monthSelect').val('').trigger('change');
        $(".yearSelect").select2({
          placeholder: "Select a Year",
          allowClear: true
        });
        $('.yearSelect').val('').trigger('change');
        $('#find').click(function (){
          window.location = "/summaries/monthly/" + $(".yearSelect").val() + "/" + $(".monthSelect").val();
        });
      });
    </script>
  @endif
  @if(isset($summary))
  <script>
    $(document).ready(function() {
      $('#chartsBtn').attr('disabled', 'disabled');

      var options = {
          ///Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines : true,
          //String - Colour of the grid lines
          scaleGridLineColor : "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth : 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve : false,
          //Number - Tension of the bezier curve between points
          bezierCurveTension : 0.4,
          //Boolean - Whether to show a dot for each point
          pointDot : true,
          //Number - Radius of each point dot in pixels
          pointDotRadius : 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth : 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius : 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke : true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth : 2,
          //Boolean - Whether to fill the dataset with a colour
          datasetFill : true,
          //String - A legend template
          legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
      };

      /**
        Maximum Temperature Line Chart
      */
      var maxtemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 1;
          foreach($dailyObs as $ob){
            if(isset($dailyObs[$i])){
                $datastr .= $i . ",";
            } else {
                $datastr .= $i;
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Max",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        $datastr .= $ob->max . ",";
                    } else {
                        $datastr .= $ob->max;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            },
            {
                label: "Max Avg",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        $datastr .= $summary->max_avg . ",";
                    } else {
                        $datastr .= $summary->max_avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var maxtemp_ctx = $("#maxtemp").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var maxtempLineChart = new Chart(maxtemp_ctx).Line(maxtemp_data, options);

      /**
        Minimum Temperature Line Chart
      */
      var mintemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 1;
          foreach($dailyObs as $ob){
            if(isset($dailyObs[$i])){
                $datastr .= $i . ",";
            } else {
                $datastr .= $i;
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Min",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        $datastr .= $ob->min . ",";
                    } else {
                        $datastr .= $ob->min;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            },
            {
                label: "Min Avg",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        $datastr .= $summary->min_avg . ",";
                    } else {
                        $datastr .= $summary->min_avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var mintemp_ctx = $("#mintemp").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var mintempLineChart = new Chart(mintemp_ctx).Line(mintemp_data, options);

      /**
        At Ob Temperature Line Chart
      */
      var atobtemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 1;
          foreach($dailyObs as $ob){
            if(isset($dailyObs[$i])){
                $datastr .= $i . ",";
            } else {
                $datastr .= $i;
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Temp",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        $datastr .= $ob->atob . ",";
                    } else {
                        $datastr .= $ob->atob;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var atobtemp_ctx = $("#atobtemp").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var atobtempLineChart = new Chart(atobtemp_ctx).Line(atobtemp_data, options);

      /**
        Precip Line Chart
      */
      var precip_data = {
        labels: [<?php
          $datastr = "";
          $i = 1;
          foreach($dailyObs as $ob){
            if(isset($dailyObs[$i])){
                $datastr .= $i . ",";
            } else {
                $datastr .= $i;
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Precip",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        if($ob->precip == -77){
                          $datastr .= 0.001 . ",";
                        } else {
                          $datastr .= $ob->precip . ",";
                        }
                    } else {
                      if($ob->precip == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->precip;
                      }
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var precip_ctx = $("#precip").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var precipLineChart = new Chart(precip_ctx).Line(precip_data, options);

      /**
        Snowfall/SnowDepth Line Chart
      */
      var sfsd_data = {
        labels: [<?php
          $datastr = "";
          $i = 1;
          foreach($dailyObs as $ob){
            if(isset($dailyObs[$i])){
                $datastr .= $i . ",";
            } else {
                $datastr .= $i;
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Snowfall",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        if($ob->snowfall == -77){
                          $datastr .= 0.001 . ",";
                        } else {
                          $datastr .= $ob->snowfall . ",";
                        }
                    } else {
                      if($ob->snowfall == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->snowfall;
                      }
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            },
            {
                label: "Snowdepth",
                fillColor: "rgba(76,175,80, 0.2)",
                strokeColor: "rgba(76,175,80, 1)",
                pointColor: "rgba(76,175,80,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(76,175,80,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($dailyObs as $ob){
                    if(isset($dailyObs[$i+1])){
                        if($ob->snowdepth == -77){
                          $datastr .= 0.001 . ",";
                        } else {
                          $datastr .= $ob->snowdepth . ",";
                        }
                    } else {
                      if($ob->snowdepth == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->snowdepth;
                      }
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var sfsd_ctx = $("#sfsd").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var sfsdLineChart = new Chart(sfsd_ctx).Line(sfsd_data, options);
    });



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
    }

    function iframeLoaded() {
      var iFrameID = document.getElementById('textSummaryiFrame');
      if(iFrameID) {
        // here you can make the height, I delete it first, then I make it again
        iFrameID.height = "";
        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }
    }
  </script>
  @endif
  <div id="" class="container" style="min-height: 650px;">
    @if(!isset($summary))
      <h2 style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #777;">Find Summary</h2>
      <div class="row betterRow">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center">
          <select class="monthSelect" style="width: 100%">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center" placeholder="Select a Year">
          <select class="yearSelect" style="width: 100%">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center; margin-bottom: 5px;">
          <input type="button" id="find" class="btn btn-success" style="width: 100%" value="Find Summary" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
      </div>
    @endif
    @if(isset($summary))
      <div class="row betterRow">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
          <h1>{{date('F', mktime(0, 0, 0, $summary->month, 10))}} Monthly Summary</h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="summaryBtns" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left; margin-bottom:5px;">
          <a href="{{route('summaries.monthly.home')}}" class="btn btn-info"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp; Back</a>
          <a href="#" id="textBtn" onclick="viewTextSummary()" class="btn btn-primary"><span class="glyphicon glyphicon-font" aria-hidden="true"></span>&nbsp; View Text Summary</a>
          <a href="#" id="chartsBtn" onclick="viewCharts()" class="btn btn-primary"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span>&nbsp; View Charts</a>
          <a href="#" class="btn btn-primary"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>&nbsp; Download Text PDF</a>
          <a href="#" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Edit Remarks</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="charts">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Maximum Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="maxtemp" style="width: 100%; height: 400px"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Maximum: {{ $summary->max_avg }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Minimum Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="mintemp" style="width: 100%; height: 400px;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Minimum: {{ $summary->min_avg }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Temperature at Observation (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="atobtemp" style="width: 100%; height: 400px;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Temp: {{ $summary->avg }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Precipitation (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="precip" style="width: 100%; height: 400px;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Total Precipitation: {{ $summary->total_precip }}</h4>
          </div>-->
          @if(in_array($summary->month, array(10,11,12,1,2,3,4)))
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Snowfall/Snowdepth (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="sfsd" style="width: 100%; height: 400px;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Total Snowfall: {{ $summary->total_sf }}</h4>
            <h4>Greatest Snowdepth: {{ $summary->grts_sd }}</h4>
          </div>-->
          @endif
        </div>
        <div id="textSummary" style="display:none;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <iframe id="textSummaryiFrame" style="width:100%; border:none;" onload="iframeLoaded()" src="{{route('summaries.monthly.raw', ['year' => $summary->year, 'month' => $summary->month])}}"></iframe>
          </div>
        </div>
      </div>
    @endif

  </div>
@endsection
