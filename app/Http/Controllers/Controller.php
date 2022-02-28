<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function error( $code = 1, $msg = 'error', array $append = [])
    {
        return response()->json(array_merge(['code' => $code, 'msg' => $msg], $append));
    }

    protected function success($code = 0, $msg = 'success', array $append = [])
    {
        return response()->json(array_merge(['code' => $code, 'msg' => $msg], $append));
    }
}
