<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::apiResource('conference', 'ConferenceController');
Route::put('conference/{conference}/submissionStatus', 'ConferenceController@submissionStatus');
Route::put('conference/{conference}/biddingStatus', 'ConferenceController@biddingStatus');

Route::apiResource('paper', 'PaperController');

Route::post('bid/{paper}', 'BidController@store');


Route::post('review/paper/{paper}', 'ReviewController@store');
Route::put('review/{review}/paper/{paper}', 'ReviewController@update');