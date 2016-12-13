@extends('layouts.master')

@section('title', 'Weather Events')

@section('navbar-type', 'static-top')


@section('content')
  <div class="container" style="min-height: 650px;">
  @if(!empty($photos))
    <script>
    $(document).ready(function (){
      $('#carousel-example-generic').carousel();
    });
    </script>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Indicators-->
      <ol class="carousel-indicators">
        <?php
          $i = 0;
          foreach($photos as $photo){
            if($i == 0){
              echo "<li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>";
            } else {
              echo "<li data-target=\"#carousel-example-generic\" data-slide-to=\"1\"></li>";
            }
            $i++;
          }
        ?>
      </ol>


        <div class="carousel-inner" role="listbox">
          <?php
            $i = 0;
            $str = "";
            foreach($photos as $photo){
              if($i == 0){
                $str .= "<div class=\"item active\">";
              } else {
                $str .= "<div class=\"item\">";
              }
              $str .= "  <img alt=\"West Hampstead\" src=\"" . asset($photo->url) . "\" style=\"margin-right:0px; display: inline;\"  />";
              $str .= "  <div class=\"carousel-caption\">";
              $str .= "    <h3>". $photo->caption ."</h3>";
              $str .= "  </div>";
              $str .= "</div>";

              $i++;
            }
            echo $str;
          ?>
        </div>


      <!-- Controls-->
      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  @endif
</div>
@endsection
