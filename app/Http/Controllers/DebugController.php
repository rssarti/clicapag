<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccess;
use App\Models\Mcc;
use App\Services\Zoop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DebugController extends Controller
{
    public function debug()
    {
        $amount = 1 ;
        Mail::to("rs.sarti@gmail.com")->send(new PaymentSuccess($amount));

//        $zoop = new Zoop() ;
//
//        $data = $zoop->getSellers() ;
//
//        dd($data) ;

        //
//        $this->processDataMcc($data);
//
//        for($i=2;$i<=$data->total_pages;$i++) {
//            $this->processDataMcc($zoop->getMCC($i));
//        }


    }

    public function processDataMcc($data)
    {

        foreach($data->items as $value) {
            $item = new Mcc() ;
            $item->code = $value->code ;
            $item->category = $value->category ;
            $item->description = $value->description ;

            try{
                $item->save() ;
                echo "Adicionado! ".$value->category." \r\n" ;
            } catch (\Exception $e) {
                echo "Duplicado! \r\n" ;
            }

        }
    }
}
