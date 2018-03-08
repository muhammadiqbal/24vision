@extends('layouts.app')

@section('content')
	 <div class="content">        
        <div class="box box-primary">
            <div class="box-body">
				<div id="fee_div"  style="width:800px;border:1px solid black"></div>
				<div id="fuel_div"  style="width:800px;border:1px solid black"></div>
				<div id="bdi_div"  style="width:800px;border:1px solid black"></div>
				@linechart('feePricedata', 'fee_div')
				@linechart('fuelPricedata', 'fuel_div')
				@linechart('bdiPricedata', 'bdi_div')
			</div>
		</div>
	</div>
@endsection