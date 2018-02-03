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
	Route::get('/home', 'DashboardController@index');

	Route::get('/testing', 'DashboardController@testing');

	Route::get('/voyage/{ship}/{cargo}/{port_ship}/{date}', 'VoyageController@getVoyage');

	Route::resource('shipTypes', 'ShipTypeController');

	Route::resource('shipSpecializations', 'ShipSpecializationController');

	Route::resource('ships', 'ShipController');

	Route::resource('regions', 'RegionController');

	Route::resource('ports', 'PortController');
	
	Route::resource('zones', 'ZoneController');

	Route::resource('cargos', 'CargoController');

	Route::resource('routes', 'RouteController');

	Route::resource('fuelTypes', 'FuelTypeController');

	Route::resource('fuelPrices', 'FuelPriceController');

	Route::resource('bdis', 'BdiController');

	Route::resource('bdiCodes', 'BdiCodeController');

	Route::resource('ports', 'PortController');

	Route::resource('users', 'UserController');

	Route::get('emails','EmailController@index');
});





Route::resource('emails', 'EmailController');