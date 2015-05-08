<?php

// Pages
Route::get('/', 'LivestreamController@index');
Route::get('/video-archive', 'VideoArchiveController@index');
Route::get('/about', 'AboutController@index');

// API
Route::resource('api/camera', 'ApiCameraController',
                ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
