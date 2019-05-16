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

// Landing Page
Route::get('/', 'PagesController@index');


// User Routes
Auth::routes();
Route::post( 'switchBranch', 'ProcessBusinessSettings@switchBranch');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/Dashboard/userProfile/{id}', 'DashboardController@userProfile')->name('userProfile');
Route::get('/Dashboard/myProfile', 'DashboardController@myProfile')->name('myProfile');
Route::post('/Dashboard/myProfile/updateMyProfile', 'DashboardController@updateMyProfile')->name('updateMyProfile');

Route::get('/Dashboard/sales', 'DashboardController@sales')->name('sales');
Route::get( 'Dashboard/getReciept/{data}', 'Transactions@getReciept');
Route::post( 'storeSales', 'Transactions@storeSales');
Route::put( 'Dashboard/clearOutstanding/{data}', 'Transactions@clearOutstanding');
Route::delete( 'Dashboard/deleteSale/{data}', 'Transactions@deleteSale');

Route::get('/Dashboard/expenses', 'DashboardController@expenses')->name('expenses');
Route::post( 'storeExpenses', 'Transactions@storeExpenses');
Route::delete( 'Dashboard/deleteExpense/{data}', 'Transactions@deleteExpense');

Route::get('/Dashboard/stock', 'DashboardController@stock')->name('stock');
Route::post( 'storeStock', 'Transactions@storeStock');
Route::delete( 'Dashboard/deleteStock/{data}', 'Transactions@deleteStock');

Route::get('/Dashboard/statistics', 'DashboardController@statistics')->name('statistics');
Route::get('/Dashboard/customers', 'DashboardController@customers')->name('customers');

Route::get( '/Dashboard/businessSettings', 'DashboardController@businessSettings')->name('businessSettings');
Route::post( 'storeBusinessSettings', 'ProcessBusinessSettings@businessSettings');

Route::get( '/Dashboard/branchSettings', 'DashboardController@branchSettings')->name('branchSettings');
Route::post( 'storeBranchSettings', 'ProcessBusinessSettings@branchSettings');
Route::delete('/Dashboard/deleteBranch/{id}', 'ProcessBusinessSettings@deleteBranch');

Route::get( '/Dashboard/staffSettings', 'DashboardController@staffSettings')->name('staffSettings');
Route::post( 'storeStaffSettings', 'ProcessBusinessSettings@staffSettings');









