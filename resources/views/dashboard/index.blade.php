@extends('layouts.app')

@section('content')
	 <div class="content">        
        <div class="box box-primary">
            <div class="box-body">
				<div id="fee_div"  style="width:800px;border:1px solid black"></div>
				<div id="fuel_div"  style="width:800px;border:1px solid black"></div>
				<div id="bdi_div"  style="width:800px;border:1px solid black"></div>
				<?php $feePriceChart->render('LineChart', 'feePricedata', 'fee_div'); ?>
				<?php $fuelPriceChart->render('LineChart', 'fuelPricedata', 'fuel_div'); ?>
				<?php $bdiPriceChart->render('LineChart', 'bdiPricedata', 'bdi_div'); ?>
			</div>
		</div>
	</div>
@endsection