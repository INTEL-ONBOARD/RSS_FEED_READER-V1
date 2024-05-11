<?php
use App\Http\Controllers\rssController;
use Illuminate\Support\Facades\Route;


Route::view('/','index')->name('get.home');
Route::post('/{url}', [rssController::class, 'post_rssJobData'])->name('post.fetchData');