@extends('layouts.raw')

@section('title', 'Monthly Summary')

@section('content')
  <div class="container" style="min-height: 500px;">

    @if(isset($summary))
      <div class="row betterRow">
        Month: {{ $summary->month }} <br>
        Year: {{ $summary->year }} <br>
        Max: {{ $summary->max_avg }} <br>
        Min: {{ $summary->min_avg }} <br>
        Avg: {{ $summary->avg }} <br>
      </div>
    @endif

  </div>
@endsection
