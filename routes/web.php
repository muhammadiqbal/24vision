<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@showLoginForm'
]);


Auth::routes();

Route::group(['middleware' => 'auth'], function() 
{
	Route::get('/home', 'DashboardController@index')->middleware('auth');

	Route::get('/testing', 'DashboardController@testing');

	Route::get('/voyage/{$ship}/{$cargo}/{$port_ship}/{$date}', 'VoyageController@getVoyage');

	Route::resource('shipTypes', 'ShipTypeController');

	Route::resource('shipSpecializations', 'ShipSpecializationController');

	Route::resource('ships', 'ShipController');

	Route::resource('regions', 'RegionController');

	Route::resource('ports', 'PortController');

	Route::resource('cargos', 'CargoController');

	Route::resource('shipPositions', 'ShipPositionController');

	Route::resource('routes', 'RouteController');

	Route::resource('fuelTypes', 'FuelTypeController');

	Route::resource('fuelPrices', 'FuelPriceController');

	Route::resource('bdis', 'BdiController');

	Route::resource('bdiCodes', 'BdiCodeController');

	Route::resource('customers', 'CustomerController');

});

Route::resource('bdis', 'BdiController');

Route::resource('zones', 'ZoneController');

Route::resource('routes', 'RouteController');

Route::resource('cargoStatuses', 'CargoStatusController');

Route::resource('cargoTypes', 'CargoTypeController');

Route::resource('bdiPrices', 'BdiPriceController');

Route::resource('feePrices', 'FeePriceController');

Route::resource('zonePoints', 'ZonePointController');

Route::resource('zonePorts', 'ZonePortsController');

Route::resource('paths', 'PathController');

Route::resource('distances', 'DistanceController');

Route::resource('zonePorts', 'ZonePortController');

Route::resource('ldRateTypes', 'LdRateTypeController');

Route::resource('routes', 'RouteController');

Route::resource('ships', 'ShipController');

Route::resource('zonePoints', 'ZonePointController');

//Route::resource('cargos', 'CargoController');

Route::resource('cargoTypes', 'CargoTypeController');

Route::resource('distances', 'DistanceController');

Route::resource('routes', 'RouteController');

Route::get('testView', function(){
	return view('voyages.index');
});



Route::resource('cargoTypes', 'CargoTypeController');