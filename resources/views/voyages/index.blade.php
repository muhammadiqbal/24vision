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
var ports = getPorts(); 

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

         //render the points
         ports.forEach(function(d) { 
            var x = projection(d.coordinates)[1];
            var y = projection(d.coordinates)[0];

            svg.append("svg:circle")
            .attr("class","point")
            .attr("cx", x)
            .attr("cy", y)
            .attr("fill", "#FF0000")
            .attr("r", 3);
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
  //coordinates[long, lat]
  return   [{"name":"FANG-CHENG","coordinates":[21.45,108.21]},
  {"name":"BEIHAI","coordinates":[21.29,109.04]},
  {"name":"HAIKOU","coordinates":[20.03,110.17]},
  {"name":"BASUO","coordinates":[19.06,108.37]},
  {"name":"ZHANJIANG","coordinates":[21.12,110.24]},
  {"name":"LON SHUI TERMINAL","coordinates":[20.50,115.41]},
  {"name":"SHEKOU","coordinates":[22.28,113.52]},
  {"name":"SANYA","coordinates":[18.19,109.27]},
  {"name":"YANGPU","coordinates":[19.44,109.11]},
  {"name":"CHIWAN","coordinates":[19.58,110.02]},
  {"name":"SHUI DONG","coordinates":[21.29,111.05]},
  {"name":"QINZHOU","coordinates":[21.44,108.35]},
  {"name":"ZHUHAI","coordinates":[22.14,113.35]},
  {"name":"HUANGPU","coordinates":[23.05,113.25]},
  {"name":"HUANGPUXINGANG","coordinates":[23.05,113.30]},
  {"name":"GUANGZHOU","coordinates":[23.07,113.14]},
  {"name":"YANTIAN","coordinates":[22.35,114.16]},
  {"name":"HUIZHOU","coordinates":[22.43,114.31]},
  {"name":"SHAN T OU","coordinates":[23.22,116.41]},
  {"name":"CHAOZHOU","coordinates":[23.37,117.05]},
  {"name":"DONGSHAN","coordinates":[23.45,117.31]},
  {"name":"XIAMEN","coordinates":[24.27,118.04]},
  {"name":"ZHANGZHOU","coordinates":[24.41,118.09]},
  {"name":"QUANZHOU","coordinates":[24.53,118.36]},
  {"name":"XIUYU","coordinates":[25.14,118.59]},
  {"name":"FUZHOU","coordinates":[26.05,119.18]},
  {"name":"WENZHOU","coordinates":[28.01,120.39]},
  {"name":"HAIMEN","coordinates":[28.41,121.27]},
  {"name":"NINGBO","coordinates":[29.53,121.33]},
  {"name":"ZHEN HAI","coordinates":[29.57,121.42]},
  {"name":"ZHOUSHAN","coordinates":[30.00,122.06]},
  {"name":"ZHAPU","coordinates":[30.35,121.05]},
  {"name":"SHANGHAI","coordinates":[31.13,121.30]},
  {"name":"CHANGSHU","coordinates":[31.46,120.57]},
  {"name":"TAICANG","coordinates":[31.39,121.12]},
  {"name":"JIANGYIN","coordinates":[31.55,120.14]},
  {"name":"CHANGZHOU","coordinates":[31.58,119.59]},
  {"name":"GAOGANG","coordinates":[32.17,119.51]},
  {"name":"YANGZHOU","coordinates":[32.16,119.26]},
  {"name":"ZHANGJIANGANG","coordinates":[31.58,120.24]},
  {"name":"NANTONG","coordinates":[32.00,120.48]},
  {"name":"ZHENJIANG","coordinates":[32.13,119.26]},
  {"name":"NANJING","coordinates":[32.05,118.45]},
  {"name":"WU HU","coordinates":[31.20,118.22]},
  {"name":"ANKINGCHENG","coordinates":[30.31,117.02]},
  {"name":"HANKOW","coordinates":[30.35,114.17]},
  {"name":"WANXIAN","coordinates":[30.49,108.26]},
  {"name":"CHUNG CHING","coordinates":[29.34,106.38]},
  {"name":"LANSHAN","coordinates":[30.06,119.22]},
  {"name":"LIANYUNGANG","coordinates":[34.44,119.27]},
  {"name":"RIZHAO","coordinates":[35.23,119.34]},
  {"name":"QINGDAO GANG","coordinates":[36.02,120.16]},
  {"name":"WEIHAI","coordinates":[37.30,122.06]},
  {"name":"YANTAI","coordinates":[37.33,121.27]},
  {"name":"PENGLAI","coordinates":[37.49,120.50]},
  {"name":"LONGKOU GANG","coordinates":[37.38,120.17]},
  {"name":"DAGU TANGGU","coordinates":[38.58,117.40]},
  {"name":"TIANJIN XIN GANG","coordinates":[38.58,117.50]},
  {"name":"TANGSHAN (JINGTANG)","coordinates":[39.12,119.01]},
  {"name":"QINHUANGDAO","coordinates":[39.56,119.37]},
  {"name":"SUIZHANG GANG","coordinates":[40.04,121.03]},
  {"name":"HULUDAO GANG","coordinates":[40.42,120.59]},
  {"name":"JINZHOU WAN","coordinates":[40.45,121.06]},
  {"name":"YINGKOU","coordinates":[40.41,122.14]},
  {"name":"BAYUQUAN","coordinates":[40.18,122.05]},
  {"name":"DANDONG","coordinates":[39.49,124.09]},
  {"name":"LUSHUN","coordinates":[38.47,121.15]},
  {"name":"DALIAN","coordinates":[38.55,121.40]},
  {"name":"INCHON","coordinates":[37.28,126.37]},
  {"name":"DAESAN HANG","coordinates":[37.01,126.24]},
  {"name":"PYEONGTAEK HANG","coordinates":[37.00,126.48]},
  {"name":"KUNSAN","coordinates":[35.59,126.37]},
  {"name":"MOKPO","coordinates":[34.47,126.23]},
  {"name":"CHEJU HANG","coordinates":[33.31,126.32]},
  {"name":"YOSU","coordinates":[34.44,127.45]},
  {"name":"GWANGYANG HANG","coordinates":[34.51,127.48]},
  {"name":"MASAN","coordinates":[35.11,128.34]},
  {"name":"CHINAE","coordinates":[35.08,128.39]},
  {"name":"PUSAN","coordinates":[35.06,129.02]},
  {"name":"ULSAN","coordinates":[35.27,129.24]},
  {"name":"POHANG","coordinates":[36.03,129.23]},
  {"name":"MUKHO","coordinates":[37.34,129.07]},
  {"name":"TONGHAE","coordinates":[37.32,129.09]},
  {"name":"SOKCHO HANG","coordinates":[38.12,128.36]},
  {"name":"MOMBETSU KO","coordinates":[44.21,143.21]},
  {"name":"ABASHIRI KO","coordinates":[44.01,144.17]},
  {"name":"NEMURO KO","coordinates":[43.20,145.35]},
  {"name":"HANASAKI KO","coordinates":[43.17,145.35]},
  {"name":"KUSHIRO KO","coordinates":[42.59,144.22]},
  {"name":"TOMAKOMAI KO","coordinates":[42.38,141.38]},
  {"name":"MURORAN KO","coordinates":[42.21,140.58]},
  {"name":"TOKACHI","coordinates":[42.15,143.18]},
  {"name":"MORI","coordinates":[42.07,140.35]},
  {"name":"HAKODATE KO","coordinates":[41.47,140.43]},
  {"name":"ESASI KO","coordinates":[41.52,140.07]},
  {"name":"OTARU KO","coordinates":[43.12,141.01]},
  {"name":"ISIKARI WAN","coordinates":[43.14,141.22]},
  {"name":"ISHIKARI BAY NEW PORT","coordinates":[43.13,141.17]},
  {"name":"RUMOI KO","coordinates":[43.57,141.38]},
  {"name":"WAKKANAI","coordinates":[43.25,141.41]},
  {"name":"AOMORI KO","coordinates":[40.50,140.45]},
  {"name":"NOSHIRO KO","coordinates":[40.13,140.00]},
  {"name":"HACHINOHE KO","coordinates":[40.32,141.33]},
  {"name":"MIYAKO","coordinates":[39.38,141.59]},
  {"name":"KAMAISHI KO","coordinates":[39.16,141.54]},
  {"name":"OFUNATO","coordinates":[39.03,141.44]},
  {"name":"KESENNUMA KO","coordinates":[38.52,141.36]},
  {"name":"ONAGAWA","coordinates":[38.27,141.27]},
  {"name":"ISHINOMAKI KO","coordinates":[38.24,141.19]},
  {"name":"SENDAI-SHIOGAMA","coordinates":[38.19,141.02]},
  {"name":"SOMA","coordinates":[37.50,140.57]},
  {"name":"ONAHAMA KO","coordinates":[36.56,140.54]},
  {"name":"HITACHI","coordinates":[36.30,140.38]},
  {"name":"KASHIMA KO","coordinates":[35.56,140.42]},
  {"name":"CHOSHI","coordinates":[35.44,140.51]},
  {"name":"TATEYAMA KO","coordinates":[35.00,139.48]},
  {"name":"KISARAZU KO","coordinates":[35.22,139.53]},
  {"name":"CHIBA KO","coordinates":[35.35,140.04]},
  {"name":"KATSUNAN KO","coordinates":[35.40,139.59]},
  {"name":"FUNABASHI","coordinates":[35.40,139.57]},
  {"name":"TOKYO KO","coordinates":[35.40,139.45]},
  {"name":"KAWASAKI KO","coordinates":[35.30,139.46]},
  {"name":"YOKOHAMA KO","coordinates":[35.27,139.35]},
  {"name":"YOKOSUKA KO","coordinates":[35.17,139.40]},
  {"name":"URAGA KO","coordinates":[35.14,139.43]},
  {"name":"TAGONOURA KO","coordinates":[35.08,138.42]},
  {"name":"ATSUMI","coordinates":[34.40,137.04]},
  {"name":"SHIMODA KO","coordinates":[34.40,138.57]},
  {"name":"OMAEZAKI KO","coordinates":[34.36,138.14]},
  {"name":"SHIMIZU KO","coordinates":[35.01,138.30]},
  {"name":"MIKAWA","coordinates":[34.43,137.18]},
  {"name":"KINUURA KO","coordinates":[34.51,136.57]},
  {"name":"GAMAGORI KO","coordinates":[34.49,137.13]},
  {"name":"NAGOYA KO","coordinates":[35.04,136.52]},
  {"name":"YOKKAICHI","coordinates":[34.58,136.38]},
  {"name":"MATSUSAKA","coordinates":[34.36,136.34]},
  {"name":"TOBA","coordinates":[34.29,136.51]},
  {"name":"OWASE KO","coordinates":[34.04,136.13]},
  {"name":"TANABE KO","coordinates":[33.43,135.22]},
  {"name":"YURA","coordinates":[33.57,135.06]},
  {"name":"WAKAYAMA-SHIMOTSU KO","coordinates":[34.12,135.08]},
  {"name":"SAKAI-SENBOKU","coordinates":[34.33,135.26]},
  {"name":"OSAKA","coordinates":[34.39,135.26]},
  {"name":"AMAGASAKI","coordinates":[34.42,135.23]},
  {"name":"KOBE","coordinates":[34.39,135.11]},
  {"name":"HIROHATA","coordinates":[34.46,134.38]},
  {"name":"SHIKAMA","coordinates":[34.46,134.39]},
  {"name":"HIMEJI","coordinates":[34.45,134.38]},
  {"name":"HIGASHI-HARIMA","coordinates":[34.42,134.50]},
  {"name":"AIOI","coordinates":[34.47,134.28]},
  {"name":"O0KIHAMA","coordinates":[34.45,134.34]},
  {"name":"KAKOGAWA","coordinates":[34.42,134.50]},
  {"name":"UNO KO","coordinates":[34.29,133.57]},
  {"name":"HIBI KO","coordinates":[34.27,133.56]},
  {"name":"MIZUSHIMA KO","coordinates":[34.30,133.45]},
  {"name":"FUKUYAMA","coordinates":[34.26,133.26]},
  {"name":"HABU KO","coordinates":[34.17,133.11]},
  {"name":"ONOMICHI-ITOZAKI","coordinates":[34.23,133.10]},
  {"name":"KURE","coordinates":[34.14,132.33]},
  {"name":"MITSUKOJIMA","coordinates":[34.11,132.31]},
  {"name":"HIROSHIMA","coordinates":[34.21,132.28]},
  {"name":"KANOKAWA KO","coordinates":[34.11,132.26]},
  {"name":"IWAKUNI KO","coordinates":[34.11,132.15]},
  {"name":"NAMIKATA","coordinates":[34.07,132.54]},
  {"name":"KUDAMATSU","coordinates":[34.00,131.52]},
  {"name":"TOKUYAMA","coordinates":[34.02,131.49]},
  {"name":"UBE KO","coordinates":[33.56,131.14]},
  {"name":"HIKARI","coordinates":[33.57,131.56]},
  {"name":"SHIMONOSEKI","coordinates":[33.56,130.56]},
  {"name":"HAGI KO","coordinates":[34.25,131.24]},
  {"name":"HAMADA KO","coordinates":[34.54,132.05]},
  {"name":"SAKAI KO","coordinates":[35.33,133.15]},
  {"name":"SAKAIMINATO","coordinates":[35.32,133.14]},
  {"name":"MIYAZU","coordinates":[35.32,135.12]},
  {"name":"MAIZURU KO","coordinates":[35.31,135.20]},
  {"name":"UCHIURA","coordinates":[35.31,135.30]},
  {"name":"FUKUI","coordinates":[36.04,136.12]},
  {"name":"TSURUGA KO","coordinates":[35.39,136.04]},
  {"name":"FUKUI KO","coordinates":[36.11,136.06]},
  {"name":"KANAZAWA","coordinates":[36.37,136.36]},
  {"name":"NANAO KO","coordinates":[37.03,136.59]},
  {"name":"FUSHIKI-TOYAMA","coordinates":[36.46,137.08]},
  {"name":"SHIMMINATO","coordinates":[36.46,137.07]},
  {"name":"HIMEKAWA","coordinates":[37.02,137.51]},
  {"name":"NAOETSU KO","coordinates":[37.11,138.15]},
  {"name":"KASHIWAZAKI","coordinates":[37.22,138.33]},
  {"name":"NIIGATA KO","coordinates":[37.55,139.03]},
  {"name":"EASTERN PART OF NIIGATA-KO","coordinates":[38.01,139.14]},
  {"name":"RYOTU KO","coordinates":[38.05,138.34]},
  {"name":"SAKATA KO","coordinates":[38.56,139.49]},
  {"name":"AKITA-FUNAKAWA KO","coordinates":[39.50,140.00]},
  {"name":"MEGA","coordinates":[34.47,134.42]},
  {"name":"HANNAN KO","coordinates":[34.28,135.21]},
  {"name":"TAKAMATSU","coordinates":[34.21,134.03]},
  {"name":"KOMATSUSHIMA","coordinates":[34.01,134.36]},
  {"name":"TACHIBANA","coordinates":[33.52,134.40]},
  {"name":"SHINGU","coordinates":[33.40,135.59]},
  {"name":"KOCHI KO","coordinates":[33.30,133.34]},
  {"name":"SUSAKI KO","coordinates":[33.23,133.18]},
  {"name":"UWAJIMA KO","coordinates":[33.13,132.34]},
  {"name":"YAWATAHAMA","coordinates":[33.27,132.25]},
  {"name":"MATSUYAMA","coordinates":[33.51,132.42]},
  {"name":"KIKUMA KO","coordinates":[34.02,132.50]},
  {"name":"MUTUREZIMA KO","coordinates":[33.58,130.52]},
  {"name":"IMABARI KO","coordinates":[34.04,133.01]},
  {"name":"TAKUMA","coordinates":[34.13,133.41]},
  {"name":"TONDA","coordinates":[34.02,131.45]},
  {"name":"ONODA","coordinates":[34.00,131.11]},
  {"name":"NIIHAMA","coordinates":[33.59,133.17]},
  {"name":"MISHIMA-KAWANOE KO","coordinates":[34.00,133.33]},
  {"name":"MARUGAME KO","coordinates":[34.18,133.47]},
  {"name":"SAKAIDE KO","coordinates":[34.20,133.51]},
  {"name":"YANAI","coordinates":[33.57,132.08]},
  {"name":"TOBATA","coordinates":[33.55,130.49]},
  {"name":"HIBIKINADA","coordinates":[33.56,130.50]},
  {"name":"WAKAMATSU KO","coordinates":[33.54,130.49]},
  {"name":"YAHATA","coordinates":[33.52,130.49]},
  {"name":"KOKURA KO","coordinates":[33.53,130.53]},
  {"name":"MOJI KO","coordinates":[33.57,130.58]},
  {"name":"KANDA","coordinates":[33.47,131.01]},
  {"name":"BEPPU","coordinates":[33.19,131.31]},
  {"name":"OITA KO","coordinates":[33.15,131.40]},
  {"name":"SAGANOSEKI KO","coordinates":[33.15,131.52]},
  {"name":"TSUKUMI KO","coordinates":[33.05,131.52]},
  {"name":"SAIKI KO","coordinates":[32.58,131.56]},
  {"name":"HOSOSHIMA KO","coordinates":[32.26,131.40]},
  {"name":"KAGOSHIMA KO","coordinates":[31.35,130.34]},
  {"name":"SHIBUSHI WAN","coordinates":[31.28,131.06]},
  {"name":"KIIRE","coordinates":[31.23,130.33]},
  {"name":"MINAMATA KO","coordinates":[32.12,130.23]},
  {"name":"YATSUSHIRO KO","coordinates":[32.30,130.32]},
  {"name":"MISUMI KO","coordinates":[32.36,130.28]},
  {"name":"MIIKE KO","coordinates":[33.00,130.25]},
  {"name":"MATSU-SHIMA","coordinates":[32.56,129.36]},
  {"name":"AOKATA","coordinates":[32.59,129.04]},
  {"name":"NAGASAKI","coordinates":[32.43,129.51]},
  {"name":"SASEBO","coordinates":[33.10,129.43]},
  {"name":"IMARI","coordinates":[33.17,129.53]},
  {"name":"KARATSU","coordinates":[33.29,129.58]},
  {"name":"HAKATA","coordinates":[33.36,130.24]},
  {"name":"IZUHARA","coordinates":[34.12,129.18]},
  {"name":"KIN WAN","coordinates":[26.25,127.54]},
  {"name":"NISHIHARA","coordinates":[26.13,127.48]},
  {"name":"NAHA KO","coordinates":[26.13,127.41]},
  {"name":"NAKAGUSUKU","coordinates":[26.16,127.55]},
  {"name":"HIRARA KO","coordinates":[24.48,125.17]},
  {"name":"ISHIGAKI","coordinates":[24.20,124.1]},
  {"name":"NAVLAKHI","coordinates":[22.57,70.27]},
  {"name":"BEDI","coordinates":[22.31,70.02]},
  {"name":"OKHA","coordinates":[22.28,69.05]},
  {"name":"DAHEJ","coordinates":[21.42,72.32]},
  {"name":"PORBANDAR","coordinates":[21.38,69.36]},
  {"name":"VERAVAL","coordinates":[20.54,70.22]},
  {"name":"PIPAVAV BANDAR","coordinates":[20.55,71.31]},
  {"name":"BHAVNAGAR","coordinates":[21.46,72.14]},
  {"name":"CARRABELLE","coordinates":[29.51,-84.40]},
  {"name":"APALACHICOLA","coordinates":[29.43,-84.59]},
  {"name":"PORT ST JOE","coordinates":[29.49,-85.19]},
  {"name":"PANAMA CITY","coordinates":[30.08,-85.39]},
  {"name":"PENSACOLA","coordinates":[30.24,-87.13]},
  {"name":"MOBILE","coordinates":[30.41,-88.07]},
  {"name":"PASCAGOULA","coordinates":[30.21,-88.34]},
  {"name":"BILOXI","coordinates":[30.23,-88.53]},
  {"name":"GULFPORT","coordinates":[30.21,-89.05]},
  {"name":"SLIDELL","coordinates":[30.16,-89.47]},
  {"name":"MADISONVILLE","coordinates":[30.24,-90.09]},
  {"name":"SOUTHWEST PASS","coordinates":[28.27,-90.42]},
  {"name":"PORT SULPHUR","coordinates":[29.29,-89.41]},
  {"name":"GRETNA","coordinates":[29.55,-90.04]},
  {"name":"NEW ORLEANS","coordinates":[29.57,-90.03]},
  {"name":"PORT OF MEMPHIS","coordinates":[35.04,-90.10]},
  {"name":"TRI-CITY PORT","coordinates":[38.43,-90.12]},
  {"name":"ST. JAMES","coordinates":[29.59,-90.56]},
  {"name":"CONVENT","coordinates":[30.01,-90.50]},
  {"name":"ST ROSE","coordinates":[29.57,-90.19]},
  {"name":"RESERVE","coordinates":[30.03,-90.33]},
  {"name":"DESTREHAN","coordinates":[29.57,-90.22]},
  {"name":"BATON ROUGE","coordinates":[30.27,-91.11]},
  {"name":"LOOP TERMINAL","coordinates":[28.53,-90.01]},
  {"name":"GRAND ISLE","coordinates":[29.14,-90.00]},
  {"name":"MORGAN CITY","coordinates":[29.42,-91.13]},
  {"name":"HAYMARK TERMINAL","coordinates":[30.08,-93.19]},
  {"name":"LAKE CHARLES","coordinates":[30.13,-93.15]},
  {"name":"SABINE","coordinates":[29.43,-93.52]},
  {"name":"SABINE PASS","coordinates":[29.44,-93.54]},
  {"name":"ORANGE","coordinates":[30.05,-93.44]},
  {"name":"PORT ARTHUR","coordinates":[29.50,-93.58]},
  {"name":"PORT NECHES","coordinates":[30.00,-93.57]},
  {"name":"BEAUMONT","coordinates":[30.05,-94.05]},
  {"name":"GALVESTON","coordinates":[29.19,-94.47]},
  {"name":"TEXAS CITY","coordinates":[29.23,-94.55]},
  {"name":"BAYTOWN","coordinates":[29.44,-95.01]},
  {"name":"NORSWORTHY","coordinates":[29.44,-95.12]},
  {"name":"PASADENA","coordinates":[29.43,-95.13]},
  {"name":"SINCO","coordinates":[29.43,-95.14]},
  {"name":"DEER PARK","coordinates":[29.45,-95.20]},
  {"name":"HOUSTON","coordinates":[29.45,-95.17]},
  {"name":"FREEPORT","coordinates":[28.57,-95.20]},
  {"name":"PALACIOS","coordinates":[28.41,-96.13]},
  {"name":"PORT LAVACA","coordinates":[28.37,-96.37]},
  {"name":"PORT OCONNOR","coordinates":[28.27,-96.24]},
  {"name":"ROCKPORT","coordinates":[28.01,-97.03]},
  {"name":"CORPUS CHRISTI","coordinates":[27.49,-97.24]},
  {"name":"PORT ARANSAS","coordinates":[27.50,-97.03]},
  {"name":"PORT INGLESIDE","coordinates":[27.49,-97.11]},
  {"name":"PORT ISABEL","coordinates":[26.05,-97.12]},
  {"name":"BROWNSVILLE","coordinates":[25.57,-97.24]},
  {"name":"LAGOS","coordinates":[6.24,3.24]},
  {"name":"TIN CAN ISLAND","coordinates":[6.21,3.21]},
  {"name":"ESCRAVOS OIL TERMINAL","coordinates":[5.30,5.00]},
  {"name":"KOKO","coordinates":[6.00,5.28]},
  {"name":"SAPELE","coordinates":[5.54,5.41]},
  {"name":"FORCADOS","coordinates":[5.22,5.26]},
  {"name":"FORCADOS OIL TERMINAL","coordinates":[5.10,5.11]},
  {"name":"BURUTU","coordinates":[5.21,5.30},
  {"name":"WARRI","coordinates":[5.31,5.44},
  {"name":"UKPOKITI MARINE TERMINAL","coordinates":[5.43,4.50]},
  {"name":"YOHO TERMINAL","coordinates":[4.01,7.28]},
  {"name":"SEA EAGLE TERMINAL","coordinates":[4.48,5.19]},
  {"name":"BRASS OIL TERMINAL","coordinates":[4.04,6.17]},
  {"name":"QUA IBOE OIL TERMINAL","coordinates":[4.14,8.02]},
  {"name":"PENNINGTON OIL TERMINAL","coordinates":[4.15,5.37]},
  {"name":"BONNY","coordinates":[4.27,7.10]},
  {"name":"BONNY OFFSHORE TERMINAL","coordinates":[4.11,7.14},
  {"name":"OKRIKA","coordinates":[4.43,7.05]},
  {"name":"ONNE","coordinates":[4.41,7.09]},
  {"name":"PORT HARCOURT","coordinates":[4.46,7.00]},
  {"name":"ANTAN OIL TERMINAL","coordinates":[4.13,8.20]},
  {"name":"CALABAR","coordinates":[4.58,8.19]},
  {"name":"ODUDU TERMINAL","coordinates":[4.00,7.46]},
  {"name":"OKONO TERMINAL","coordinates":[3.59,7.18]},
  {"name":"OKWORI TERMINAL","coordinates":[3.51,6.59]},
  {"name":"WALVIS BAY","coordinates":[-22.5714.30]},
  {"name":"LUDERITZ BAY","coordinates":[-26.3915.09]},
  {"name":"SAN PEDRO","coordinates":[4.44,-6.37]},
  {"name":"BAOBAB MARINE TERMINAL","coordinates":[4.58,-4.33]},
  {"name":"PORT BOUET","coordinates":[5.14,-3.58]},
  {"name":"ABIDJAN","coordinates":[5.15,-4.01]},
  {"name":"ESPOIR MARINE TERMINAL","coordinates":[5.03,-4.27]},
  {"name":"GEMLIK","coordinates":[40.25,29.07]},
  {"name":"ECEABAT","coordinates":[40.11,26.22]},
  {"name":"GELIBOLU","coordinates":[40.24,26.40]},
  {"name":"BORUSAN FERTILIZER JETTY","coordinates":[40.25,29.06]},
  {"name":"AMBARLI","coordinates":[40.58,28.42]},
  {"name":"TEKIRDAG","coordinates":[40.59,27.31]},
  {"name":"ISTANBUL","coordinates":[41.01,28.58]},
  {"name":"DEFTERDAR BURNU","coordinates":[41.03,29.02]},
  {"name":"ISTINYE","coordinates":[41.07,29.03]},
  {"name":"HOPA","coordinates":[41.25,41.24]},
  {"name":"RIZE","coordinates":[41.04,40.31]},
  {"name":"TRABZON","coordinates":[41.01,39.46]},
  {"name":"GIRESUN","coordinates":[40.56,38.24]},
  {"name":"ORDU","coordinates":[41.00,37.53]},
  {"name":"SAMSUN","coordinates":[41.18,36.21]},
  {"name":"SINOP","coordinates":[42.03,35.10]},
  {"name":"INEBOLU","coordinates":[41.59,33.46]},
  {"name":"ZONGULDAK","coordinates":[41.28,31.49]},
  {"name":"EREGLI","coordinates":[41.18,31.27]},
  {"name":"HAYDARPASA","coordinates":[41.00,29.01]},
  {"name":"BOTAS NATURAL GAS TERMINAL","coordinates":[41.00,27.59]},
  {"name":"YARIMCA","coordinates":[40.48,29.42]},
  {"name":"KABA BURNU","coordinates":[40.46,29.32]},
  {"name":"DERINCE BURNU","coordinates":[40.45,29.49]},
  {"name":"IZMIT","coordinates":[40.46,29.55]},
  {"name":"GEBZE","coordinates":[40.46,29.33]},
  {"name":"GOLCUK BURNU","coordinates":[40.44,29.49]},
  {"name":"MUDANYA","coordinates":[40.23,28.53]},
  {"name":"BANDIRMA","coordinates":[40.21,27.58]},
  {"name":"ERDEK","coordinates":[40.23,27.48]},
  {"name":"KARABIGA","coordinates":[40.24,27.19]},
  {"name":"CANAKKALE","coordinates":[40.09,26.24]},
  {"name":"FAKSE LADEPLADS HAVN","coordinates":[55.13,12.10]},
  {"name":"KOGE","coordinates":[55.27,12.12]},
  {"name":"KOBENHAVN","coordinates":[55.42,12.37]},
  {"name":"TUBORG","coordinates":[55.43,12.35]},
  {"name":"HELSINGOR","coordinates":[56.02,12.37]},
  {"name":"HUNDESTED","coordinates":[55.58,11.51]},
  {"name":"FREDERIKSVAERK","coordinates":[55.58,12.01]},
  {"name":"FREDERIKSSUND","coordinates":[55.50,12.03]},
  {"name":"KYNDBYVAERKETS HAVN","coordinates":[55.49,11.53]},
  {"name":"HOLBAEK","coordinates":[55.43,11.43]},
  {"name":"NYKOBING (MOR)","coordinates":[56.46,11.52]},
  {"name":"KALUNDBORG","coordinates":[55.41,11.06]},
  {"name":"KORSOR","coordinates":[55.20,11.08]},
  {"name":"SKAELSKOR","coordinates":[55.15,11.18]},
  {"name":"STIGSNAESVAERKET","coordinates":[55.12,11.15]},
  {"name":"GULFHAVEN","coordinates":[55.12,11.16]},
  {"name":"NAESTVED","coordinates":[55.14,11.45]},
  {"name":"VORDINGBORG","coordinates":[55.00,11.54]},
  {"name":"STUBBEKOBING","coordinates":[54.53,12.03]},
  {"name":"STEGE","coordinates":[54.59,12.17]},
  {"name":"NYKOBING (FALSTER)","coordinates":[54.46,11.52]},
  {"name":"SAKSKOBING","coordinates":[54.48,11.38]},
  {"name":"BANDHOLM","coordinates":[54.50,11.30]},
  {"name":"NAKSKOV","coordinates":[54.50,11.08]},
  {"name":"RODBY HAVN","coordinates":[54.39,11.21]},
  {"name":"NYSTED","coordinates":[54.40,11.44]},
  {"name":"RUDKOBING","coordinates":[54.57,10.43]},
  {"name":"MARSTAL","coordinates":[54.55,10.20]},
  {"name":"AEROSKOBING","coordinates":[54.53,10.25]},
  {"name":"SVENDBORG","coordinates":[55.04,10.37]},
  {"name":"NYBORG","coordinates":[55.19,10.48]},
  {"name":"KERTEMINDE","coordinates":[55.27,10.40]},
  {"name":"ODENSE","coordinates":[55.25,10.23]},
  {"name":"FALKENBERG","coordinates":[56.54,12.30]},
  {"name":"HALMSTAD","coordinates":[56.40,12.52]},
  {"name":"HOGANAS","coordinates":[56.12,12.33]},
  {"name":"HELSINGBORG","coordinates":[56.03,12.42]},
  {"name":"LANDSKRONA","coordinates":[55.52,12.50]},
  {"name":"MALMO","coordinates":[55.37,13.00]},
  {"name":"LIMHAMN","coordinates":[55.35,12.56]},
  {"name":"TRELLEBORG","coordinates":[55.22,13.09]},
  {"name":"YSTAD","coordinates":[55.26,13.50]}
  ];
}
</script>
@endsection
