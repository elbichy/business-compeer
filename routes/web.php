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
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


// USER PROFILE
Route::get('/dashboard/user-profile/{id}', 'ProfileController@userProfile')->name('userProfile');
Route::get('/dashboard/myProfile', 'ProfileController@myProfile')->name('myProfile');
Route::post('/dashboard/myProfile/updateMyProfile', 'ProfileController@updateMyProfile')->name('updateMyProfile');


// SALES
Route::get('/dashboard/sales', 'SaleController@sales')->name('sales');
Route::get('/dashboard/sales/lastAddedSale', 'SaleController@lastAddedSale')->name('lastAddedSale');
Route::get('/dashboard/sales/lastAddedTransfer', 'SaleController@lastAddedTransfer')->name('lastAddedTransfer');
Route::get('/dashboard/sales/lastAddedUtility', 'SaleController@lastAddedUtility')->name('lastAddedUtility');
Route::get( '/dashboard/sales/getReciept/{data}', 'SaleController@getReciept')->name('getReciept');
Route::post( '/dashboard/sales/storeSales', 'SaleController@storeSales')->name('storeSales');
Route::put( '/dashboard/sales/clearOutstanding/{data}', 'SaleController@clearOutstanding')->name('clearOutstanding');
Route::delete( '/dashboard/sales/deleteSale/{data}', 'SaleController@deleteSale')->name('deleteSale');
Route::get('/dashboard/sales/load-notification/{count}', 'SaleController@loadNotification')->name('loadNotification');

// mobile money transfer
Route::get('/dashboard/transfers', 'SaleController@transfers')->name('transfers');
// admin process transfer
Route::get('/dashboard/sales/manage-transfers', 'SaleController@manageTransfers')->name('manageTransfers');

// Utilty bill payment
Route::get('/dashboard/utility-bill-payment', 'SaleController@utility')->name('utility');
// Admin process Utilty bill payment
Route::get('/dashboard/sales/manage-utility-bill-payment', 'SaleController@manageUtility')->name('manageUtility');

Route::get('/dashboard/sales/load-notification/{count}', 'SaleController@loadNotification')->name('loadNotification');




// EXPENSES
Route::get('/dashboard/expenses', 'ExpenseController@expenses')->name('expenses');
Route::post( '/dashboard/expenses/store-expenses', 'ExpenseController@storeExpenses')->name('storeExpenses');
Route::delete( 'dashboard/expenses/delete-expense/{data}', 'ExpenseController@deleteExpense')->name('deleteExpense');


// STOCK
Route::get('/dashboard/stock', 'StockController@stock')->name('stock');
Route::post( '/dashboard/stock/storeStock', 'StockController@storeStock')->name('storeStock');
Route::delete( '/dashboard/stock/deleteStock/{data}', 'StockController@deleteStock')->name('deleteStock');


// STATISTICS
Route::get('/dashboard/statistics', 'StatisticController@statistics')->name('statistics');
Route::get('/dashboard/customers', 'CustomerController@customers')->name('customers');


// BUSINESS SETTINGS
Route::get( '/dashboard/business-settings', 'BusinessSettingsController@businessSettings')->name('businessSettings');
Route::post( '/dashboard/settings/store-business-settings', 'BusinessSettingsController@storeBusinessSettings')->name('storeBusinessSettings');


// BRANCH SETTINGS
Route::get( '/dashboard/branch-settings', 'BranchSettingsController@branchSettings')->name('branchSettings');
Route::post( '/dashboard/settings/store-branch-settings', 'BranchSettingsController@storeBranchSettings')->name('storeBranchSettings');
Route::delete('/dashboard/settings/delete-branch/{id}', 'BranchSettingsController@deleteBranch')->name('deleteBranch');
Route::post( 'switchBranch', 'ProcessBusinessSettings@switchBranch')->name('switchBranch');

// STAFF SETTINGS
Route::get( '/dashboard/staff-settings', 'StaffSettingsController@staffSettings')->name('staffSettings');
Route::post( '/dashboard/settings/store-staff-settings', 'StaffSettingsController@storeStaffSettings')->name('storeStaffSettings');









