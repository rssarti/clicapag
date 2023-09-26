<?php

namespace App\Livewire\Pay;

use Livewire\Component;

class Link extends Component
{

    public $data ;

    public function mount($uuid)
    {
        $this->data = \App\Models\Link::where('uuid', $uuid)->first() ;
    }

    public function render()
    {
        return view('livewire.pay.link')->layout('layouts.guest');
    }

    public function checkout()
    {
        return redirect()->route('pay.checkout', ['uuid' => $this->data->uuid]) ;
    }
}
