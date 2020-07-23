<?php
Route::group(['middleware' => config('sentemails.middleware'), 'namespace' => 'Dcblogdev\LaravelSentEmails\Controllers'], function () {
    Route::get(config('sentemails.routepath'), 'SentEmailsController@index');
    Route::get(config('sentemails.routepath').'/email/{id}', 'SentEmailsController@email');
    Route::get(config('sentemails.routepath').'/body/{id}', 'SentEmailsController@body');
});