<?php

namespace App\Http\Controllers;

use App\Models\LogWebHook;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function logWebHook(Request $request)
    {
        $log = new LogWebHook() ;
        $log->body = $request->all() ;
        $log->save() ;
    }
}
