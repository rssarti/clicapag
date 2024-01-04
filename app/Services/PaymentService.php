<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentService
{

    public $data ;
    public $client ;
    public $zoop ;
    public $buyer ;
    public function __construct()
    {
        $this->zoop = new Zoop() ;
    }

    public function setClientPayment($data)
    {
        $this->client = $data ;
    }

    public function setBuyer($buyer)
    {
        $this->buyer = $buyer ;
    }

    public function setLink($id)
    {
        $this->data['link_id'] = $id ;
    }

    public function setUserCreate($id)
    {
        $this->data['user_id'] = $id ;
    }

    public function setApi($id)
    {
        $this->data['api_key_id'] = $id ;
    }

    public function setType($type)
    {
        $this->data['type_payment'] = $type ;
    }

    public function setAmount($amount)
    {
        $this->data['amount'] = $amount ;
    }

    public function setSellerReceipt($seller_id)
    {
        $this->data['seller_id_receipt'] = $seller_id ;
    }

    public function createPayment()
    {

        $payment = new Payment() ;

        $payment->hash = Str::uuid() ;
        $payment->seller_receipt = $this->data['seller_id_receipt'] ;
        $payment->user_id = $this->data['user_id'] ;
        $payment->link_id = $this->data['link_id'] ;
        $payment->amount = $this->data['amount'] ;

        $payment->save() ;
    }


    public function save()
    {
        $item = new Payment() ;

        $item->hash = Str::uuid() ;


        $item->status = 'A' ;
        $item->seller_receipt = $this->data['seller_id_receipt'] ;
        $item->user_id = $this->data['user_id'] ;
        $item->amount = $this->data['amount'] ;
        $item->client = $this->client ;

        $item->save() ;

        return true ;


    }

    public function observerCreatedPending($payment)
    {

        if($payment->status=="PEN") { // PENDENTE


            if($payment->type_payment=="P") { // P = PIX

                $user = User::find($payment->user_id) ;

                $this->zoop->setBuyer($user->seller_id);

                $payment->data_payment = $this->zoop->cobrarPix([
                    'description' => 'teste de pix',
                    'seller_id' => $user->seller_id,
                    'amount' => Str::remove(".", $payment->amount*100)]) ;

                $payment->status = "A" ;
                try {
                    $payment->save() ;
                    return redirect()->route('pay', ['uuid' => $payment->hash]) ;
                } catch (\Exception $e) {

                }

            }
        }
    }
}
