<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/{any}', fn () => view('vue'))->where('any', '.*');
