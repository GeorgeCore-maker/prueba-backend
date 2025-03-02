<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DialogflowController;

Route::post('/dialogflow/message', [DialogflowController::class, 'sendMessage']);
