<?php

Route::post('posts-gallery/store-file',['uses' => 'PostGalleryController@storeFile', 'as' => 'posts-gallery.store-file']);
Route::post('posts-gallery/store-video-id',['uses' => 'PostGalleryController@storeVideoId', 'as' => 'posts-gallery.store-video-id']);
Route::get('posts-gallery/get-media/{postId?}',['uses' => 'PostGalleryController@getMedia', 'as' => 'posts-gallery.get-media']);
Route::delete('posts-gallery/destroy-file/{postGalleryId?}', ['uses' => 'PostGalleryController@destroyFile', 'as'=> 'posts-gallery.destroy-file']);
