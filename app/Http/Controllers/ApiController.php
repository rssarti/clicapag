<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\LogWebHook;
use App\Services\BuyerService;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public $contract ;

    public function logWebHook(Request $request)
    {
        $log = new LogWebHook() ;
        $log->body = $request->all() ;
        $log->save() ;
    }

    public function validateAuth($auth)
    {
        $auth = explode(' ', $auth) ;

        if($auth[0]=="Bearer") {
            $this->contract = Contract::where('hash', $auth[1])->first();
        }

        if($this->contract) {
            return true ;
        }

    }

    public function createBuyer(Request $request)
    {

        if($this->validateAuth($request->header('Authorization'))) {
            if($this->contract) {
                $buyer = new BuyerService() ;
                $buyer->setData($request->all());
                $buyer->setContract($this->contract) ;
                return $buyer->store() ;
            }
        } else {
            return response(['error' => true, 'message' => 'Error create buyer'], 401)
                ->header('content-type', 'application/json') ;
        }



    }

    public function cardBuyer(Request $request)
    {
        if($this->validateAuth($request->header('Authorization'))) {

            $buyer = new BuyerService() ;
            $buyer->setBuyer($request->get('buyer'));
            $buyer->setCard($request->all());

        } else {
            return response(['error' => true, 'message' => 'Error create card'], 401)
                ->header('content-type', 'application/json') ;
        }
    }

    public function payCard(Request $request)
    {
        if($this->validateAuth($request->header('Authorization'))) {
            $buyer = new BuyerService() ;
            $buyer->setContract($this->contract);
            $buyer->payCard($request->all());
        }
    }

}
