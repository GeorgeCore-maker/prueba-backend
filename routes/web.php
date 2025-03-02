<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DialogflowController;

Route::get('/', [DialogflowController::class, 'showMessage']);

