<?php

use Dcblogdev\LaravelSentEmails\Controllers\SentEmailsController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('sentemails.middleware'))->group(function () {
    Route::get(config('sentemails.routepath'), [SentEmailsController::class, 'index'])->name('sentemails.index');
    Route::get(config('sentemails.routepath').'/email/{id}', [SentEmailsController::class, 'email'])->name('sentemails.email');
    Route::get(config('sentemails.routepath').'/body/{id}', [SentEmailsController::class, 'body'])->name('sentemails.body');
    Route::get(config('sentemails.routepath').'/attachment-{id}', [SentEmailsController::class, 'downloadAttachment'])->name('sentemails.downloadAttachment');
});