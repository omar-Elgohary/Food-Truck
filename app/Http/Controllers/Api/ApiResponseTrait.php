<?php
namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public function getCurrentLang()
    {
        return app()->getLocale();
    }


    public function returnData($status = null, $message = null, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
// ss

    public function returnSuccess($status, $message)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }


    public function returnError($status, $message)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
