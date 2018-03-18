@extends('layouts.app')
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
@section('content')
    <section class="content-header">
        <h1>
            Distance
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
        <svg></svg>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('distances.show_fields')
                    <a href="{!! route('distances.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">


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

       // close the polygon to create a shape
       var route = {
                    type: "LineString",
                    coordinates: [
                    [{!! $distance->startPort->longitude!!},{!! $distance->startPort->latitude!!}],
                    [{!! $distance->endPort->longitude!!},{!! $distance->endPort->latitude!!}]
                    ]};
                 svg.append("path")
                 .datum(route)
                 .attr("class", "route")
                 .attr("d", path);
         };

</script>
@endsection
