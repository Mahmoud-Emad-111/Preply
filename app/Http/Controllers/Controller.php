<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    use AuthorizesRequests, ValidatesRequests;
    public function handelResponse($result, $msg)
    {
        $res = [
            'data' => $result,
            'message' => $msg
        ];
        return response()->json($res, 200);
    }
    //////////////////////Handel Error//////////////////////////////
    public function handelError($error, $code = 404)
    {


        return response()->json($error, $code);
    }
}
