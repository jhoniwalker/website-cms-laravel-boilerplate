<?php

Route::resource('posts', 'PostController', ['except' => 'show']);
Route::put('posts/table-switches/{postId}', ['uses' => 'PostController@tableSwitches', 'as'=> 'posts.table-switches']);
Route::post('posts/store-file',['uses' => 'PostController@storeFile', 'as' => 'posts.store-file']);
Route::post('posts/store-video-id',['uses' => 'PostController@storeVideoId', 'as' => 'posts.store-video-id']);
Route::get('posts/get-media/{postId?}',['uses' => 'PostController@getMedia', 'as' => 'posts.get-media']);
Route::delete('posts/destroy-file/{postGalleryId?}', ['uses' => 'PostController@destroyFile', 'as'=> 'posts.destroy-file']);
