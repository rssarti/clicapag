<?php

namespace App\Livewire\Pay;

use App\Models\Payment;
use Livewire\Component;

class Pay extends Component
{

    public $uuid = '' ;
    public object $payment  ;

    public function mount($uuid)
    {
        $this->uuid = $uuid ;
        $this->payment = Payment::where('hash', $uuid)->first() ;

    }

    public function render()
    {


        return view('livewire.pay.pay')->layout('layouts.guest');
    }
}
