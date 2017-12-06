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

Route::get('/home', 'DashboardController@index');

Route::get('/home', 'DashboardController@testing');
//Route::get('/openPositions/{port}', 'HomeController@openPosition');

Route::resource('roles', 'roleController');

//Route::get('/home', 'HomeController@index');

Route::resource('roles', 'RoleController');

Route::resource('shipTypes', 'ShipTypeController');

Route::resource('shipSpecializations', 'ShipSpecializationController');

Route::resource('ships', 'ShipController');

Route::resource('regions', 'RegionController');

Route::resource('ports', 'PortController');

Route::resource('stowageFactorUnits', 'StowageFactorUnitController');

Route::resource('quantityMeasurements', 'QuantityMeasurementController');

Route::resource('ldRateTypes', 'LdRateTypeController');

Route::resource('freightIdeaMeasurements', 'FreightIdeaMeasurementController');

Route::resource('cargos', 'CargoController');

Route::resource('shipPositions', 'ShipPositionController');

Route::resource('agreements', 'AgreementController');

Route::resource('agreements', 'AgreementController');

Route::resource('cargos', 'CargoController');

Route::resource('shipPositions', 'ShipPositionController');

Route::resource('ships', 'ShipController');

Route::resource('routes', 'RouteController');

Route::resource('fuelTypes', 'FuelTypeController');

Route::resource('fuelPrices', 'FuelPriceController');

Route::resource('bdis', 'BdiController');

Route::resource('ships', 'ShipController');

Route::resource('bdis', 'BdiController');

Route::resource('bdiCodes', 'BdiCodeController');

Route::resource('customers', 'CustomerController');

Route::resource('cargos', 'CargoController');

Route::resource('ports', 'PortController');

Route::resource('ports', 'PortController');

Route::resource('ports', 'PortController');