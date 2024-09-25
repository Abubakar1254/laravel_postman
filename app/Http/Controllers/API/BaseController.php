<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message) // Added comma
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $ErrorMessage = [], $code = 404) // Added commas
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($ErrorMessage)) {
            $response['data'] = $ErrorMessage;
        }
        
        return response()->json($response, $code);
    }
}