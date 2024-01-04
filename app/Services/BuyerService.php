<?php

namespace App\Services;

use App\Mail\PaymentSuccess;
use App\Models\Buyer;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BuyerService
{

    public $data ;

    public $contract ;

    public $buyer ;

    public function setContract($contract)
    {
        $this->contract = $contract ;
        $this->data['contract_id'] = $contract->id ;
    }

    public function setBuyer($buyerHash)
    {
        $this->buyer = Buyer::where('hash', $buyerHash)->first() ;
    }

    public function setData($data)
    {
        $this->data = $data ;
    }

    public function setCard($data)
    {
        $zoop = new Zoop() ;
        $zoop->setBuyer($this->buyer);
        $zoop->setCard($data) ;

    }

    public function payCard($data)
    {

        $this->setBuyer($data['buyer']);

        $zoop = new Zoop() ;
        $zoop->setSeller($this->contract->seller_id);

        $pay = $zoop->cobrar($this->buyer->external_id_payment, $data['amount'], $data['currency']) ;


        $payment = new Payment() ;
        $payment->sales_receipt = $pay->sales_receipt ;
        $payment->seller_receipt = 'third' ;
        $payment->amount = (float)$pay->amount ;
        $payment->hash = Str::uuid()->toString();
        $payment->data_payment = $pay ;
        $payment->status = 'PG' ;
        $payment->amount_min_installmes = (float)$pay->amount ;
        $payment->max_installments = 0 ;
        $payment->installments = 0 ;

        if($pay->status=='succeeded') {
            $payment->type_payment = 'PG' ;
            Mail::to($this->contract->business_email)->send(new PaymentSuccess());
        } else {
            $payment->type_payment = 'D' ;
        }

        $payment->save() ;
    }

    public function store()
    {
        $buyer = new Buyer() ;
        $this->data['hash'] = Str::uuid()->toString() ;
        $buyer->create($this->data) ;
        return response()->json([
            'success' => true,
            'hash' => $this->data['hash']
        ]) ;
    }
}
