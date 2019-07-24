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



/**
 * send email to verificate it on registered users
 */
Auth::routes(['verify' => true]);


/*Route::get('/home', function () {
    return view('home');
    //return App\Subcategory::find(1)->category->name;
})->middleware('verified');*/
Route::get('/home','HomeController@home');

//announcement controllers
Route::get('/addAnnouncement','AnnouncementController@index')->name('addAnnouncement');
Route::get('/addAnnouncement/create/{id}','AnnouncementController@createAnnouncement')
    ->name('announcementForm')
    ->middleware('verified')
    ->where(['id' => '[0-9]+']);
Route::post('/addAnnouncement/create/','AnnouncementController@store')->name('store');


//profile controllers
Route::get('/profile','UserProfileController@index')->name('profile')->middleware('verified');
Route::delete('/profile/{id}','AnnouncementController@destroy')->name('delete');
Route::get('/profile/{id}/edit','AnnouncementController@edit')->name('edit')
    ->where('id', '[0-9]+');
Route::put('/profile/{id}','AnnouncementController@update')->name('update');


//product search routing
Route::get('/{category}/{subcategory}/{id}' , 'HomeController@show_page')->name("product_page")
    ->where(['id' => '[0-9]+']);
Route::get('/','HomeController@index')->name("/");

//Route::get('/search/', 'HomeController@search')->name("search");

Auth::routes();
