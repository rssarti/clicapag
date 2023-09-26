<?php

namespace App\Livewire\Pay;

use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{

    public $data ;
    public $link ;
    public $form = [
        'type_payment' => '',
        'address' => '',
        'address_district' => '',
        'address_city' => '',
        'address_state' => '',
    ] ;

    public function mount($uuid)
    {
        try {
            $this->link = \App\Models\Link::where('uuid', $uuid)->first() ;
            $this->link->views = $this->link->views + 1 ;
        } catch (\Exception $e) {
            return redirect()->route('dashboard') ;
        }

        $this->link->save() ;
        $this->data = $this->link->toArray() ;
    }

    public function render()
    {
        return view('livewire.pay.checkout')->layout('layouts.site');
    }


    public function updateCep()
    {


        if(Str::length($this->form['address_zip_code'])==9) {

            $data = Http::get('https://viacep.com.br/ws/'.Str::remove("-", $this->form['address_zip_code']).'/json/');
            $address = json_decode($data->body(), true) ;
            $this->form['address'] = $address['logradouro'] ;
            $this->form['address_district'] = $address['bairro'] ;
            $this->form['address_city'] = $address['localidade'] ;
            $this->form['address_state'] = $address['uf'] ;

        }
    }

    public function save()
    {
        $payment = new PaymentService() ;
        $payment->setClientPayment($this->form);
        $payment->setLink($this->data->id);
        $payment->setUserCreate($this->data->user_id);
    }
}
