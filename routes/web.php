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
	Route::get('testing', 'DashboardController@testing');

	Route::resource('bdiCodes', 'BdiCodeController');

	Route::resource('bdis', 'BdiController');
	
	Route::resource('bdiPrices', 'BdiPriceController');

	Route::resource('cargos', 'CargoController');

	Route::resource('distances', 'DistanceController');

	Route::resource('emails', 'EmailController');	

	Route::resource('fuelPrices', 'FuelPriceController');
	
	Route::resource('feePrices', 'FeePriceController');

	Route::resource('ports', 'PortController');

	Route::resource('routes', 'RouteController');

	Route::resource('ships', 'ShipController');

	Route::resource('users', 'UserController');

	Route::resource('zones', 'ZoneController');
	
	Route::resource('zonePoints', 'ZonePointController');
	
	Route::get('linechart','DashboardController@linechart');
	
	Route::get('imap','IMAPController@inbox');
	
	Route::get('cargoMap','DashboardController@cargoMap');
	
	Route::put('/emails/reclassify/{id}','EmailController@reclassify');
	
	Route::get('/home/{ship_id?}/{port_id?}/{date_of_opening?}/{occupied_size?}/{occupied_tonage?}/{range?}', 'DashboardController@index');

	Route::get('/voyage/{ship}/{cargo}/{port_ship}/{date}', 'VoyageController@getVoyage');

	// Route::get('execBCT','DashboardController@execBCT');

	//Route::resource('shipSpecializations', 'ShipSpecializationController');

	//Route::resource('fuelTypes', 'FuelTypeController');
	
	//Route::resource('shipTypes', 'ShipTypeController');

	//Route::get('controlPanel','DashboardController@controlPanel');

});




