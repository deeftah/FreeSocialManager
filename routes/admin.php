<?php

// your CRUD resources and other admin routes here
CRUD::resource('client', 'ClientCrudController');
CRUD::resource('publish', 'PublishCrudController');
CRUD::resource('tag', 'TagCrudController');
CRUD::resource('taggroup', 'TagGroupCrudController');
CRUD::resource('publishclientaccount', 'PublishClientAccountCrudController');

// ClientAccount routes
$controller = 'ClientAccountCrudController';
Route::get('clientAccount/create/{template}', $controller . '@create');
Route::get('clientAccount/{id}/edit/{template}', $controller . '@edit');
Route::get('clientAccount/reorder', $controller . '@reorder');
Route::get('clientAccount/reorder/{lang}', $controller . '@reorder');
Route::post('clientAccount/reorder', $controller . '@saveReorder');
Route::post('clientAccount/reorder/{lang}', $controller . '@saveReorder');
Route::get('clientAccount/{id}/details', $controller . '@showDetailsRow');
Route::get('clientAccount/{id}/translate/{lang}', $controller . '@translateItem');
Route::post('clientAccount/search', [
    'as' => 'crud.page.search',
    'uses' => $controller . '@search',
]);
Route::resource('clientAccount', $controller);