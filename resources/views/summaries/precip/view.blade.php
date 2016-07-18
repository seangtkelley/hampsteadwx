@extends('layouts.master')

@section('title', 'Precipitation Summary' )

@section('navbar-type', 'static-top')

@section('content')
    <div id="" class="container" style="min-height: 650px;">
        <h3 style="text-align: center;">Precipitation Summary</h3>
        <table class="table table-striped">
            <tr>
                <th>Year</th>
                <th>January</th>
                <th>February</th>
                <th>March</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>August</th>
                <th>September</th>
                <th>October</th>
                <th>November</th>
                <th>December</th>
            </tr>
            <?php
                $str = "";
                $i = 0;
                foreach ($summaries as $summary){
                    if($i == 0){
                        $str .= "<tr>";
                        $str .= "<td>" . $summary->year . "</td>";
                        $str .= "<td>";
                        $str .= $summary->total_precip;
                        $str .= "</td>";
                    } else if($summary->month == 1){
                        $str .= "</tr>";
                        echo $str;
                        $str = "";
                        $str .= "<tr>";
                        $str .= "<td>" . $summary->year . "</td>";
                        $str .= "<td>";
                        $str .= $summary->total_precip;
                        $str .= "</td>";
                    } else {
                        $str .= "<td>";
                        $str .= $summary->total_precip;
                        $str .= "</td>";
                    }
                    $i++;
                }
                echo $str;
            ?>
        </table>
    </div>
@endsection