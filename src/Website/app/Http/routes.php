<?php

// Pages
Route::get('', 'LivestreamController@index');
Route::get('video-archive', 'VideoArchiveController@index');
Route::get('about', 'AboutController@index');

// API
Route::resource('api/settings', 'ApiSettingsController',
                ['only' => ['index', 'store']]);

Route::resource('api/cameras', 'ApiCameraController',
                ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

Route::resource('api/videos', 'ApiVideoController',
                ['only' => ['index', 'show', 'destroy']]);
