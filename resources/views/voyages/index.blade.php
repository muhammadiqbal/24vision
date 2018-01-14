@extends('layouts.app')

@section('content')
    Date:
    Range: 
 <div class="voyage_container">
	<div>
 <div class="voyage_box_ship">
 <div class="voyage_box_title">Ship</div>
 <table>
  <tr>
    <th>Name:</th>
    <td>{{$ship->name}}</td> 
  </tr>
  <tr>
    <th>Imo:</th>
    <td>{{$ship->imo}}</td> 
  </tr>
  <tr>
    <th>DWCC:</th>
    <td>{{number_format($ship->dwcc,0)}}</td> 
  </tr>
    <tr>
    <th>Max Holds Capacity:</th>
    <td>{{number_format($ship->max_holds_capacity,0)}}</td> 
  </tr>
  <tr>
    <th>Ballast Draft</th>
    <td>{{$ship->ballast_draft}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td>{{$ship->max_laden_draft}}</td> 
  </tr>
  <tr>
    <th>Speed Laden:</th>
    <td>{{number_format($ship->speed_laden,1)}}</td> 
  </tr>
  <tr>
    <th>Speed Ballast:</th>
    <td>{{number_format($ship->speed_ballast,1)}}</td> 
  </tr>
  <tr>
    <th>Fuel Type:</th>
    <td>{{$ship_fuel_type}}</td> 
  </tr>
  <tr>
    <th>Fuel Cons. at Sea:</th>
    <td>{{number_format($ship->fuel_consumption_at_sea,1)}}</td> 
  </tr>
  <tr>
    <th>Fuel Cons. in Port:</th>
    <td>{{number_format($ship->fuel_consumption_in_port,1)}}</td> 
  </tr>
</table>
 </div>
 
 
 <div class="voyage_box_cargo">
 <div class="voyage_box_title">Cargo</div>
 <table>
  <tr>
    <th>Cargo:</th>
    <td>{{$cargo_name}}</td> 
  </tr>
  <tr>
    <th>Quantity:</th>
    <td>{{$cargo->quantity}}</td> 
  </tr>
  <tr>
    <th>StowageFactor:</th>
    <td>{{$cargo->stowage}}</td> 
  </tr>
    <tr>
    <th>LayCanFirst:</th>
    <td>{{$cargo->laycan_first_day}}</td> 
  </tr>
  <tr>
    <th>LayCanLast:</th>
    <td>{{$cargo->laycan_last_day}}</td> 
  </tr>
  <tr>
    <th>Commission:</th>
    <td>{{$cargo->commission}} %</td> 
  </tr>

</table>
 </div>
 <div class="footer"></div>
	</div>
 
 
	<div>
 <div class="voyage_box_startport">
 <div class="voyage_box_title">Start Port</div>
 <table>
  <tr>
    <th>Name:</th>
    <td>{{$port_start->name}}</td> 
  </tr>
  <tr>
    <th>Zone:</th>
    <td>{{$port_start_zone}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td>{{$port_start->max_laden_draft}}</td> 
  </tr>
    <tr>
    <th>Draft Factor:</th>
    <td>{{$port_start->draft_factor}}</td> 
  </tr>
  <tr>
    <th>Load/Disch Rate:</</th>
    <td>{{$cargo->loading_rate}}</td> 
  </tr>
  <tr>
    <th>Rate Type</th>
    <td>{{$port_start_rate_type}}</td> 
  </tr>
  <tr>
    <th>Rate Factor</th>
    <td>{{number_format($cargo->loading_rate,0)}}<</td> 
  </tr>
  <tr>
    <th>Fee</th>
    <td>{{number_format($port_fee_load,0)}} $</td> 
  </tr>

</table>
 </div>
 
 <div class="voyage_box_endport">
 <div class="voyage_box_title">End Port</div>
 <table>
  <tr>
    <th>Name:</th>
    <td>{{$port_end->name}}</td> 
  </tr>
  <tr>
    <th>Zone:</th>
    <td>{{$port_end_zone}}</td> 
  </tr>
  <tr>
    <th>Max Laden Draft:</th>
    <td>{{$port_end->max_laden_draft}}</td> 
  </tr>
    <tr>
    <th>Draft Factor:</th>
    <td>{{$port_end->draft_factor}}</td> 
  </tr>
  <tr>
    <th>Load/Disch Rate:</th>
    <td>{{$cargo->discharging_rate}}</td> 
  </tr>
  <tr>
    <th>Rate Type</th>
    <td>{{$port_start_rate_type}}</td> 
  </tr>
  <tr>
    <th>Rate Factor</th>
    <td>{{number_format($cargo->discharging_rate,0)}}</td> 
  </tr>
  <tr>
    <th>Fee</th>
    <td>{{number_format($port_fee_disch,0) }} $</td> 
  </tr>

</table>
 </div>
 <div class="footer"></div>
  </div>
  
  
   <div>
 <div class="voyage_box_calculation1">
<div class="voyage_box_title">Calculation</div>
 <table>
  <tr>
    <th>Route:</th>
    <td></td> 
  </tr>
  <tr>
    <th>BDI:</th>
    <td>{{$bdi}} $</td> 
  </tr>
  <tr>
    <th>Fuel Price:</th>
    <td>{{$fuel_price}} $</td> 
  </tr>
    <tr>
    <th>Consumption:</th>
    <td>{{number_format($fuel_consumption,20)}}</td> 
  </tr>
  <tr>
    <th>Fuel Costs:</th>
    <td> $</td> 
  </tr>
  <tr>
    <th>Remain Size:</th>
    <td></td> 
  </tr>
  <tr>
    <th>Remain Tonnage:</th>
    <td></td> 
  </tr>
  <tr>
    <th>Draft:</th>
    <td></td> 
  </tr>

</table>
 </div>
 
 <div class="voyage_box_calculation2">
 <div class="voyage_box_title"> </div>
 <table>
  <tr>
    <th>Range to Start:</th>
    <td></td> 
  </tr>
  <tr>
    <th>Distance to Start:</th>
    <td>{{number_format($distance_to_start,2) }}</td> 
  </tr>
  <tr>
    <th>Distance Start to End:</th>
    <td>{{number_format($distance_cargo,2)}}</td> 
  </tr>
    <tr>
    <th>Distance Total:</th>
    <td>{{$distance_sum}}</td> 
  </tr>
  <tr>
    <th>Days to Start:</th>
    <td>{{number_format($travel_time_to_start,2)}}</td> 
  </tr>
  <tr>
    <th>Days Start to End:</th>
    <td>{{number_format($travel_time_cargo,2)}}</td> 
  </tr>
  <tr>
    <th>Port Time:</th>
    <td>{{number_format($port_time_sum,2)}}</td> 
  </tr>
  <tr>
    <th>Voyage Time	:</th>
    <td>{{number_format($voyage_time,2)}}</td> 
  </tr>

</table>
 </div>
 
 <div class="voyage_box_calculation3">

 <table>
  <tr>
    <th>Non Hire Costs:</th>
    <td>{{number_format($non_hire_costs,2)}} $</td> 
  </tr>
  <tr>
    <th>Gross Rate:</th>
    <td>{{number_format($gross_rate,2)}} $</td> 
  </tr>
  <tr>
    <th>NTCE:</th>
    <td>{{number_format($ntce,0)}} $</td> 
  </tr>
</table>
 </div>
 <div class="footer"></div>
    </div>
	<div class="footer"></div>
  </div>

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
@endsection

