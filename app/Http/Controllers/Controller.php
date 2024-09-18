<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

abstract class Controller
{



    /**
     * For returning responses of the application 25 oct 2022
     *
     * @param [type] $status
     * @param [type] $message
     * @param [type] $data
     * @return void
     * @author Bashir <wamulabash1@gmail.com.com>
     */
    public function genericResponse($status, $message, $code, $data){
        return response()->json([
            "status"=>$status,
            "code"=>$code,
            "message"=>$message,
            "data"=>$data
        ], $code);
    }



    /**
     * Summary of generateUuid
     * @return string
     */
    public function generateUuid(){
        return Str::uuid()->toString();
    }


}
