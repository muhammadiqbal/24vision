@extends('layouts.app')

@section('content')
	
	<?php $feePriceChart->render('LineChart', 'feePriceChart', 'fee-div'); ?>
	<?php $fuelPriceChart->render('LineChart', 'fuelPriceChart', 'fuel-div'); ?>
	<?php $bdiPriceChart->render('LineChart', 'bdiPriceChart', 'bdi-div'); ?>
@endsection