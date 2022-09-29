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

Route::middleware(['auth', 'subscribed'])->group(function() {
    // API Routes
    Route::get('/api/user', 'UserController@getUser');
    Route::get('/api/goals', 'GoalsController@getGoals');
    Route::get('/api/billing', 'BillingController@getBilling');
    
    // Catch All for Vue
    Route::view('/{any}', 'app')->where('any', '.*');

});
