<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentService
{

    public $data ;
    public function setClientPayment($data)
    {
        $this->data = $data ;
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

    public function setType($id)
    {
        $this->data['type'] = $id ;
    }

    public function save()
    {
        $item = new Payment() ;

        $item->hash = Str::uuid() ;
        $item->type = $this->data['type'] ;
        $item->user_id = $this->data['user_id'] ;
        $item->amount = $this->data['amount'] ;
        $item->name = ($this->data['name']!=null) ? $this->data['name'] : null ;
    }
}
