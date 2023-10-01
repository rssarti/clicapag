<?php

namespace App\Http\Controllers;

use App\Services\Zoop;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function debug()
    {
        $zoop = new Zoop(true) ;
        dd($zoop->getSellers()) ;
    }
}
