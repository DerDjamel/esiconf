<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::apiResource('conference', 'ConferenceController');
Route::get('user/conferences', 'ConferenceController@user_conferences');
Route::get('conference/{conference}/reviews', 'ConferenceController@conference_reviews');
Route::get('conference/{conference}/papers', 'ConferenceController@conference_papers');
Route::get('conference/{conference}/bids', 'ConferenceController@conference_bids');
Route::put('conference/{conference}/submissionStatus', 'ConferenceController@submissionStatus');
Route::put('conference/{conference}/biddingStatus', 'ConferenceController@biddingStatus');


Route::get('user/paper', 'PaperController@user_papers');
Route::get('paper/download/{paper}', 'PaperController@download');
Route::post('paper/{paper}/accept', 'PaperController@accept_paper');
Route::post('paper/{paper}/reject', 'PaperController@reject_paper');
Route::apiResource('paper', 'PaperController');



Route::post('bid/{paper}', 'BidController@store');
Route::get('user/bids', 'BidController@user_bids');

Route::post('review/paper/{paper}', 'ReviewController@store');
Route::get('review/{review}', 'ReviewController@show');
Route::put('review/{review}/paper/{paper}', 'ReviewController@update');
Route::get('user/reviews', 'ReviewController@user_reviews');