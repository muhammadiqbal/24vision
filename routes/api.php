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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


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

Route::resource('cargos', 'CargoAPIController');

Route::resource('cargo_types', 'CargoTypeAPIController');

Route::resource('distances', 'DistanceAPIController');

Route::resource('routes', 'RouteAPIController');