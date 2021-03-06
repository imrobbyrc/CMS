<?php

Route::get('admin/clear/', 'Admin\DashboardController@clear');

Auth::routes();

Route::get('admin/login/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login/', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

//cms route
Route::get('/admin', 'Admin\DashboardController@index')->name('home');
Route::group(['middleware' => 'auth','prefix' => 'admin'], function() {
    
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('/role', 'Admin\RoleController')->except([
            'create', 'show', 'edit', 'update'
        ]);

        Route::resource('/users', 'UserController')->except([
            'show'
        ]);
        Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
        Route::put('/users/roles/{id}', 'UserController@setRole')->name('users.set_role');
        Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
        Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.roles_permission');
        Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');
    });

    Route::get('/home', 'Admin\DashboardController@index')->name('home');
    Route::get('/homepage/{alias}', 'Admin\HomepageController@index')->name('homepage');
    Route::get('/homepage/{alias}/create', 'Admin\HomepageController@create')->name('homepage.create');
    Route::get('/homepage/{alias}/show/{id}', 'Admin\HomepageController@show')->name('homepage.show');
    Route::post('/homepage/{alias}', 'Admin\HomepageController@store')->name('homepage.store');
    Route::get('/homepage/{alias}/edit/{id}', 'Admin\HomepageController@edit')->name('homepage.edit');
    Route::post('/homepage/{alias}/update', 'Admin\HomepageController@update')->name('homepage.update');
    Route::post('/homepage/{alias}/delete', 'Admin\HomepageController@destroy')->name('homepage.destroy');

    Route::get('/content/{alias}', 'Admin\ContentController@index')->name('content');
    Route::get('/content/{alias}/create', 'Admin\ContentController@create')->name('content.create');
    Route::get('/content/{alias}/show/{id}', 'Admin\ContentController@show')->name('content.show');
    Route::post('/content/{alias}', 'Admin\ContentController@store')->name('content.store');
    Route::get('/content/{alias}/edit/{id}', 'Admin\ContentController@edit')->name('content.edit');
    Route::post('/content/{alias}/update', 'Admin\ContentController@update')->name('content.update');
    Route::post('/content/{alias}/delete', 'Admin\ContentController@destroy')->name('content.destroy');

    Route::get('/contact-us/{alias}', 'Admin\ContactController@index')->name('contact-us');
    Route::post('/contact-us/{alias}', 'Admin\ContactController@store')->name('contact-us.store');

    Route::resource('/partnership','Admin\PartnershipController')->except(['update', 'destroy']);
    Route::post('/partnership/update', 'Admin\PartnershipController@update')->name('partnership.update');
    Route::post('/partnership/delete', 'Admin\PartnershipController@destroy')->name('partnership.destroy');

    Route::resource('/testimonial','Admin\TestimonialController')->except(['update', 'destroy']);
    Route::post('/testimonial/update', 'Admin\TestimonialController@update')->name('testimonial.update');
    Route::post('/testimonial/delete', 'Admin\TestimonialController@destroy')->name('testimonial.destroy');
    
    Route::get('/inbox', 'Admin\InboxController@index')->name('inbox');
    Route::get('/inbox/show/{id}', 'Admin\InboxController@show')->name('inbox.show');
    Route::get('/inbox/test', 'Admin\InboxController@test')->name('inbox.test');
    Route::get('/inbox/markAsRead/{id}', 'Admin\InboxController@readNotif')->name('inbox.read');
    
    //ajax
    Route::get('/homepage/{alias}/getdata', 'Admin\HomepageController@getData')->name('homepage.getdata');
    Route::get('/content/{alias}/getdata', 'Admin\ContentController@getData')->name('content.getdata');
    Route::get('/partnerships_getdata', 'Admin\PartnershipController@getData')->name('partnership.getdata');
    Route::get('/testimonials_getdata', 'Admin\TestimonialController@getData')->name('testimonial.getdata');
    Route::get('/inbox/getdata', 'Admin\InboxController@getData')->name('inbox.getdata');
    Route::post('/ajax_get_all_submenu', 'Admin\ContentController@ajax_get_all_submenu')->name('ajax_get_all_submenu');
});


Route::get('/', 'FrontEndController@index');
Route::get('/{menu}/{submenu?}/{content?}', 'FrontEndController@get');
Route::post('contact-us','Admin\InboxController@contactUs')->name('contact.store');