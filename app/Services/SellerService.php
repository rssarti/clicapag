<?php

namespace App\Services;

use App\Livewire\Contract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerService
{
    public $data ;

    public function setData($data)
    {
        $this->data = $data ;
    }

    public function setDocuments($contract, $documents)
    {
        $contract->mcc = (isset($this->data['mcc'])) ? $this->data['mcc'] : null ;
        $contract->business_opening_date = (isset($this->data['business_opening_date'])) ? $this->data['business_opening_date'] : null ;
        $contract->documents_upload = $documents ;
        $contract->status = 'V' ;
        $contract->save() ;
    }

    public function save($id=null)
    {
        $user = Auth::user() ;

        if($id) {
            $contract = \App\Models\Contract::find($id) ;
        } else {
            $contract = new \App\Models\Contract() ;
        }

        $contract->description = (isset($this->data['description'])) ? $this->data['description'] : null ;
        $contract->business_name = (isset($this->data['business_name'])) ? $this->data['business_name'] : null ;
        $contract->business_email = (isset($this->data['business_email'])) ? $this->data['business_email'] : null ;
        $contract->business_website = (isset($this->data['business_website'])) ? $this->data['business_website'] : null ;
        $contract->business_description = (isset($this->data['business_description'])) ? $this->data['business_description'] : null ;
        $contract->business_facebook = (isset($this->data['business_facebook'])) ? $this->data['business_facebook'] : null ;
        $contract->business_twitter = (isset($this->data['business_twitter'])) ? $this->data['business_twitter'] : null ;
        $contract->ein = (isset($this->data['ein'])) ? $this->data['ein'] : null ;
        $contract->user_id = $user->id ;
        $contract->hash = Str::uuid()->toString();
        $contract->owner = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone,
            'taxpayer_id' => $user->cpf,
            'birthdate' => $user->birthdate,
        ] ;

        $contract->business_address = [
           'line1' => (isset($this->data['address_street'])) ? $this->data['address_street'] : null,
           'line2' => (isset($this->data['address_n'])) ? $this->data['address_n'] : null,
           'line3' => (isset($this->data['address_complement'])) ? $this->data['address_complement'] : null,
           'neighborhood' => (isset($this->data['address_distric'])) ? $this->data['address_district'] : null,
           'state' => (isset($this->data['address_state'])) ? $this->data['address_state'] : null,
           'city' => (isset($this->data['address_city'])) ? $this->data['address_city'] : null,
           'postal_code' => (isset($this->data['address_cep'])) ? $this->data['address_cep'] : null,
           'country_code' => 'BR',
        ] ;

        $contract->save() ;

    }

}
