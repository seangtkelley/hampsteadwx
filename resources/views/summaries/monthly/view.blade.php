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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>

    google.charts.load('current', {'packages':['corechart']});
    //google.charts.setOnLoadCallback(drawVisualization);


    function drawVisualization() {
      // Some raw data (not necessarily accurate)
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'Maximum');
      data.addColumn('number', 'Minimum');
      data.addColumn('number', 'Average');

      data.addRows([
         <?php
           $i = 1;
           $str = "";
           foreach($dailyObs as $ob){
             $str .= "[" . $i . "," . $ob->max . "," . $ob->min . "," . ($ob->max + $ob->min)/2;

             if(isset($dailyObs[$i])){
               $str .= "],";
             } else {
               $str .= "]";
             }

             $i++;
           }
           echo $str;
         ?>
      ]);

      dataview = new google.visualization.DataView(data);
      dataview.setColumns([0,1,2]);

      var options = {
        //title : 'Temperature',
        vAxis: {
          title: 'Temperature (°F)',
          viewWindowMode:'explicit',
          viewWindow: {
            max: <?php echo (ceil($summary->highest / 10) * 10) ?>,
            min: <?php if($summary->lowest < 0){ echo (floor($summary->lowest / 10) * 10); } else { echo 0; } ?>
          },
          gridlines: {
            count:
            <?php
              if($summary->lowest < 0){
                echo ((ceil(($summary->highest - $summary->lowest) / 10) * 10) / 5) + 2;
              } else {
                echo ((ceil($summary->highest / 10) * 10)/5);
              }
            ?>
          }
        },
        hAxis: {
          title: 'Day',
          ticks: [
            <?php
            $i = 1;
            $str = "";
            foreach($dailyObs as $ob){
              if(!($i & 1)){
                $str .= $i;

                if(isset($dailyObs[$i])){
                  $str .= ",";
                } else {
                  $str .= "";
                }
              }

              $i++;
            }
            echo $str;
          ?>
          ]
        },
        legend: 'top',
        seriesType: 'bars',
        series: [
          {color: 'rgb(211,47,47)', visibleInLegend: true},
          {color: 'rgb(48,63,159)', visibleInLegend: true},
          {color: 'rgb(83,197,17)', visibleInLegend: true},
        ],
        chartArea: {'width': '80%', 'height': '80%'},
        trendlines: {
          0: {
            type: 'linear',
            //degree: 5,
            visibleInLegend: true,
          },
          1: {
            type: 'linear',
            //degree: 5,
            visibleInLegend: true,
          }
        }
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
      chart.draw(dataview, options);
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
      //setTimeout(drawVisualization, 500);
      drawVisualization();
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
        drawVisualization();
      });

      Chart.defaults.global.responsive = true;
      Chart.defaults.global.elements.point.hitRadius = 25;
      Chart.defaults.global.display = true;
      var globaloptions = {
          scaleBeginAtZero: false,
          barBeginAtOrigin: true,
          scaleStepWidth: 1,
          scales:{
            xAxes: [{
              display: true,
              gridLines: [{
                color:"rgba(255, 0, 0, 1)"
              }]
            }],
            yAxes: [{
              display: true,
              gridLines: [{
                color:"rgba(255, 0, 0, 1)"
              }]
            }]
          }
      };

      /**
        Max/Min Double Bar Chart
      */
      var maxmintemp_data = {
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
                backgroundColor: "rgba(211,47,47,1)",
                borderColor: "rgba(211,47,47,0.2)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(211,47,47,0.8)",
                hoverBorderColor: "rgba(211,47,47,1)",
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
                label: "Min",
                backgroundColor: "rgba(48,63,159,1)",
                borderColor: "rgba(48,63,159,0.2)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(48,63,159,0.8)",
                hoverBorderColor: "rgba(48,63,159,1)",
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
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      //var maxmintemp_ctx = $("#maxmintemp");
      // This will get the first returned node in the jQuery collection.
      /*var maxmintempLineChart = new Chart(maxmintemp_ctx, {
        type: 'bar',
        data: maxmintemp_data,
        options: {
          scaleBeginAtZero: false,
          barBeginAtOrigin: true,
          scaleStepWidth: 1,
          scales:{
            xAxes: [{
              display: true,
              scaleLabel: [{
                display: true,
                labelString: "Day",
              }],
              gridLines: [{
                display: true,
                color:"rgba(0, 0, 0, 1)"
              }]
            }],
            yAxes: [{
              display: true,
              scaleLabel: [{
                display: true,
                labelString: "Temperature (°F)"
              }],
              gridLines: [{
                display: true,
                color:"rgba(0, 0, 0, 1)"
              }]
            }]
          }
        }
      });*/

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
                fill: false,
                backgroundColor: "rgba(151,187,205,0.2)",
                borderColor: "rgba(151,187,205,1)",
                pointBorderColor: "rgba(220,220,220,1)",
                pointBackgroundColor: "rgba(151,187,205,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(220,220,220,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                tension: 0.0,
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
                fill: false,
                borderColor: "rgba(220,220,220,1)",
                pointBorderColor: "rgba(220,220,220,1)",
                pointBackgroundColor: "rgba(220,220,220,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(220,220,220,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
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
      //var maxtemp_ctx = $("#maxtemp");
      // This will get the first returned node in the jQuery collection.
      /*var maxtempLineChart = new Chart(maxtemp_ctx, {
        type: 'line',
        data: maxtemp_data,
        options: globaloptions
      });*/

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
                fill: false,
                backgroundColor: "rgba(151,187,205,0.2)",
                borderColor: "rgba(151,187,205,1)",
                pointBorderColor: "rgba(220,220,220,1)",
                pointBackgroundColor: "rgba(151,187,205,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(220,220,220,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                tension: 0.0,
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
                fill: false,
                borderColor: "rgba(220,220,220,1)",
                pointBorderColor: "rgba(220,220,220,1)",
                pointBackgroundColor: "rgba(220,220,220,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(220,220,220,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
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
      //var mintemp_ctx = $("#mintemp");
      // This will get the first returned node in the jQuery collection.
      /*var mintempLineChart = new Chart(mintemp_ctx, {
        type: 'line',
        data: mintemp_data,
        options: globaloptions
      });*/

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
                fill: false,
                backgroundColor: "rgba(151,187,205,0.2)",
                borderColor: "rgba(151,187,205,1)",
                pointBorderColor: "rgba(220,220,220,1)",
                pointBackgroundColor: "rgba(151,187,205,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(220,220,220,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                tension: 0.0,
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
      //var atobtemp_ctx = $("#atobtemp");
      // This will get the first returned node in the jQuery collection.
      /*var atobtempLineChart = new Chart(atobtemp_ctx, {
        type: 'line',
        data: atobtemp_data,
        options: globaloptions
      });*/

      /**
        Precip Bar Chart
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
                backgroundColor: "rgba(151,187,205,1)",
                borderColor: "rgba(151,187,205,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(151,187,205,0.8)",
                hoverBorderColor: "rgba(151,187,205,1)",
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
      var precip_ctx = $("#precip");
      // This will get the first returned node in the jQuery collection.
      var precipLineChart = new Chart(precip_ctx, {
        type: 'bar',
        data: precip_data,
        options: {
          scaleBeginAtZero: false,
          barBeginAtOrigin: true,
          scaleStepWidth: 1,
          scales:{
            xAxes: [{
              display: true,
              scaleLabel: [{
                display: true,
                labelString: "Day"
              }],
              gridLines: [{
                display: true,
                color:"rgba(0, 0, 0, 1)"
              }]
            }],
            yAxes: [{
              display: true,
              scaleLabel: [{
                display: true,
                labelString: "Precipitation (in.)"
              }],
              gridLines: [{
                display: true,
                color:"rgba(0, 0, 0, 1)"
              }]
            }]
          }
        }
      });

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
                fill: true,
                backgroundColor: "rgba(151,187,205,0.2)",
                borderColor: "rgba(151,187,205,1)",
                pointBorderColor: "#fff",
                pointBackgroundColor: "rgba(151,187,205,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(151,187,205,1)",
                pointHoverBorderWidth: 2,
                tension: 0.0,
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
                fill: true,
                backgroundColor: "rgba(76,175,80, 0.2)",
                borderColor: "rgba(76,175,80, 1)",
                pointBorderColor: "#fff",
                pointBackgroundColor: "rgba(76,175,80,1)",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(76,175,80,1)",
                pointHoverBorderWidth: 2,
                tension: 0.0,
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
      var sfsd_ctx = $("#sfsd");
      // This will get the first returned node in the jQuery collection.
      var sfsdLineChart = new Chart(sfsd_ctx, {
        type: 'line',
        data: sfsd_data,
        options: {
          scaleBeginAtZero: false,
          barBeginAtOrigin: true,
          scaleStepWidth: 1,
          scales:{
            xAxes: [{
              display: true,
              scaleLabel: [{
                display: true,
                labelString: "Day"
              }],
              gridLines: [{
                display: true,
                color:"rgba(0, 0, 0, 1)"
              }]
            }],
            yAxes: [{
              display: true,
              scaleLabel: [{
                display: true,
                labelString: "Snowfall/Snowdepth (in)"
              }],
              gridLines: [{
                display: true,
                color:"rgba(0, 0, 0, 1)"
              }]
            }]
          }
        }
      });
    });
  </script>
  @endif
  <div id="" class="container" style="min-height: 650px;">
    @if(!isset($summary))
      <h2 style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #777;">Find Summary</h2>
      <div class="row better-row">
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
            <?php
              for($i = 2011; $i <= date("Y"); $i++){
                echo "<option value=\"" . $i . "\">" . $i . "</option>";
              }
            ?>
          </select>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: center; margin-bottom: 5px;">
          <input type="button" id="find" class="btn btn-success" style="width: 100%" value="Find Summary" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
      </div>
    @endif
    @if(isset($summary))
      <div class="row better-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
          <h1>{{date('F', mktime(0, 0, 0, $summary->month, 10))}} Monthly Summary</h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="summaryBtns" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left; margin-bottom:5px;">
          <a href="{{route('summaries.monthly.home')}}" class="btn btn-info"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp; Back</a>
          <a href="#" id="textBtn" onclick="viewTextSummary()" class="btn btn-primary"><span class="glyphicon glyphicon-font" aria-hidden="true"></span>&nbsp; View Text Summary</a>
          <a href="#" id="chartsBtn" onclick="viewCharts()" class="btn btn-primary"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span>&nbsp; View Charts</a>
          <a href="{{route('summaries.monthly.text', ['year' => $summary->year, 'month' => $summary->month])}}" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp; Open Text Summary</a>
          <a href="{{route('summaries.monthly.csv', ['year' => $summary->year, 'month' => $summary->month])}}" class="btn btn-primary"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>&nbsp; Download CSV</a>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRemarks">
            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Edit Remarks
          </button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="charts" style="display:none;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>
              <?php echo date('F', mktime(0, 0, 0, $summary->month, 10)) . " " . $summary->year; ?> <br>
              Daily Maximum & Minimum Temperatures (°F) <br>
              West Hampstead, NH
            </h2>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="maxmintemp" style="width: 100%;"></canvas>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div id="chart_div" style="width: 100%; min-height: 555px;"></div>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Maximum Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="maxtemp" style="width: 100%;"></canvas>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Maximum: {{ $summary->max_avg }}</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Minimum Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="mintemp" style="width: 100%;"></canvas>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Minimum: {{ $summary->min_avg }}</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Temperature at Observation (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="atobtemp" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Temp: {{ $summary->avg }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Precipitation (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="precip" style="width: 100%;"></canvas>
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
            <canvas id="sfsd" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Total Snowfall: {{ $summary->total_sf }}</h4>
            <h4>Greatest Snowdepth: {{ $summary->grts_sd }}</h4>
          </div>-->
          @endif
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left; min-height: 20px;"></div>
        </div>
        <div id="textSummary">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <iframe id="textSummaryiFrame" style="width:100%; border:none;" src="{{route('summaries.monthly.text', ['year' => $summary->year, 'month' => $summary->month])}}"></iframe>
          </div>
        </div>
        <div id="editRemarks" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Remarks</h4>
              </div>
              <form action="{{route('summaries.monthly.editRemarks', ['year' => $summary->year, 'month' => $summary->month])}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-body">
                  <textarea name="remarks" rows="10" cols="70" style="margin-bottom: 10px;" class="form-control">{{ $summary->remarks }}</textarea>
                  <input type="password" name="password" class="form-control" placeholder="Enter Password" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Save changes">
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
      </div>
    @endif

  </div>
@endsection
