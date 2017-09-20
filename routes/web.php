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

Route::get('/', function () {
    return view('welcome');
});


//Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');


Route::resource('roles', 'roleController');

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::resource('roles', 'RoleController');

Route::resource('roles', 'RoleController');

Route::resource('roles', 'RoleController');

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