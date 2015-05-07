<?php

// Pages
Route::get('/', 'WelcomeController@index');
Route::get('/video-archive', 'VideoArchiveController@index');
Route::get('/about', 'AboutController@index');

// API
Route::resource('api/camera', 'ApiCameraController',
                ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
