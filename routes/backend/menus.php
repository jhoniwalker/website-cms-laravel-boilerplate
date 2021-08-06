<?php
use App\Http\Controllers\Backend\MenuController;

Route::resource('menus', 'MenuController', ['except' => 'show']);
Route::put('menus/published/{menuId}', ['uses' => 'MenuController@published', 'as'=> 'menus.published']);
Route::post('menus/store-file',['uses' => 'MenuController@storeFile', 'as' => 'menus.store-file']);
Route::post('menus/store-video-id',['uses' => 'MenuController@storeVideoId', 'as' => 'menus.store-video-id']);
Route::get('menus/get-media/{menuId?}',['uses' => 'MenuController@getMedia', 'as' => 'menus.get-media']);
Route::delete('menus/destroy-file/{menuGalleryId}', ['uses' => 'MenuController@destroyFile', 'as'=> 'menus.destroy-file']);
Route::post('menus/reorder-table', ['uses' => 'MenuController@reorderTable', 'as'=> 'menus.reorder-table']);