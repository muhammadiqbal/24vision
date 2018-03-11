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

   <script src="http://d3js.org/d3.v3.min.js"></script>
   <script src="http://d3js.org/topojson.v1.min.js"></script>
   <script src="http://d3js.org/queue.v1.min.js"></script>

<script type="text/javascript">
var countries = getPorts(); 

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

         //render the points
         countries.features.forEach(function(d) { 
            var x = projection(d.latitude);
            var y = projection(d.longitude);

            svg.append("svg:circle")
            .attr("class","point")
            .attr("cx", x)
            .attr("cy", y)
            .attr("fill", "#FF0000")
            .attr("r", 3)

         });

         d3.select(self.frameElement).style("height", height + "px");

         // var features = countries.features;
         // for(var i=240; i<features.length-2; i++) {
         //    if(features[i].geometry.coordinates[0] < features[i+1].geometry.coordinates[0]){
         //       var route = {
         //          type: "LineString",
         //          coordinates: [
         //          features[i].geometry.coordinates,
         //          features[i+1].geometry.coordinates
         //          ]
         //       };
         //       svg.append("path")
         //       .datum(route)
         //       .attr("class", "route")
         //       .attr("d", path);
         //    }

         // }

          var route = {
                  type: "LineString",
                  coordinates: [
                  "{!!$cargo->loadingPort->latitude!!}","{!!$cargo->loadingPort->longitude!!}",
                  "{!!$cargo->dischargingPort->latitude!!}","{!!$cargo->dischargingPort->longitude!!}"
                  ]};
               svg.append("path")
               .datum(route)
               .attr("class", "route")
               .attr("d", path);

      }

function getPorts(){
  return  {"name":"FANG-CHENG","latitude":"21.45","longitude":"108.21"},{"name":"BEIHAI","latitude":"21.29","longitude":"109.04"},{"name":"HAIKOU","latitude":"20.03","longitude":"110.17"},{"name":"BASUO","latitude":"19.06","longitude":"108.37"},{"name":"ZHANJIANG","latitude":"21.12","longitude":"110.24"},{"name":"LON SHUI TERMINAL","latitude":"20.50","longitude":"115.41"},{"name":"SHEKOU","latitude":"22.28","longitude":"113.52"},{"name":"SANYA","latitude":"18.19","longitude":"109.27"},{"name":"YANGPU","latitude":"19.44","longitude":"109.11"},{"name":"CHIWAN","latitude":"19.58","longitude":"110.02"},{"name":"SHUI DONG","latitude":"21.29","longitude":"111.05"},{"name":"QINZHOU","latitude":"21.44","longitude":"108.35"},{"name":"ZHUHAI","latitude":"22.14","longitude":"113.35"},{"name":"HUANGPU","latitude":"23.05","longitude":"113.25"},{"name":"HUANGPUXINGANG","latitude":"23.05","longitude":"113.30"},{"name":"GUANGZHOU","latitude":"23.07","longitude":"113.14"},{"name":"YANTIAN","latitude":"22.35","longitude":"114.16"},{"name":"HUIZHOU","latitude":"22.43","longitude":"114.31"},{"name":"SHAN T OU","latitude":"23.22","longitude":"116.41"},{"name":"CHAOZHOU","latitude":"23.37","longitude":"117.05"},{"name":"DONGSHAN","latitude":"23.45","longitude":"117.31"},{"name":"XIAMEN","latitude":"24.27","longitude":"118.04"},{"name":"ZHANGZHOU","latitude":"24.41","longitude":"118.09"},{"name":"QUANZHOU","latitude":"24.53","longitude":"118.36"},{"name":"XIUYU","latitude":"25.14","longitude":"118.59"},{"name":"FUZHOU","latitude":"26.05","longitude":"119.18"},{"name":"WENZHOU","latitude":"28.01","longitude":"120.39"},{"name":"HAIMEN","latitude":"28.41","longitude":"121.27"},{"name":"NINGBO","latitude":"29.53","longitude":"121.33"},{"name":"ZHEN HAI","latitude":"29.57","longitude":"121.42"},{"name":"ZHOUSHAN","latitude":"30.00","longitude":"122.06"},{"name":"ZHAPU","latitude":"30.35","longitude":"121.05"},{"name":"SHANGHAI","latitude":"31.13","longitude":"121.30"},{"name":"CHANGSHU","latitude":"31.46","longitude":"120.57"},{"name":"TAICANG","latitude":"31.39","longitude":"121.12"},{"name":"JIANGYIN","latitude":"31.55","longitude":"120.14"},{"name":"CHANGZHOU","latitude":"31.58","longitude":"119.59"},{"name":"GAOGANG","latitude":"32.17","longitude":"119.51"},{"name":"YANGZHOU","latitude":"32.16","longitude":"119.26"},{"name":"ZHANGJIANGANG","latitude":"31.58","longitude":"120.24"},{"name":"NANTONG","latitude":"32.00","longitude":"120.48"},{"name":"ZHENJIANG","latitude":"32.13","longitude":"119.26"},{"name":"NANJING","latitude":"32.05","longitude":"118.45"},{"name":"WU HU","latitude":"31.20","longitude":"118.22"},{"name":"ANKINGCHENG","latitude":"30.31","longitude":"117.02"},{"name":"HANKOW","latitude":"30.35","longitude":"114.17"},{"name":"WANXIAN","latitude":"30.49","longitude":"108.26"},{"name":"CHUNG CHING","latitude":"29.34","longitude":"106.38"},{"name":"LANSHAN","latitude":"30.06","longitude":"119.22"},{"name":"LIANYUNGANG","latitude":"34.44","longitude":"119.27"},{"name":"RIZHAO","latitude":"35.23","longitude":"119.34"},{"name":"QINGDAO GANG","latitude":"36.02","longitude":"120.16"},{"name":"WEIHAI","latitude":"37.30","longitude":"122.06"},{"name":"YANTAI","latitude":"37.33","longitude":"121.27"},{"name":"PENGLAI","latitude":"37.49","longitude":"120.50"},{"name":"LONGKOU GANG","latitude":"37.38","longitude":"120.17"},{"name":"DAGU TANGGU","latitude":"38.58","longitude":"117.40"},{"name":"TIANJIN XIN GANG","latitude":"38.58","longitude":"117.50"},{"name":"TANGSHAN (JINGTANG)","latitude":"39.12","longitude":"119.01"},{"name":"QINHUANGDAO","latitude":"39.56","longitude":"119.37"},{"name":"SUIZHANG GANG","latitude":"40.04","longitude":"121.03"},{"name":"HULUDAO GANG","latitude":"40.42","longitude":"120.59"},{"name":"JINZHOU WAN","latitude":"40.45","longitude":"121.06"},{"name":"YINGKOU","latitude":"40.41","longitude":"122.14"},{"name":"BAYUQUAN","latitude":"40.18","longitude":"122.05"},{"name":"DANDONG","latitude":"39.49","longitude":"124.09"},{"name":"LUSHUN","latitude":"38.47","longitude":"121.15"},{"name":"DALIAN","latitude":"38.55","longitude":"121.40"},{"name":"INCHON","latitude":"37.28","longitude":"126.37"},{"name":"DAESAN HANG","latitude":"37.01","longitude":"126.24"},{"name":"PYEONGTAEK HANG","latitude":"37.00","longitude":"126.48"},{"name":"KUNSAN","latitude":"35.59","longitude":"126.37"},{"name":"MOKPO","latitude":"34.47","longitude":"126.23"},{"name":"CHEJU HANG","latitude":"33.31","longitude":"126.32"},{"name":"YOSU","latitude":"34.44","longitude":"127.45"},{"name":"GWANGYANG HANG","latitude":"34.51","longitude":"127.48"},{"name":"MASAN","latitude":"35.11","longitude":"128.34"},{"name":"CHINAE","latitude":"35.08","longitude":"128.39"},{"name":"PUSAN","latitude":"35.06","longitude":"129.02"},{"name":"ULSAN","latitude":"35.27","longitude":"129.24"},{"name":"POHANG","latitude":"36.03","longitude":"129.23"},{"name":"MUKHO","latitude":"37.34","longitude":"129.07"},{"name":"TONGHAE","latitude":"37.32","longitude":"129.09"},{"name":"SOKCH'O HANG","latitude":"38.12","longitude":"128.36"},{"name":"MOMBETSU KO","latitude":"44.21","longitude":"143.21"},{"name":"ABASHIRI KO","latitude":"44.01","longitude":"144.17"},{"name":"NEMURO KO","latitude":"43.20","longitude":"145.35"},{"name":"HANASAKI KO","latitude":"43.17","longitude":"145.35"},{"name":"KUSHIRO KO","latitude":"42.59","longitude":"144.22"},{"name":"TOMAKOMAI KO","latitude":"42.38","longitude":"141.38"},{"name":"MURORAN KO","latitude":"42.21","longitude":"140.58"},{"name":"TOKACHI","latitude":"42.15","longitude":"143.18"},{"name":"MORI","latitude":"42.07","longitude":"140.35"},{"name":"HAKODATE KO","latitude":"41.47","longitude":"140.43"},{"name":"ESASI KO","latitude":"41.52","longitude":"140.07"},{"name":"OTARU KO","latitude":"43.12","longitude":"141.01"},{"name":"ISIKARI WAN","latitude":"43.14","longitude":"141.22"},{"name":"ISHIKARI BAY NEW PORT","latitude":"43.13","longitude":"141.17"},{"name":"RUMOI KO","latitude":"43.57","longitude":"141.38"},{"name":"WAKKANAI","latitude":"43.25","longitude":"141.41"},{"name":"AOMORI KO","latitude":"40.50","longitude":"140.45"},{"name":"NOSHIRO KO","latitude":"40.13","longitude":"140.00"},{"name":"HACHINOHE KO","latitude":"40.32","longitude":"141.33"},{"name":"MIYAKO","latitude":"39.38","longitude":"141.59"},{"name":"KAMAISHI KO","latitude":"39.16","longitude":"141.54"},{"name":"OFUNATO","latitude":"39.03","longitude":"141.44"},{"name":"KESENNUMA KO","latitude":"38.52","longitude":"141.36"},{"name":"ONAGAWA","latitude":"38.27","longitude":"141.27"},{"name":"ISHINOMAKI KO","latitude":"38.24","longitude":"141.19"},{"name":"SENDAI-SHIOGAMA","latitude":"38.19","longitude":"141.02"},{"name":"SOMA","latitude":"37.50","longitude":"140.57"},{"name":"ONAHAMA KO","latitude":"36.56","longitude":"140.54"},{"name":"HITACHI","latitude":"36.30","longitude":"140.38"},{"name":"KASHIMA KO","latitude":"35.56","longitude":"140.42"},{"name":"CHOSHI","latitude":"35.44","longitude":"140.51"},{"name":"TATEYAMA KO","latitude":"35.00","longitude":"139.48"},{"name":"KISARAZU KO","latitude":"35.22","longitude":"139.53"},{"name":"CHIBA KO","latitude":"35.35","longitude":"140.04"},{"name":"KATSUNAN KO","latitude":"35.40","longitude":"139.59"},{"name":"FUNABASHI","latitude":"35.40","longitude":"139.57"},{"name":"TOKYO KO","latitude":"35.40","longitude":"139.45"},{"name":"KAWASAKI KO","latitude":"35.30","longitude":"139.46"},{"name":"YOKOHAMA KO","latitude":"35.27","longitude":"139.35"},{"name":"YOKOSUKA KO","latitude":"35.17","longitude":"139.40"},{"name":"URAGA KO","latitude":"35.14","longitude":"139.43"},{"name":"TAGONOURA KO","latitude":"35.08","longitude":"138.42"},{"name":"ATSUMI","latitude":"34.40","longitude":"137.04"},{"name":"SHIMODA KO","latitude":"34.40","longitude":"138.57"},{"name":"OMAEZAKI KO","latitude":"34.36","longitude":"138.14"},{"name":"SHIMIZU KO","latitude":"35.01","longitude":"138.30"},{"name":"MIKAWA","latitude":"34.43","longitude":"137.18"},{"name":"KINUURA KO","latitude":"34.51","longitude":"136.57"},{"name":"GAMAGORI KO","latitude":"34.49","longitude":"137.13"},{"name":"NAGOYA KO","latitude":"35.04","longitude":"136.52"},{"name":"YOKKAICHI","latitude":"34.58","longitude":"136.38"},{"name":"MATSUSAKA","latitude":"34.36","longitude":"136.34"},{"name":"TOBA","latitude":"34.29","longitude":"136.51"},{"name":"OWASE KO","latitude":"34.04","longitude":"136.13"},{"name":"TANABE KO","latitude":"33.43","longitude":"135.22"},{"name":"YURA","latitude":"33.57","longitude":"135.06"},{"name":"WAKAYAMA-SHIMOTSU KO","latitude":"34.12","longitude":"135.08"},{"name":"SAKAI-SENBOKU","latitude":"34.33","longitude":"135.26"},{"name":"OSAKA","latitude":"34.39","longitude":"135.26"},{"name":"AMAGASAKI","latitude":"34.42","longitude":"135.23"},{"name":"KOBE","latitude":"34.39","longitude":"135.11"},{"name":"HIROHATA","latitude":"34.46","longitude":"134.38"},{"name":"SHIKAMA","latitude":"34.46","longitude":"134.39"},{"name":"HIMEJI","latitude":"34.45","longitude":"134.38"},{"name":"HIGASHI-HARIMA","latitude":"34.42","longitude":"134.50"},{"name":"AIOI","latitude":"34.47","longitude":"134.28"},{"name":"O0KIHAMA","latitude":"34.45","longitude":"134.34"},{"name":"KAKOGAWA","latitude":"34.42","longitude":"134.50"},{"name":"UNO KO","latitude":"34.29","longitude":"133.57"},{"name":"HIBI KO","latitude":"34.27","longitude":"133.56"},{"name":"MIZUSHIMA KO","latitude":"34.30","longitude":"133.45"},{"name":"FUKUYAMA","latitude":"34.26","longitude":"133.26"},{"name":"HABU KO","latitude":"34.17","longitude":"133.11"},{"name":"ONOMICHI-ITOZAKI","latitude":"34.23","longitude":"133.10"},{"name":"KURE","latitude":"34.14","longitude":"132.33"},{"name":"MITSUKOJIMA","latitude":"34.11","longitude":"132.31"},{"name":"HIROSHIMA","latitude":"34.21","longitude":"132.28"},{"name":"KANOKAWA KO","latitude":"34.11","longitude":"132.26"},{"name":"IWAKUNI KO","latitude":"34.11","longitude":"132.15"},{"name":"NAMIKATA","latitude":"34.07","longitude":"132.54"},{"name":"KUDAMATSU","latitude":"34.00","longitude":"131.52"},{"name":"TOKUYAMA","latitude":"34.02","longitude":"131.49"},{"name":"UBE KO","latitude":"33.56","longitude":"131.14"},{"name":"HIKARI","latitude":"33.57","longitude":"131.56"},{"name":"SHIMONOSEKI","latitude":"33.56","longitude":"130.56"},{"name":"HAGI KO","latitude":"34.25","longitude":"131.24"},{"name":"HAMADA KO","latitude":"34.54","longitude":"132.05"},{"name":"SAKAI KO","latitude":"35.33","longitude":"133.15"},{"name":"SAKAIMINATO","latitude":"35.32","longitude":"133.14"},{"name":"MIYAZU","latitude":"35.32","longitude":"135.12"},{"name":"MAIZURU KO","latitude":"35.31","longitude":"135.20"},{"name":"UCHIURA","latitude":"35.31","longitude":"135.30"},{"name":"FUKUI","latitude":"36.04","longitude":"136.12"},{"name":"TSURUGA KO","latitude":"35.39","longitude":"136.04"},{"name":"FUKUI KO","latitude":"36.11","longitude":"136.06"},{"name":"KANAZAWA","latitude":"36.37","longitude":"136.36"},{"name":"NANAO KO","latitude":"37.03","longitude":"136.59"},{"name":"FUSHIKI-TOYAMA","latitude":"36.46","longitude":"137.08"},{"name":"SHIMMINATO","latitude":"36.46","longitude":"137.07"},{"name":"HIMEKAWA","latitude":"37.02","longitude":"137.51"},{"name":"NAOETSU KO","latitude":"37.11","longitude":"138.15"},{"name":"KASHIWAZAKI","latitude":"37.22","longitude":"138.33"},{"name":"NIIGATA KO","latitude":"37.55","longitude":"139.03"},{"name":"EASTERN PART OF NIIGATA-KO","latitude":"38.01","longitude":"139.14"},{"name":"RYOTU KO","latitude":"38.05","longitude":"138.34"},{"name":"SAKATA KO","latitude":"38.56","longitude":"139.49"},{"name":"AKITA-FUNAKAWA KO","latitude":"39.50","longitude":"140.00"},{"name":"MEGA","latitude":"34.47","longitude":"134.42"},{"name":"HANNAN KO","latitude":"34.28","longitude":"135.21"},{"name":"TAKAMATSU","latitude":"34.21","longitude":"134.03"},{"name":"KOMATSUSHIMA","latitude":"34.01","longitude":"134.36"},{"name":"TACHIBANA","latitude":"33.52","longitude":"134.40"},{"name":"SHINGU","latitude":"33.40","longitude":"135.59"},{"name":"KOCHI KO","latitude":"33.30","longitude":"133.34"},{"name":"SUSAKI KO","latitude":"33.23","longitude":"133.18"},{"name":"UWAJIMA KO","latitude":"33.13","longitude":"132.34"},{"name":"YAWATAHAMA","latitude":"33.27","longitude":"132.25"},{"name":"MATSUYAMA","latitude":"33.51","longitude":"132.42"},{"name":"KIKUMA KO","latitude":"34.02","longitude":"132.50"},{"name":"MUTUREZIMA KO","latitude":"33.58","longitude":"130.52"},{"name":"IMABARI KO","latitude":"34.04","longitude":"133.01"},{"name":"TAKUMA","latitude":"34.13","longitude":"133.41"},{"name":"TONDA","latitude":"34.02","longitude":"131.45"},{"name":"ONODA","latitude":"34.00","longitude":"131.11"},{"name":"NIIHAMA","latitude":"33.59","longitude":"133.17"},{"name":"MISHIMA-KAWANOE KO","latitude":"34.00","longitude":"133.33"},{"name":"MARUGAME KO","latitude":"34.18","longitude":"133.47"},{"name":"SAKAIDE KO","latitude":"34.20","longitude":"133.51"},{"name":"YANAI","latitude":"33.57","longitude":"132.08"},{"name":"TOBATA","latitude":"33.55","longitude":"130.49"},{"name":"HIBIKINADA","latitude":"33.56","longitude":"130.50"},{"name":"WAKAMATSU KO","latitude":"33.54","longitude":"130.49"},{"name":"YAHATA","latitude":"33.52","longitude":"130.49"},{"name":"KOKURA KO","latitude":"33.53","longitude":"130.53"},{"name":"MOJI KO","latitude":"33.57","longitude":"130.58"},{"name":"KANDA","latitude":"33.47","longitude":"131.01"},{"name":"BEPPU","latitude":"33.19","longitude":"131.31"},{"name":"OITA KO","latitude":"33.15","longitude":"131.40"},{"name":"SAGANOSEKI KO","latitude":"33.15","longitude":"131.52"},{"name":"TSUKUMI KO","latitude":"33.05","longitude":"131.52"},{"name":"SAIKI KO","latitude":"32.58","longitude":"131.56"},{"name":"HOSOSHIMA KO","latitude":"32.26","longitude":"131.40"},{"name":"KAGOSHIMA KO","latitude":"31.35","longitude":"130.34"},{"name":"SHIBUSHI WAN","latitude":"31.28","longitude":"131.06"},{"name":"KIIRE","latitude":"31.23","longitude":"130.33"},{"name":"MINAMATA KO","latitude":"32.12","longitude":"130.23"},{"name":"YATSUSHIRO KO","latitude":"32.30","longitude":"130.32"},{"name":"MISUMI KO","latitude":"32.36","longitude":"130.28"},{"name":"MIIKE KO","latitude":"33.00","longitude":"130.25"},{"name":"MATSU-SHIMA","latitude":"32.56","longitude":"129.36"},{"name":"AOKATA","latitude":"32.59","longitude":"129.04"},{"name":"NAGASAKI","latitude":"32.43","longitude":"129.51"},{"name":"SASEBO","latitude":"33.10","longitude":"129.43"},{"name":"IMARI","latitude":"33.17","longitude":"129.53"},{"name":"KARATSU","latitude":"33.29","longitude":"129.58"},{"name":"HAKATA","latitude":"33.36","longitude":"130.24"},{"name":"IZUHARA","latitude":"34.12","longitude":"129.18"},{"name":"KIN WAN","latitude":"26.25","longitude":"127.54"},{"name":"NISHIHARA","latitude":"26.13","longitude":"127.48"},{"name":"NAHA KO","latitude":"26.13","longitude":"127.41"},{"name":"NAKAGUSUKU","latitude":"26.16","longitude":"127.55"},{"name":"HIRARA KO","latitude":"24.48","longitude":"125.17"},{"name":"ISHIGAKI","latitude":"24.20","longitude":"124.10"},{"name":"NAVLAKHI","latitude":"22.57","longitude":"70.27"},{"name":"BEDI","latitude":"22.31","longitude":"70.02"},{"name":"OKHA","latitude":"22.28","longitude":"69.05"},{"name":"DAHEJ","latitude":"21.42","longitude":"72.32"},{"name":"PORBANDAR","latitude":"21.38","longitude":"69.36"},{"name":"VERAVAL","latitude":"20.54","longitude":"70.22"},{"name":"PIPAVAV BANDAR","latitude":"20.55","longitude":"71.31"},{"name":"BHAVNAGAR","latitude":"21.46","longitude":"72.14"},{"name":"CARRABELLE","latitude":"29.51","longitude":"-84.40"},{"name":"APALACHICOLA","latitude":"29.43","longitude":"-84.59"},{"name":"PORT ST JOE","latitude":"29.49","longitude":"-85.19"},{"name":"PANAMA CITY","latitude":"30.08","longitude":"-85.39"},{"name":"PENSACOLA","latitude":"30.24","longitude":"-87.13"},{"name":"MOBILE","latitude":"30.41","longitude":"-88.07"},{"name":"PASCAGOULA","latitude":"30.21","longitude":"-88.34"},{"name":"BILOXI","latitude":"30.23","longitude":"-88.53"},{"name":"GULFPORT","latitude":"30.21","longitude":"-89.05"},{"name":"SLIDELL","latitude":"30.16","longitude":"-89.47"},{"name":"MADISONVILLE","latitude":"30.24","longitude":"-90.09"},{"name":"SOUTHWEST PASS","latitude":"28.27","longitude":"-90.42"},{"name":"PORT SULPHUR","latitude":"29.29","longitude":"-89.41"},{"name":"GRETNA","latitude":"29.55","longitude":"-90.04"},{"name":"NEW ORLEANS","latitude":"29.57","longitude":"-90.03"},{"name":"PORT OF MEMPHIS","latitude":"35.04","longitude":"-90.10"},{"name":"TRI-CITY PORT","latitude":"38.43","longitude":"-90.12"},{"name":"ST. JAMES","latitude":"29.59","longitude":"-90.56"},{"name":"CONVENT","latitude":"30.01","longitude":"-90.50"},{"name":"ST ROSE","latitude":"29.57","longitude":"-90.19"},{"name":"RESERVE","latitude":"30.03","longitude":"-90.33"},{"name":"DESTREHAN","latitude":"29.57","longitude":"-90.22"},{"name":"BATON ROUGE","latitude":"30.27","longitude":"-91.11"},{"name":"LOOP TERMINAL","latitude":"28.53","longitude":"-90.01"},{"name":"GRAND ISLE","latitude":"29.14","longitude":"-90.00"},{"name":"MORGAN CITY","latitude":"29.42","longitude":"-91.13"},{"name":"HAYMARK TERMINAL","latitude":"30.08","longitude":"-93.19"},{"name":"LAKE CHARLES","latitude":"30.13","longitude":"-93.15"},{"name":"SABINE","latitude":"29.43","longitude":"-93.52"},{"name":"SABINE PASS","latitude":"29.44","longitude":"-93.54"},{"name":"ORANGE","latitude":"30.05","longitude":"-93.44"},{"name":"PORT ARTHUR","latitude":"29.50","longitude":"-93.58"},{"name":"PORT NECHES","latitude":"30.00","longitude":"-93.57"},{"name":"BEAUMONT","latitude":"30.05","longitude":"-94.05"},{"name":"GALVESTON","latitude":"29.19","longitude":"-94.47"},{"name":"TEXAS CITY","latitude":"29.23","longitude":"-94.55"},{"name":"BAYTOWN","latitude":"29.44","longitude":"-95.01"},{"name":"NORSWORTHY","latitude":"29.44","longitude":"-95.12"},{"name":"PASADENA","latitude":"29.43","longitude":"-95.13"},{"name":"SINCO","latitude":"29.43","longitude":"-95.14"},{"name":"DEER PARK","latitude":"29.45","longitude":"-95.20"},{"name":"HOUSTON","latitude":"29.45","longitude":"-95.17"},{"name":"FREEPORT","latitude":"28.57","longitude":"-95.20"},{"name":"PALACIOS","latitude":"28.41","longitude":"-96.13"},{"name":"PORT LAVACA","latitude":"28.37","longitude":"-96.37"},{"name":"PORT OCONNOR","latitude":"28.27","longitude":"-96.24"},{"name":"ROCKPORT","latitude":"28.01","longitude":"-97.03"},{"name":"CORPUS CHRISTI","latitude":"27.49","longitude":"-97.24"},{"name":"PORT ARANSAS","latitude":"27.50","longitude":"-97.03"},{"name":"PORT INGLESIDE","latitude":"27.49","longitude":"-97.11"},{"name":"PORT ISABEL","latitude":"26.05","longitude":"-97.12"},{"name":"BROWNSVILLE","latitude":"25.57","longitude":"-97.24"},{"name":"LAGOS","latitude":"6.24","longitude":"3.24"},{"name":"TIN CAN ISLAND","latitude":"6.21","longitude":"3.21"},{"name":"ESCRAVOS OIL TERMINAL","latitude":"5.30","longitude":"5.00"},{"name":"KOKO","latitude":"6.00","longitude":"5.28"},{"name":"SAPELE","latitude":"5.54","longitude":"5.41"},{"name":"FORCADOS","latitude":"5.22","longitude":"5.26"},{"name":"FORCADOS OIL TERMINAL","latitude":"5.10","longitude":"5.11"},{"name":"BURUTU","latitude":"5.21","longitude":"5.30"},{"name":"WARRI","latitude":"5.31","longitude":"5.44"},{"name":"UKPOKITI MARINE TERMINAL","latitude":"5.43","longitude":"4.50"},{"name":"YOHO TERMINAL","latitude":"4.01","longitude":"7.28"},{"name":"SEA EAGLE TERMINAL","latitude":"4.48","longitude":"5.19"},{"name":"BRASS OIL TERMINAL","latitude":"4.04","longitude":"6.17"},{"name":"QUA IBOE OIL TERMINAL","latitude":"4.14","longitude":"8.02"},{"name":"PENNINGTON OIL TERMINAL","latitude":"4.15","longitude":"5.37"},{"name":"BONNY","latitude":"4.27","longitude":"7.10"},{"name":"BONNY OFFSHORE TERMINAL","latitude":"4.11","longitude":"7.14"},{"name":"OKRIKA","latitude":"4.43","longitude":"7.05"},{"name":"ONNE","latitude":"4.41","longitude":"7.09"},{"name":"PORT HARCOURT","latitude":"4.46","longitude":"7.00"},{"name":"ANTAN OIL TERMINAL","latitude":"4.13","longitude":"8.20"},{"name":"CALABAR","latitude":"4.58","longitude":"8.19"},{"name":"ODUDU TERMINAL","latitude":"4.00","longitude":"7.46"},{"name":"OKONO TERMINAL","latitude":"3.59","longitude":"7.18"},{"name":"OKWORI TERMINAL","latitude":"3.51","longitude":"6.59"},{"name":"WALVIS BAY","latitude":"-22.57","longitude":"14.30"},{"name":"LUDERITZ BAY","latitude":"-26.39","longitude":"15.09"},{"name":"SAN PEDRO","latitude":"4.44","longitude":"-6.37"},{"name":"BAOBAB MARINE TERMINAL","latitude":"4.58","longitude":"-4.33"},{"name":"PORT BOUET","latitude":"5.14","longitude":"-3.58"},{"name":"ABIDJAN","latitude":"5.15","longitude":"-4.01"},{"name":"ESPOIR MARINE TERMINAL","latitude":"5.03","longitude":"-4.27"},{"name":"GEMLIK","latitude":"40.25","longitude":"29.07"},{"name":"ECEABAT","latitude":"40.11","longitude":"26.22"},{"name":"GELIBOLU","latitude":"40.24","longitude":"26.40"},{"name":"BORUSAN FERTILIZER JETTY","latitude":"40.25","longitude":"29.06"},{"name":"AMBARLI","latitude":"40.58","longitude":"28.42"},{"name":"TEKIRDAG","latitude":"40.59","longitude":"27.31"},{"name":"ISTANBUL","latitude":"41.01","longitude":"28.58"},{"name":"DEFTERDAR BURNU","latitude":"41.03","longitude":"29.02"},{"name":"ISTINYE","latitude":"41.07","longitude":"29.03"},{"name":"HOPA","latitude":"41.25","longitude":"41.24"},{"name":"RIZE","latitude":"41.04","longitude":"40.31"},{"name":"TRABZON","latitude":"41.01","longitude":"39.46"},{"name":"GIRESUN","latitude":"40.56","longitude":"38.24"},{"name":"ORDU","latitude":"41.00","longitude":"37.53"},{"name":"SAMSUN","latitude":"41.18","longitude":"36.21"},{"name":"SINOP","latitude":"42.03","longitude":"35.10"},{"name":"INEBOLU","latitude":"41.59","longitude":"33.46"},{"name":"ZONGULDAK","latitude":"41.28","longitude":"31.49"},{"name":"EREGLI","latitude":"41.18","longitude":"31.27"},{"name":"HAYDARPASA","latitude":"41.00","longitude":"29.01"},{"name":"BOTAS NATURAL GAS TERMINAL","latitude":"41.00","longitude":"27.59"},{"name":"YARIMCA","latitude":"40.48","longitude":"29.42"},{"name":"KABA BURNU","latitude":"40.46","longitude":"29.32"},{"name":"DERINCE BURNU","latitude":"40.45","longitude":"29.49"},{"name":"IZMIT","latitude":"40.46","longitude":"29.55"},{"name":"GEBZE","latitude":"40.46","longitude":"29.33"},{"name":"GOLCUK BURNU","latitude":"40.44","longitude":"29.49"},{"name":"MUDANYA","latitude":"40.23","longitude":"28.53"},{"name":"BANDIRMA","latitude":"40.21","longitude":"27.58"},{"name":"ERDEK","latitude":"40.23","longitude":"27.48"},{"name":"KARABIGA","latitude":"40.24","longitude":"27.19"},{"name":"CANAKKALE","latitude":"40.09","longitude":"26.24"},{"name":"FAKSE LADEPLADS HAVN","latitude":"55.13","longitude":"12.10"},{"name":"KOGE","latitude":"55.27","longitude":"12.12"},{"name":"KOBENHAVN","latitude":"55.42","longitude":"12.37"},{"name":"TUBORG","latitude":"55.43","longitude":"12.35"},{"name":"HELSINGOR","latitude":"56.02","longitude":"12.37"},{"name":"HUNDESTED","latitude":"55.58","longitude":"11.51"},{"name":"FREDERIKSVAERK","latitude":"55.58","longitude":"12.01"},{"name":"FREDERIKSSUND","latitude":"55.50","longitude":"12.03"},{"name":"KYNDBYVAERKETS HAVN","latitude":"55.49","longitude":"11.53"},{"name":"HOLBAEK","latitude":"55.43","longitude":"11.43"},{"name":"NYKOBING (MOR)","latitude":"56.46","longitude":"11.52"},{"name":"KALUNDBORG","latitude":"55.41","longitude":"11.06"},{"name":"KORSOR","latitude":"55.20","longitude":"11.08"},{"name":"SKAELSKOR","latitude":"55.15","longitude":"11.18"},{"name":"STIGSNAESVAERKET","latitude":"55.12","longitude":"11.15"},{"name":"GULFHAVEN","latitude":"55.12","longitude":"11.16"},{"name":"NAESTVED","latitude":"55.14","longitude":"11.45"},{"name":"VORDINGBORG","latitude":"55.00","longitude":"11.54"},{"name":"STUBBEKOBING","latitude":"54.53","longitude":"12.03"},{"name":"STEGE","latitude":"54.59","longitude":"12.17"},{"name":"NYKOBING (FALSTER)","latitude":"54.46","longitude":"11.52"},{"name":"SAKSKOBING","latitude":"54.48","longitude":"11.38"},{"name":"BANDHOLM","latitude":"54.50","longitude":"11.30"},{"name":"NAKSKOV","latitude":"54.50","longitude":"11.08"},{"name":"RODBY HAVN","latitude":"54.39","longitude":"11.21"},{"name":"NYSTED","latitude":"54.40","longitude":"11.44"},{"name":"RUDKOBING","latitude":"54.57","longitude":"10.43"},{"name":"MARSTAL","latitude":"54.55","longitude":"10.20"},{"name":"AEROSKOBING","latitude":"54.53","longitude":"10.25"},{"name":"SVENDBORG","latitude":"55.04","longitude":"10.37"},{"name":"NYBORG","latitude":"55.19","longitude":"10.48"},{"name":"KERTEMINDE","latitude":"55.27","longitude":"10.40"},{"name":"ODENSE","latitude":"55.25","longitude":"10.23"},{"name":"FALKENBERG","latitude":"56.54","longitude":"12.30"},{"name":"HALMSTAD","latitude":"56.40","longitude":"12.52"},{"name":"HOGANAS","latitude":"56.12","longitude":"12.33"},{"name":"HELSINGBORG","latitude":"56.03","longitude":"12.42"},{"name":"LANDSKRONA","latitude":"55.52","longitude":"12.50"},{"name":"MALMO","latitude":"55.37","longitude":"13.00"},{"name":"LIMHAMN","latitude":"55.35","longitude":"12.56"},{"name":"TRELLEBORG","latitude":"55.22","longitude":"13.09"},{"name":"YSTAD","latitude":"55.26","longitude":"13.50"};
 
</script>
@endsection
