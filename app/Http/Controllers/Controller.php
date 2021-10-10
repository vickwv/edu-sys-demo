<?php

namespace App\Http\Controllers;

use App\Tools\Tool;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success(string $msg, array $data = [], array $header = []) {
        $result = [
            'code'      => (int) Tool::code('success'),
            'msg'       => Tool::message($msg),
            'data'      => $data,
            'timestamp' => time(),
        ];

        return response()->json($result, 200, $header, JSON_UNESCAPED_UNICODE);
    }

    public function fail(string $errCode, string $errMsg, array $data = [], array $header = []) {
        if (!is_numeric($errCode)) {
            $code = Tool::code($errCode);
        } else {
            $code = $errCode;
        }
        $result = [
            'code'      => (int) $code,
            'msg'       => $errMsg ?? Tool::message($errCode),
            'data'      => $data,
            'timestamp' => time(),
        ];

        return response()->json($result, 200, $header, JSON_UNESCAPED_UNICODE);
    }

}
