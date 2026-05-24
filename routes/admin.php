<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;

Route::resource('categories', CategoryController::class); //Ruta para el CRUD de categorías
Route::resource('posts', PostController::class); //Ruta para el CRUD de posts
Route::resource('tags', TagController::class); //Ruta para el CRUD de etiquetas