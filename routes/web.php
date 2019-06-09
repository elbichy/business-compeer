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
Route::get('/dashboard/notify', 'DashboardController@notify');


// USER PROFILE
Route::get('/Dashboard/userProfile/{id}', 'DashboardController@userProfile')->name('userProfile');
Route::get('/Dashboard/myProfile', 'DashboardController@myProfile')->name('myProfile');
Route::post('/Dashboard/myProfile/updateMyProfile', 'DashboardController@updateMyProfile')->name('updateMyProfile');


// SALES
Route::get('/Dashboard/sales', 'DashboardController@sales')->name('sales');
Route::get('/Dashboard/sales/lastAddedSale', 'DashboardController@lastAddedSale')->name('lastAddedSale');
Route::get('/Dashboard/sales/lastAddedTransfer', 'DashboardController@lastAddedTransfer')->name('lastAddedTransfer');
Route::get( 'Dashboard/getReciept/{data}', 'Transactions@getReciept');
Route::post( 'storeSales', 'Transactions@storeSales');
Route::put( 'Dashboard/clearOutstanding/{data}', 'Transactions@clearOutstanding');
Route::delete( 'Dashboard/deleteSale/{data}', 'Transactions@deleteSale');
// mobile money transfer
Route::get('/Dashboard/transfers', 'DashboardController@transfers')->name('transfers');
// admin process transfer
Route::get('/Dashboard/manageTransfers', 'DashboardController@manageTransfers')->name('manageTransfers');
Route::get('/Dashboard/loadNotification/{count}', 'DashboardController@loadNotification')->name('loadNotification');


// EXPENSES
Route::get('/Dashboard/expenses', 'DashboardController@expenses')->name('expenses');
Route::post( 'storeExpenses', 'Transactions@storeExpenses');
Route::delete( 'Dashboard/deleteExpense/{data}', 'Transactions@deleteExpense');


// STOCK
Route::get('/Dashboard/stock', 'DashboardController@stock')->name('stock');
Route::post( 'storeStock', 'Transactions@storeStock');
Route::delete( 'Dashboard/deleteStock/{data}', 'Transactions@deleteStock');


// STATISTICS
Route::get('/Dashboard/statistics', 'DashboardController@statistics')->name('statistics');
Route::get('/Dashboard/customers', 'DashboardController@customers')->name('customers');


// BUSINESS SETTINGS
Route::get( '/Dashboard/businessSettings', 'DashboardController@businessSettings')->name('businessSettings');
Route::post( 'storeBusinessSettings', 'ProcessBusinessSettings@businessSettings');


// BRANCH SETTINGS
Route::get( '/Dashboard/branchSettings', 'DashboardController@branchSettings')->name('branchSettings');
Route::post( 'storeBranchSettings', 'ProcessBusinessSettings@branchSettings');
Route::delete('/Dashboard/deleteBranch/{id}', 'ProcessBusinessSettings@deleteBranch');


// STAFF SETTINGS
Route::get( '/Dashboard/staffSettings', 'DashboardController@staffSettings')->name('staffSettings');
Route::post( 'storeStaffSettings', 'ProcessBusinessSettings@staffSettings');









