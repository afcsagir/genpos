<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/', 'HomeController@index');
Route::get('/pos', 'PosController@getProduct');
//Adding pos to Cart
//Route::get('addCart/ajax', 'PosController@addProductsCarts');
Route::post('addCart/ajax', 'PosController@addProductsCarts');
//getting data
Route::get('/getData','PosController@getData');
Route::get('/addProduct/{id}/{quantity}', 'CartController@addItem');
Route::get('/removeItem/{itemId}', 'CartController@removeItem');
Route::get('/checkout/{userId}', 'CartController@checkOut');


/*Route::get('/test', function(){
	if(Request::ajax()){
		return 'getRequest has loaded completely.';
	}
});*/
Route::get('/test', 'PosController@testFunction');
//Route::post('/test', 'PosController@testfunction');

Route::get('/customer', 'CustomerController@showAddCustomer');
Route::post('/customer-data-add', 'CustomerController@postCustomerData');

Route::get('/edit-customer/{customerId}', 'CustomerController@showEditCustomerData');

Route::post('/customer-data-update', 'CustomerController@updateCustomerData');
Route::get('/report-by-date/{time?}', 'ReportController@showReportByDate');
Route::post('/report-by-date-custom', 'ReportController@showReportByDate');
Route::get('/report-by-product', 'ReportController@showReportByProduct');
Route::get('/up-payments', 'ReportController@uploadOldSalesData');
Route::post('/up-payments-post', 'ReportController@uploadOldSalesData');
Route::get('/up-items', 'ReportController@uploadOldItems');
Route::post('/up-items-post', 'ReportController@uploadOldItems');
Route::get('/up-employees', 'ReportController@uploadEmployees');
Route::post('/up-employees-post', 'ReportController@uploadEmployees');
Route::get('/report-employees', 'ReportController@showReportEmployees');
Route::get('/up-simple-products', 'ReportController@uploadProducts');
Route::post('/up-simple-products-post', 'ReportController@uploadProducts');
