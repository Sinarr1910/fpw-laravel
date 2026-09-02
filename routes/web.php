<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Selamat datang di Toko sinar sejahtera! Kami menjual berbagai kebutuhan sehari-hari dengan harga yang sangat terjangkau';
});