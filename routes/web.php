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

Route::get('/', function () {
    return view('welcome');
});




Route::get('reload-captcha', 'ContactData@reloadCaptcha');
Route::get('/contact','ContactData@index');
Route::post('/contact-save','ContactData@contactSave');

Route::post('get-states-by-country','ContactData@getState');

Route::get('contacts', ['uses' => 'ContactData@contactList','as' => 'contact-list']);

Route::get('contact/destroy/{id}', 'ContactData@destroy');

Route::get('contact-list/{id}/edit', 'ContactData@edit');
Route::get('contact-list/{id}/view', 'ContactData@view');

Route::post('contact-list/store', 'ContactData@store');
Route::get('contact-list/searchFilter', 'ContactData@searchFilter');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
