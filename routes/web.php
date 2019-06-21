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
Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('BusinessExists');


// USER PROFILE
Route::get('/dashboard/myProfile', 'ProfileController@myProfile')->name('myProfile')->middleware('BusinessExists');
Route::post('/dashboard/myProfile/updateMyProfile', 'ProfileController@updateMyProfile')->name('updateMyProfile')->middleware('BusinessExists');


// SALES
Route::get('/dashboard/sales', 'SaleController@sales')->name('sales')->middleware('BusinessExists');
Route::get('/dashboard/sales/lastAddedTransfer', 'SaleController@lastAddedTransfer')->name('lastAddedTransfer')->middleware('BusinessExists');
Route::get('/dashboard/sales/lastAddedUtility', 'SaleController@lastAddedUtility')->name('lastAddedUtility')->middleware('BusinessExists');
Route::get( '/dashboard/sales/getReciept/{data}', 'SaleController@getReciept')->name('getReciept')->middleware('BusinessExists');
Route::post( '/dashboard/sales/storeSales', 'SaleController@storeSales')->name('storeSales')->middleware('BusinessExists');
Route::put( '/dashboard/sales/clearOutstanding', 'SaleController@clearOutstanding')->name('clearOutstanding')->middleware('BusinessExists');
Route::delete( '/dashboard/sales/deleteSale/{data}', 'SaleController@deleteSale')->name('deleteSale')->middleware('BusinessExists');
Route::get('/dashboard/sales/load-notification/{count}', 'SaleController@loadNotification')->name('loadNotification')->middleware('BusinessExists');

// mobile money transfer
Route::get('/dashboard/transfers', 'SaleController@transfers')->name('transfers')->middleware('BusinessExists');
// admin process transfer
Route::get('/dashboard/sales/manage-transfers', 'SaleController@manageTransfers')->name('manageTransfers')->middleware('BusinessExists');
Route::get('/dashboard/sales/get-transfer/{id}/{notification}', 'SaleController@getTransfer')->name('manageTransfers')->middleware('BusinessExists');
Route::get('/dashboard/sales/approve-transfer/{id}/{notification}', 'SaleController@approveTransfer')->name('approveTransfer')->middleware('BusinessExists');

// Utilty bill payment
Route::get('/dashboard/utility-bill-payment', 'SaleController@utility')->name('utility')->middleware('BusinessExists');
// Admin process Utilty bill payment
Route::get('/dashboard/sales/manage-utility-bill-payment', 'SaleController@manageUtility')->name('manageUtility')->middleware('BusinessExists');

Route::get('/dashboard/sales/load-notification/{count}', 'SaleController@loadNotification')->name('loadNotification')->middleware('BusinessExists');




// EXPENSES
Route::get('/dashboard/expenses', 'ExpenseController@expenses')->name('expenses')->middleware('BusinessExists');
Route::post( '/dashboard/expenses/store-expenses', 'ExpenseController@storeExpenses')->name('storeExpenses')->middleware('BusinessExists');
Route::delete( 'dashboard/expenses/delete-expense/{data}', 'ExpenseController@deleteExpense')->name('deleteExpense')->middleware('BusinessExists');


// STOCK
Route::get('/dashboard/stock', 'StockController@stock')->name('stock')->middleware('BusinessExists');
Route::post( '/dashboard/stock/storeStock', 'StockController@storeStock')->name('storeStock')->middleware('BusinessExists');
Route::delete( '/dashboard/stock/deleteStock/{data}', 'StockController@deleteStock')->name('deleteStock')->middleware('BusinessExists');


// STATISTICS
Route::get('/dashboard/statistics', 'StatisticController@statistics')->name('statistics')->middleware('BusinessExists');
Route::get('/dashboard/customers', 'CustomerController@customers')->name('customers')->middleware('BusinessExists');


// BUSINESS SETTINGS
Route::get( '/dashboard/business-settings', 'BusinessSettingsController@businessSettings')->name('businessSettings');
Route::post( '/dashboard/settings/store-business-settings', 'BusinessSettingsController@storeBusinessSettings')->name('storeBusinessSettings');


// BRANCH SETTINGS
Route::get( '/dashboard/branch-settings', 'BranchSettingsController@branchSettings')->name('branchSettings');
Route::post( '/dashboard/settings/store-branch-settings', 'BranchSettingsController@storeBranchSettings')->name('storeBranchSettings');
Route::delete('/dashboard/settings/delete-branch/{id}', 'BranchSettingsController@deleteBranch')->name('deleteBranch');
Route::post( 'switchBranch', 'BranchSettingsController@switchBranch')->name('switchBranch');

// STAFF SETTINGS
Route::get( '/dashboard/staff-settings', 'StaffSettingsController@staffSettings')->name('staffSettings')->middleware('BusinessExists');
Route::post( '/dashboard/settings/store-staff-settings', 'StaffSettingsController@storeStaffSettings')->name('storeStaffSettings')->middleware('BusinessExists');









