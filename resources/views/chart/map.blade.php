@extends('layouts.app')

@section('content')
<div class="box-primary">
	<h1>{!!$title!!}</h1>
	<svg width="960" height="500"></svg>
</div>
<script src="https://d3js.org/d3.v4.min.js"></script>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://d3js.org/topojson.v1.min.js"></script>
<script>
var width = 1200,
    height = 720;
var projection = d3.geo.mercator()
    .scale(8000)
    .precision(.1)
    .center([13.320255,52.52831499])
    .translate([width / 2, height / 2])
var path = d3.geo.path()
    .projection(projection);
var graticule = d3.geo.graticule();
var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height);
svg.append("path")
    .datum(graticule)
    .attr("class", "graticule")
    .attr("d", path);
d3.json("world-50m.json", function(error, world) {
  svg.insert("path", ".graticule")
      .datum(topojson.feature(world, world.objects.land))
      .attr("class", "land")
      .attr("d", path);
  svg.insert("path", ".graticule")
      .datum(topojson.mesh(world, world.objects.countries, function(a, b) { return a !== b; }))
      .attr("class", "boundary")
      .attr("d", path);
});
d3.json("stops_berlin.geojson", function(error, data) {
  // using d3.geo.path() which does all the work for you
  svg.append("path")
    .datum(data)
    .classed("geopath", true)
    .attr("d", path)
});

d3.select(self.frameElement).style("height", height + "px");
  

</script>
@endsection