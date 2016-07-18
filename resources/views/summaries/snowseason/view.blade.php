@extends('layouts.master')

@section('title', 'Snow Season ')

@section('navbar-type', 'static-top')


@section('content')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    $(document).ready(function (){
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn('string', 'Season');
        dataTable.addColumn('number', 'Total Snowfall (in.)');
        dataTable.addColumn({type: 'string', role: 'annotation'});

        dataTable.addRows([
          <?php
            $i = 0;
            $str = "";
            foreach($summaries as $summary){
              $str .= "['" . $summary->winter . "'," . $summary->total . ",'" . $summary->total . "'";

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
          legend: {position: 'none'},
          chartArea: {'width': '75%', 'height': '90%'},
          bars: 'horizontal',
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(dataTable, options);

        google.visualization.events.addListener(chart, 'select', function (){
          var selection = chart.getSelection();
          var item = selection[0];
          var winter = dataTable.getFormattedValue(item.row, 0);
          window.location.href = '{{route('summaries.snowseason.view')}}/' + winter;
        });

        google.visualization.events.addListener(chart, 'onmouseover', function (){
          $('#chart_div').css('cursor','pointer');
        });
        google.visualization.events.addListener(chart, 'onmouseout', function (){
          $('#chart_div').css('cursor','default');
        });
      }
      $(window).resize(function (){
        drawChart();
      });
    });
  </script>
  <div id="" class="container" style="min-height: 650px;">
    <h3 style="text-align: center;">Snow Season Summaries</h3>
    <h4 style="text-align: center;">1990-1991 to 2002-2003 data are from Mr. Maurice Randall, Hampstead Town Historian</h4>
    <div style="text-align: center;">Click on a bar to see the month graph.</div>
    <div id="chart_div" style="height: <?php
      $height = 0;
      foreach($summaries as $summary){
        $height += 25;
      }
      echo $height;
    ?>px;"></div>
  </div>
@endsection
