@extends('layouts.app')

@section('content')
	<div class="fee-div"></div>
	<div class="fuel-div"></div>
	<div class="bdi-div"></div>
	<?php $feePriceChart->render('LineChart', 'feePricedata', 'fee-div'); ?>
	<?php $fuelPriceChart->render('LineChart', 'fuelPricedata', 'fuel-div'); ?>
	<?php $bdiPriceChart->render('LineChart', 'bdiPricedata', 'bdi-div'); ?>
@endsection