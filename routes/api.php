<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibleController;

Route::post('/query', [BibleController::class, 'query']);
