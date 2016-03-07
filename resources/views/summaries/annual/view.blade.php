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
  <script>
    $(document).ready(function() {
      $('#chartsBtn').attr('disabled', 'disabled');

      Chart.defaults.global.responsive = true;
      Chart.defaults.global.elements.point.hitRadius = 25;
      Chart.defaults.global.display = true;
      var globaloptions = {
          scaleBeginAtZero: false,
          barBeginAtOrigin: true,
          scaleStepWidth: 1,
          gridLines: {
            color:"rgba(0, 0, 0, 1)"
          },
      };

      /**
        Maximum Temperature Line Chart
      */
      var maxtemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $ob->max_avg . ",";
                    } else {
                        $datastr .= $ob->max_avg;
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $max_avg . ",";
                    } else {
                        $datastr .= $max_avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var maxtemp_ctx = $("#maxtemp");
      // This will get the first returned node in the jQuery collection.
      var maxtempLineChart = new Chart(maxtemp_ctx, {
        type: 'line',
        data: maxtemp_data,
        options: globaloptions
      });

      /**
        Minimum Temperature Line Chart
      */
      var mintemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $ob->min_avg . ",";
                    } else {
                        $datastr .= $ob->min_avg;
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $min_avg . ",";
                    } else {
                        $datastr .= $min_avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var mintemp_ctx = $("#mintemp");
      // This will get the first returned node in the jQuery collection.
      var mintempLineChart = new Chart(mintemp_ctx, {
        type: 'line',
        data: mintemp_data,
        options: globaloptions
      });

      /**
        At Ob Temperature Line Chart
      */
      var avgtemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $ob->avg . ",";
                    } else {
                        $datastr .= $ob->avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            },
            {
                label: "Avg",
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $avg . ",";
                    } else {
                        $datastr .= $avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var avgtemp_ctx = $("#avgtemp");
      // This will get the first returned node in the jQuery collection.
      var avgtempLineChart = new Chart(avgtemp_ctx, {
        type: 'line',
        data: avgtemp_data,
        options: globaloptions
      });

      /**
        Depart Temperature Bar Chart
      */
      var departtemp_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Temp",
                backgroundColor: "rgba(151,187,205,1)",
                borderColor: "rgba(151,187,205,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(151,187,205,0.8)",
                hoverBorderColor: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $ob->depart_temp_avg . ",";
                    } else {
                        $datastr .= $ob->depart_temp_avg;
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var departtemp_ctx = $("#departtemp");
      // This will get the first returned node in the jQuery collection.
      var departtempLineChart = new Chart(departtemp_ctx, {
        type: 'bar',
        data: departtemp_data,
        options: globaloptions
      });

      /**
        Precip Bar Chart
      */
      var precip_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        if($ob->total_precip == -77){
                          $datastr .= 0.001 . ",";
                        } else {
                          $datastr .= $ob->total_precip . ",";
                        }
                    } else {
                      if($ob->total_precip == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->total_precip;
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
        options: globaloptions
      });

      /**
        Depart Precip Bar Chart
      */
      var departprecip_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Temp",
                backgroundColor: "rgba(151,187,205,1)",
                borderColor: "rgba(151,187,205,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(151,187,205,0.8)",
                hoverBorderColor: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        $datastr .= $ob->total_precip - $avg_precip_array[$ob->month-1] . ",";
                    } else {
                        $datastr .= $ob->total_precip - $avg_precip_array[$ob->month-1];
                    }
                    $i++;
                  }
                  echo $datastr;
                ?>]
            }
        ]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var departprecip_ctx = $("#departprecip").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var departprecipLineChart = new Chart(departprecip_ctx, {
        type: 'bar',
        data: departprecip_data,
        options: globaloptions
      });

      /**
        Greatest Day Precip Bar Chart
      */
      var grtsprecip_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
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
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        if($ob->grts_precip == -77){
                          $datastr .= 0.001 . ",";
                        } else {
                          $datastr .= $ob->grts_precip . ",";
                        }
                    } else {
                      if($ob->grts_precip == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->grts_precip;
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
      var grtsprecip_ctx = $("#grtsprecip");
      // This will get the first returned node in the jQuery collection.
      var grtsprecipLineChart = new Chart(grtsprecip_ctx, {
        type: 'bar',
        data: grtsprecip_data,
        options: globaloptions
      });

      /**
        Snowfall Bar Chart
      */
      var sf_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Snowfall",
                backgroundColor: "rgba(151,187,205,1)",
                borderColor: "rgba(151,187,205,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(151,187,205,0.8)",
                hoverBorderColor: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                        if($ob->total_sf == -77){
                          $datastr .= 0.001 . ",";
                        } else {
                          $datastr .= $ob->total_sf . ",";
                        }
                    } else {
                      if($ob->total_sf == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->total_sf;
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
      var sf_ctx = $("#sf");
      // This will get the first returned node in the jQuery collection.
      var sfLineChart = new Chart(sf_ctx, {
        type: 'bar',
        data: sf_data,
        options: globaloptions
      });

      /**
        Snowdepth Bar Chart
      */
      <?php
      /*$winterDays = array();
      foreach($dailyObs as $ob){
        if(in_array($ob->month, array(10,11,12,1,2,3,4))){
         array_push($winterDays, $ob);
        }
      }*/
      ?>
      var sd_data = {
        labels: [<?php
          $datastr = "";
          $i = 0;
          foreach($monthlyObs as $ob){
            if(isset($monthlyObs[$i+1])){
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "',";
            } else {
                $datastr .= "'" . date('F', mktime(0, 0, 0, $ob->month, 10)) . "'";
            }
            $i++;
          }
          echo $datastr;
        ?>],
        datasets: [
            {
                label: "Snowdepth",
                backgroundColor: "rgba(151,187,205,1)",
                borderColor: "rgba(151,187,205,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(151,187,205,0.8)",
                hoverBorderColor: "rgba(151,187,205,1)",
                data: [<?php
                  $datastr = "";
                  $i = 0;
                  foreach($monthlyObs as $ob){
                    if(isset($monthlyObs[$i+1])){
                      if($ob->grts_sd == -77){
                        $datastr .= 0.001 . ",";
                      } else {
                        $datastr .= $ob->grts_sd . ",";
                      }
                    } else {
                      if($ob->grts_sd == -77){
                        $datastr .= 0.001;
                      } else {
                        $datastr .= $ob->grts_sd;
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
      var sd_ctx = $("#sd");
      // This will get the first returned node in the jQuery collection.
      var sdLineChart = new Chart(sd_ctx, {
        type: 'bar',
        data: sd_data,
        options: globaloptions
      });
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
    @if(is_null($year))
      <h2 style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #777;">Find Summary</h2>
      <div class="row better-row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="text-align: center" placeholder="Select a Year">
          <select class="yearSelect" style="width: 100%">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
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
          <a href="{{route('summaries.annual.html', ['year' => $year])}}" class="btn btn-primary"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>&nbsp; Download HTML</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 5px; border-top: 1px solid grey;"></div>
        <div id="charts">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Maximum Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="maxtemp" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Maximum: {{ $MxA_str }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Minimum Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="mintemp" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Minimum: {{ $MnA_str }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Average Temperature (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="avgtemp" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Temp: {{ $A_str }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Monthly Temperature Departure (°F)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="departtemp" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Temp: {{ $A_str }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Total Precipitation (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="precip" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Total Precipitation: {{ $total_precip }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Monthly Precipitation Departure (in.)</h2>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="departprecip" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Average Temp: {{ $A_str }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Greatest Precipitation Day (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="grtsprecip" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Greatest Precipitation: {{ $grts_precip }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Snowfall (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="sf" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Total Snowfall: {{ $total_sf }}</h4>
            <h4>Greatest Snowdepth: {{ $grts_sd }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <h2>Greatest Snowdepth (in.)</h2>
            <h4>0.001 = Trace</h4>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <canvas id="sd" style="width: 100%;"></canvas>
          </div>
          <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
            <h4>Total Snowfall: {{ $total_sf }}</h4>
            <h4>Greatest Snowdepth: {{ $grts_sd }}</h4>
          </div>-->
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left; min-height: 20px;"></div>
        </div>
        <div id="textSummary" style="display:none;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <iframe id="textSummaryiFrame" style="width:100%; height: 1250px; border:none;" src="{{route('summaries.annual.raw', ['year' => $year])}}"></iframe>
          </div>
        </div>
      </div>
    @endif

  </div>
@endsection
