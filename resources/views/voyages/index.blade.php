@extends('layouts.app')

@section('content')
<div>
    Date: {{$date->format('m/d/Y')}}<br/>
 
</div>
 <div class="form-group col-sm-6" style="height:240px;">
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
 
 
 <div class="form-group col-sm-6" style="height:240px;">
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
    <td style="text-align:right">{{$cargo->laycan_first_day->format('m/d/Y')}}</td> 
  </tr>
  <tr>
    <th>LayCanLast:</th>
    <td style="text-align:right">{{$cargo->laycan_last_day->format('m/d/Y')}}</td> 
  </tr>
  <tr>
    <th>Commission:</th>
    <td style="text-align:right">{{$cargo->commission}} %</td> 
  </tr>

</table>
 </div>

 <div class="form-group col-sm-6" style="height:180px;">
 <div class="voyage_box_title">Start Port</div>
 <table style="min-width:300px">
  <tr>
    <th>Name:</th>
    <td style="text-align:right">{{$port_start->name}}</td> 
  </tr>
  <tr>
    <th>Zone:</th>
    <td style="text-align:right">{{$port_start_zone}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td style="text-align:right">{{$port_start->max_laden_draft}}</td> 
  </tr>
    <tr>
    <th>Draft Factor:</th>
    <td style="text-align:right">{{$port_start->draft_factor}}</td> 
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
 
 <div class="form-group col-sm-6" style="height:180px;">
 <div class="voyage_box_title">End Port</div>
 <table style="min-width:300px">
  <tr>
    <th>Name:</th>
    <td style="text-align:right">{{$port_end->name}}</td> 
  </tr>
  <tr>
    <th>Zone:</th>
    <td style="text-align:right">{{$port_end_zone}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td style="text-align:right">{{$port_end->max_laden_draft}}</td> 
  </tr>
    <tr>
    <th>Draft Factor:</th>
    <td style="text-align:right">{{$port_end->draft_factor}}</td> 
  </tr>
  <tr>
    <th>Load/Disch Rate:</th>
    <td style="text-align:right">{{number_format($cargo->discharging_rate,0)}}</td> 
  </tr>
  <tr>
    <th>Rate Type</th>
    <td style="text-align:right">{{$port_start_rate_type}}</td> 
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

 <div class="form-group col-sm-6" style="height:180px;">
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
 
 <div class="form-group col-sm-6" style="height:190px;">
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
 
 

 
 
 
 <!--


    <h1>Calculation</h1>

    <div class="form-group col-sm-6">
        {!! Form::label('route', 'Route:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('bdi', 'BDI:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fuel_price', 'Fuel Price:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fuel_consumption', 'Fuel Consumption:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fuel_cost', 'Fuel cost:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('remaining_size', 'Remaining Size:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('remaining_tonnage', 'Remaining Tonnage:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('draft', 'Draft:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('non_hire_cost', 'Non Hire Cost:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('ntce', 'NTCE:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('range_to_start', 'Range to Start:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('distance_to_start', 'Distance to Start:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('distance_start_to_end', 'Distance Start to End:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('distance_total', 'Distance Total:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('days_to_start', 'Days to Start:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('days_to_end', 'Days to End:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('port_time', 'Port Time:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('voyage_time', 'Voyage Time:') !!}
    </div>
	-->
@endsection

