<div id="footer" class="footer">
  <script>
    $(document).ready(function (){
      if(($("#main-content").height() + $("#footer").height() + $(".navbar").height()) < $(window).height()){
        $("#main-content").height($(window).height()-$("#footer").height()-$(".navbar").height());
      }

      $(window).resize(function (){
        if(($("#main-content").height() + $("#footer").height() + $(".navbar").height()) < $(window).height()){
          $("#main-content").height($(window).height()-$("#footer").height()-$(".navbar").height());
        }
      });
    });
  </script>
  <div class="row better-row">
    <div class="col-md-12 col-lg-12" style="text-align: center; padding-left: 0px; padding-right: 0px">
      <div class="well" style="margin-bottom: 0px; border: none;">
        <div class="row better-row">
          <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2" style="text-align: center">
            <h4 class="footer-element">Observations</h4>
            <ul class="footer-element">
              <li><a href="http://www.nws.noaa.gov/view/validProds.php?prod=HYD&amp;node=KGYX" target="_blank">Daily</a></li>
              <li><a href="http://www.nohrsc.noaa.gov/interactive/html/graph.html?station=HMPN3" target="_blank">Weekly</a></li>
              <li><a href="http://mesonet.agron.iastate.edu/sites/plot.php?prod=0&station=HMPN3&network=NH_COOP" target="_blank">Max/Min Temps for Past 7 Days</a></li>
              <li><a href="http://mesonet.agron.iastate.edu/sites/plot.php?prod=1&station=HMPN3&network=NH_COOP" target="_blank">Max/Min Temps for Present Month</a></li>
            </ul>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
            <h4 class="footer-element">Summaries</h4>
            <ul class="footer-element">
              <li><a href="{{route('summaries.monthly.home')}}">Monthly</a></li>
              <li><a href="{{route('summaries.annual.home')}}">Annual</a></li>
              <li><a href="{{route('summaries.snowseason.view')}}">Snow Season</a></li>
              <li><a href="{{route('summaries.sunsetlake.view')}}">Sunset Lake: Ice In/Ice Out</a></li>
              <li><a href="{{route('summaries.peakfoliage.view')}}">Peak Foliage</a></li>
            </ul>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
            <h4 class="footer-element">Events</h4>
            <ul class="footer-element">
              <li><a href="{{route('events.home')}}">All Events</a></li>
            </ul>
          </div>
          <div class="col-xs-6 col-sm-6 col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <h4 class="footer-element">Normals</h4>
            <ul class="footer-element">
              <li><a href="{{route('normals')}}">All Normals</a></li>
            </ul>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
            <h4 class="footer-element">Info</h4>
            <ul class="footer-element">
              <li><a href="{{route('info')}}">All Info</a></li>
            </ul>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
            <h4 class="footer-element">Photos</h4>
            <ul class="footer-element">
              <li><a href="{{route('photos.home')}}">All Photos</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!--<div class="col-md-1 col-lg-1">

    </div>-->
  </div>
</div>
