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
<div class="box-primary">
	<h1>Cargo Maps</h1>
	<svg></svg>
</div>
  <script src="http://d3js.org/d3.v3.min.js"></script>
   <script src="http://d3js.org/topojson.v1.min.js"></script>
   <script src="http://d3js.org/queue.v1.min.js"></script>

<script type="text/javascript">
var cargos = getCargos(); 

      var width = 960,
      height = 960;

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

         cargos.forEach(function(d) { 
            var route = {
                    type: "LineString",
                    coordinates: [
                    [d.lPortLongitude,d.lPortLatitude],
                    [d.dPortLongitude,d.dPortLatitude]
                    ]};
                 svg.append("path")
                 .datum(route)
                 .attr("class", "route")
                 .attr("d", path);

                svg.append("text")
                .attr("class", "labels")
                .text(d.name +" "+ d.count)
                .attr("x", projection(d.lPortLongitude))
                .attr("y", projection(d.lPortLatitude));
         });

        

      }

function getCargos(){

  return  {!!$cargos!!};
}
</script>
@endsection