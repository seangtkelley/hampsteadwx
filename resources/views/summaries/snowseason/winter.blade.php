@extends('layouts.master')

@section('title', $summary->winter . ' Snow Season ')

@section('navbar-type', 'fixed-top')


@section('content')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    $(document).ready(function (){
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn('string', 'Month');
        dataTable.addColumn('number', 'Total Snowfall (in.)');
        dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

        dataTable.addRows([
          <?php
            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">October</h4>" . ($summary->oct == -77 ? 'Trace' : $summary->oct) . "</div>";
            $str  = "['October', " . (($summary->oct == -77 || $summary->oct < 0.5) ? 0.5 : $summary->oct) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">November</h4>" . ($summary->nov == -77 ? 'Trace' : $summary->nov) . "</div>";
            $str .= "['November', " . (($summary->nov == -77 || $summary->nov < 0.5) ? 0.5 : $summary->nov) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">December</h4>" . ($summary->dec == -77 ? 'Trace' : $summary->dec) . "</div>";
            $str .= "['December', " . (($summary->dec == -77 || $summary->dec < 0.5) ? 0.5 : $summary->dec) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">January</h4>" . ($summary->jan == -77 ? 'Trace' : $summary->jan) . "</div>";
            $str .= "['January', " . (($summary->jan == -77 || $summary->jan < 0.5) ? 0.5 : $summary->jan) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">February</h4>" . ($summary->feb == -77 ? 'Trace' : $summary->feb) . "</div>";
            $str .= "['February', " . (($summary->feb == -77 || $summary->feb < 0.5) ? 0.5 : $summary->feb) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">March</h4>" . ($summary->mar == -77 ? 'Trace' : $summary->mar) . "</div>";
            $str .= "['March', " . (($summary->mar == -77 || $summary->mar < 0.5) ? 0.5 : $summary->mar) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">April</h4>" . ($summary->apr == -77 ? 'Trace' : $summary->apr) . "</div>";
            $str .= "['April', " . (($summary->apr == -77 || $summary->apr < 0.5) ? 0.5 : $summary->apr) . ", '" . $tooltip . "'],";

            $tooltip  = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">May</h4>" . ($summary->may == -77 ? 'Trace' : $summary->may) . "</div>";
            $str .= "['May', " . (($summary->may == -77 || $summary->may < 0.5) ? 0.5 : $summary->may) . ", '" . $tooltip . "']";

            echo $str;
          ?>
        ]);

        var options = {
          hAxis: {
            title: 'Month'
          },
          vAxis: {
            title: 'Total Snowfall (in.)'
          },
          legend: {position: 'none'},
          bars: 'vertical',
          tooltip: { isHtml: true }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div')).draw(dataTable, options);
      }
      $(window).resize(function (){
        drawChart();
      });
    });
  </script>
  <div id="" class="container" style="min-height: 650px;">
    <h3 style="text-align: center;">Snow Season Summaries</h3>
    <h4 style="text-align: center;">1990-1991 to 2002-2003 data are from Mr. Maurice Randall, Hampstead Town Historian</h4>
    <div id="chart_div" style="height: 500px;"></div>
  </div>
@endsection
