<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentService
{

    public $data ;
    public $client ;
    public function setClientPayment($data)
    {
        $this->client = $data ;
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
        dd($item) ;


    }
}
