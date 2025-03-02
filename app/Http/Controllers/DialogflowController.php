<?php

namespace App\Http\Controllers;

use App\Services\DialogflowService;
use Illuminate\Http\Request;

class DialogflowController extends Controller
{
    protected $dialogflowService;

    public function __construct(DialogflowService $dialogflowService)
    {
        $this->dialogflowService = $dialogflowService;
    }

    public function showMessage(Request $request)
    {
        return view('dialogflow');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $response = $this->dialogflowService->sendTextQuery($message);

        return response()->json(['response' => $response]);
    }
}
