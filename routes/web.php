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
//Route::resource('stowageFactorUnits', 'StowageFactorUnitController');

//Route::resource('quantityMeasurements', 'QuantityMeasurementController');

//Route::resource('ldRateTypes', 'LdRateTypeController');

//Route::resource('freightIdeaMeasurements', 'FreightIdeaMeasurementController');


