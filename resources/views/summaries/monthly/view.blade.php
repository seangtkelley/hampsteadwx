@extends('layouts.master')

@section('title', (isset($summary)) ? date('F', mktime(0, 0, 0, $summary->month, 10)) . ' Monthly Summary' : 'Monthly Summary' )

@section('navbar-type', 'static-top')


@section('content')
    @if(!isset($summary))
        <script>
            $(document).ready(function () {
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
                $('#find').click(function () {
                    window.location = "{{route('summaries.monthly.home')}}/" + $(".yearSelect").val() + "/" + $(".monthSelect").val();
                });
            });
        </script>
    @endif
    @if(isset($summary))
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>

            google.charts.load('current', {'packages': ['corechart']});


            function drawMinMaxChart() {
                // Some raw data (not necessarily accurate)
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'Day');
                dataTable.addColumn('number', 'Maximum');
                dataTable.addColumn('number', 'Minimum');
                dataTable.addColumn('number', 'Average');

                dataTable.addRows([
                    <?php
                    $i = 1;
                    $str = "";
                    foreach ($dailyObs as $ob) {
                        $str .= "[" . $i . "," . $ob->max . "," . $ob->min . "," . ($ob->max + $ob->min) / 2;

                        if (isset($dailyObs[$i])) {
                            $str .= "],";
                        } else {
                            $str .= "]";
                        }

                        $i++;
                    }
                    echo $str;
                    ?>
                ]);

                dataview = new google.visualization.DataView(dataTable);
                dataview.setColumns([0, 1, 2]);

                var options = {
                    //title : 'Temperature',
                    vAxis: {
                        title: 'Temperature (°F)',
                        viewWindowMode: 'explicit',
                        viewWindow: {
                            max: <?php echo(ceil($summary->highest / 10) * 10) ?>,
                            min: <?php if ($summary->lowest < 0) {
                            echo(floor($summary->lowest / 10) * 10);
                        } else {
                            echo 0;
                        } ?>
                        },
                        gridlines: {
                            count:
                            <?php
                            if ($summary->lowest < 0) {
                                echo ((ceil(($summary->highest - $summary->lowest) / 10) * 10) / 5) + 2;
                            } else {
                                echo((ceil($summary->highest / 10) * 10) / 5);
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
                            foreach ($dailyObs as $ob) {
                                if (!($i & 1)) {
                                    $str .= $i;

                                    if (isset($dailyObs[$i])) {
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
                            visibleInLegend: true
                        },
                        1: {
                            type: 'linear',
                            //degree: 5,
                            visibleInLegend: true
                        }
                    }
                };

                var chart = new google.visualization.ComboChart(document.getElementById('maxmintemp'));
                chart.draw(dataview, options);
            }

            function drawPrecipChart() {
                // Some raw data (not necessarily accurate)
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'Day');
                dataTable.addColumn('number', 'Precipitation');
                dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

                dataTable.addRows([
                    <?php
                    $i = 1;
                    $str = "";
                    foreach ($dailyObs as $ob) {
                        $datestr = $summary->month . "/" . $i . "/" . $summary->year;
                        $tooltip = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . $datestr . "</h4>" . ($ob->precip == -77 ? 'Trace' : $ob->precip) . "</div>";
                        $str .= "[" . $i . "," . (($ob->precip == -77) ? 0.01 : $ob->precip) . ", '" . $tooltip . "'";

                        if (isset($dailyObs[$i])) {
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
                        title: 'Day',
                        ticks: [
                            <?php
                            $i = 1;
                            $str = "";
                            foreach ($dailyObs as $ob) {
                                if (!($i & 1)) {
                                    $str .= $i;

                                    if (isset($dailyObs[$i])) {
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
                    vAxis: {
                        title: 'Precipitation (in.)'
                    },
                    legend: {position: 'none'},
                    chartArea: {top: 5, 'width': '80%', 'height': '90%'},
                    bars: 'vertical',
                    tooltip: {isHtml: true}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('precip'));
                chart.draw(dataTable, options);
            }

            function drawSnowfallChart() {
                // Some raw data (not necessarily accurate)
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'Day');
                dataTable.addColumn('number', 'Snowfall');
                dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

                dataTable.addRows([
                    <?php
                    $i = 1;
                    $str = "";
                    foreach ($dailyObs as $ob) {
                        $datestr = $summary->month . "/" . $i . "/" . $summary->year;
                        $tooltip = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . $datestr . "</h4>" . ($ob->snowfall == -77 ? 'Trace' : $ob->snowfall) . "</div>";
                        $str .= "[" . $i . "," . (($ob->snowfall == -77) ? 0.01 : $ob->snowfall) . ", '" . $tooltip . "'";

                        if (isset($dailyObs[$i])) {
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
                        title: 'Day',
                        ticks: [
                            <?php
                            $i = 1;
                            $str = "";
                            foreach ($dailyObs as $ob) {
                                if (!($i & 1)) {
                                    $str .= $i;

                                    if (isset($dailyObs[$i])) {
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
                    vAxis: {
                        title: 'Snowfall (in.)'
                    },
                    legend: {position: 'none'},
                    chartArea: {top: 5, 'width': '80%', 'height': '90%'},
                    bars: 'vertical',
                    tooltip: {isHtml: true}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('snowfall'));
                chart.draw(dataTable, options);
            }

            function drawSnowDepthChart() {
                // Some raw data (not necessarily accurate)
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'Day');
                dataTable.addColumn('number', 'Snow Depth');
                dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

                dataTable.addRows([
                    <?php
                    $i = 1;
                    $str = "";
                    foreach ($dailyObs as $ob) {
                        $datestr = $summary->month . "/" . $i . "/" . $summary->year;
                        $tooltip = "<div style=\"margin: 5px;\"><h4 style=\"border-bottom: 1px solid grey;\">" . $datestr . "</h4>" . ($ob->snowdepth == -77 ? 'Trace' : $ob->snowdepth) . "</div>";
                        $str .= "[" . $i . "," . (($ob->snowdepth == -77) ? 0.01 : $ob->snowdepth) . ", '" . $tooltip . "'";

                        if (isset($dailyObs[$i])) {
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
                        title: 'Day',
                        ticks: [
                            <?php
                            $i = 1;
                            $str = "";
                            foreach ($dailyObs as $ob) {
                                if (!($i & 1)) {
                                    $str .= $i;

                                    if (isset($dailyObs[$i])) {
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
                    vAxis: {
                        title: 'Snow Depth (in.)'
                    },
                    legend: {position: 'none'},
                    chartArea: {top: 5, 'width': '80%', 'height': '90%'},
                    bars: 'vertical',
                    tooltip: {isHtml: true}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('snowdepth'));
                chart.draw(dataTable, options);
            }

            function viewTextSummary() {
                $('#textSummary').show();
                $('#charts').hide();
                $('#textBtn').attr('disabled', 'disabled');
                $('#chartsBtn').removeAttr('disabled');
            }

            function viewCharts() {
                $('#textSummary').hide();
                $('#charts').show();
                $('#textBtn').removeAttr('disabled');
                $('#chartsBtn').attr('disabled', 'disabled');
                drawMinMaxChart();
                drawPrecipChart();
                drawSnowfallChart();
                drawSnowDepthChart();
            }

            function iframeLoaded() {
                var iFrameID = document.getElementById('textSummaryiFrame');
                if (iFrameID) {
                    // here you can make the height, I delete it first, then I make it again
                    iFrameID.height = "";
                    iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
                }
            }
            $(document).ready(function () {
                $('#textSummaryiFrame').load(function () {
                    iframeLoaded();
                });

                $('#textBtn').attr('disabled', 'disabled');

                $(window).resize(function () {
                    drawMinMaxChart();
                    drawPrecipChart();
                    drawSnowfallChart();
                    drawSnowDepthChart();
                });
            });
        </script>
    @endif
    <div id="" class="container" style="min-height: 650px;">
        @if(!isset($summary))
            <h2 style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #777;">Find Summary</h2>
            <div class="row better-row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="text-align: center">
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
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="text-align: center"
                     placeholder="Select a Year">
                    <select class="yearSelect" style="width: 100%">
                        <?php
                        for ($i = 2011; $i <= date("Y"); $i++) {
                            echo "<option value=\"" . $i . "\">" . $i . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="text-align: center; margin-bottom: 5px;">
                    <input type="button" id="find" class="btn btn-success" style="width: 100%" value="Find Summary"/>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                     style="min-height: 5px; border-top: 1px solid grey;"></div>
            </div>
        @endif
        @if(isset($summary))
            <div class="row better-row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left">
                    <h1>{{date('F', mktime(0, 0, 0, $summary->month, 10))}} {{$summary->year}} Monthly Summary</h1>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                     style="min-height: 5px; border-top: 1px solid grey;"></div>
                <div id="summaryBtns" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                     style="text-align: left; margin-bottom:5px;">
                    <a href="{{route('summaries.monthly.home')}}" class="btn btn-info"><span
                                class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp; Back</a>
                    <a href="#" id="textBtn" onclick="viewTextSummary()" class="btn btn-primary"><span
                                class="glyphicon glyphicon-font" aria-hidden="true"></span>&nbsp; View Text Summary</a>
                    <a href="#" id="chartsBtn" onclick="viewCharts()" class="btn btn-primary"><span
                                class="glyphicon glyphicon-signal" aria-hidden="true"></span>&nbsp; View Charts</a>
                    <a href="{{route('summaries.monthly.text', ['year' => $summary->year, 'month' => $summary->month])}}"
                       target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"
                                                                     aria-hidden="true"></span>&nbsp; Open Text Summary</a>
                    <a href="{{route('summaries.monthly.csv', ['year' => $summary->year, 'month' => $summary->month])}}"
                       class="btn btn-primary"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>&nbsp;
                        Download CSV</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRemarks">
                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Edit Remarks
                    </button>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                     style="min-height: 5px; border-top: 1px solid grey;"></div>
                <div id="charts" style="display:none;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                        <h2>
                            <?php echo date('F', mktime(0, 0, 0, $summary->month, 10)) . " " . $summary->year; ?> <br>
                            Daily Maximum & Minimum Temperatures (°F) <br>
                            West Hampstead, NH
                        </h2>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                        <div id="maxmintemp" style="width: 100%; min-height: 555px;"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                        <h2>Daily Precipitation (in.)</h2>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                        <div id="precip" style="width: 100%; min-height: 555px;"></div>
                    </div>
                    @if(in_array($summary->month, array(10,11,12,1,2,3,4)))
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                            <h2>Daily Snowfall (in.)</h2>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                            <div id="snowfall" style="width: 100%; min-height: 555px;"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                            <h2>Daily Snow Depth (in.)</h2>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
                            <div id="snowdepth" style="width: 100%; min-height: 555px;"></div>
                        </div>
                    @endif
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                         style="text-align: left; min-height: 20px;"></div>
                </div>
                <div id="textSummary">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <iframe id="textSummaryiFrame" style="width:100%; border:none;"
                                src="{{route('summaries.monthly.text', ['year' => $summary->year, 'month' => $summary->month])}}"></iframe>
                    </div>
                </div>
                <div id="editRemarks" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Remarks</h4>
                            </div>
                            <form action="{{route('summaries.monthly.editRemarks', ['year' => $summary->year, 'month' => $summary->month])}}"
                                  method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <div class="modal-body">
                                    <textarea name="remarks" rows="10" cols="70" style="margin-bottom: 10px;"
                                              class="form-control">{{ $summary->remarks }}</textarea>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Enter Password"/>
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
