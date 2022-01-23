<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    const SUCCESS = 200;
    const FAILED = 400;
    const ERROR = 500;

    public function error($msg)
    {
        $response['status'] = false;
        $response['code'] = self::ERROR;
        $response['message'] = $msg;
        return response()->json($response,  self::ERROR);
    }

    public function failed($msg = [])
    {
        $response['status'] = false;
        $response['code'] = self::FAILED;
        if (is_array($msg)) {
            if (array_key_exists("errors", $msg)) {
                $response['errors'] = $msg['errors'];
                if (array_key_exists('message', $msg)) {
                    $response['message'] = $msg['message'];
                }
            }
        } else {
            $response['message'] = $msg;
        }
        return response()->json($response,  self::FAILED);
    }
    
    public function success($msg = [])
    {
        $response['status'] = true;
        $response['code'] = self::SUCCESS;
        if (is_array($msg)) {
            foreach ($msg as $key => $value) {
                $response[$key]  = $value;
            }
        } else {
            $response['message'] = $msg;
        }
        return response()->json($response,  self::SUCCESS);
    }
}
