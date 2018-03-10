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
      stroke: blue;
      stroke-width: 1px;
   }

</style>
@endsection
@section('content')
<div class="box-primary">
  <svg width="960" height="600"></svg>

  Result for: <br/>
  <b>Cargo:</b> {{$cargo->quantity}} {{$cargo_name}} from {{$port_start_name}} to {{$port_end_name}} (Status: ) [ID {{$cargo->id}}] <br/>
  <b>Ship:</b> {{$ship->name}} [ID {{$ship->id}}] <br/>
  <b>Start-Port:</b> {{$port_ship->name}} [ID {{$port_ship->id}}]<br/>
  <b>Date:</b> {{$date->format('m/d/Y')}}<br/>
  <br/>
  <br/>
</div>
<div class="box-primary col-sm-6" style="height:240px;">
 <div class="voyage_box_title">Ship</div>
 <table style="min-width:300px">
  <tr>
    <th>Name:</th>
    <td style="text-align:right">{{$ship->name}}</td> 
  </tr>
  <tr>
    <th>Imo:</th>
    <td style="text-align:right">{{$ship->imo}}</td> 
  </tr>
  <tr>
    <th>DWCC:</th>
    <td style="text-align:right">{{number_format($ship->dwcc,0)}}</td> 
  </tr>
  <tr>
    <th>Max Holds Capacity:</th>
    <td style="text-align:right">{{number_format($ship->max_holds_capacity,0)}}</td> 
  </tr>
  <tr>
    <th>Ballast Draft</th>
    <td style="text-align:right">{{$ship->ballast_draft}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td style="text-align:right">{{$ship->max_laden_draft}}</td> 
  </tr>
  <tr>
    <th>Speed Laden:</th>
    <td style="text-align:right">{{number_format($ship->speed_laden,1)}}</td> 
  </tr>
  <tr>
    <th>Speed Ballast:</th>
    <td style="text-align:right">{{number_format($ship->speed_ballast,1)}}</td> 
  </tr>
  <tr>
    <th>Fuel Type:</th>
    <td style="text-align:right">{{$ship_fuel_type}}</td> 
  </tr>
  <tr>
    <th>Fuel Cons. at Sea:</th>
    <td style="text-align:right">{{number_format($ship->fuel_consumption_at_sea,1)}}</td> 
  </tr>
  <tr>
    <th>Fuel Cons. in Port:</th>
    <td style="text-align:right">{{number_format($ship->fuel_consumption_in_port,1)}}</td> 
  </tr>
</table>
</div>


<div class="box-primary col-sm-6" style="height:240px;">
 <div class="voyage_box_title">Cargo</div>
 <table style="min-width:300px">
  <tr>
    <th>Cargo:</th>
    <td style="text-align:right">{{$cargo_name}}</td> 
  </tr>
  <tr>
    <th>Quantity:</th>
    <td style="text-align:right">{{$cargo->quantity}}</td> 
  </tr>
  <tr>
    <th>StowageFactor:</th>
    <td style="text-align:right">{{$cargo_stowage[0]}} {{$cargo_stowage[1]}}</td> 
  </tr>
  <tr>
    <th>LayCanFirst:</th>
    <td style="text-align:right">{{$laycan_first_day}}</td> 
  </tr>
  <tr>
    <th>LayCanLast:</th>
    <td style="text-align:right">{{$laycan_last_day}}</td> 
  </tr>
  <tr>
    <th>Commission:</th>
    <td style="text-align:right">{{$cargo->commission}} %</td> 
  </tr>

</table>
</div>

<div class="box-primary col-sm-6" style="height:180px;">
 <div class="voyage_box_title">Start Port</div>
 <table style="min-width:300px">
  <tr>
    <th>Name:</th>
    <td style="text-align:right">{{$port_start_name}}</td> 
  </tr>
  <tr>
    <th>Zone:</th>
    <td style="text-align:right">{{$port_start_zone}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td style="text-align:right">{{$port_start_max_laden_draft}}</td> 
  </tr>
  <tr>
    <th>Draft Factor:</th>
    <td style="text-align:right">{{$port_start_draft_factor}}</td> 
  </tr>
  <tr>
    <th>Load/Disch Rate:</</th>
    <td style="text-align:right">{{number_format($cargo->loading_rate,0)}}</td> 
  </tr>
  <tr>
    <th>Rate Type</th>
    <td style="text-align:right">{{$port_start_rate_type}}</td> 
  </tr>
  <tr>
    <th>Rate Factor</th>
    <td style="text-align:right">{{number_format($port_start_rate_factor,2)}}</td> 
  </tr>
  <tr>
    <th>Fee</th>
    <td style="text-align:right">{{number_format($port_fee_load,0)}} $</td> 
  </tr>

</table>
</div>

<div class="box-primary col-sm-6" style="height:180px;">
 <div class="voyage_box_title">End Port</div>
 <table style="min-width:300px">
  <tr>
    <th>Name:</th>
    <td style="text-align:right">{{$port_end_name}}</td> 
  </tr>
  <tr>
    <th>Zone:</th>
    <td style="text-align:right">{{$port_end_zone}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td style="text-align:right">{{$port_end_max_laden_draft}}</td> 
  </tr>
  <tr>
    <th>Draft Factor:</th>
    <td style="text-align:right">{{$port_end_draft_factor}}</td> 
  </tr>
  <tr>
    <th>Load/Disch Rate:</th>
    <td style="text-align:right">{{number_format($cargo->discharging_rate,0)}}</td> 
  </tr>
  <tr>
    <th>Rate Type</th>
    <td style="text-align:right">{{$port_end_rate_type}}</td> 
  </tr>
  <tr>
    <th>Rate Factor</th>
    <td style="text-align:right">{{number_format($port_end_rate_factor,2)}}</td> 
  </tr>
  <tr>
    <th>Fee</th>
    <td style="text-align:right">{{number_format($port_fee_disch,0) }} $</td> 
  </tr>

</table>
</div>

<div class="box-primary col-sm-6" style="height:180px;">
 <div class="voyage_box_title"style="height:20px;">Calculation </div>
 <table style="min-width:300px">

  <tr>
    <th>Distance to Start:</th>
    <td style="text-align:right">{{number_format($distance_to_start,2) }}</td> 
  </tr>
  <tr>
    <th>Distance Start to End:</th>
    <td style="text-align:right">{{number_format($distance_cargo,2)}}</td> 
  </tr>
  <tr>
    <th>Distance Total:</th>
    <td style="text-align:right">{{number_format($distance_sum,2)}}</td> 
  </tr>
  <tr>
    <th>Days to Start:</th>
    <td style="text-align:right">{{number_format($travel_time_to_start,2)}}</td> 
  </tr>
  <tr>
    <th>Days Start to End:</th>
    <td style="text-align:right">{{number_format($travel_time_cargo,2)}}</td> 
  </tr>
  <tr>
    <th>Port Time:</th>
    <td style="text-align:right">{{number_format($port_time_sum,2)}}</td> 
  </tr>
  <tr>
    <th>Voyage Time	:</th>
    <td style="text-align:right">{{number_format($voyage_time,2)}}</td> 
  </tr>

</table>
</div>

<div class="box-primary col-sm-6" style="height:190px;">
  <div class="voyage_box_title" style="height:20px;"></div>
  <table style="min-width:300px">
    <tr>
      <th>BDI Name:</th>
      <td style="text-align:right">{{$bdi_code}}</td> 
    </tr>
    <tr>
      <th>BDI Price:</th>
      <td style="text-align:right">{{number_format($bdi,0)}} $</td> 
    </tr>
    <tr>
      <th>Fuel Price:</th>
      <td style="text-align:right">{{$fuel_price}} $</td> 
    </tr>
    <tr>
      <th>Consumption:</th>
      <td style="text-align:right">{{number_format($fuel_consumption,2)}}</td> 
    </tr>
    <tr>
      <th>Fuel Costs:</th>
      <td style="text-align:right">{{number_format($fuel_costs,2)}} $</td> 
    </tr>
    <tr>
      <th>Non Hire Costs:</th>
      <td style="text-align:right">{{number_format($non_hire_costs,2)}} $</td> 
    </tr>
    <tr>
     <th></br></th>
     <td> </td>
   </tr>
   <tr>
    <th>Gross Rate:</th>
    <td style="text-align:right">{{number_format($gross_rate,2)}} $</td> 
  </tr>
  <tr>
    <th>NTCE:</th>
    <td style="text-align:right">{{number_format($ntce,0)}} $</td> 
  </tr>
</table>
</div>

@endsection
@section('script')
<script src="http://d3js.org/d3.v4.min.js" charset="utf-8"></script>
<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
<script src="http://d3js.org/topojson.v1.min.js"></script>

<script type="text/javascript">
var countries = getCountries(); 

      var width = 960,
      height = 960;

      var projection = d3.geo.mercator()
      .scale((width + 1) / 2 / Math.PI)
      .translate([width / 2, height / 2])
      .precision(.1);

      var path = d3.geo.path()
      .projection(projection);

      var graticule = d3.geo.graticule();

      var svg = d3.select("svg")
      .attr("width", width)
      .attr("height", height);

      queue()
      .defer(d3.json, "http://bl.ocks.org/mbostock/raw/4090846/world-50m.json")
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

         //render the points
         countries.features.forEach(function(d) { 
            var x = projection(d.geometry.coordinates)[0];
            var y = projection(d.geometry.coordinates)[1];

            svg.append("svg:circle")
            .attr("class","point")
            .attr("cx", x)
            .attr("cy", y)
            .attr("fill", "#FF0000")
            .attr("r", 3)

         });

         d3.select(self.frameElement).style("height", height + "px");

         var features = countries.features;
         for(var i=240; i<features.length-2; i++) {
            if(features[i].geometry.coordinates[0] < features[i+1].geometry.coordinates[0]){
               var route = {
                  type: "LineString",
                  coordinates: [
                  features[i].geometry.coordinates,
                  features[i+1].geometry.coordinates
                  ]
               };
               svg.append("path")
               .datum(route)
               .attr("class", "route")
               .attr("d", path);
            }

         }

      }

function getCountries(){return{"type":"FeatureCollection","features":[{"type":"Feature","id":"0","geometry":{"type":"Point","coordinates":["1.52109","42.50779"],"properties":{"name":"Andorra","countryCode":"AD"}}},{"type":"Feature","id":"1","geometry":{"type":"Point","coordinates":["55.30472","25.25817"],"properties":{"name":"United Arab Emirates","countryCode":"AE"}}},{"type":"Feature","id":"2","geometry":{"type":"Point","coordinates":["69.17233","34.52813"],"properties":{"name":"Afghanistan","countryCode":"AF"}}},{"type":"Feature","id":"3","geometry":{"type":"Point","coordinates":[-63.0578327178955,18.2170409282136],"properties":{"name":"Anguilla","countryCode":"AI"}}},{"type":"Feature","id":"4","geometry":{"type":"Point","coordinates":["-61.85","17.11667"],"properties":{"name":"Antigua and Barbuda","countryCode":"AG"}}},{"type":"Feature","id":"5","geometry":{"type":"Point","coordinates":["19.81889","41.3275"],"properties":{"name":"Albania","countryCode":"AL"}}},{"type":"Feature","id":"6","geometry":{"type":"Point","coordinates":["44.51361","40.18111"],"properties":{"name":"Armenia","countryCode":"AM"}}},{"type":"Feature","id":"7","geometry":{"type":"Point","coordinates":["13.23432","-8.83682"],"properties":{"name":"Angola","countryCode":"AO"}}},{"type":"Feature","id":"8","geometry":{"type":"Point","coordinates":["-58.37723","-34.61315"],"properties":{"name":"Argentina","countryCode":"AR"}}},{"type":"Feature","id":"9","geometry":{"type":"Point","coordinates":[-85.5,-78.1666667],"properties":{"name":"Antarctica","countryCode":"AQ"}}},{"type":"Feature","id":"10","geometry":{"type":"Point","coordinates":["-170.7025","-14.27806"],"properties":{"name":"American Samoa","countryCode":"AS"}}},{"type":"Feature","id":"11","geometry":{"type":"Point","coordinates":["16.37208","48.20849"],"properties":{"name":"Austria","countryCode":"AT"}}},{"type":"Feature","id":"12","geometry":{"type":"Point","coordinates":["115.8614","-31.95224"],"properties":{"name":"Australia","countryCode":"AU"}}},{"type":"Feature","id":"13","geometry":{"type":"Point","coordinates":["-70.02703","12.52398"],"properties":{"name":"Aruba","countryCode":"AW"}}},{"type":"Feature","id":"14","geometry":{"type":"Point","coordinates":[19.9348050355911,60.0972557714159],"properties":{"name":"Åland","countryCode":"AX"}}},{"type":"Feature","id":"15","geometry":{"type":"Point","coordinates":["49.89201","40.37767"],"properties":{"name":"Azerbaijan","countryCode":"AZ"}}},{"type":"Feature","id":"16","geometry":{"type":"Point","coordinates":["18.35644","43.84864"],"properties":{"name":"Bosnia and Herzegovina","countryCode":"BA"}}},{"type":"Feature","id":"17","geometry":{"type":"Point","coordinates":["-59.61667","13.1"],"properties":{"name":"Barbados","countryCode":"BB"}}},{"type":"Feature","id":"18","geometry":{"type":"Point","coordinates":["90.40744","23.7104"],"properties":{"name":"Bangladesh","countryCode":"BD"}}},{"type":"Feature","id":"19","geometry":{"type":"Point","coordinates":[4.34878349304199,50.8504450552593],"properties":{"name":"Belgium","countryCode":"BE"}}},{"type":"Feature","id":"20","geometry":{"type":"Point","coordinates":["-1.53388","12.36566"],"properties":{"name":"Burkina Faso","countryCode":"BF"}}},{"type":"Feature","id":"21","geometry":{"type":"Point","coordinates":["23.32415","42.69751"],"properties":{"name":"Bulgaria","countryCode":"BG"}}},{"type":"Feature","id":"22","geometry":{"type":"Point","coordinates":["50.5832","26.21536"],"properties":{"name":"Bahrain","countryCode":"BH"}}},{"type":"Feature","id":"23","geometry":{"type":"Point","coordinates":["29.3644","-3.3822"],"properties":{"name":"Burundi","countryCode":"BI"}}},{"type":"Feature","id":"24","geometry":{"type":"Point","coordinates":[2.60358810424805,6.49646462064073],"properties":{"name":"Benin","countryCode":"BJ"}}},{"type":"Feature","id":"25","geometry":{"type":"Point","coordinates":["-62.84978","17.89618"],"properties":{"name":"Saint Barthélemy","countryCode":"BL"}}},{"type":"Feature","id":"26","geometry":{"type":"Point","coordinates":["-64.77797","32.29149"],"properties":{"name":"Bermuda","countryCode":"BM"}}},{"type":"Feature","id":"27","geometry":{"type":"Point","coordinates":["114.94806","4.94029"],"properties":{"name":"Brunei","countryCode":"BN"}}},{"type":"Feature","id":"28","geometry":{"type":"Point","coordinates":["-65.26274","-19.03332"],"properties":{"name":"Bolivia","countryCode":"BO"}}},{"type":"Feature","id":"29","geometry":{"type":"Point","coordinates":[-68.266667,12.15],"properties":{"name":"Bonaire","countryCode":"BQ"}}},{"type":"Feature","id":"30","geometry":{"type":"Point","coordinates":["-46.63611","-23.5475"],"properties":{"name":"Brazil","countryCode":"BR"}}},{"type":"Feature","id":"31","geometry":{"type":"Point","coordinates":["-77.34306","25.05823"],"properties":{"name":"Bahamas","countryCode":"BS"}}},{"type":"Feature","id":"32","geometry":{"type":"Point","coordinates":["89.64191","27.46609"],"properties":{"name":"Bhutan","countryCode":"BT"}}},{"type":"Feature","id":"33","geometry":{"type":"Point","coordinates":["3.35278","-54.40917"],"properties":{"name":"Bouvet Island","countryCode":"BV"}}},{"type":"Feature","id":"34","geometry":{"type":"Point","coordinates":[25.908594131469727,-24.65450599548674],"properties":{"name":"Botswana","countryCode":"BW"}}},{"type":"Feature","id":"35","geometry":{"type":"Point","coordinates":["27.56667","53.9"],"properties":{"name":"Belarus","countryCode":"BY"}}},{"type":"Feature","id":"36","geometry":{"type":"Point","coordinates":["-88.19756","17.49952"],"properties":{"name":"Belize","countryCode":"BZ"}}},{"type":"Feature","id":"37","geometry":{"type":"Point","coordinates":["-73.58781","45.50884"],"properties":{"name":"Canada","countryCode":"CA"}}},{"type":"Feature","id":"38","geometry":{"type":"Point","coordinates":["96.82251","-12.15681"],"properties":{"name":"Cocos [Keeling] Islands","countryCode":"CC"}}},{"type":"Feature","id":"39","geometry":{"type":"Point","coordinates":[15.308074951171875,-4.321420378994415],"properties":{"name":"Democratic Republic of the Congo","countryCode":"CD"}}},{"type":"Feature","id":"40","geometry":{"type":"Point","coordinates":["18.55496","4.36122"],"properties":{"name":"Central African Republic","countryCode":"CF"}}},{"type":"Feature","id":"41","geometry":{"type":"Point","coordinates":["15.28318","-4.26613"],"properties":{"name":"Republic of the Congo","countryCode":"CG"}}},{"type":"Feature","id":"42","geometry":{"type":"Point","coordinates":["8.55","47.36667"],"properties":{"name":"Switzerland","countryCode":"CH"}}},{"type":"Feature","id":"43","geometry":{"type":"Point","coordinates":["-5.27674","6.82055"],"properties":{"name":"Ivory Coast","countryCode":"CI"}}},{"type":"Feature","id":"44","geometry":{"type":"Point","coordinates":[-159.775,-21.2077778],"properties":{"name":"Cook Islands","countryCode":"CK"}}},{"type":"Feature","id":"45","geometry":{"type":"Point","coordinates":["-70.64827","-33.45694"],"properties":{"name":"Chile","countryCode":"CL"}}},{"type":"Feature","id":"46","geometry":{"type":"Point","coordinates":["11.51667","3.86667"],"properties":{"name":"Cameroon","countryCode":"CM"}}},{"type":"Feature","id":"47","geometry":{"type":"Point","coordinates":["116.39723","39.9075"],"properties":{"name":"China","countryCode":"CN"}}},{"type":"Feature","id":"48","geometry":{"type":"Point","coordinates":["-74.08175","4.60971"],"properties":{"name":"Colombia","countryCode":"CO"}}},{"type":"Feature","id":"49","geometry":{"type":"Point","coordinates":[-84.0833333,9.9333333],"properties":{"name":"Costa Rica","countryCode":"CR"}}},{"type":"Feature","id":"50","geometry":{"type":"Point","coordinates":["-82.38304","23.13302"],"properties":{"name":"Cuba","countryCode":"CU"}}},{"type":"Feature","id":"51","geometry":{"type":"Point","coordinates":["-23.51254","14.93152"],"properties":{"name":"Cape Verde","countryCode":"CV"}}},{"type":"Feature","id":"52","geometry":{"type":"Point","coordinates":["-68.93354","12.1084"],"properties":{"name":"Curacao","countryCode":"CW"}}},{"type":"Feature","id":"53","geometry":{"type":"Point","coordinates":["105.67912","-10.42172"],"properties":{"name":"Christmas Island","countryCode":"CX"}}},{"type":"Feature","id":"54","geometry":{"type":"Point","coordinates":[33.3666667,35.1666667],"properties":{"name":"Cyprus","countryCode":"CY"}}},{"type":"Feature","id":"55","geometry":{"type":"Point","coordinates":["14.42076","50.08804"],"properties":{"name":"Czechia","countryCode":"CZ"}}},{"type":"Feature","id":"56","geometry":{"type":"Point","coordinates":["13.41053","52.52437"],"properties":{"name":"Germany","countryCode":"DE"}}},{"type":"Feature","id":"57","geometry":{"type":"Point","coordinates":["43.14503","11.58901"],"properties":{"name":"Djibouti","countryCode":"DJ"}}},{"type":"Feature","id":"58","geometry":{"type":"Point","coordinates":["12.56553","55.67594"],"properties":{"name":"Denmark","countryCode":"DK"}}},{"type":"Feature","id":"59","geometry":{"type":"Point","coordinates":[-61.3880825042725,15.3017368927302],"properties":{"name":"Dominica","countryCode":"DM"}}},{"type":"Feature","id":"60","geometry":{"type":"Point","coordinates":["-69.98857","18.50012"],"properties":{"name":"Dominican Republic","countryCode":"DO"}}},{"type":"Feature","id":"61","geometry":{"type":"Point","coordinates":["3.04197","36.7525"],"properties":{"name":"Algeria","countryCode":"DZ"}}},{"type":"Feature","id":"62","geometry":{"type":"Point","coordinates":["-78.52495","-0.22985"],"properties":{"name":"Ecuador","countryCode":"EC"}}},{"type":"Feature","id":"63","geometry":{"type":"Point","coordinates":["24.75353","59.43696"],"properties":{"name":"Estonia","countryCode":"EE"}}},{"type":"Feature","id":"64","geometry":{"type":"Point","coordinates":[31.249666213989258,30.06263141517916],"properties":{"name":"Egypt","countryCode":"EG"}}},{"type":"Feature","id":"65","geometry":{"type":"Point","coordinates":["-13.20315","27.16224"],"properties":{"name":"Western Sahara","countryCode":"EH"}}},{"type":"Feature","id":"66","geometry":{"type":"Point","coordinates":["38.93184","15.33805"],"properties":{"name":"Eritrea","countryCode":"ER"}}},{"type":"Feature","id":"67","geometry":{"type":"Point","coordinates":["-3.70256","40.4165"],"properties":{"name":"Spain","countryCode":"ES"}}},{"type":"Feature","id":"68","geometry":{"type":"Point","coordinates":["38.74689","9.02497"],"properties":{"name":"Ethiopia","countryCode":"ET"}}},{"type":"Feature","id":"69","geometry":{"type":"Point","coordinates":[24.9354457855225,60.1695247444755],"properties":{"name":"Finland","countryCode":"FI"}}},{"type":"Feature","id":"70","geometry":{"type":"Point","coordinates":["178.44149","-18.14161"],"properties":{"name":"Fiji","countryCode":"FJ"}}},{"type":"Feature","id":"71","geometry":{"type":"Point","coordinates":["-57.85","-51.7"],"properties":{"name":"Falkland Islands","countryCode":"FK"}}},{"type":"Feature","id":"72","geometry":{"type":"Point","coordinates":["151.8468","7.45154"],"properties":{"name":"Micronesia","countryCode":"FM"}}},{"type":"Feature","id":"73","geometry":{"type":"Point","coordinates":["-6.77164","62.00973"],"properties":{"name":"Faroe Islands","countryCode":"FO"}}},{"type":"Feature","id":"74","geometry":{"type":"Point","coordinates":[2.3488,48.85341],"properties":{"name":"France","countryCode":"FR"}}},{"type":"Feature","id":"75","geometry":{"type":"Point","coordinates":["9.45356","0.39241"],"properties":{"name":"Gabon","countryCode":"GA"}}},{"type":"Feature","id":"76","geometry":{"type":"Point","coordinates":["-0.12574","51.50853"],"properties":{"name":"United Kingdom","countryCode":"GB"}}},{"type":"Feature","id":"77","geometry":{"type":"Point","coordinates":["-61.74849","12.05644"],"properties":{"name":"Grenada","countryCode":"GD"}}},{"type":"Feature","id":"78","geometry":{"type":"Point","coordinates":["44.83368","41.69411"],"properties":{"name":"Georgia","countryCode":"GE"}}},{"type":"Feature","id":"79","geometry":{"type":"Point","coordinates":[-52.333333,4.933333],"properties":{"name":"French Guiana","countryCode":"GF"}}},{"type":"Feature","id":"80","geometry":{"type":"Point","coordinates":["-2.53527","49.45981"],"properties":{"name":"Guernsey","countryCode":"GG"}}},{"type":"Feature","id":"81","geometry":{"type":"Point","coordinates":["-0.1969","5.55602"],"properties":{"name":"Ghana","countryCode":"GH"}}},{"type":"Feature","id":"82","geometry":{"type":"Point","coordinates":["-5.35257","36.14474"],"properties":{"name":"Gibraltar","countryCode":"GI"}}},{"type":"Feature","id":"83","geometry":{"type":"Point","coordinates":["-51.72157","64.18347"],"properties":{"name":"Greenland","countryCode":"GL"}}},{"type":"Feature","id":"84","geometry":{"type":"Point","coordinates":[-16.5780258178711,13.4527355073529],"properties":{"name":"Gambia","countryCode":"GM"}}},{"type":"Feature","id":"85","geometry":{"type":"Point","coordinates":["-13.67729","9.53795"],"properties":{"name":"Guinea","countryCode":"GN"}}},{"type":"Feature","id":"86","geometry":{"type":"Point","coordinates":["-61.50451","16.27095"],"properties":{"name":"Guadeloupe","countryCode":"GP"}}},{"type":"Feature","id":"87","geometry":{"type":"Point","coordinates":["8.78333","3.75"],"properties":{"name":"Equatorial Guinea","countryCode":"GQ"}}},{"type":"Feature","id":"88","geometry":{"type":"Point","coordinates":["23.71622","37.97945"],"properties":{"name":"Greece","countryCode":"GR"}}},{"type":"Feature","id":"89","geometry":{"type":"Point","coordinates":[-36.5091991424561,-54.2811116049432],"properties":{"name":"South Georgia and the South Sandwich Islands","countryCode":"GS"}}},{"type":"Feature","id":"90","geometry":{"type":"Point","coordinates":["-90.51327","14.64072"],"properties":{"name":"Guatemala","countryCode":"GT"}}},{"type":"Feature","id":"91","geometry":{"type":"Point","coordinates":["144.8391","13.51777"],"properties":{"name":"Guam","countryCode":"GU"}}},{"type":"Feature","id":"92","geometry":{"type":"Point","coordinates":["-15.59767","11.86357"],"properties":{"name":"Guinea-Bissau","countryCode":"GW"}}},{"type":"Feature","id":"93","geometry":{"type":"Point","coordinates":["-58.15527","6.80448"],"properties":{"name":"Guyana","countryCode":"GY"}}},{"type":"Feature","id":"94","geometry":{"type":"Point","coordinates":[114.157691001892,22.2855225817732],"properties":{"name":"Hong Kong","countryCode":"HK"}}},{"type":"Feature","id":"95","geometry":{"type":"Point","coordinates":["73.51667","-53.1"],"properties":{"name":"Heard Island and McDonald Islands","countryCode":"HM"}}},{"type":"Feature","id":"96","geometry":{"type":"Point","coordinates":["-87.20681","14.0818"],"properties":{"name":"Honduras","countryCode":"HN"}}},{"type":"Feature","id":"97","geometry":{"type":"Point","coordinates":["15.97798","45.81444"],"properties":{"name":"Croatia","countryCode":"HR"}}},{"type":"Feature","id":"98","geometry":{"type":"Point","coordinates":["-72.335","18.53917"],"properties":{"name":"Haiti","countryCode":"HT"}}},{"type":"Feature","id":"99","geometry":{"type":"Point","coordinates":[19.0399074554443,47.4980099893041],"properties":{"name":"Hungary","countryCode":"HU"}}},{"type":"Feature","id":"100","geometry":{"type":"Point","coordinates":["-6.24889","53.33306"],"properties":{"name":"Ireland","countryCode":"IE"}}},{"type":"Feature","id":"101","geometry":{"type":"Point","coordinates":["106.84513","-6.21462"],"properties":{"name":"Indonesia","countryCode":"ID"}}},{"type":"Feature","id":"102","geometry":{"type":"Point","coordinates":["35.21633","31.76904"],"properties":{"name":"Israel","countryCode":"IL"}}},{"type":"Feature","id":"103","geometry":{"type":"Point","coordinates":["-4.48333","54.15"],"properties":{"name":"Isle of Man","countryCode":"IM"}}},{"type":"Feature","id":"104","geometry":{"type":"Point","coordinates":[72.88261413574219,19.07282592774],"properties":{"name":"India","countryCode":"IN"}}},{"type":"Feature","id":"105","geometry":{"type":"Point","coordinates":["72","-6"],"properties":{"name":"British Indian Ocean Territory","countryCode":"IO"}}},{"type":"Feature","id":"106","geometry":{"type":"Point","coordinates":["44.40088","33.34058"],"properties":{"name":"Iraq","countryCode":"IQ"}}},{"type":"Feature","id":"107","geometry":{"type":"Point","coordinates":["51.42151","35.69439"],"properties":{"name":"Iran","countryCode":"IR"}}},{"type":"Feature","id":"108","geometry":{"type":"Point","coordinates":["-21.89541","64.13548"],"properties":{"name":"Iceland","countryCode":"IS"}}},{"type":"Feature","id":"109","geometry":{"type":"Point","coordinates":[12.4839019775391,41.8947384616695],"properties":{"name":"Italy","countryCode":"IT"}}},{"type":"Feature","id":"110","geometry":{"type":"Point","coordinates":["-2.10491","49.18804"],"properties":{"name":"Jersey","countryCode":"JE"}}},{"type":"Feature","id":"111","geometry":{"type":"Point","coordinates":["-76.79358","17.99702"],"properties":{"name":"Jamaica","countryCode":"JM"}}},{"type":"Feature","id":"112","geometry":{"type":"Point","coordinates":["35.94503","31.95522"],"properties":{"name":"Jordan","countryCode":"JO"}}},{"type":"Feature","id":"113","geometry":{"type":"Point","coordinates":["139.69171","35.6895"],"properties":{"name":"Japan","countryCode":"JP"}}},{"type":"Feature","id":"114","geometry":{"type":"Point","coordinates":[36.8166667,-1.2833333],"properties":{"name":"Kenya","countryCode":"KE"}}},{"type":"Feature","id":"115","geometry":{"type":"Point","coordinates":["74.59","42.87"],"properties":{"name":"Kyrgyzstan","countryCode":"KG"}}},{"type":"Feature","id":"116","geometry":{"type":"Point","coordinates":["104.91601","11.56245"],"properties":{"name":"Cambodia","countryCode":"KH"}}},{"type":"Feature","id":"117","geometry":{"type":"Point","coordinates":["172.97696","1.3278"],"properties":{"name":"Kiribati","countryCode":"KI"}}},{"type":"Feature","id":"118","geometry":{"type":"Point","coordinates":["43.25506","-11.70216"],"properties":{"name":"Comoros","countryCode":"KM"}}},{"type":"Feature","id":"119","geometry":{"type":"Point","coordinates":[-62.7260971069336,17.2948388453016],"properties":{"name":"Saint Kitts and Nevis","countryCode":"KN"}}},{"type":"Feature","id":"120","geometry":{"type":"Point","coordinates":["125.75432","39.03385"],"properties":{"name":"North Korea","countryCode":"KP"}}},{"type":"Feature","id":"121","geometry":{"type":"Point","coordinates":["126.97783","37.56826"],"properties":{"name":"South Korea","countryCode":"KR"}}},{"type":"Feature","id":"122","geometry":{"type":"Point","coordinates":["47.97833","29.36972"],"properties":{"name":"Kuwait","countryCode":"KW"}}},{"type":"Feature","id":"123","geometry":{"type":"Point","coordinates":["-81.36706","19.28692"],"properties":{"name":"Cayman Islands","countryCode":"KY"}}},{"type":"Feature","id":"124","geometry":{"type":"Point","coordinates":[71.4459800720215,51.1800962564279],"properties":{"name":"Kazakhstan","countryCode":"KZ"}}},{"type":"Feature","id":"125","geometry":{"type":"Point","coordinates":["102.6","17.96667"],"properties":{"name":"Laos","countryCode":"LA"}}},{"type":"Feature","id":"126","geometry":{"type":"Point","coordinates":["35.49442","33.88894"],"properties":{"name":"Lebanon","countryCode":"LB"}}},{"type":"Feature","id":"127","geometry":{"type":"Point","coordinates":["-61.00614","13.9957"],"properties":{"name":"Saint Lucia","countryCode":"LC"}}},{"type":"Feature","id":"128","geometry":{"type":"Point","coordinates":["9.52154","47.14151"],"properties":{"name":"Liechtenstein","countryCode":"LI"}}},{"type":"Feature","id":"129","geometry":{"type":"Point","coordinates":[79.8477778,6.9319444],"properties":{"name":"Sri Lanka","countryCode":"LK"}}},{"type":"Feature","id":"130","geometry":{"type":"Point","coordinates":["-10.7969","6.30054"],"properties":{"name":"Liberia","countryCode":"LR"}}},{"type":"Feature","id":"131","geometry":{"type":"Point","coordinates":["27.48333","-29.31667"],"properties":{"name":"Lesotho","countryCode":"LS"}}},{"type":"Feature","id":"132","geometry":{"type":"Point","coordinates":["25.2798","54.68916"],"properties":{"name":"Lithuania","countryCode":"LT"}}},{"type":"Feature","id":"133","geometry":{"type":"Point","coordinates":["6.13","49.61167"],"properties":{"name":"Luxembourg","countryCode":"LU"}}},{"type":"Feature","id":"134","geometry":{"type":"Point","coordinates":[24.1058921813965,56.9460041154056],"properties":{"name":"Latvia","countryCode":"LV"}}},{"type":"Feature","id":"135","geometry":{"type":"Point","coordinates":["13.18746","32.87519"],"properties":{"name":"Libya","countryCode":"LY"}}},{"type":"Feature","id":"136","geometry":{"type":"Point","coordinates":["-6.83255","34.01325"],"properties":{"name":"Morocco","countryCode":"MA"}}},{"type":"Feature","id":"137","geometry":{"type":"Point","coordinates":["7.41667","43.73333"],"properties":{"name":"Monaco","countryCode":"MC"}}},{"type":"Feature","id":"138","geometry":{"type":"Point","coordinates":["28.8575","47.00556"],"properties":{"name":"Moldova","countryCode":"MD"}}},{"type":"Feature","id":"139","geometry":{"type":"Point","coordinates":[19.2636111,42.4411111],"properties":{"name":"Montenegro","countryCode":"ME"}}},{"type":"Feature","id":"140","geometry":{"type":"Point","coordinates":["-63.08333","18.06667"],"properties":{"name":"Saint Martin","countryCode":"MF"}}},{"type":"Feature","id":"141","geometry":{"type":"Point","coordinates":["47.53613","-18.91368"],"properties":{"name":"Madagascar","countryCode":"MG"}}},{"type":"Feature","id":"142","geometry":{"type":"Point","coordinates":["171.38027","7.08971"],"properties":{"name":"Marshall Islands","countryCode":"MH"}}},{"type":"Feature","id":"143","geometry":{"type":"Point","coordinates":["21.43141","41.99646"],"properties":{"name":"Macedonia","countryCode":"MK"}}},{"type":"Feature","id":"144","geometry":{"type":"Point","coordinates":[-8,12.65],"properties":{"name":"Mali","countryCode":"ML"}}},{"type":"Feature","id":"145","geometry":{"type":"Point","coordinates":["96.15611","16.80528"],"properties":{"name":"Myanmar [Burma]","countryCode":"MM"}}},{"type":"Feature","id":"146","geometry":{"type":"Point","coordinates":["106.88324","47.90771"],"properties":{"name":"Mongolia","countryCode":"MN"}}},{"type":"Feature","id":"147","geometry":{"type":"Point","coordinates":["113.54611","22.20056"],"properties":{"name":"Macao","countryCode":"MO"}}},{"type":"Feature","id":"148","geometry":{"type":"Point","coordinates":["145.7545","15.21233"],"properties":{"name":"Northern Mariana Islands","countryCode":"MP"}}},{"type":"Feature","id":"149","geometry":{"type":"Point","coordinates":[-61.073341369628906,14.608916925759976],"properties":{"name":"Martinique","countryCode":"MQ"}}},{"type":"Feature","id":"150","geometry":{"type":"Point","coordinates":["-15.9785","18.08581"],"properties":{"name":"Mauritania","countryCode":"MR"}}},{"type":"Feature","id":"151","geometry":{"type":"Point","coordinates":["-62.21667","16.71667"],"properties":{"name":"Montserrat","countryCode":"MS"}}},{"type":"Feature","id":"152","geometry":{"type":"Point","coordinates":["14.46111","35.89722"],"properties":{"name":"Malta","countryCode":"MT"}}},{"type":"Feature","id":"153","geometry":{"type":"Point","coordinates":["57.49889","-20.16194"],"properties":{"name":"Mauritius","countryCode":"MU"}}},{"type":"Feature","id":"154","geometry":{"type":"Point","coordinates":[73.5088777542114,4.17479639013428],"properties":{"name":"Maldives","countryCode":"MV"}}},{"type":"Feature","id":"155","geometry":{"type":"Point","coordinates":["33.78725","-13.96692"],"properties":{"name":"Malawi","countryCode":"MW"}}},{"type":"Feature","id":"156","geometry":{"type":"Point","coordinates":["-99.12766","19.42847"],"properties":{"name":"Mexico","countryCode":"MX"}}},{"type":"Feature","id":"157","geometry":{"type":"Point","coordinates":["101.68653","3.1412"],"properties":{"name":"Malaysia","countryCode":"MY"}}},{"type":"Feature","id":"158","geometry":{"type":"Point","coordinates":["32.58322","-25.96553"],"properties":{"name":"Mozambique","countryCode":"MZ"}}},{"type":"Feature","id":"159","geometry":{"type":"Point","coordinates":[17.08322525024414,-22.559409406709573],"properties":{"name":"Namibia","countryCode":"NA"}}},{"type":"Feature","id":"160","geometry":{"type":"Point","coordinates":["166.4572","-22.27631"],"properties":{"name":"New Caledonia","countryCode":"NC"}}},{"type":"Feature","id":"161","geometry":{"type":"Point","coordinates":["2.1098","13.51366"],"properties":{"name":"Niger","countryCode":"NE"}}},{"type":"Feature","id":"162","geometry":{"type":"Point","coordinates":["167.96628","-29.05459"],"properties":{"name":"Norfolk Island","countryCode":"NF"}}},{"type":"Feature","id":"163","geometry":{"type":"Point","coordinates":["3.39583","6.45306"],"properties":{"name":"Nigeria","countryCode":"NG"}}},{"type":"Feature","id":"164","geometry":{"type":"Point","coordinates":[-86.25040054321289,12.13281653939173],"properties":{"name":"Nicaragua","countryCode":"NI"}}},{"type":"Feature","id":"165","geometry":{"type":"Point","coordinates":["4.88969","52.37403"],"properties":{"name":"Netherlands","countryCode":"NL"}}},{"type":"Feature","id":"166","geometry":{"type":"Point","coordinates":["10.74609","59.91273"],"properties":{"name":"Norway","countryCode":"NO"}}},{"type":"Feature","id":"167","geometry":{"type":"Point","coordinates":["85.3206","27.70169"],"properties":{"name":"Nepal","countryCode":"NP"}}},{"type":"Feature","id":"168","geometry":{"type":"Point","coordinates":["166.933","-0.517"],"properties":{"name":"Nauru","countryCode":"NR"}}},{"type":"Feature","id":"169","geometry":{"type":"Point","coordinates":[-169.91867065429688,-19.059521889847332],"properties":{"name":"Niue","countryCode":"NU"}}},{"type":"Feature","id":"170","geometry":{"type":"Point","coordinates":["174.77557","-41.28664"],"properties":{"name":"New Zealand","countryCode":"NZ"}}},{"type":"Feature","id":"171","geometry":{"type":"Point","coordinates":["58.5922","23.61387"],"properties":{"name":"Oman","countryCode":"OM"}}},{"type":"Feature","id":"172","geometry":{"type":"Point","coordinates":["-79.51973","8.9936"],"properties":{"name":"Panama","countryCode":"PA"}}},{"type":"Feature","id":"173","geometry":{"type":"Point","coordinates":["-77.02824","-12.04318"],"properties":{"name":"Peru","countryCode":"PE"}}},{"type":"Feature","id":"174","geometry":{"type":"Point","coordinates":[-149.5666667,-17.5333333],"properties":{"name":"French Polynesia","countryCode":"PF"}}},{"type":"Feature","id":"175","geometry":{"type":"Point","coordinates":["147.17972","-9.44314"],"properties":{"name":"Papua New Guinea","countryCode":"PG"}}},{"type":"Feature","id":"176","geometry":{"type":"Point","coordinates":["120.9822","14.6042"],"properties":{"name":"Philippines","countryCode":"PH"}}},{"type":"Feature","id":"177","geometry":{"type":"Point","coordinates":["67.0822","24.9056"],"properties":{"name":"Pakistan","countryCode":"PK"}}},{"type":"Feature","id":"178","geometry":{"type":"Point","coordinates":["21.01178","52.22977"],"properties":{"name":"Poland","countryCode":"PL"}}},{"type":"Feature","id":"179","geometry":{"type":"Point","coordinates":[-56.171963810920715,46.78090922678383],"properties":{"name":"Saint Pierre and Miquelon","countryCode":"PM"}}},{"type":"Feature","id":"180","geometry":{"type":"Point","coordinates":["-130.10147","-25.06597"],"properties":{"name":"Pitcairn Islands","countryCode":"PN"}}},{"type":"Feature","id":"181","geometry":{"type":"Point","coordinates":["-66.10572","18.46633"],"properties":{"name":"Puerto Rico","countryCode":"PR"}}},{"type":"Feature","id":"182","geometry":{"type":"Point","coordinates":["34.46667","31.5"],"properties":{"name":"Palestine","countryCode":"PS"}}},{"type":"Feature","id":"183","geometry":{"type":"Point","coordinates":["-9.13333","38.71667"],"properties":{"name":"Portugal","countryCode":"PT"}}},{"type":"Feature","id":"184","geometry":{"type":"Point","coordinates":[134.131329059601,6.90331462016765],"properties":{"name":"Palau","countryCode":"PW"}}},{"type":"Feature","id":"185","geometry":{"type":"Point","coordinates":["-57.63591","-25.30066"],"properties":{"name":"Paraguay","countryCode":"PY"}}},{"type":"Feature","id":"186","geometry":{"type":"Point","coordinates":["51.52245","25.27932"],"properties":{"name":"Qatar","countryCode":"QA"}}},{"type":"Feature","id":"187","geometry":{"type":"Point","coordinates":["55.4504","-20.88231"],"properties":{"name":"Réunion","countryCode":"RE"}}},{"type":"Feature","id":"188","geometry":{"type":"Point","coordinates":["26.10626","44.43225"],"properties":{"name":"Romania","countryCode":"RO"}}},{"type":"Feature","id":"189","geometry":{"type":"Point","coordinates":[20.4651260375977,44.8040064347669],"properties":{"name":"Serbia","countryCode":"RS"}}},{"type":"Feature","id":"190","geometry":{"type":"Point","coordinates":["37.61556","55.75222"],"properties":{"name":"Russia","countryCode":"RU"}}},{"type":"Feature","id":"191","geometry":{"type":"Point","coordinates":["30.05885","-1.94995"],"properties":{"name":"Rwanda","countryCode":"RW"}}},{"type":"Feature","id":"192","geometry":{"type":"Point","coordinates":["46.72185","24.68773"],"properties":{"name":"Saudi Arabia","countryCode":"SA"}}},{"type":"Feature","id":"193","geometry":{"type":"Point","coordinates":["159.95","-9.43333"],"properties":{"name":"Solomon Islands","countryCode":"SB"}}},{"type":"Feature","id":"194","geometry":{"type":"Point","coordinates":[55.45,-4.6166667],"properties":{"name":"Seychelles","countryCode":"SC"}}},{"type":"Feature","id":"195","geometry":{"type":"Point","coordinates":["32.53241","15.55177"],"properties":{"name":"Sudan","countryCode":"SD"}}},{"type":"Feature","id":"196","geometry":{"type":"Point","coordinates":["18.0649","59.33258"],"properties":{"name":"Sweden","countryCode":"SE"}}},{"type":"Feature","id":"197","geometry":{"type":"Point","coordinates":["103.85007","1.28967"],"properties":{"name":"Singapore","countryCode":"SG"}}},{"type":"Feature","id":"198","geometry":{"type":"Point","coordinates":["-5.71675","-15.93872"],"properties":{"name":"Saint Helena","countryCode":"SH"}}},{"type":"Feature","id":"199","geometry":{"type":"Point","coordinates":[14.5051288604736,46.0510757955661],"properties":{"name":"Slovenia","countryCode":"SI"}}},{"type":"Feature","id":"200","geometry":{"type":"Point","coordinates":["15.64007","78.2186"],"properties":{"name":"Svalbard and Jan Mayen","countryCode":"SJ"}}},{"type":"Feature","id":"201","geometry":{"type":"Point","coordinates":["-13.22994","8.484"],"properties":{"name":"Sierra Leone","countryCode":"SL"}}},{"type":"Feature","id":"202","geometry":{"type":"Point","coordinates":["17.10674","48.14816"],"properties":{"name":"Slovakia","countryCode":"SK"}}},{"type":"Feature","id":"203","geometry":{"type":"Point","coordinates":["12.48167","43.96897"],"properties":{"name":"San Marino","countryCode":"SM"}}},{"type":"Feature","id":"204","geometry":{"type":"Point","coordinates":[-17.4440574645996,14.6937004879544],"properties":{"name":"Senegal","countryCode":"SN"}}},{"type":"Feature","id":"205","geometry":{"type":"Point","coordinates":["45.34375","2.03711"],"properties":{"name":"Somalia","countryCode":"SO"}}},{"type":"Feature","id":"206","geometry":{"type":"Point","coordinates":["-55.16682","5.86638"],"properties":{"name":"Suriname","countryCode":"SR"}}},{"type":"Feature","id":"207","geometry":{"type":"Point","coordinates":["31.58247","4.85165"],"properties":{"name":"South Sudan","countryCode":"SS"}}},{"type":"Feature","id":"208","geometry":{"type":"Point","coordinates":["6.72732","0.33654"],"properties":{"name":"São Tomé and Príncipe","countryCode":"ST"}}},{"type":"Feature","id":"209","geometry":{"type":"Point","coordinates":[-89.18718338012695,13.689354910772549],"properties":{"name":"El Salvador","countryCode":"SV"}}},{"type":"Feature","id":"210","geometry":{"type":"Point","coordinates":["-63.04582","18.026"],"properties":{"name":"Sint Maarten","countryCode":"SX"}}},{"type":"Feature","id":"211","geometry":{"type":"Point","coordinates":["36.72339","34.72682"],"properties":{"name":"Syria","countryCode":"SY"}}},{"type":"Feature","id":"212","geometry":{"type":"Point","coordinates":["31.13333","-26.31667"],"properties":{"name":"Swaziland","countryCode":"SZ"}}},{"type":"Feature","id":"213","geometry":{"type":"Point","coordinates":["-71.14188","21.46122"],"properties":{"name":"Turks and Caicos Islands","countryCode":"TC"}}},{"type":"Feature","id":"214","geometry":{"type":"Point","coordinates":[15.044403076171875,12.106718167231858],"properties":{"name":"Chad","countryCode":"TD"}}},{"type":"Feature","id":"215","geometry":{"type":"Point","coordinates":["70.21667","-49.35"],"properties":{"name":"French Southern Territories","countryCode":"TF"}}},{"type":"Feature","id":"216","geometry":{"type":"Point","coordinates":["1.21227","6.13748"],"properties":{"name":"Togo","countryCode":"TG"}}},{"type":"Feature","id":"217","geometry":{"type":"Point","coordinates":["100.50144","13.75398"],"properties":{"name":"Thailand","countryCode":"TH"}}},{"type":"Feature","id":"218","geometry":{"type":"Point","coordinates":["68.77905","38.53575"],"properties":{"name":"Tajikistan","countryCode":"TJ"}}},{"type":"Feature","id":"219","geometry":{"type":"Point","coordinates":[-172.515907287598,-8.54211699094261],"properties":{"name":"Tokelau","countryCode":"TK"}}},{"type":"Feature","id":"220","geometry":{"type":"Point","coordinates":["125.57361","-8.55861"],"properties":{"name":"East Timor","countryCode":"TL"}}},{"type":"Feature","id":"221","geometry":{"type":"Point","coordinates":["58.38333","37.95"],"properties":{"name":"Turkmenistan","countryCode":"TM"}}},{"type":"Feature","id":"222","geometry":{"type":"Point","coordinates":["10.16579","36.81897"],"properties":{"name":"Tunisia","countryCode":"TN"}}},{"type":"Feature","id":"223","geometry":{"type":"Point","coordinates":["-175.2018","-21.13938"],"properties":{"name":"Tonga","countryCode":"TO"}}},{"type":"Feature","id":"224","geometry":{"type":"Point","coordinates":[32.8542709350586,39.9198743755027],"properties":{"name":"Turkey","countryCode":"TR"}}},{"type":"Feature","id":"225","geometry":{"type":"Point","coordinates":["-61.51657","10.66617"],"properties":{"name":"Trinidad and Tobago","countryCode":"TT"}}},{"type":"Feature","id":"226","geometry":{"type":"Point","coordinates":["179.19417","-8.52425"],"properties":{"name":"Tuvalu","countryCode":"TV"}}},{"type":"Feature","id":"227","geometry":{"type":"Point","coordinates":["121.53185","25.04776"],"properties":{"name":"Taiwan","countryCode":"TW"}}},{"type":"Feature","id":"228","geometry":{"type":"Point","coordinates":["39.26951","-6.82349"],"properties":{"name":"Tanzania","countryCode":"TZ"}}},{"type":"Feature","id":"229","geometry":{"type":"Point","coordinates":[30.523796081543,50.4546624398828],"properties":{"name":"Ukraine","countryCode":"UA"}}},{"type":"Feature","id":"230","geometry":{"type":"Point","coordinates":["32.58219","0.31628"],"properties":{"name":"Uganda","countryCode":"UG"}}},{"type":"Feature","id":"231","geometry":{"type":"Point","coordinates":["-162.057","5.875"],"properties":{"name":"U.S. Minor Outlying Islands","countryCode":"UM"}}},{"type":"Feature","id":"232","geometry":{"type":"Point","coordinates":["-56.16735","-34.83346"],"properties":{"name":"Uruguay","countryCode":"UY"}}},{"type":"Feature","id":"233","geometry":{"type":"Point","coordinates":["-95.36327","29.76328"],"properties":{"name":"United States","countryCode":"US"}}},{"type":"Feature","id":"234","geometry":{"type":"Point","coordinates":[69.21627044677734,41.26464643600054],"properties":{"name":"Uzbekistan","countryCode":"UZ"}}},{"type":"Feature","id":"235","geometry":{"type":"Point","coordinates":["12.45332","41.90236"],"properties":{"name":"Vatican City","countryCode":"VA"}}},{"type":"Feature","id":"236","geometry":{"type":"Point","coordinates":["-61.22475","13.15872"],"properties":{"name":"Saint Vincent and the Grenadines","countryCode":"VC"}}},{"type":"Feature","id":"237","geometry":{"type":"Point","coordinates":["-66.87919","10.48801"],"properties":{"name":"Venezuela","countryCode":"VE"}}},{"type":"Feature","id":"238","geometry":{"type":"Point","coordinates":["-64.61667","18.41667"],"properties":{"name":"British Virgin Islands","countryCode":"VG"}}},{"type":"Feature","id":"239","geometry":{"type":"Point","coordinates":[-64.9307007,18.3419004],"properties":{"name":"U.S. Virgin Islands","countryCode":"VI"}}},{"type":"Feature","id":"240","geometry":{"type":"Point","coordinates":["106.62965","10.82302"],"properties":{"name":"Vietnam","countryCode":"VN"}}},{"type":"Feature","id":"241","geometry":{"type":"Point","coordinates":["168.32188","-17.73381"],"properties":{"name":"Vanuatu","countryCode":"VU"}}},{"type":"Feature","id":"242","geometry":{"type":"Point","coordinates":["-176.17453","-13.28163"],"properties":{"name":"Wallis and Futuna","countryCode":"WF"}}},{"type":"Feature","id":"243","geometry":{"type":"Point","coordinates":["-171.76666","-13.83333"],"properties":{"name":"Samoa","countryCode":"WS"}}},{"type":"Feature","id":"244","geometry":{"type":"Point","coordinates":[21.166877746582,42.672717844294],"properties":{"name":"Kosovo","countryCode":"XK"}}},{"type":"Feature","id":"245","geometry":{"type":"Point","coordinates":["44.20667","15.35472"],"properties":{"name":"Yemen","countryCode":"YE"}}},{"type":"Feature","id":"246","geometry":{"type":"Point","coordinates":["45.22722","-12.77944"],"properties":{"name":"Mayotte","countryCode":"YT"}}},{"type":"Feature","id":"247","geometry":{"type":"Point","coordinates":["28.18783","-25.74486"],"properties":{"name":"South Africa","countryCode":"ZA"}}},{"type":"Feature","id":"248","geometry":{"type":"Point","coordinates":["28.28713","-15.40669"],"properties":{"name":"Zambia","countryCode":"ZM"}}},{"type":"Feature","id":"249","geometry":{"type":"Point","coordinates":[31.05337142944336,-17.827716964964704],"properties":{"name":"Zimbabwe","countryCode":"ZW"}}}]}
      }
</script>
@endsection
