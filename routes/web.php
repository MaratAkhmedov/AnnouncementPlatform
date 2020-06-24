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
Auth::routes();

/**
 * send email to verificate it on registered users
 */
Auth::routes(['verify' => true]);


//admin panel
Route::get('/admin', 'AdminController@index')->name("admin");
Route::get('/admin/{id}/show', 'AdminController@show_announcement')->name('show_announcement');
Route::get('/admin/categories', 'AdminController@category_settings')->name('category_settings');
Route::delete('/admin/categories/{id}', 'AdminController@delete_category')->name('delete_category');
Route::put('/admin/categories/{id}', 'AdminController@change_category_name')->name('change_category_name');
Route::put('/admin/subcategories/{id}', 'AdminController@change_subcategory_name')->name('change_subcategory_name');
Route::post('/admin/categories', 'AdminController@add_category')->name('add_category');
Route::put('/admin/{id}/{status}','AdminController@change_status')->name('change_status');
Route::get('/admin/subcategories', 'AdminController@subcategory_settings')->name('subcategory_settings');
Route::post('/admin/subcategories', 'AdminController@add_subcategory')->name('add_subcategory');
Route::delete('/admin/subcategories/{id}', 'AdminController@delete_subcategory')->name('delete_subcategory');
Route::get('/admin/users', 'AdminController@user_settings')->name('user_settings');
Route::delete('/admin/users/{id}', 'AdminController@delete_user')->name('delete_user');
















// add announcement controllers
Route::group(['prefix' => 'addAnnouncement', 'middleware' => 'verified'], function()
{
    Route::get('/','AnnouncementController@index')->name('addAnnouncement');
    Route::get('/create/{id}','AnnouncementController@createAnnouncement')
        ->name('announcementForm')
        ->where(['id' => '[0-9]+']);
    Route::post('/create/','AnnouncementController@store')->name('store');
});


//profile controllers
Route::group(['prefix' => 'profile', 'middleware' => 'verified'], function()
{
    Route::get('/','Profile\IndexController@index')->name('profile');
    Route::get('/settings','Profile\EditProfileController@index')->name('profile_settings');
    Route::post('/settings','Profile\EditProfileController@update')->name('profile_update');
    Route::post('/settings/email','Profile\EditProfileController@email_modify_send')->name('email.modify.send');
    Route::get('/settings/email','Profile\EditProfileController@email_modify')->name('email.modify');
    Route::delete('/{id}','AnnouncementController@destroy')->name('delete');
    Route::get('/edit/{id}','AnnouncementController@edit')->middleware("editProfilePermssion")->name('edit')
        ->where('id', '[0-9]+');
    Route::put('/{id}','AnnouncementController@update')->name('update');
    Route::post("/settings/password","Profile\EditProfileController@password_modify")->name("password.modify");
});


/**
 * Show page of the product selected
 */
Route::get('/{category}/{subcategory}/{id}' , 'HomeController@show_page')->name("product_page")
    ->where(['id' => '[0-9]+']);



//Route::get('/','HomeController@index')->name("/");

/**
 * searching
 */


//can get infinity parameters, controller will validate if paramaters are corrects
Route::get('/{category?}/{subcategory?}/', 'HomeController@index')->name("/");




