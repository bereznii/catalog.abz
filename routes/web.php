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
Route::post('/hierarchy_add', 'HierarchyController@getSuccessors')->name('add_level');
Route::post('/update_hierarchy', 'HierarchyController@updateHierarchy')->name('update_hierarchy');

Auth::routes();

Route::post('/list_sort', 'EmployeesCRUDController@getSortedList')->middleware('auth')->name('list_sort');
Route::post('/get_supervisor', 'EmployeesCRUDController@getSupervisor')->middleware('auth')->name('get_supervisor');

Route::resource('employees', 'EmployeesCRUDController')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
