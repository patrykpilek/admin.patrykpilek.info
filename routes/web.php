<?php

//  Authentication with send verify email
Auth::routes(['verify' => true]);
//  Dashboard
Route::get('/', 'DashboardController@index')->name('dashboard');
//  Blog
Route::resource('blog', 'BlogController');
Route::put('blog/restore/{blog}', 'BlogController@restore')->name('blog.restore');
Route::delete('blog/force-destroy/{blog}', 'BlogController@forceDestroy')->name('blog.force-destroy');
//  Category
Route::resource('categories', 'CategoriesController')->except(['show']);
//  Users
Route::resource('users', 'UsersController')->except(['show']);;
Route::get('users/confirm/{user}', 'UsersController@confirm')->name('users.confirm');
//  Profile
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
Route::put('/profile/{user}', 'ProfileController@update')->name('profile.update');