@extends('layouts.raw')

@section('title', $year . ' Annual Summary')

@section('content')
    <h3>NWS COOPERATIVE CLIMATE STATION, WEST HAMPSTEAD, NH</h3>
    <h4>{{ $year }} Annual Summary</h4>
    <table class="table">
        <tr>
            <th>Month</th>
            <th>Avg. Max</th>
            <th>Avg. Min</th>
            <th>Avg.</th>
            <th>Dep.</th>
            <th>Highest</th>
            <th>Date</th>
            <th>Lowest</th>
            <th>Date</th>
            <th colspan="4">Number of Days w/</th>
            <th>Total Precip.</th>
            <th>Dep.</th>
            <th>Greatest Day</th>
            <th>Date</th>
            <th>Total Snowfall</th>
            <th>Dep.</th>
            <th>Greatest Day</th>
            <th>Date</th>
            <th>Greatest Storm</th>
            <th>Date</th>
            <th>Greatest Depth</th>
            <th>Date</th>
            <th>Fog</th>
            <th>Ice Pel</th>
            <th>Glaze</th>
            <th>Th</th>
            <th>Hail</th>
            <th>Dam Wind</th>
        </tr>
        <tr>
            <th colspan="9" style="border: none;"></th>
            <th style="border: none;">>=90</th>
            <th style="border: none;"><=32</th>
            <th style="border: none;"><=32</th>
            <th style="border: none;"><=0</th>
            <th colspan="18" style="border: none;"></th>
        </tr>
        @foreach ($monthlyObs as $ob)
            <tr>
                <td>{{substr(date('F', mktime(0, 0, 0, $ob->month, 10)), 0, 3)}}</td>
                <td>{{$ob->max_avg}}</td>
                <td>{{$ob->min_avg}}</td>
                <td>{{$ob->avg}}</td>
                <td>{{$ob->depart_temp_avg}}</td>
                <td>{{$ob->highest}}</td>
                <td><?php $temp = explode(",", $ob->highest_dates); echo end($temp); ?></td>
                <td>{{$ob->lowest}}</td>
                <td><?php $temp = explode(",", $ob->lowest_dates); echo end($temp); ?></td>
                <td>{{$ob->max_over90}}</td>
                <td>{{$ob->max_below32}}</td>
                <td>{{$ob->min_below32}}</td>
                <td>{{$ob->min_below0}}</td>
                <td>{{$ob->total_precip}}</td>
                <td>{{$ob->total_precip - $avg_precip_array[$ob->month - 1]}}</td>
                <td>{{$ob->grts_precip}}</td>
                <td><?php $temp = explode(",", $ob->grts_precip_dates); echo end($temp); ?></td>
                <td>{{$ob->total_sf}}</td>
                <td>{{$ob->total_sf - $avg_snfl_array[$ob->month - 1]}}</td>
                <td>{{$ob->grts_sf}}</td>
                <td><?php $temp = explode(",", $ob->grts_sf_dates); echo end($temp); ?></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>{{$ob->grts_sd}}</td>
                <td><?php $temp = explode(",", $ob->grts_sd_dates); echo end($temp); ?></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
        @endforeach
        <tr>
            <td>Annual</td>
            <td>{{$MxA_str}}</td>
            <td>{{$MnA_str}}</td>
            <td>{{$A_str}}</td>
            <td>{{$depart_temp_avg_str}}</td>
            <td>{{$highest}}</td>
            <td>{{end($highest_dates)}}</td>
            <td>{{$lowest}}</td>
            <td>{{end($lowest_dates)}}</td>
            <td>{{$max_over90}}</td>
            <td>{{$max_below32}}</td>
            <td>{{$min_below32}}</td>
            <td>{{$min_below0}}</td>
            <td>{{$total_precip}}</td>
            <td>{{$depart_precip_avg_str}}</td>
            <td>{{$grts_precip}}</td>
            <td>{{end($grts_precip_dates)}}</td>
            <td>{{$total_sf}}</td>
            <td>{{$depart_snfl_avg_str}}</td>
            <td>{{$grts_sf}}</td>
            <td>{{end($grts_sf_dates)}}</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>{{$grts_sd}}</td>
            <td>{{end($grts_sd_dates)}}</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
        </tr>
    </table>
@endsection