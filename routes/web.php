<?php

use Illuminate\Support\Facades\Route;
// 6|4m7L2g7BEZWoRKXTyDoe54s1J2kV32F8Zdj2Wt1866a48de4


Route::get('/', function () {
    return view('welcome');
});

Route::view('/','login');
Route::view('/allpost','allpost');
Route::view('/addpost','addpost');