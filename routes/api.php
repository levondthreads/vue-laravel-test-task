<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('book', \App\Http\Controllers\BookController::class);

Route::get('author', "\App\Http\Controllers\AuthorController@index");
Route::get('genres', "\App\Http\Controllers\GenreController@index");
