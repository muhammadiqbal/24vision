<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.basic.once')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth.basic.once'], function() 
{
	Route::resource('bdis', 'BdiAPIController');

	Route::resource('zones', 'ZoneAPIController');

	Route::resource('routes', 'RouteAPIController');

	Route::resource('cargo_statuses', 'CargoStatusAPIController');

	Route::resource('cargo_types', 'CargoTypeAPIController');

	Route::resource('bdi_prices', 'BdiPriceAPIController');

	Route::resource('fee_prices', 'FeePriceAPIController');

	Route::resource('zone_points', 'ZonePointAPIController');

	Route::resource('zone_ports', 'ZonePortsAPIController');

	Route::resource('paths', 'PathAPIController');

	Route::resource('distances', 'DistanceAPIController');

	Route::resource('zone_ports', 'ZonePortAPIController');

	Route::resource('ld_rate_types', 'LdRateTypeAPIController');

	Route::resource('routes', 'RouteAPIController');

	Route::resource('ships', 'ShipAPIController');

	Route::resource('zone_points', 'ZonePointAPIController');

	Route::resource('cargo_types', 'CargoTypeAPIController');

	Route::resource('distances', 'DistanceAPIController');

	Route::resource('routes', 'RouteAPIController');

	Route::resource('cargo_types', 'CargoTypeAPIController');

	Route::resource('cargos', 'CargoAPIController');

	Route::resource('emails', 'EmailAPIController');

	Route::resource('ports', 'PortAPIController');

	Route::resource('cargooffers', 'CargoOfferAPIController');

	Route::resource('cargoofferextracted', 'CargoOfferExtractedAPIController');

	Route::resource('shipoffers', 'CargoOfferAPIController');

	Route::resource('shipofferextracted', 'ShipOfferExtractedAPIController');

	Route::resource('shiporders', 'CargoOfferAPIController');

	Route::resource('shiporderextracted', 'ShipOfferExtractedAPIController');

	Route::resource('ports', 'PortAPIController');
	
	Route::get('emails/{filter}/{limit}', 'EmailAPIController@extra');

	Route::get('controlPanel', 'ControlPanelAPIController@execute');

	Route::put('setCleaned/{id}', 'CargoOfferExtractedAPIController@setCleaned');
});