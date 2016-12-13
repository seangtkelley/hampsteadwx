@extends('layouts.master')

@section('title', 'Precipitation Summary' )

@section('navbar-type', 'static-top')

@section('content')
    <div id="" class="container" style="min-height: 650px;">
        <h3 style="text-align: center;">Precipitation Summary</h3>
        <table class="table-striped" style="width: 100%;">
            <tr>
                <th>Year</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
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