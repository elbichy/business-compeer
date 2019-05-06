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
use App\User;
use App\Business;

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/Dashboard/sales', 'DashboardController@sales');
Route::put( 'Dashboard/clearOutstanding/{data}', 'Transactions@clearOutstanding');
Route::delete( 'Dashboard/deleteSale/{data}', 'Transactions@deleteSale');

Route::get('/Dashboard/expenses', 'DashboardController@expenses');
Route::delete( 'Dashboard/deleteExpense/{data}', 'Transactions@deleteExpense');

Route::get('/Dashboard/stock', 'DashboardController@stock');
Route::delete( 'Dashboard/deleteStock/{data}', 'Transactions@deleteStock');

Route::get('/Dashboard/statistics', 'DashboardController@statistics');
Route::get('/Dashboard/customers', 'DashboardController@customers');

Route::get( '/Dashboard/businessSettings', 'DashboardController@businessSettings');
Route::get( '/Dashboard/branchSettings', 'DashboardController@branchSettings');
Route::get( '/Dashboard/staffSettings', 'DashboardController@staffSettings');
Route::get( 'Dashboard/getReciept/{data}', 'Transactions@getReciept');

Route::post( 'storeSales', 'Transactions@storeSales');
Route::post( 'storeExpenses', 'Transactions@storeExpenses');
Route::post( 'storeStock', 'Transactions@storeStock');
Route::post( 'storeBusinessSettings', 'ProcessBusiness@businessSettings');
Route::post( 'storeBranchSettings', 'ProcessBusiness@branchSettings');
Route::post( 'storeStaffSettings', 'ProcessBusiness@staffSettings');
Route::post( 'switchBranch', 'ProcessBusiness@switchBranch');

