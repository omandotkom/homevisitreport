<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/laporan/list','ReportController@index')->name("list-laporan");
Route::get('/home',function(){
    return view('main');   
})->name('home');
Route::get('/laporan', function () {
    return view('reportform');
})->name('index-laporan');
Route::post('/laporan', 'ReportController@store')->name('store-laporan');
Route::get('/', function () {
    return view('main');
});
Route::get('/laporan/edit/{id}','ReportController@edit')->name('edit-laporan');
Route::post('/laporan/edit/{id?}','ReportController@update')->name('update-laporan');

Route::get('/s',function(){
    return view('print');
});
Route::post('/print/{id}','ReportController@print')->name('print');

Route::get('/print/{id}','ReportController@printsementara')->name('printreport');
