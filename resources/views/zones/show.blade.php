@extends('layouts.app')
@section('css')
<style>

   .graticule {
      fill: none;
      stroke: #777;
      stroke-opacity: .5;
      stroke-width: .5px;
   }

   .land {
      fill: #222;
   }

   .boundary {
      fill: none;
      stroke: #fff;
      stroke-width: .5px;
   }

   .route {
      fill: none;
      stroke: red;
      stroke-width: 1px;
   }

    .labels {
        fill: #f00;
        font-family:arial;
        font-size:1em;
        font-weight: bold;
    }
</style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Zone
        </h1>
    </section>
    <svg></svg>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('zones.show_fields')
                    <h1>Zone Point</h1>
                    <h1 class="pull-right">
                       <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('zonePoints.create') !!}">Add Zone Points</a>
                    </h1>
                    @foreach($zone->zonePoints() as $point)
                        <p>latitude: <b>{{$point->latitude}}</b></p>
                        <p>longitude: <b>{{$point->longitude}}</b></p>
                    @endforeach
                    <a href="{!! route('zones.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>

  <script src="http://d3js.org/d3.v3.min.js"></script>
   <script src="http://d3js.org/topojson.v1.min.js"></script>
   <script src="http://d3js.org/queue.v1.min.js"></script>

<script type="text/javascript">
var zonePoints = getZonePoints(); 

      var width = 480,
      height = 480;

      var projection = d3.geo.mercator()
      .scale((width + 1) / 2 / Math.PI)
      .translate([width / 2, height / 2]).precision(.1);

      var path = d3.geo.path()
      .projection(projection);

      var graticule = d3.geo.graticule();

      var svg = d3.select("svg")
      .attr("width", width)
      .attr("height", height);

      queue()
      .defer(d3.json, "{!!asset('world-50m.json')!!}")
      .await(ready);
function ready(error, world) {

         svg.append("path")
         .datum(graticule)
         .attr("class", "graticule")
         .attr("d", path);

         svg.insert("path", ".graticule")
         .datum(topojson.feature(world, world.objects.land))
         .attr("class", "land")
         .attr("d", path);

         svg.insert("path", ".graticule")
         .datum(topojson.mesh(world, world.objects.countries, function(a, b) { return a !== b; }))
         .attr("class", "boundary")
         .attr("d", path);


         d3.select(self.frameElement).style("height", height + "px");

       
        for(var i=0, len=zonePoints.length-1; i<len; i++){ 
            var route = {
                    type: "LineString",
                    coordinates: [
                    [zonePoints[i].longitude,zonePoints[i].latitude],
                    [zonePoints[i+1].longitude,zonePoints[i+1].latitude]
                    ]};
                 svg.append("path")
                 .datum(route)
                 .attr("class", "route")
                 .attr("d", path);
         };

        // close the polygon to create a shape
        var route = {
                    type: "LineString",
                    coordinates: [
                    [zonePoints[0].longitude,zonePoints[0].latitude],
                    [zonePoints[zonePoints.length-1].longitude,zonePoints[zonePoints.length-1].latitude]
                    ]};
                 svg.append("path")
                 .datum(route)
                 .attr("class", "route")
                 .attr("d", path);
      }



function getZonePoints(){

  return  {!!$zone->zonePoints->toJson()!!};
}
</script>
@endsection
