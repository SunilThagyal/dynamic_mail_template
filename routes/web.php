<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailTemplateController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('email_templates', EmailTemplateController::class);
});

Route::post('/email_templates/{template}/send-dummy', [EmailTemplateController::class, 'sendDummy'])->name('email_templates.sendDummy');
