@extends('layouts.master')

@section('title', 'Sunset Lake Ice In/Ice Out')

@section('navbar-type', 'fixed-top')


@section('content')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    $(document).ready(function (){
      google.charts.load('current', {'packages':['timeline']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'Year' });
        dataTable.addColumn({ type: 'date', id: 'Ice In' });
        dataTable.addColumn({ type: 'date', id: 'Ice Out' });
        dataTable.addRows([
          <?php
            $i = 0;
            $str = "";
            foreach($summaries as $summary){
              $start = new DateTime($summary->icein);
              $end = new DateTime($summary->iceout);
              $icein = $start->y . "," . $start->m . "," . $start->d;
              $iceout = $end->y . "," . $end->m . "," . $end->d;
              $str .= "[ '" . $summary->year . "', new Date(" . $icein . "), new Date(" . $iceout . ")";

              if(isset($summaries[$i+1])){
                $str .= "],";
              } else {
                $str .= "]";
              }

              $i++;
            }
          ?>
        ]);

        chart.draw(dataTable);
      }
      $(window).resize(function (){
        drawChart();
      });
    });
  </script>
  <div id="" class="container" style="min-height: 650px;">
    <h3>Sunset Lake Ice In/Ice Out</h3>
    <h3>NWS Cooperative Climatological Station, West Hampstead, New Hampshire</h3>
    County: Rockingham  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Town: Hampstead
    <br><br>
    <div id="timeline" style="height: 180px;"></div>
  </div>
@endsection
