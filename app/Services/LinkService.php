<?php

namespace App\Services;

use App\Models\Link;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkService
{

    public $data ;
    public function setData($data)
    {
        $this->data = $data ;
    }

    public function save($id=null)
    {
        if($id) {
            $item = Link::find($id) ;
        } else {
            $item = new Link() ;
        }


        $item->uuid = Str::uuid() ;
        $item->user_id = Auth::user()->id ;
        $item->name = ($this->data['name']!=null) ? $this->data['name'] : null ;
        $item->description = ($this->data['description']!=null) ? $this->data['description'] : null ;
        $item->photo = ($this->data['photo']!=null) ? $this->data['photo']->store('links') : null ;
        $item->amount = ($this->data['amount']!=null) ? $this->data['amount'] : null ;
        $item->max_installments = ($this->data['max_installments']!=null) ? $this->data['max_installments'] : null ;
        $item->pass_tax = ($this->data['pass_tax']!=null) ? $this->data['pass_tax'] : null ;

        $item->save();
    }
}
