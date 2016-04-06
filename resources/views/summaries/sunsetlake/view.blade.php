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
        dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
        dataTable.addRows([
          <?php
            $i = 0;
            $str = "";
            foreach($summaries as $summary){
              $start = new \DateTime($summary->icein);
              $end = new \DateTime($summary->iceout);
              $interval = date_diff($start, $end);
              $icein = /*$start->format('Y') .*/ "2015," . strval(intval($start->format('m'))-1) . "," . $start->format('d');
              $iceout = /*$end->format('Y') . */"2016," . strval(intval($end->format('m'))-1) . "," . $end->format('d');
              $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . $summary->season . "</h4>" . $start->format('m') . "/" . $start->format('d') . "/" . $start->format('Y');
              $tooltip .= " - " . $end->format('m') . "/" . $end->format('d') . "/" . $end->format('Y');
              $tooltip .= "<br>" . "<b>Duration:</b> " . $interval->format('%a days') . "</div>";

              $str .= "[ '" . $summary->season . "', new Date(" . $icein . "), new Date(" . $iceout . "), '" . $tooltip . "'";

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
            format: 'MMM',
          },
          tooltip: {isHtml: true},
        };

        var view = new google.visualization.DataView(dataTable);
        view.setColumns([0,1,2]);

        chart.draw(view, options);

        function myHandler(e){
            if(e.row != null){
                $(".google-visualization-tooltip").html(dataTable.getValue(e.row,3)).css({width:"auto",height:"auto"});
            }
        }

        google.visualization.events.addListener(chart, 'onmouseover', myHandler);
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
