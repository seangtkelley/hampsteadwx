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
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
          <?php
            $i = 0;
            $str = "";
            foreach($summaries as $summary){
              $start = new \DateTime($summary->icein);
              $end = new \DateTime($summary->iceout);
              $icein = $start->format('Y') . "," . strval(intval($start->format('m'))-1) . "," . $start->format('d');
              $iceout = $end->format('Y') . "," . strval(intval($end->format('m'))-1) . "," . $end->format('d');
              $str .= "[ '" . $summary->season . "', new Date(" . $icein . "), new Date(" . $iceout . ")";

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

        chart.draw(dataTable);
      }
      $(window).resize(function (){
        drawChart();
      });
    });
  </script>
  <div id="" class="container" style="min-height: 650px;">
    <h3 style="text-align: center;">Sunset Lake Ice In/Ice Out</h3>
    <div id="timeline"></div>
  </div>
@endsection
