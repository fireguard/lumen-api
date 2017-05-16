<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function responseSuccess($message, $code = 200, $data = [])
    {
        return $this->createResponse('success', $message, $code, $data);
    }

    public function responseError($message, $code = 500, $data = [])
    {
        return $this->createResponse('error', $message, $code, $data);
    }

    protected function createResponse($status, $message, $code = 500, $data =[])
    {
        return response()->json([
            'code' => $code,
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}
