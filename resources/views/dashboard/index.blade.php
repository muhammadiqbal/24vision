@extends('layouts.app')

@section('content')
	<div class="fee-div"></div>
	<div class="fuel-div"></div>
	<div class="bdi-div"></div>
	<?php $feePriceChart->render('LineChart', 'feePriceChart', 'fee-div'); ?>
	<?php $fuelPriceChart->render('LineChart', 'fuelPriceChart', 'fuel-div'); ?>
	<?php $bdiPriceChart->render('LineChart', 'bdiPriceChart', 'bdi-div'); ?>
@endsection