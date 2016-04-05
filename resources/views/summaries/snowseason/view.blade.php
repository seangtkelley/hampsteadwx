@extends('layouts.master')

@section('title', 'Snow Season ')

@section('navbar-type', 'fixed-top')


@section('content')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    $(document).ready(function (){
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Season', 'Total Snowfall'],
          <?php
            $i = 0;
            $str = "";
            foreach($summaries as $summary){
              $str = "['" . $summary->winter . "'," . $summary->total;

              if(isset($summaries[$i+1])){
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
          hAxis: {
            title: 'Total Snowfall (in.)'
          },
          vAxis: {
            title: 'Season'
          },
          bars: 'horizontal',
          series: {
            0: {axis: 'sf'},
          },
          axes: {
            x: {
              sf: {label: 'Total Snowfall (in.)'},
            }
          }
        };
        var material = new google.charts.Bar(document.getElementById('chart_div'));
        material.draw(data, options);
      }
      $(window).resize(function (){
        drawChart();
      });
    });
  </script>
  <div id="" class="container" style="min-height: 650px;">
    <h3 style="text-align: center;">Snow Season Summaries</h3>
    <div id="chart_div"></div>
  </div>
@endsection
