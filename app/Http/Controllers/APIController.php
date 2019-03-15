<?php

namespace App\Http\Controllers;

class APIController extends Controller
{
    /**
     * Package data with OK status
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($data)
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * Package JSON error message with specific status code.
     *
     * @param $message
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
