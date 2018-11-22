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

Route::get('/hierarchy', 'HierarchyController@index')->name('hierarchy');
Route::post('/hierarchy', 'HierarchyController@getSuccessors')->name('add_level');

Auth::routes();

Route::get('/employees_list', 'EmployeesListController@index')->name('employees_list');
Route::post('/list_sort', 'EmployeesListController@getSortedList')->name('list_sort');
Route::get('/home', 'HomeController@index')->name('home');
